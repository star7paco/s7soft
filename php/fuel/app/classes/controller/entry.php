<?php
use Fuel\Core\Input;
use Model\Entry;
use Model\Shop;
use Model\Course;
use Model\Seat;
use Model\Question;
use Fuel\Core\Cache;
use Fuel\Core\Log;
use Fuel\Core\Debug;
use Fuel\Core\Response;
use Fuel\Tasks\Lottery;

/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Entry extends Controller
{

	public $course_name = array('lunch'=>'ランチ' , 'dinner'=>'ディナー');
	public $week_name = array("日", "月", "火", "水", "木", "金", "土");


	public function before(){

	}

	/**
	 * viewを設定（sp、pc）
	 * @param string $url
	 * @return View
	 */
	public function get_view($url)
	{
		if(Agent::is_smartphone()) {
			$client_agent = 'sp';
		}else {
			$client_agent = 'pc';
		}

		$view = View::forge('entry/'.$client_agent.'/'.$url);
		$view->set('client_agent',$client_agent);
		return $view;
	}


	/**
	 * エントリーフォーム入力
	 */
	public function action_index()
	{

		$shop_id     = trim(Input::get('shop_id'));
		$course_type = trim(Input::get('course_type'));
		$visit_date  = trim(Input::get('visit_date'));


		# 入力パラメータチェック
		if( !isset( $shop_id ) ){
			# エラー
			return self::on_error_move_back(MEG_SYSTEM_ERROR);
		}
		if( !isset($course_type) ){
			# エラー
			return self::on_error_move_back(MEG_SYSTEM_ERROR);
		}
		if( !isset($visit_date) ){
			# エラー
			return self::on_error_move_back(MEG_SYSTEM_ERROR);
		}

// 		$course_type = $course_type;
// 		if( !array_key_exists($course_type, $this->course_name)){
// 			# エラー
// 			return self::on_error_move_top(MEG_ENTRY_DONE);
// 		}

		return $this->get_entry_info_view($shop_id, $course_type, $visit_date);

	}

	/**
	 * エントリーフォーム確認
	 */
	public function action_entry_conf()
	{

		$entry = Entry::forge();

		$val = Validation::forge();
		$val = Entry::get_validation($val);


		$uuid        = Input::post('uuid');
		$shop_id     = Input::post('shop_id');
		$course_type = Input::post('course_type');
		$visit_date  = Input::post('visit_date');

		if(self::is_entry_done($uuid)){
			return self::on_error_move_top(MEG_ENTRY_DONE);
		}

		if ($val->run()) {
			// validation ok
			$view = $this->get_view('entry_conf');
			$input = Input::post();

			# アンケート画面表示用情報を取得
			$question = Question::get_question_answer($input);
			$course_info = Course::find(Input::post('course'));

			$view->set('input', $input);
			$view->set('shop_id',$shop_id);
			$view->set('course_type',$course_type);
			$view->set('course_info',$course_info);
			$view->set('visit_date',$visit_date);
			$view->set('question', $question);
			return $view;

		} else {
			// validation error
			$view = $this->get_entry_info_view($shop_id, $course_type, $visit_date);
			$view->set('errors', $val->error());
			return $view;
		}

	}

	/**
	 * エントリーフォーム完了
	 */
	public function action_entry_done()
	{
		Log::debug('[ENTRY] entry_done start');

		$input = Input::post();
		$uuid  = $input['uuid'];

		# 登録済みの場合top画面へ移動
		if(self::is_entry_done($uuid)){
			return self::on_error_move_top(MEG_ENTRY_DONE);
		}

		# DB登録
		$entry_id = Entry::add_entry($input);


		# 登録済みキャッシング設定
		if( isset($entry_id) ) {
			$input['entry_id'] = $entry_id;

			# メール送信
			MailUtil::send_entry_mail($input);

			# キャッシュに処理済みフラグ追加
			self::set_entry_done($uuid);
		}else{
			return self::on_error_move_back('システムエラーが発生しました。');
		}

		$view = $this->get_view('entry_done');

		return $view;
	}

	/**
	 * エントリーフォームキャンセル画面表示
	 */
	public function action_cancel()
	{

		$input_id = trim(Input::get('entry_id'));

		#$input_id = ParameterUtil::encode(7);
		$entry_id = ParameterUtil::decode($input_id);
		Log::debug("[Input:$input_id][ID:$entry_id]");

		if( !isset($entry_id) ){
			return self::on_error_move_top(MEG_SYSTEM_ERROR);
		}
		$entry = Entry::find($entry_id);

		# 店舗情報取得失敗
		$shop = Shop::find($entry['shop_id']);
		if( !isset($shop) ){
			return self::on_error_move_top(MEG_SYSTEM_ERROR);
		}

		# コース情報取得失敗
		$course_info = Course::find($entry['course_id']);
		if( !isset($shop) ){
			return self::on_error_move_top(MEG_SYSTEM_ERROR);
		}

		# エントリー情報取得失敗
		if( !isset($entry) ){
			return self::on_error_move_top(MEG_SYSTEM_ERROR);
		}

		# コース表示用
		$course_type = $course_info['course_type'];
		$dis_course_type = $this->course_name[$course_type];
		# 来店日表示用
		$dis_visit_date = $this->get_display_visit_date($entry['visit_date']);

		if( strcasecmp( $course_type , "lunch" ) == 0 ){
			$dis_cancel_policy   = $shop['lunch_cancel_policy'];
		}else if( strcasecmp( $course_type , "dinner" ) == 0 ){
			$dis_cancel_policy   = $shop['dinner_cancel_policy'];
		}

		$entry['input_id']          = $input_id;
		$entry['shop_name']         = $shop['shop_name'];
		$entry['dis_course_type']   = $dis_course_type;
		$entry['dis_visit_date']    = $dis_visit_date;
		$entry['course_name']       = $course_info['course_name'];
		$entry['dis_cancel_policy'] = $dis_cancel_policy;


		#キャンセル期間チェック
		$using_cancel = $this->is_using_cancel($entry);
		#$using_cancel = false;

		$view = $this->get_view('cancel');
		$view->set('entry', $entry);
		$view->set('using_cancel', $using_cancel);

		if( $entry['status'] === Entry::Cancel ){
			# キャンセルずみのため、キャンセル済み画面へ移動
			#return self::on_error_move_top(MEG_SYSTEM_ERROR);
			$view = $this->get_view('cancel_done');
			$view->set('entry', $entry);
			return $view;

		}elseif( $entry['status'] !== Entry::Winning ){
			# 当選ではない、システムエラー
			return self::on_error_move_top(MEG_SYSTEM_ERROR);
		}

		return $view;
	}

	/**
	 * エントリーフォームキャンセル実行
	 */
	public function action_cancel_done()
	{
		$input = Input::post();


		$entry_id = $input['entry_id'];
		$entry = Entry::find($entry_id);

		$entry['shop_name']         = $input['shop_name'];
		$entry['dis_course_type']   = $input['dis_course_type'];
		$entry['dis_visit_date']    = $input['dis_visit_date'];
		$entry['course_name']       = $input['course_name'];


		if( $entry['status'] === Entry::Cancel ){

			$view = $this->get_view('cancel_done');
			$view->set('entry', $entry);
			return $view;
		}


		if( $entry['status'] !== Entry::Winning ){
			return self::on_error_move_top(MEG_SYSTEM_ERROR);
		}

		# ステータス更新
		$entry->status = Entry::Cancel;
		$entry->save();

		# メール送信
		MailUtil::send_cancel_mail($entry);

		# キャッシング再読込設定
		Cache::set(JSON_RELOAD, TRUE, 3600 * 24);

		$view = $this->get_view('cancel_done');
		$view->set('entry', $entry);
		return $view;
// 		}

	}




	public function action_test()
	{
		$view = View::forge('entry/test');

		# tasksディレクトリの中からTaskOneに対応するファイルを探し、そのパスを取得
		$file = \Finder::search('tasks', strtolower('Lottery'));
		# TaskOneのファイルをロード
		require_once $file;

		$entry_list = array();
		$winning_entry = Lottery::get_entry_seat_over('shop_001', '1011','lunch',2);




		$view->set('entry_list',$entry_list);
		$view->set('entry_keys',$winning_entry);
		return $view;
	}





	/**
	 * 残席データJSONファイル
	 *
	 */
	public function action_seat_info()
	{
		$json = array();
		try
		{
			if( self::is_json_reload() ){
				$json =  Seat::get_shop_unsold_list();
			}else{
				$json = Cache::get(UNSOLD_SEAT_JSON);
			}

		}
		catch (\CacheNotFoundException $e)
		{
			# 枠情報取得
			$json =  Seat::get_shop_unsold_list();
		}

		echo json_encode($json);

	}


	public function on_error_move_back($message){
		# エラーメッセージ表示後、戻る
		$view = View::forge('entry/error');
		if(isset($message)){
			$view->set('on_dialog',true);
			$view->set('dialog_msg',$message);
		}
		$view->set('redirect_url','history.back();');
		return $view;
	}
	public function on_error_move_top($message){
		# エラーメッセージ表示後、トップページへ
		$view = View::forge('entry/error');
		if(isset($message)){
			$view->set('on_dialog',true);
			$view->set('dialog_msg',$message);
		}
		$view->set('redirect_url', TOP_URL);
		return $view;
	}

	/**
	 * 入力フォーム作成
	 *
	 */
	private function get_entry_info_view($shop_id,$course_type,$visit_date){
		# 店舗情報取得
		$shop = Shop::find($shop_id);

		# コース情報取得
		$courses = Course::get_course_list($shop_id , $course_type);

		# 枠情報取得
		$seats = Seat::get_seat_list($shop_id , $course_type, $visit_date);

		# コース表示用
		$dis_course_type = $this->course_name[$course_type];
		$dis_visit_date = $this->get_display_visit_date($visit_date);

		# 来店時間リストを作成
		$time_list = array();
		$time_list['']='選択してください';

		if( strcasecmp( $course_type , "lunch" ) == 0 ){
			$start_time = $shop['lunch_start_time'];
			$end_time   = $shop['lunch_end_time'];
			$dis_cancel_policy   = $shop['lunch_cancel_policy'];

		}else if( strcasecmp( $course_type , "dinner" ) == 0 ){
			$start_time = $shop['dinner_start_time'];
			$end_time   = $shop['dinner_end_time'];
			$dis_cancel_policy   = $shop['dinner_cancel_policy'];
		}

		$start = intval(substr($start_time,0,2));
		$end = intval(substr($end_time,0,2));

		if( strcmp(substr($start_time,3,2), "30") == 0 ){
			$time_list[$start_time] = $start_time;
			$start = $start+1;
		}

		for ($i=$start; $i < $end ; ++$i) {
			$time = $i.':00';
			$time_list[$time] = $time;

			$time = $i.':30';
			$time_list[$time] = $time;
		}

		if( strcmp(substr($end_time,3,2), "00") <> 0 ){
			$time = str_replace("30","00", $end_time);
			$time_list[$time] = $time;

		}else{

		}
		$time_list[$end_time] = $end_time;


		## 来店人数作成

		# 枠を超える予約フラグ
		$seat_over_flg = $shop['seat_over_flg'];
		$seat_list = array();
		#売り切れ無視フラグ
		$sold_out_ignore = false;

		#枠の分ループ
		foreach ($seats as &$value) {
			$min = $value['seats_min'];
			$max = $value['seats_max'];

			$unsold_count = $value['seats_count'] - $value['sold_count'];

			#残席数が0の場合非活性化
			$seat_disable = ($unsold_count==0);

			#売り切れ無視フラグを設定
			if($seat_over_flg and !$seat_disable){
				$sold_out_ignore = true;
			}

			#売り切れを無視
			if($sold_out_ignore){
				$seat_disable = false;
			}

			for ($i= $max ; $i >= $min ; --$i) {
				$seat_count = (string)$i;
				array_push($seat_list , array('seat_count'=>$seat_count,'seat_disable'=>$seat_disable));
			}
		}
		#ソートして少ない人数順にする。
		asort($seat_list);

		#残席数が0の場合はエラーでトップページへ移動
		$sold_out_count = 0;
		foreach ($seat_list as &$value) {
			if( $value['seat_disable'] ){
				$sold_out_count++;
			}
		}
		if( count($seat_list) === $sold_out_count ){
			return $this->on_error_move_top(MEG_SYSTEM_ERROR);
		}

		# 画面表示用設定
		$view = $this->get_view('entry');

		$view->set('shop_id',$shop_id);
		$view->set('course_type',$course_type);
		$view->set('visit_date',$visit_date);


		$view->set('course_type',$course_type);
		$view->set('dis_course_type',$dis_course_type);
		$view->set('dis_visit_date',$dis_visit_date);
		$view->set('dis_cancel_policy',$dis_cancel_policy);


		$view->set('shop',$shop);
		$view->set('courses',$courses);
		$view->set('seats',$seats);
		$view->set('time_list',$time_list);
		$view->set('seat_list',$seat_list);

		# アンケートを作成
		$view->set('question', Question::get_question_list());

		$view->set('uuid', Str::random('uuid'));

		return $view;
	}

	private function set_entry_done($uuid){
		# uuidを使用済みとして1時間保管する。
		Cache::set($uuid, false, 3600 * 1);
	}
	private function is_entry_done($uuid){
		# uuidを使用済みか確認
		Log::debug("[Entry] $uuid is Done");
		try
		{
			$uuid = Cache::get($uuid);
			return true;
		}
		catch (\CacheNotFoundException $e)
		{
			return false;
		}

	}


	/***
	 * 来店日MMDDを画面表示用へ変換する。
	 * @param 来店日 $visit_date
	 */
	private function  get_display_visit_date($visit_date){
		# 来店日表示用
		# 日付を指定
		$month = substr( $visit_date , 0 , 2 );
		$day = substr( $visit_date , 2 , 2 );;

		#指定日のタイムスタンプを取得
		$timestamp = mktime(0, 0, 0, $month, $day, EVENT_YEAR);

		#指定日の曜日番号（日:0  月:1  火:2  水:3  木:4  金:5  土:6）を取得
		$week = $this->week_name[date('w', $timestamp)];
		$dis_visit_date = date('Y年n月j日', $timestamp).'('.$week.')';

		#指定日曜日番号出力
		#echo $weekno;
		return $dis_visit_date;
	}


	/***
	 * キャンセル可能判定
	 * 2日前の18時までキャンセル可能
	 *
	 * @param Entry $entry
	 * @return boolean
	 */
	public function is_using_cancel($entry){

		$visit_date = "";
		$today = time();

		if(isset($entry['visit_date'])){
			$visit_date = $entry['visit_date'];
		}else{
			$visit_date = $entry;
		}

		# 2日前の18時までキャンセル可能
		$month = substr( $visit_date , 0 , 2 );
		$day = substr( $visit_date , 2 , 2 )-2;

		#指定日のタイムスタンプを取得
		$timestamp = mktime(18, 0, 0, $month, $day, EVENT_YEAR);


		if($today - $timestamp < 0){
			return true;
		}else{
			return false;
		}

	}


	/***
	 * unsold_jsonファイル
	 * キャッシュを再作成フラグ判定
	 *
	 * @return DB再読込フラグ
	 */
	private  function  is_json_reload(){

		try
		{
			return Cache::get(JSON_RELOAD);
		}
		catch (\CacheNotFoundException $e)
		{
			Cache::set(JSON_RELOAD, FALSE, 3600 * 24);
			return true;
		}

	}



}




<?php
namespace Model;

use Orm\Model;
use DB;
use Fuel\Core\Log;
use Fuel\Core\Validation;

class Entry extends \Orm\Model
{
	#ENTRY、WINNING、REJECTED、CANCEL
	const Entry = "ENTRY";
	const Winning = "WINNING";
	const Rejected = "REJECTED";
	const Cancel = "CANCEL";

	protected static $_properties = array(
		'id',
		'shop_id',
		'course_id',
		'seat_id',
		'visit_date',
		'visit_time',
		'seat_count',
		'memo',
		'status',
		'shop_cancel_flg',
		'user_name',
		'user_name_kana',
		'user_mail_address',
		'user_phone_number',
		'user_sex',
		'user_age',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
		),
	);

	protected static $_table_name = 'entry';


	public static function get_validation(Validation $val)
	{
		$val->add_callable('\Model\Entry');
		$val->add('seat_count', '来店人数')
				->add_rule('required_select');

		$val->add('visit_time', '来店時間')
			->add_rule( 'required_select');

		$val->add('user_name', 'お名前')
				->add_rule( 'required')
				->add_rule('min_length',2)
				->add_rule( 'name');

		$val->add('user_name_kana', 'お名前（カナ）')
				->add_rule( 'required')
				->add_rule('min_length',2)
				->add_rule('name_kana');

		$val->add('user_mail_address', 'メールアドレス')
				->add_rule( 'required')
				->add_rule('valid_email')
				->add_rule('min_length',5)
				->add_rule('max_length',250);

		$val->add('user_mail_address_confirm', 'メールアドレスの確認')
				->add_rule( 'required')
				->add_rule('valid_email')
				->add_rule('min_length',5)
				->add_rule('max_length',250)
				->add_rule('match_field','user_mail_address');

		$val->add('user_phone_number', '電話番号')
				->add_rule( 'required');

		$val->add('user_sex', '性別')
				->add_rule( 'required_select');

		$val->add('user_age', '年齢')
				->add_rule( 'required_select');

		$val->add('confirm', '注意事項')
				->add_rule('required_confirm');

		return $val;
	}


	public static function _validation_name($val)
	{
		Log::debug("check :  $val");
		mb_regex_encoding("UTF-8");
		if (preg_match("/^[　 ぁ-んァ-ヶーa-zA-Z一-龠、。\n\r]+$/u",$val)) {
			return true;
		}else{
			return false;
		}
	}

	public static function _validation_name_kana($val)
	{
		Log::debug("check :  $val");
		mb_regex_encoding("UTF-8");
		if (preg_match("/^[　 ァ-ヶーｦ-ﾟｰ、。\n\r]+$/u",$val)) {
			return true;
		}else{
			return false;
		}
	}

	public static function _validation_required_confirm($val)
	{

		Log::debug("check _validation_required_confirm :  $val");
		if ($val) {
			return true;
		}
		return false;
	}
	public static function _validation_required_select($val)
	{
		return ! ($val === false or $val === null or $val === '' or $val === array());
	}

	public static function add_entry($entry){
		try{
			# トランザクション開始
			\DB::start_transaction();

			/******
			 追加・更新・削除といったデータ操作処理
			 ******/

			$query = DB::insert('entry');
			$query->columns(array(
					'shop_id',
					'course_id',
					'seat_id',
					'visit_date',
					'visit_time',
					'seat_count',
					'memo',
					'status',
					'shop_cancel_flg',
					'user_name',
					'user_name_kana',
					'user_mail_address',
					'user_phone_number',
					'user_sex',
					'user_age',
					'created_at'
				)
			);

			$query->values(array(
					$entry['shop_id'],
					$entry['course'],
					null,
					$entry['visit_date'],
					$entry['visit_time'],
					$entry['seat_count'],
					$entry['memo'],
					Entry::Entry,
					false,
					$entry['user_name'],
					$entry['user_name_kana'],
					$entry['user_mail_address'],
					$entry['user_phone_number'],
					$entry['user_sex'],
					$entry['user_age'],
					DB::expr('NOW()'),
				)
			);
			$query->execute();


			// SELECT COUNT(*) FROM `users`
			$result = DB::select(DB::expr('MAX(id) as max'))->from('entry')->execute()->current();
			// Get the current/first result
			$entry_id = $result['max'];

			#$entry_id = DB::query('select max(id) as max_id from entry;')->execute();

			# アンケートデータ登録
			$question = Question::get_question_answer($entry);
			$query = DB::insert('question_answer');
			$query->columns(array(
					'question_id',
					'entry_id',
					'item_id',
					'answer',
					'created_at',
				)
			);
			foreach ($question as &$value) {

				$query->values(array($value['question_id'],  $entry_id, $value['question_value_id'] , $value['question_value'] , DB::expr('NOW()') ) );
			}
			$query->execute();


			# トランザクションコミット
			\DB::commit_transaction();
			return $entry_id;
		} catch(Exception $e){
			# トランザクションロールバック
			\DB::rollback_transaction();
			Log::error($e->getMessage());
			return null;
		}
	}


	public static function cancel_entry($entry_id){
		$query = DB::update('entry')
		->value('status', self::Cancel)
		->where('id' , $entry_id)
		->execute();
	}




	public static function update_status_winning($seat_id, $entry_id){
		Log::debug("[update_status_winning] $seat_id / $entry_id");
		$query = DB::update('entry')
		->value('status', self::Winning)
		->value('seat_id', $seat_id)
		->where('id' , $entry_id)
		->execute();
	}

	public static function update_status_reject_all(){
		Log::debug("[update_status_reject_all]");
		$query = DB::update('entry')
		->value('status', self::Rejected)
		->where('id' , $entry_id)
		->execute();
	}


	public static function get_entry_lottery_list($shop_id , $visit_date, $course_type , $count ){
		$status = self::Entry;

		$sql = " SELECT entry.id, entry.shop_id, course.course_type, entry.seat_id, entry.visit_date, entry.visit_time, entry.seat_count, entry.status ";
		$sql .= " FROM entry JOIN course on (entry.course_id = course.id )  ";
		$sql .= " WHERE entry.shop_id = '$shop_id' ";
		$sql .= " AND course.course_type = '$course_type' ";
		$sql .= " AND entry.visit_date = '$visit_date' ";
		$sql .= " AND entry.status = '$status' ";
		$sql .= " AND entry.seat_count = $count ";
		$sql .= " ORDER BY entry.seat_count DESC";

		$query = DB::query($sql);

		// SQLを実行する
		return $query->execute()->as_array();

	}


	public static function get_entry_lottery_seat_over($shop_id , $visit_date, $course_type , $count ){
		$status = self::Entry;

		$sql = " SELECT entry.id, entry.shop_id, course.course_type, entry.seat_id, entry.visit_date, entry.visit_time, entry.seat_count, entry.status ";
		$sql .= " FROM entry JOIN course on (entry.course_id = course.id )  ";
		$sql .= " WHERE entry.shop_id = '$shop_id' ";
		$sql .= " AND course.course_type = '$course_type' ";
		$sql .= " AND entry.visit_date = '$visit_date' ";
		$sql .= " AND entry.status = '$status' ";
		$sql .= " AND entry.seat_count <= $count ";
		$sql .= " ORDER BY entry.seat_count DESC";

		$query = DB::query($sql);

		// SQLを実行する
		return $query->execute()->as_array();

	}


}

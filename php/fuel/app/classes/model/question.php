<?php

namespace Model;

use Orm\Model;
use DB;
use Fuel\Core\Log;
use Fuel\Core\Cache;

class Question extends \Orm\Model
{
	protected static $_properties = array(

		'question_id',
		'question',
		'type',
		'example',
		'display_order',
		'enabled',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_update'),
			'mysql_timestamp' => false,
		),
	);

	protected static $_table_name = 'question';


	/**
	 * アンケート情報を取得
	 * キャッシングを使用
	 */
	public static function get_question_list(){
		try
		{
			$questions = Cache::get('questions');
			Log::debug('[Cache] using Cache Question list');
		}
		catch (\CacheNotFoundException $e)
		{
			Log::debug('[Cache] setup Question list');

			$sql  = " SELECT question.*, group_concat(CONCAT(question_item.id,'_',question_item.text) order by question_item.display_order separator '||') as item ";
			$sql .= " FROM question LEFT OUTER JOIN question_item using (question_id) ";
			$sql .= " GROUP BY question_id ORDER BY question.display_order ";

			$query = DB::query($sql);

			# SQLを実行する
			$questions =  $query->execute()->as_array();

			# アンケート設定
			foreach ($questions as &$value) {
				$options = array();
				if($value['type'] == 'select' ){
					$options['']='選択してください';
					foreach(explode('||',$value['item']) as $option){
						$item =explode('_',$option);
						if(count($item) > 1){
							$options[$item[0]]=$item[1];
						}
					}
				}else if($value['type'] == 'radio' ){
					foreach(explode('||',$value['item']) as $option){
						$item =explode('_',$option);
						if(count($item) > 1){
							$options[$item[0]]=$item[1];
						}
					}

				}else if($value['type'] == 'text' ){
					$options = null;
				}else if($value['type'] == 'textarea' ){
					$options = null;
				}
				$value['options'] = $options;
			}
			Cache::set('questions', $questions, 3600 * 24);
		}

		return $questions;
	}

	/**
	 * アンケート情報と入力情報を組み合わせる
	 */
	public static function get_question_answer($input){
		# アンケート画面表示用情報を取得
		$question = self::get_question_list();
		foreach ($question as &$value) {
			$question_id = 'question'.$value['question_id'];
			$question_value = $input[$question_id];
			$value['question_value_id'] = null;

			if( $question_value === '' ){
				$question_value = '未回答';

			}else if($value['type'] === 'select' or $value['type'] === 'radio' ){
				$question_value = $value['options'][$question_value];
				$value['question_value_id'] = $input[$question_id];
			}
			$value['question_value']=$question_value;
		}

		return $question;
	}
}

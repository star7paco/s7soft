<?php

use Model\MailQueue;
use Model\MailTemplate;
use Fuel\Core\Log;
use \Email;

class MailUtil {


	private static function make_mail($input, $mail_template_id){

		#メールテンプレート取得
		$mail_template = MailTemplate::find( $mail_template_id );
		$mailbody = $mail_template->content;

		#メール情報作成

		$target = array(
		'%user_name%' ,
		'%shop_name%' ,
		'%dis_coures_type%',
		'%coures_name%',
		'%dis_visit_date%',
		'%dis_visit_time%',
		'%seat_count%',
		'%memo%',
		'%user_name_kana%',
		'%user_mail_address%',
		'%user_phone_number%',
		'%order_id%',

		);
		$replace = array(
				isset($input['user_name'])         ? $input['user_name']:'',
				isset($input['shop_name'])         ? $input['shop_name']:'',
				isset($input['dis_course_type'])   ? $input['dis_course_type']:'',
				isset($input['course_name'])       ? $input['course_name']:'',
				isset($input['dis_visit_date'])    ? $input['dis_visit_date']:'',
				isset($input['visit_time'])        ? $input['visit_time']:'',
				isset($input['seat_count'])        ? $input['seat_count']:'',
				isset($input['memo'])              ? $input['memo']:'',
				isset($input['user_name_kana'])    ? $input['user_name_kana']:'',
				isset($input['user_mail_address']) ? $input['user_mail_address']:'',
				isset($input['user_phone_number']) ? $input['user_phone_number']:'',
				isset($input['order_id'])          ? $input['order_id']:'',
		);

		$mailbody = str_replace ( $target, $replace, $mailbody );
		#$mailbody = mb_convert_encoding($mailbody, 'jis');

		$input['subject']   = $mail_template->subject;
		$input['content']   = $mailbody;
		$input['from']      = $mail_template->from_address;
		$input['to']        = $input['user_mail_address'];

		return $input;
	}

	public static function send_cancel_mail($input){
		Log::debug('[MAIL] send_cancel_mail ');

		$input = self::make_mail( $input , 2 );

		$input = self::send_mail($input);
		MailQueue::add_mail( $input);
	}


	public static function send_entry_mail($input){
		Log::debug('[MAIL] send_entry_mail ');

		$input = self::make_mail( $input , 1 );

		$input = self::send_mail($input);
		MailQueue::add_mail( $input);
	}

	public static function send_mail($input){
		Log::debug($input['subject']);
		Log::debug($input['content']);

		$email = Email::forge();

		$email->from($input['from']);
		$email->to($input['to']);
		$email->subject($input['subject']);
		$email->body($input['content']);

		try
		{
			$email->send();

			$input['status'] = MailQueue::SUCCESS;
			#mail_qにデータ追加

		}
		catch(\EmailValidationFailedException $e)
		{
			$input['status'] = MailQueue::ERROR;
			Log::error("[MAIL] EmailValidationFailedException $e" );
			// バリデーションが失敗したとき
		}
		catch(\EmailSendingFailedException $e)
		{

			$input['status'] = MailQueue::FAILURE;
			Log::error("[MAIL] EmailSendingFailedException $e" );
			// ドライバがメールを送信できなかったとき
		}
		return $input;
	}

}


<?php
namespace Model;

use Orm\Model;
use Fuel\Core\DB;

class MailQueue extends \Orm\Model
{

	const WAITING = "W";
	const SUCCESS = "S";
	const FAILURE = "F";
	const ERROR = "E";

	protected static $_properties = array(

		'id',
		'subject',
		'content',
		'from_address',
		'to_address',
		'shop_id',
		'entry_id',
		'status',
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

	protected static $_table_name = 'mail_queue';

	public static function add_mail($email){

		$query = DB::insert('mail_queue');
		$query->columns(array(
				'subject',
				'content',
				'from_address',
				'to_address',
				'shop_id',
				'entry_id',
				'status',
			)
		);

		$query->values(array(

				$email['subject'],
				$email['content'],
				$email['from'],
				$email['to'],



				$email['shop_id'],
				$email['entry_id'],
				$email['status'],
		));

		$query->execute();
	}
}

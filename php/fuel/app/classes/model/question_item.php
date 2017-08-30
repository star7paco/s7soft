<?php
namespace Model;

use Orm\Model;

class Question_Item extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'question_id',
		'text',
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

	protected static $_table_name = 'question_item';

}

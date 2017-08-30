<?php
namespace Model;

use Orm\Model;

class FaxQueue extends \Orm\Model
{
	protected static $_properties = array(

		'id',
		'shop_id',
		'file_path',
		'fax_number',
		'fax_no',
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

	protected static $_table_name = 'fax_queue';

}

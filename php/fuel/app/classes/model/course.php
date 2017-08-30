<?php
namespace Model;

use Orm\Model;

class Course extends \Orm\Model
{
	protected static $_properties = array(

		'id',
		'shop_id',
		'course_type',
		'course_name',
		'course_price',
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

	protected static $_table_name = 'course';
	protected static $_primary_key = array('id');


	public static function get_course_list($shop_id, $course_type){

		$courses = Course::find('all', array(
				'where' => array(
						array('shop_id',     $shop_id),
						array('course_type', $course_type),
						array('enabled', true),

				),
				'order_by' => array('course_price' => 'asc'),
		));
		return $courses;
	}

}

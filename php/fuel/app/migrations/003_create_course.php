<?php

namespace Fuel\Migrations;

class Create_course
{
	public function up()
	{
		\DBUtil::create_table('course', array(
			'id'           => array('constraint' => 11,  'type' => 'int', 'auto_increment'=>true),
			'shop_id'      => array('constraint' => 8, 'type' => 'varchar'),
			'course_type'  => array('constraint' => 255, 'type' => 'varchar'),
			'course_name'  => array('constraint' => 255, 'type' => 'varchar'),
			'course_price' => array('constraint' => 11,  'type' => 'int'),
			'enabled' => array('type' => 'boolean','default'=>true),

        	'updated_at' => array('type' => 'timestamp'),
			'created_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('courses');
	}
}
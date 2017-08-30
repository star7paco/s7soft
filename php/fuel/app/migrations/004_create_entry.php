<?php

namespace Fuel\Migrations;

class Create_entry
{
	public function up()
	{
		\DBUtil::create_table('entry', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment'=>true),
			'shop_id' => array('constraint' => 8, 'type' => 'varchar'),
			'course_id' => array('constraint' => 11, 'type' => 'int'),
			'seat_id' => array('constraint' => 11, 'type' => 'int', 'null' => true),
			'visit_date' => array('constraint' => 4, 'type' => 'varchar'),
			'visit_time' => array('constraint' => 5, 'type' => 'varchar'),
			'seat_count' => array('constraint' => 11, 'type' => 'int'),
			'memo' => array('type' => 'text'),
			'status' => array('constraint' => 8, 'type' => 'varchar'),
			'shop_cancel_flg' => array('type' => 'boolean'),
			'user_name' => array('constraint' => 255, 'type' => 'varchar'),
			'user_name_kana' => array('constraint' => 255, 'type' => 'varchar'),
			'user_mail_address' => array('constraint' => 255, 'type' => 'varchar'),
			'user_phone_number' => array('constraint' => 255, 'type' => 'varchar'),
			'user_sex' => array('constraint' => 255, 'type' => 'varchar'),
			'user_age' => array('constraint' => 255, 'type' => 'varchar'),

			'updated_at' => array('type' => 'timestamp'),
			'created_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('entry');
	}
}
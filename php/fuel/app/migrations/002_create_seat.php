<?php

namespace Fuel\Migrations;

class Create_seat
{
	public function up()
	{
		\DBUtil::create_table('seat', array(
				'id' => array('constraint' => 11, 'type' => 'int' , 'auto_increment'=>true),
				'shop_id' => array('constraint' => 8, 'type' => 'varchar'),
				'visit_date' => array('constraint' => 4, 'type' => 'varchar'),
				'course_type' => array('constraint' => 6, 'type' => 'varchar'),
				'seats_min' => array('constraint' => 11, 'type' => 'int'),
				'seats_max' => array('constraint' => 11, 'type' => 'int'),
				'seats_count' => array('constraint' => 11, 'type' => 'int'),
				'enabled' => array('type' => 'boolean','default'=>true),
				'updated_at' => array('type' => 'timestamp'),
				'created_at' => array('type' => 'timestamp'),


		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('seat');
	}
}
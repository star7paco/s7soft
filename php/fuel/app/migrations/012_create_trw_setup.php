<?php

namespace Fuel\Migrations;

class Create_trw_setup
{
	public function up()
	{
		\DBUtil::create_table('trw_setup', array(
			'id' => array('constraint' => 11, 'type' => 'int' , 'auto_increment'=>true),
			'key' => array('constraint' => 255, 'type' => 'varchar'),
			'value' => array('constraint' => 255, 'type' => 'varchar'),

			'updated_at' => array('type' => 'timestamp'),
			'created_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('trw_setup');
	}
}
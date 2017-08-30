<?php

namespace Fuel\Migrations;

class Create_fax_queue
{
	public function up()
	{
		\DBUtil::create_table('fax_queue', array(
			'id' => array('constraint' => 11, 'type' => 'int' , 'auto_increment'=>true),
			'shop_id' => array('constraint' => 255, 'type' => 'varchar'),
			'file_path' => array('constraint' => 255, 'type' => 'varchar'),
			'fax_number' => array('constraint' => 255, 'type' => 'varchar'),
			'fax_no' => array('constraint' => 255, 'type' => 'varchar'),
			'status' => array('constraint' => 255, 'type' => 'varchar'),


			'updated_at' => array('type' => 'timestamp'),
			'created_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('fax_queue');
	}
}
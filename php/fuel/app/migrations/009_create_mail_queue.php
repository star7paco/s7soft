<?php

namespace Fuel\Migrations;

class Create_mail_queue
{
	public function up()
	{
		\DBUtil::create_table('mail_queue', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment'=>true),
			'subject' => array('constraint' => 255, 'type' => 'varchar'),
			'content' => array('type' => 'text'),
			'from_address' => array('constraint' => 255, 'type' => 'varchar'),
			'to_address' => array('constraint' => 255, 'type' => 'varchar'),
			'shop_id' => array('constraint' => 255, 'type' => 'varchar'),
			'entry_id' => array('constraint' => 11, 'type' => 'int'),
			'status' => array('constraint' => 255, 'type' => 'varchar'),


			'updated_at' => array('type' => 'timestamp'),
			'created_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('mail_queue');
	}
}
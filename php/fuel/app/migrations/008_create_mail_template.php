<?php

namespace Fuel\Migrations;

class Create_mail_template
{
	public function up()
	{
		\DBUtil::create_table('mail_template', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'template_name' => array('constraint' => 255, 'type' => 'varchar'),
			'subject' => array('constraint' => 255, 'type' => 'varchar'),
			'content' => array('type' => 'text'),
			'from_address' => array('constraint' => 255, 'type' => 'varchar'),

			'updated_at' => array('type' => 'timestamp'),
			'created_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('mail_template');
	}
}
<?php

namespace Fuel\Migrations;

class Create_admin_user
{
	public function up()
	{
		\DBUtil::create_table('admin_user', array(
			'id' => array('constraint' => 11, 'type' => 'int' , 'auto_increment'=>true),
			'login_id' => array('constraint' => 255, 'type' => 'varchar'),
			'login_pwd' => array('constraint' => 255, 'type' => 'varchar'),
			'roles' => array('constraint' => 255, 'type' => 'varchar'),
			'enabled' => array('type' => 'boolean'),


			'updated_at' => array('type' => 'timestamp'),
			'created_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('admin_user');
	}
}
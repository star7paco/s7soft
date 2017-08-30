<?php

namespace Fuel\Migrations;

class Create_question_item
{
	public function up()
	{
		\DBUtil::create_table('question_item', array(
			'id' => array('constraint' => 11, 'type' => 'int'),
			'question_id' => array('constraint' => 11, 'type' => 'int'),
			'text' => array('constraint' => 255, 'type' => 'varchar'),
			'display_order' => array('constraint' => 11, 'type' => 'int'),
			'enabled' => array('type' => 'boolean','default'=>true),

			'updated_at' => array('type' => 'timestamp'),
			'created_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('question_item');
	}
}
<?php

namespace Fuel\Migrations;

class Create_question
{
	public function up()
	{
		\DBUtil::create_table('question', array(
			'question_id' => array('constraint' => 11, 'type' => 'int'),
			'question' => array('constraint' => 255, 'type' => 'varchar'),
			'type' => array('constraint' => 255, 'type' => 'varchar'),
			'example' => array('constraint' => 255, 'type' => 'varchar'),
			'display_order' => array('constraint' => 11, 'type' => 'int'),
			'enabled' => array('type' => 'boolean','default'=>true),

			'updated_at' => array('type' => 'timestamp'),
			'created_at' => array('type' => 'timestamp'),

		), array('question_id'));
	}

	public function down()
	{
		\DBUtil::drop_table('question');
	}
}
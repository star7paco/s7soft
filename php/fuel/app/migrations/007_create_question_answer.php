<?php

namespace Fuel\Migrations;

class Create_question_answer
{
	public function up()
	{
		\DBUtil::create_table('question_answer', array(
			'id' => array('constraint' => 11, 'type' => 'int', 'auto_increment'=>true),
			'question_id' => array('constraint' => 11, 'type' => 'int'),
			'entry_id' => array('constraint' => 11, 'type' => 'int'),
			'item_id' => array('constraint' => 11, 'type' => 'int'),
			'answer' => array('constraint' => 255, 'type' => 'varchar'),

			'updated_at' => array('type' => 'timestamp'),
			'created_at' => array('type' => 'timestamp'),

		), array('id'));
	}

	public function down()
	{
		\DBUtil::drop_table('question_answer');
	}
}
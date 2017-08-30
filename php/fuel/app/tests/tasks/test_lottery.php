<?php


use Fuel\Tasks\Lottery;

/**
 * @group unit
 * @group task
 */
class Test_Lottery extends TestCase
{

	protected function setUp()
	{

	}

	public function test_random_lottery()
	{
		# tasksディレクトリの中からTaskOneに対応するファイルを探し、そのパスを取得
		$file = \Finder::search('tasks', strtolower('Lottery'));
		# TaskOneのファイルをロード
		require_once $file;

		$entry_list = array(1,2,3,4,5,6,7,8,9,10);
		$unsold_count = 5;
		$winning_entry = Lottery::lottery_entry_list($entry_list, $unsold_count);
		$this->assertEquals($unsold_count, count($winning_entry));
		$winning_entry = array_unique($winning_entry);
		$this->assertEquals($unsold_count, count($winning_entry));


		$entry_list = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16);
		$unsold_count = 10;
		$winning_entry = Lottery::lottery_entry_list($entry_list, $unsold_count);
		$this->assertEquals($unsold_count, count($winning_entry));
		$winning_entry = array_unique($winning_entry);
		$this->assertEquals($unsold_count, count($winning_entry));


		$entry_list = array(1,2,3,4,5);
		$unsold_count = 4;
		$winning_entry = Lottery::lottery_entry_list($entry_list, $unsold_count);
		$this->assertEquals($unsold_count, count($winning_entry));
		$winning_entry = array_unique($winning_entry);
		$this->assertEquals($unsold_count, count($winning_entry));

	}
}
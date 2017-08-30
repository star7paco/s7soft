<?php

use Model\Entry;
use Fuel\Core\Validation;

/**
 * @group unit
 * @group model
 * @group entry
 */
class Test_Entry extends \TestCase
{


	public function test_entry_validation_check()
	{
		$input = array('hello');

// 		$entry = array(
// 			'seat_count'=>'2',
// 			'visit_time '=> '11:00',
// 			'user_name '=> '漢字　名',
// 			'user_name_kana '=> 'カナ　メイ',
// 			'user_mail_address '=> 'test_email@test.jp',
// 			'user_mail_address_confirm '=> 'test_email@test.jp',
// 			'user_phone_number '=> '00-0000-0000',
// 			'user_sex '=> 'man',
// 			'user_age '=> '50歳以上',
// 			'confirm'=>'true',
// 		);

		$entry = array(
				'seat_count'=>'',
				'visit_time '=> '',
				'user_name '=> '',
				'user_name_kana '=> '',
				'user_mail_address '=> '',
				'user_mail_address_confirm '=> 'test_email@test.jp',
				'user_phone_number '=> '00-0000-0000',
				'user_sex '=> 'man',
				'user_age '=> '50歳以上',
				'confirm'=>'true',
		);


		$val = Validation::forge();
		$val = Entry::get_validation($val);

		#print_r( "Validation1:". var_dump($val));
		$ret = $val->run($entry);
		#print_r( "Validation2:". var_dump($val));

		print_r( "ERROR:". var_dump($val->error()));

		$this->assertThat( $ret , $this->equalTo(FALSE) );
		$this->assertThat( $val->error()['seat_count'], $this->equalTo('seat_count') );



		$entry = array(
				'seat_count'=>'',
				'visit_time '=> '11:00',
				'user_name '=> '漢字　名',
				'user_name_kana '=> 'カナ　メイ',
				'user_mail_address '=> 'test_email@test.jp',
				'user_mail_address_confirm '=> 'test_email@test.jp',
				'user_phone_number '=> '00-0000-0000',
				'user_sex '=> 'man',
				'user_age '=> '50歳以上',
				'confirm'=>'true',
		);
		$val = Validation::forge();
		$val = Entry::get_validation($val);
		$this->assertFalse($val->run());

		$error = $val->error();
		$this->assertTrue(isset($error));

		$this->assertThat($error['seat_count'] ,
				$this->equalTo('・未入力です')
				);

	}

	public function test_Equals()
    {
    	$this->assertTrue(true);


    }

    public function test_validation_valid_string_numeric_success()
    {
    	$this->assertTrue(true);
    }



}
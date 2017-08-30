<?php

/**
 * @group unit
 * @group util
 * @group entry
 */
class Test_ParameterUtil extends TestCase
{



	public function test_input_paramater()
	{


		$entry_id = ParameterUtil::decode( 'NGZSNg==' );
		$this->assertThat('6',  $this->equalTo($entry_id));

		$entry_id = ParameterUtil::decode( 'NGZSNw==' );
		$this->assertThat('7',  $this->equalTo($entry_id));


		$entry_id = ParameterUtil::encode( '1001');
		$this->assertThat('NGZSMTAwMQ==',  $this->equalTo($entry_id));


		$entry_id = ParameterUtil::encode( '1002');
		$this->assertThat('NGZSMTAwMg==',  $this->equalTo($entry_id));

	}

}
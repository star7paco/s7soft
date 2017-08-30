<?php

/**
 * The welcome hello presenter.
*
* @package  app
* @extends  Presenter
*/
class Presenter_Entry_Input extends Presenter
{

	public static  $age_values = array(
			''=>'選択してください',
			'20歳～24歳'=>'20歳～24歳',
			'25歳～29歳'=>'25歳～29歳',
			'30歳～34歳'=>'30歳～34歳',
			'35歳～39歳'=>'35歳～39歳',
			'40歳～44歳'=>'40歳～44歳',
			'45歳～49歳'=>'45歳～49歳',
			'50歳以上'=>'50歳以上',
	);

	/**
	 * Prepare the view data, keeping this in here helps clean up
	 * the controller.
	 *
	 * @return void
	 */
	public function view()
	{
		$this->test = 'test';
		$this->age_value = $age_values;
	}
}

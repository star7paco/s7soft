<?php

/**
 * The welcome hello presenter.
*
* @package  app
* @extends  Presenter
*/
class Presenter_Admin_Login extends Presenter
{
	/**
	 * Prepare the view data, keeping this in here helps clean up
	 * the controller.
	 *
	 * @return void
	 */
	public function view()
	{
		$this->title = 'ログイン';
	}
}

<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.8
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2016 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Admin extends Controller
{
	/**
	 * The basic welcome message
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_login()
	{

		$user = Session::get('admmin_user');

// 		if($user != null){
// 			$view = View::forge('admin/top');
// 		}

		// ビューを作成
		$view = View::forge('admin/login');

		// ビューに渡す変数を割り当てる
		// ビューに渡す変数を割り当てる別の方法
		//$view->set('username', 'Joe14');
		$view->set('title', 'ログイン');




			//既にログイン済みであればブログトップページにリダイレクト
			Auth::check() and Response::redirect('article');

			//ビューに渡す配列の初期化
			$data = array();

			//Auth_Login_Driverクラスのインスタンスの作成
			$auth = Auth::instance();
			//usernameとpasswordがPOSTされている場合は認証を試みる
			if (Input::post('username') and Input::post('password')) {
				$username = Input::post('username');
				$password = Input::post('password');
				$auth = Auth::instance();

				//認証
				if ($auth->login($username, $password)) {

					//ブログトップにリダイレクト
					Response::redirect('article');
				} else {
					//認証失敗時にはビューに$errorをセットする
					$data['error'] = true;
				}
			}
			//usernameとpasswordのいずれか一方でも送信されていない場合
			//および認証に失敗した場合はログインフォームを表示
			//ビューの読み込み
			$this->template->title = 'ログイン';
			$this->template->content = View::forge('admin/');

			// ブラウザに出力するビューを割り当てる
			return $view;


	}

	public function action_Logout()
	{
		Session::set('admmin_user', null);
		// ビューを作成
		$view = View::forge('admin/login');
		$view->set('title', 'ログイン');
		return $view;

	}


	/**
	 * A typical "Hello, Bob!" type example.  This uses a Presenter to
	 * show how to use them.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_top()
	{
		return Response::forge(Presenter::forge('admin/top'));
	}


}

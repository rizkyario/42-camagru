<?php

class Account extends Controller
{
	protected $view;

	public function __construct()
	{
		parent::__construct();
	}

	public function index($username = '')
	{
		if ($this->user !== NULL && $username == '')
			$username = $this->user->username;
		if ($username == '')
			$this->redirect('/account/login');
		$photos = Photo::find(array('user' => $username));
		$this->view = $this->view('photos/index', array('photos' => $photos));
		$this->view->render();
	}

	public function login()
	{
		if ($this->method === 'POST')
		{
			$user = User::Login($_POST['username'], $_POST['password']);
			if ($user instanceof User)
			{
				$_SESSION['user'] = serialize($user);
				$this->redirect('/');
			}
		}
		$this->view('account/login')->render();
	}

	public function register()
	{
		$this->view('account/register')->render();
	}

	public function logout()
	{
		unset($_SESSION['user']);
		$this->redirect('/');
	}
}

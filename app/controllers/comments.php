<?php

class Comments extends Controller
{
	protected $view;

	public function __construct()
	{
		parent::__construct();
	}

	public function delete()
	{
		if (!isset($_POST['comment']))
			$this->redirect('/');
		$comment = new Comment(array('id' => $_POST['comment']));
		$comment->delete();
		echo 'OK';
	}

	public function insert()
	{
		if (!isset($_POST['comment']) || !isset($_POST['user']) || !isset($_POST['photo']))
			$this->redirect('/');
		$user = USER::get(array('username' => $_POST['user']));
		$photo = Photo::get(array ('id' => $_POST['photo']));
		$user->insert_comment($photo, $_POST['comment']);
	}
}

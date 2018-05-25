<?php

class Like
{
	public $id;
	public $user;
	public $photo;

	public function __construct(array $params = [])
	{
		array_key_exists('user', $params) ? $this->user = $params['user'] : 0;
		array_key_exists('photo', $params) ? $this->photo = $params['photo'] : 0;
	}

	public function delete()
	{
		$like = ORM::getInstance()->findOne('like', array('id' => $this->id));
		if ($like instanceof Like)
			return ORM::getInstance()->delete_s('like', $like->id);
		return false;
	}
	static public function get(array $params=[])
	{
		$like = ORM::getInstance()->findOne('like', $params);
		if ($like instanceof Like)
			return ($like);
		else
			return (NULL);
		return (NULL);
	}

	public function insert(User $user, $photo)
	{
		$this->user = $user->username;
		if ($photo instanceof Photo)
			$this->photo = $photo->id;
		else
			$this->photo = $photo['id'];
		$like = Like::get(array('photo' => $this->photo, 'user' => $this->user));
		if ($like == NULL)
			$this->id = ORM::getInstance()->store('like', get_object_vars($this));
		else
		{
			$this->id = $like->id;
			if ($like->user != $user->username)
				$this->id = ORM::getInstance()->store('like', get_object_vars($this));
			else
				$this->delete();
		}
	}

	static public function find(array $params = [])
	{
		$likes = ORM::getInstance()->findAll('like', $params, array('createdAt', 'ASC'), []);
		return $likes;
	}

	static public function ownedBy($user)
	{
		if (isset($_SESSION['user']))
			$current_user = unserialize($_SESSION['user']);
		return 	($user != $current_user->username) ? 'hidden' : 'show';
	}
}
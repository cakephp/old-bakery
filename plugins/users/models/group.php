<?php
class Group extends UsersAppModel {
	public $useDbConfig = 'user_plug';

	const GUESTS = 0;
	const USERS = 10;
	const AUTHORS = 20;
	const MODERATORS = 50;
	const EDITORS = 60;
	const COREDEVS = 80;
	const ADMINS = 100;
		
	public $hasMany = array(
		'Users.User'
	);
}
?>
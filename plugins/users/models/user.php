<?php
class User extends UsersAppModel {
	public $belongsTo = array(
		'Users.Group'
	);
}
?>
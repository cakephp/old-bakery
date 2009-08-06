<?php
App::import('Model', 'Group');
$config['App']['permissions'] = array(
    'Pages' => array(
        'display'        => Group::GUESTS,
    ),
    'Users.Users' => array(
        'logout'         => Group::GUESTS,
	'index'          => Group::USERS
    ),
    'Users.Messages' => array(
        'send'           => Group::USERS,
    ),
    'Users.Conversations' => array(
        'index'           => Group::USERS,
    ),
    'DebugKit.ToolbarAccess' => array(
        'history_state'  => Group::GUESTS
    )
);
?>
<?php
App::import('Model', 'Users.Group');
$config['App']['permissions'] = array(
    'Pages' => array(
        'display'        => Group::GUESTS,
    ),
    'Users.Users' => array(
        'logout'        => Group::GUESTS,
    ),
    'DebugKit.ToolbarAccess' => array(
        'history_state' => Group::GUESTS
    )
);
?>
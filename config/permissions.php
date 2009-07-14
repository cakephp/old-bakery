<?php
App::import('Model', 'Users.Group');
$config['App']['permissions'] = array(
    'Users.Users' => array(
        'logout'        => Group::GUESTS,
    ),
    'DebugKit.ToolbarAccess' => array(
        'history_state' => Group::GUESTS
    )
);
?>
<?php
echo $form->create('User', array('url' => array('plugin' => 'users', 'controller' => 'users', 'action' => 'login', 'admin' => false)));
echo $form->inputs(array(
	$authFields['username'] => array('label' => __('Username', true)),
	$authFields['password'] => array('label' => __('Password', true)),
	'remember' => array('type' => 'checkbox', 'label' => __('Remember me', true)),
	'legend' => __('Login', true)
));
echo $form->end(__('Login', true));
?>
<?php 
echo $form->create('Message', array('url' => '/' . $this->params['url']['url']));
echo $form->inputs(array(
	'legend' => sprintf(__('Message to %s', true), $recipientName),
	'Conversation.title',
	'Message.message'
));
echo $form->end(__('Send', true));
?>
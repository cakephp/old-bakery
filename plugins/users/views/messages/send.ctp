<?php 
echo $form->create('Message', array('url' => '/' . $this->params['url']['url']));
$inputs = array();
if (empty($this->params['named']['conversation'])) {
	$inputs['legend'] = sprintf(__('Message to %s', true), $recipientName);
	$inputs[] = 'Conversation.title';
} else {
	$inputs['legend'] = __('New reply', true);
}

$inputs[] = 'Message.message';
echo $form->inputs($inputs);
echo $form->end(__('Send', true));
?>
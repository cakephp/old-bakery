<h2><?php __('Conversation'); ?></h2>
<h3><?php echo $conversation['Conversation']['title']; ?></h3>

<?php echo $this->element('paging'); ?>
	<?php foreach ($messages as $message) : ?>
	<div class="conversationMessage">
		<div class="username"><?php echo $message['User']['username']; ?></div>
		<div class="textmessage"><?php echo $message['Message']['message']; ?></div>
		<div class="created"><?php echo $message['Message']['created']; ?></div>
	</div>
	<?php endforeach; ?>
<?php echo $this->element('paging'); ?>
<?php echo $html->link(__('Reply', true), array('plugin' => 'users', 'controller' => 'messages', 'action' => 'send', 'conversation' => $conversation['Conversation']['id'])); ?>
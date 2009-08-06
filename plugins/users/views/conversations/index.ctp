<h2><?php __('Personal mailbox'); ?></h2>
<?php if (!empty($conversations)) : ?>
	<?php echo $this->element('paging'); ?>
	<table>
		<tr>
			<th><?php echo $paginator->sort(__('#', true), 'Conversation.id'); ?></th>
			<th><?php echo $paginator->sort(__('Title', true), 'Conversation.title'); ?></th>
			<th><?php echo $paginator->sort(__('Date', true), 'ConversationsUser.modified'); ?></th>
			<th>&nbsp;</th>
			<th>&nbsp;</th>
		</tr>
		<?php foreach ($conversations as $conversation) : ?>
		<tr class="<?php echo ($conversation['ConversationsUser']['new'] == true) ? 'new' : 'old'; ?>">
			<td><?php echo $conversation['Conversation']['id']; ?></td>
			<td><?php echo $conversation['Conversation']['title']; ?></td>
			<td><?php echo $conversation['ConversationsUser']['modified']; ?></td>
			<td><?php echo ($conversation['ConversationsUser']['new'] == true) ? 'mark as read' : '&nbsp'; ?></td>
			<td>read</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php echo $this->element('paging'); ?>
<?php else : ?>
	<em><?php __('No messages found.'); ?></em>
<?php endif; ?>
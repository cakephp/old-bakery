<h2><?php __('Memberlist'); ?></h2>

<?php 
	echo $form->create('User', array('url' => array('action' => 'search')));
	echo $form->inputs(array(
		'legend' => __('Search user', true),
		'keyword' => array('default' => !empty($this->params['named']['keyword']) ? $this->params['named']['keyword'] : null)
	));
	echo $form->end(__('Search', true));
?>

<?php if (!empty($users)) : ?>
	<?php $paginator->options(array('url' => $this->passedArgs)); ?>
	<?php echo $this->element('paging'); ?>
	<table>
		<tr>
			<th><?php echo $paginator->sort(__('#', true), 'User.id'); ?></th>
			<th><?php echo $paginator->sort(__('Username', true), 'User.username'); ?></th>
			<th><?php echo $paginator->sort(__('Last login', true), 'User.last_login'); ?></th>
			<th><?php echo $paginator->sort(__('Registered', true), 'User.created'); ?></th>
			<th>&nbsp;</th>
		</tr>
		<?php foreach ($users as $user) : ?>
		<tr>
			<td><?php echo $user['User']['id']; ?></td>
			<td><?php echo $user['User']['username']; ?></td>
			<td><?php echo $user['User']['last_login']; ?></td>
			<td><?php echo $user['User']['created']; ?></td>
			<td>Send message (not yet implemented)</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php echo $this->element('paging'); ?>
<?php else : ?>
	<em><?php __('No users found.'); ?></em>
<?php endif; ?>
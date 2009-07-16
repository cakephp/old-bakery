<div class="tags view">
<h2><?php  __('Tag');?></h2>
	<dl>
		<dt><?php __('Id'); ?></dt>
		<dd>
			<?php echo $tag['Tag']['id']; ?>
			&nbsp;
		</dd>
		<dt><?php __('Linked'); ?></dt>
		<dd>
			<?php echo $tag['Tag']['linked']; ?>
			&nbsp;
		</dd>
		<dt><?php __('Name'); ?></dt>
		<dd>
			<?php echo $tag['Tag']['name']; ?>
			&nbsp;
		</dd>
		<dt><?php __('Keyname'); ?></dt>
		<dd>
			<?php echo $tag['Tag']['keyname']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php
	$menu->add('context',array(__('Edit Tag', true), array('action'=>'edit', $tag['Tag']['id'])));
	$menu->add('context',array(__('Delete Tag', true), array('action'=>'delete', $tag['Tag']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $tag['Tag']['id'])));
	$menu->add('context',array(__('List Tags', true), array('action'=>'index')));
	$menu->add('context',array(__('New Tag', true), array('action'=>'add')));
	$menu->add('context',array(__('List Articles', true), array('controller'=> 'articles', 'action'=>'index')));
	$menu->add('context',array(__('New Article', true), array('controller'=> 'articles', 'action'=>'add')));
?>
<div class="related">
	<h3><?php __('Related Articles');?></h3>
	<?php if (!empty($tag['Article'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Parent Id'); ?></th>
		<th><?php __('Lang'); ?></th>
		<th><?php __('Slug'); ?></th>
		<th><?php __('Category Id'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Rate Count'); ?></th>
		<th><?php __('Rate Sum'); ?></th>
		<th><?php __('Viewed'); ?></th>
		<th><?php __('Title'); ?></th>
		<th><?php __('Comment Count'); ?></th>
		<th><?php __('Article Page Count'); ?></th>
		<th><?php __('Published'); ?></th>
		<th><?php __('Published Date'); ?></th>
		<th><?php __('Deleted'); ?></th>
		<th><?php __('Deleted Date'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($tag['Article'] as $article):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $article['id'];?></td>
			<td><?php echo $article['parent_id'];?></td>
			<td><?php echo $article['lang'];?></td>
			<td><?php echo $article['slug'];?></td>
			<td><?php echo $article['category_id'];?></td>
			<td><?php echo $article['user_id'];?></td>
			<td><?php echo $article['rate_count'];?></td>
			<td><?php echo $article['rate_sum'];?></td>
			<td><?php echo $article['viewed'];?></td>
			<td><?php echo $article['title'];?></td>
			<td><?php echo $article['comment_count'];?></td>
			<td><?php echo $article['article_page_count'];?></td>
			<td><?php echo $article['published'];?></td>
			<td><?php echo $article['published_date'];?></td>
			<td><?php echo $article['deleted'];?></td>
			<td><?php echo $article['deleted_date'];?></td>
			<td><?php echo $article['created'];?></td>
			<td><?php echo $article['modified'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'articles', 'action'=>'view', $article['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'articles', 'action'=>'edit', $article['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'articles', 'action'=>'delete', $article['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $article['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Article', true), array('controller'=> 'articles', 'action'=>'add'));?> </li>
		</ul>
	</div>
</div>

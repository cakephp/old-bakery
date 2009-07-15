<div class="articles index">
<h2><?php __('Articles');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('parent_id');?></th>
	<th><?php echo $paginator->sort('lang');?></th>
	<th><?php echo $paginator->sort('slug');?></th>
	<th><?php echo $paginator->sort('category_id');?></th>
	<th><?php echo $paginator->sort('user_id');?></th>
	<th><?php echo $paginator->sort('rate_count');?></th>
	<th><?php echo $paginator->sort('rate_sum');?></th>
	<th><?php echo $paginator->sort('viewed');?></th>
	<th><?php echo $paginator->sort('title');?></th>
	<th><?php echo $paginator->sort('comment_count');?></th>
	<th><?php echo $paginator->sort('article_page_count');?></th>
	<th><?php echo $paginator->sort('published');?></th>
	<th><?php echo $paginator->sort('published_date');?></th>
	<th><?php echo $paginator->sort('deleted');?></th>
	<th><?php echo $paginator->sort('deleted_date');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 1;
foreach ($articles as $article):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $article['Article']['id']; ?>
		</td>
		<td>
			<?php echo $html->link($article['Parent']['title'], array('controller'=> 'articles', 'action'=>'view', $article['Parent']['id'])); ?>
		</td>
		<td>
			<?php echo $article['Article']['lang']; ?>
		</td>
		<td>
			<?php echo $article['Article']['slug']; ?>
		</td>
		<td>
			<?php echo $html->link($article['Category']['name'], array('controller'=> 'categories', 'action'=>'view', $article['Category']['id'])); ?>
		</td>
		<td>
			<?php echo $html->link($article['User']['id'], array('controller'=> 'users', 'action'=>'view', $article['User']['id'])); ?>
		</td>
		<td>
			<?php echo $article['Article']['rate_count']; ?>
		</td>
		<td>
			<?php echo $article['Article']['rate_sum']; ?>
		</td>
		<td>
			<?php echo $article['Article']['viewed']; ?>
		</td>
		<td>
			<?php echo $html->link($article['Article']['title'], array('action'=>'view', $article['Article']['id'])); ?>
		</td>
		<td>
			<?php echo $article['Article']['comment_count']; ?>
		</td>
		<td>
			<?php echo $article['Article']['article_page_count']; ?>
		</td>
		<td>
			<?php echo $article['Article']['published']; ?>
		</td>
		<td>
			<?php echo $article['Article']['published_date']; ?>
		</td>
		<td>
			<?php echo $article['Article']['deleted']; ?>
		</td>
		<td>
			<?php echo $article['Article']['deleted_date']; ?>
		</td>
		<td>
			<?php echo $article['Article']['created']; ?>
		</td>
		<td>
			<?php echo $article['Article']['modified']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $article['Article']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $article['Article']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $article['Article']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<?php
	$menu->add('context',array(__('New Article', true), array('action'=>'add')));
	$menu->add('context',array(__('List Articles', true), array('controller'=> 'articles', 'action'=>'index')));
	$menu->add('context',array(__('List Categories', true), array('controller'=> 'categories', 'action'=>'index')));
	$menu->add('context',array(__('List Users', true), array('controller'=> 'users', 'action'=>'index')));
	$menu->add('context',array(__('List Article Pages', true), array('controller'=> 'article_pages', 'action'=>'index')));
?>


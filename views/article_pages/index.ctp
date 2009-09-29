<div class="articlePages index">
<h2><?php __('ArticlePages');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('page_number');?></th>
	<th><?php echo $paginator->sort('title');?></th>
	<th><?php echo $paginator->sort('content');?></th>
	<th><?php echo $paginator->sort('article_id');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 1;
foreach ($articlePages as $articlePage):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $articlePage['ArticlePage']['page_number']; ?>
		</td>
		<td>
			<?php echo $articlePage['ArticlePage']['title']; ?>
		</td>
		<td>
			<?php echo $articlePage['ArticlePage']['content']; ?>
		</td>
		<td>
			<?php echo $html->link($articlePage['Article']['title'], array('controller' => 'articles', 'action' => 'view', $articlePage['ArticlePage']['article_id'])); ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $articlePage['ArticlePage']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $articlePage['ArticlePage']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $articlePage['ArticlePage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $articlePage['ArticlePage']['id'])); ?>
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
	$menu->add('context',array(__('Articles', true), array('controller'=>'articles', 'action'=>'index')));

?>
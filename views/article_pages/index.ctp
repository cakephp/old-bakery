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
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('article_id');?></th>
	<th><?php echo $paginator->sort('title');?></th>
	<th><?php echo $paginator->sort('pagenum');?></th>
	<th><?php echo $paginator->sort('content');?></th>
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
			<?php echo $articlePage['ArticlePage']['id']; ?>
		</td>
		<td>
			<?php echo $articlePage['ArticlePage']['article_id']; ?>
		</td>
		<td>
			<?php echo $html->link($articlePage['ArticlePage']['title'], array('action'=>'view', $articlePage['ArticlePage']['id'])); ?>
		</td>
		<td>
			<?php echo $articlePage['ArticlePage']['pagenum']; ?>
		</td>
		<td>
			<?php echo $articlePage['ArticlePage']['content']; ?>
		</td>
		<td class="actions">
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


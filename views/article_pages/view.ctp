<div class="articlePages view">
<h2><?php  __('ArticlePage');?></h2>
	<dl>
		<dt><?php __('Id'); ?></dt>
		<dd>
			<?php echo $articlePage['ArticlePage']['id']; ?>
			&nbsp;
		</dd>
		<dt><?php __('Article Id'); ?></dt>
		<dd>
			<?php echo $articlePage['ArticlePage']['article_id']; ?>
			&nbsp;
		</dd>
		<dt><?php __('Title'); ?></dt>
		<dd>
			<?php echo $articlePage['ArticlePage']['title']; ?>
			&nbsp;
		</dd>
		<dt><?php __('page_number'); ?></dt>
		<dd>
			<?php echo $articlePage['ArticlePage']['page_number']; ?>
			&nbsp;
		</dd>
		<dt><?php __('Content'); ?></dt>
		<dd>
			<?php echo $articlePage['ArticlePage']['content']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php
	$menu->add('context',array(__('Edit ArticlePage', true), array('action'=>'edit', $articlePage['ArticlePage']['id'])));
	$menu->add('context',array(__('Delete ArticlePage', true), array('action'=>'delete', $articlePage['ArticlePage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $articlePage['ArticlePage']['id'])));
	$menu->add('context',array(__('List ArticlePages', true), array('action'=>'index')));
	$menu->add('context',array(__('New ArticlePage', true), array('action'=>'add')));
?>

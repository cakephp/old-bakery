<div class="articles view">
<h2><?php echo $article['Article']['title']; ?></h2>
	<dl>
		<?php if (!empty($article['Parent']['title'])) : ?>
		<dt><?php __('Original Article'); ?></dt>
		<dd>
			<?php echo $html->link($article['Parent']['title'], array('controller'=> 'articles', 'action'=>'view', $article['Parent']['id'])); ?>
			&nbsp;
		</dd>
		<?php endif; ?>
		<dt><?php __('Lang'); ?></dt>
		<dd>
			<?php echo $article['Article']['lang']; ?>
			&nbsp;
		</dd>
		<dt><?php __('Category'); ?></dt>
		<dd>
			<?php echo $html->link($article['Category']['name'], array('controller'=> 'categories', 'action'=>'view', $article['Category']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php __('User'); ?></dt>
		<dd>
			<?php echo $html->link($article['User']['username'], array('controller'=> 'users', 'action'=>'view', $article['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php __('Rated'); ?></dt>
		<dd>
			<?php echo $article['Article']['rate_sum'] . $article['Article']['rate_count'] ; ?>
			&nbsp;
		</dd>
		<dt><?php __('Viewed'); ?></dt>
		<dd>
			<?php echo $article['Article']['viewed']; ?>
			&nbsp;
		</dd>
		<dt><?php __('Comments'); ?></dt>
		<dd>
			<?php echo $article['Article']['comment_count']; ?>
			&nbsp;
		</dd>
		<dt><?php __('Pages'); ?></dt>
		<dd>
			<?php echo $article['Article']['article_page_count']; ?>
			&nbsp;
		</dd>
		<dt><?php __('Published'); ?></dt>
		<dd><?php
			if ($article['Article']['published'])
				echo $article['Article']['published_date'];
			else 
				__('Unpublished');
		?> &nbsp;
		</dd>
		<dt><?php __('Tags'); ?></dt>
		<dd><?php $tags = '';
			foreach ($article['Tag'] as $tag) {
				$tags .= $tag['name'].', ';
			}
			echo substr($tags, 0, -2);
		?>	&nbsp;
		</dd>
		<dt><?php __('Intro'); ?></dt>
		<dd>
			<?php echo $article['Intro']['content']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<?php
	$menu->add('context',array(__('Edit Article', true), array('action'=>'edit', $article['Article']['id'])));

	if ($article['Article']['published'])
		$menu->add('context',array(__('Unpublish Article', true), array('action'=>'unpublish', $article['Article']['id'])));
	else
		$menu->add('context',array(__('Publish Article', true), array('action'=>'publish', $article['Article']['id'])));

	$menu->add('context',array(__('Delete Article', true), array('action'=>'delete', $article['Article']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $article['Article']['id'])));
	$menu->add('context',array(__('List Articles', true), array('controller'=> 'articles', 'action'=>'index')));
	$menu->add('context',array(__('List Categories', true), array('controller'=> 'categories', 'action'=>'index')));
?>
<div class="related">
	<h3><?php __('Article Pages');?></h3>
	<?php if (!empty($article['ArticlePage'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Page Number'); ?></th>
		<th><?php __('Title'); ?></th>
		<th><?php __('Content'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($article['ArticlePage'] as $articlePage):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $articlePage['page_number'];?></td>
			<td><?php echo $articlePage['title'];?></td>
			<td><?php echo $articlePage['content'];?></td>
			<td class="actions">
				<?php echo $html->link(__('View', true), array('controller'=> 'article_pages', 'action'=>'view', $articlePage['id'])); ?>
				<?php echo $html->link(__('Edit', true), array('controller'=> 'article_pages', 'action'=>'edit', $articlePage['id'])); ?>
				<?php echo $html->link(__('Delete', true), array('controller'=> 'article_pages', 'action'=>'delete', $articlePage['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $articlePage['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $html->link(__('New Article Page', true), array('controller'=> 'article_pages', 'action'=>'add', $article['Article']['id']));?> </li>
		</ul>
	</div>
</div>
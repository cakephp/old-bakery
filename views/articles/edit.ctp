<div class="articles form">
<?php
    echo $form->create('Article');
    echo $form->inputs(array('fieldset' => false,
			'id',
			'parent_id',
			'lang',
			'slug',
			'category_id',
			'user_id',
			'rate_count',
			'rate_sum',
			'viewed',
			'title',
			'comment_count',
			'article_page_count',
			'published',
			'published_date',
			'deleted',
			'deleted_date',
	));
    echo $form->end('Submit');?>
</div>
<?php
	$menu->add('context',array(__('Delete', true), array('action'=>'delete', $form->value('Article.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Article.id'))));
	$menu->add('context',array(__('List Articles', true), array('action'=>'index')));
	$menu->add('context',array(__('List Articles', true), array('controller'=> 'articles', 'action'=>'index')));
	$menu->add('context',array(__('List Categories', true), array('controller'=> 'categories', 'action'=>'index')));
	$menu->add('context',array(__('List Users', true), array('controller'=> 'users', 'action'=>'index')));
	$menu->add('context',array(__('List Article Pages', true), array('controller'=> 'article_pages', 'action'=>'index')));
?>

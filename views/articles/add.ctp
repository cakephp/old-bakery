<div class="articles form">
<?php
    echo $form->create('Article');
    echo $form->inputs(array('fieldset' => false,
			'parent_id' => array('empty' => __('Opiontally select parent article',true)),
		//	'lang',
		//	'slug',
			'category_id',
		//	'user_id',
		//	'rate_count',
		//	'rate_sum',
		//	'viewed',
			'title',
		//	'comment_count',
		//	'article_page_count',
		//	'published',
		//	'published_date',
		//	'deleted',
		//	'deleted_date',
		'tags',
		'Intro.content'
	));
    echo $form->end('Submit');?>
</div>
<?php
	$menu->add('context',array(__('List Articles', true), array('action'=>'index')));
	$menu->add('context',array(__('List Categories', true), array('controller'=> 'categories', 'action'=>'index')));
#	$menu->add('context',array(__('List Users', true), array('controller'=> 'users', 'action'=>'index')));
#	$menu->add('context',array(__('List Article Pages', true), array('controller'=> 'article_pages', 'action'=>'index')));
?>

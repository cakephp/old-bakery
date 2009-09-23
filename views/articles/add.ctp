<div class="articles form">
<?php
    echo $form->create('Article');
    echo $form->inputs(array('fieldset' => false,
		'title',
		'tags',
		'category_id',
		'parent_id' => array('empty' => __('Opiontally select parent article',true)),
		'lang',
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

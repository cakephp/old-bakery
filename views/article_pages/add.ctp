<div class="articlePages form">
<?php
    echo $form->create('ArticlePage');
    echo $form->inputs(array('fieldset' => false,
			'title',
			'content',
	));
    echo $form->end('Submit');?>
</div>
<?php
	$menu->add('context',array(__('List ArticlePages', true), array('action'=>'index')));
?>

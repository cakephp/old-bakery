<div class="articlePages form">
<?php
    echo $form->create('ArticlePage');
    echo $form->inputs(array('fieldset' => false,
			'id',
			'article_id',
			'title',
			'page_number',
			'content',
	));
    echo $form->end('Submit');?>
</div>
<?php
	$menu->add('context',array(__('Delete', true), array('action'=>'delete', $form->value('ArticlePage.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('ArticlePage.id'))));
	$menu->add('context',array(__('List ArticlePages', true), array('action'=>'index')));
?>

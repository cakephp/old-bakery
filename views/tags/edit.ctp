<div class="tags form">
<?php
    echo $form->create('Tag');
    echo $form->inputs(array('fieldset' => false,
			'id',
			'linked',
			'name',
			'keyname',
			'Article',
	));
    echo $form->end('Submit');?>
</div>
<?php
	$menu->add('context',array(__('Delete', true), array('action'=>'delete', $form->value('Tag.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Tag.id'))));
	$menu->add('context',array(__('List Tags', true), array('action'=>'index')));
	$menu->add('context',array(__('List Articles', true), array('controller'=> 'articles', 'action'=>'index')));
?>

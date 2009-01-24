<div class="form"><fieldset><legend><?php echo __('Edit field',true); ?></legend>
<?php
	echo $form->create('DummyField');
	echo $form->inputs(array('fieldset'=>false,
		'id',
		'field_type' => array('type'=>'hidden'),
		'tablename' => array('type'=>'hidden'),
		'custom_variable',
	));
	switch ($this->data['DummyField']['type']) {
		case 'Date':
			echo $form->inputs(array('fieldset'=>false,
				'DummyField.custom_min' => array('type'=>'date','dateFormat'=>'DMY'),
				'DummyField.custom_max' => array('type'=>'date','dateFormat'=>'DMY')
			));
		break;	
		case 'DateTime':
			echo $form->inputs(array('fieldset'=>false,
				'custom_min' => array('type'=>'datetime', 'timeFormat' => 24),
				'custom_max' => array('type'=>'datetime', 'timeFormat' => 24)
			));
		break;	
		case 'Time':
			echo $form->inputs(array('fieldset'=>false,
				'custom_min' => array('type'=>'time', 'timeFormat' => 24),
				'custom_max' => array('type'=>'time', 'timeFormat' => 24)
			));
		break;		
		default:
			echo $form->inputs(array('fieldset'=>false,
				'custom_min',
				'custom_max'
			));
		break;
	}
	echo $form->end('Update');
	
	$menu->add('context', array('Back', array('action'=>'index',$this->data['DummyField']['tablename'])));
?>
</fieldset>
</div>
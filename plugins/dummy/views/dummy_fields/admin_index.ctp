<?php 
	// debug($data);
	
	$menu->add('context', array('Back', array('controller'=>'dummy_tables','action'=>'index','admin'=>true,'plugin'=>'dummy')));
	if ($editable) {
	    $menu->add('context',array(
	        'Reanalyze table', 
	         array('controller'=>'dummy_tables','action'=>'analyze',$table)
	    ));
	} 
	$menu->add('context',array(
        'Empty data', 
         array('controller'=>'dummy_tables','action'=>'truncate',$table),
         array(),
         __('Are you sure?',true),
    ));	
    

	$menu->add('context', array('Generate', array('controller'=>'dummy_tables','action'=>'generate',$table,'admin'=>true,'plugin'=>'dummy')));
	
?>
<div class="dummyFields index">
<h2><?php echo $table;?></h2>
<h4>Active</h4>
<table cellpadding="0" cellspacing="0">
	<tr>
		<th><?php __('name');?></th>
		<th><?php __('type');?></th>
		<th><?php __('allow_null');?></th>
		<th><?php __('default');?></th>
		<th><?php __('custom_min');?></th>
		<th><?php __('custom_max');?></th>
		<th><?php __('custom_var');?></th>
<?php if ($editable) {	?>
		<th class="actions"><?php __('Actions');?></th>
<?php } ?>
	</tr>
<?php
$i = 1;
foreach ($data as $dummyField):
	$class = null;
	if ($dummyField['DummyField']['active'] ) {
	
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr <?php echo $class;?>>
		<td>
			<?php echo $dummyField['DummyField']['name']; ?>
		</td>
		<td style="text-align:left">
			<?php 
			if ($editable) {
				$field_type = strtok($dummyField['DummyField']['field_type'],'(');
				$type_options = $types[$field_type];
				if (sizeof($type_options) > 1) {
					echo $form->create('DummyField', array('url' => array('action'=>'change',$table)));
					echo $form->hidden('DummyField.id', array('value' => $dummyField['DummyField']['id']));
					echo $form->select(
						'DummyField.type',
						$type_options,
						$dummyField['DummyField']['type'],
						array(
							'style'=>'width:100%',
							'onchange' => 'submit()',
						),
						false
					);
					echo $form->end();
				} else {
					echo $dummyField['DummyField']['type'];
				}
			} else {
				echo $dummyField['DummyField']['type'];
			}
			?>
		</td>
		<td>
			<?php echo ($dummyField['DummyField']['allow_null'])? __('YES',true) : __('No',true); ?>
		</td>
		<td>
			<?php echo $dummyField['DummyField']['default']; ?>
		</td>
		<td>
			<?php echo $dummyField['DummyField']['custom_min']; ?>
		</td>
		<td>
			<?php echo $dummyField['DummyField']['custom_max']; ?>
		</td>
		<td>
			<?php echo $dummyField['DummyField']['custom_variable']; ?>
		</td>
	<?php 
	if ($editable) { ?>
		<td class="actions">
<?php 			echo $html->link(__('Deactivate', true), array('action'=>'deactivate', $dummyField['DummyField']['id'], 'admin' => true));	; 
				echo ' '.$html->link(__('Edit', true), array('action'=>'edit', $dummyField['DummyField']['id']));
?>
		</td>
<?php 		}
?>		
	</tr>
<?php  }
endforeach; ?>
</table>

<h4>Inactive</h4>
<table cellpadding="0" cellspacing="0" style="width:auto;">
	<tr>
		<th><?php __('name');?></th>
		<th><?php __('default');?></th>
<?php if ($editable) { ?>
		<th class="actions"><?php __('Actions');?></th>
<?php } ?>		
	</tr>
<?php
$i = 1;
foreach ($data as $dummyField):
	$class = null;
	if (!$dummyField['DummyField']['active'] ) {
	
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr <?php echo $class;?>>
		<td>
			<?php echo $dummyField['DummyField']['name']; ?>
		</td>
		<td>
			<?php echo $dummyField['DummyField']['default']; ?>
		</td>
<?php if ($editable) { ?>
		<td class="actions">
<?php 		echo $html->link(__('Activate', true), array('action'=>'activate', $dummyField['DummyField']['id'], 'admin' => true));	?>
		</td>
<?php } ?>
	</tr>
<?php  }
endforeach; ?>
</table>
<?  
if (sizeof($contents)) { ?>
	<br />
	<h4>Contents</h4>
	<table cellpadding="0" cellspacing="0" style='width: auto'>
		<thead>
			<tr>
	<?php		
		foreach ($contents[0]['Model'] as $key => $value) {
			echo '<th>' . $key . '</th>';
		} ?>
	  	</tr>
		</thead>
		<tbody>
	<?php $i = 1;
		 foreach ($contents as $one) : 
		 $row = $one['Model'];
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}?>
		<tr <?php echo $class?>>
			<? foreach ($row as $field) : ?>
			<td><? echo str_replace('<','&lt;',$field); ?></td>
			<? endforeach; ?>
		</tr>  	
	<? endforeach; ?>
	  	</tbody>
	</table>	
	<? 
	echo $form->end();
} else {
	echo '<p>'; 
	__('No contents yet. Generate some.');
	echo '</p>';
} ?>
</div>
<?php // echo $javascript->link('jquery-1.2.1.min'); ?>
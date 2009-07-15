<div class="<?php echo $pluralVar;?> form">
<?php echo "<?php\n";?>
    <?php echo "echo \$form->create('{$modelClass}');\n";?>
    <?php echo "echo \$form->inputs(array('fieldset' => false,\n";  //'legend' => '$action $singularHumanName',\n"; 
		foreach ($fields as $field) {
			if ($action == 'add' && $field == $primaryKey) {
				continue;
			} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
				if (isset($keyFields[$field])) {
					echo "\t\t\t'$field' => array('empty' => true),\n";
				} else {
					echo "\t\t\t'$field',\n";
				}
			}
		}
		if(!empty($associations['hasAndBelongsToMany'])) {
			foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
				echo "\t\t\t'{$assocName}',\n";
			}
		}
	echo "\t));\n";?>
    <?php echo "echo \$form->end('Submit');?>\n"; ?>
</div>
<?php 
	echo "<?php\n";
	if ($action != 'add'):
		echo "\t\$menu->add('context',array(__('Delete', true), array('action'=>'delete', \$form->value('{$modelClass}.{$primaryKey}')), null, sprintf(__('Are you sure you want to delete # %s?', true), \$form->value('{$modelClass}.{$primaryKey}'))));\n";
	endif;
 	echo "\t\$menu->add('context',array(__('List {$pluralHumanName}', true), array('action'=>'index')));\n";

		$done = array();
		foreach ($associations as $type => $data) {
			foreach($data as $alias => $details) {
				if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
					echo "\t\$menu->add('context',array(__('List ".Inflector::humanize($details['controller'])."', true), array('controller'=> '{$details['controller']}', 'action'=>'index')));\n";
				//	echo "\t\$menu->add('context',array(__('New ".Inflector::humanize(Inflector::underscore($alias))."', true), array('controller'=> '{$details['controller']}', 'action'=>'add')));\n";
					$done[] = $details['controller'];
				}
			}
		}
		
	echo "?>\n";
?>

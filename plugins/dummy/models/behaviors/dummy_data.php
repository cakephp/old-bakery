<?php
App::import('vendor', 'dummy.dummydata/generators');
class DummyDataBehavior extends ModelBehavior {
	/**
	 * Contains configuration settings for use with individual model objects.  This
	 * is used because if multiple models use this Behavior, each will use the same
	 * object instance.  Individual model settings should be stored as an
	 * associative array, keyed off of the model name.
	 *
	 * @var array
	 * @access public
	 * @see Model::$alias
	 */
	var $settings = array();
	/**
	 * Allows the mapping of preg-compatible regular expressions to public or
	 * private methods in this class, where the array key is a /-delimited regular
	 * expression, and the value is a class method.  Similar to the functionality of
	 * the findBy* / findAllBy* magic methods.
	 *
	 * @var array
	 * @access public
	 */
	var $mapMethods = array();
	/**
	 * Setup this behavior with the specified configuration settings.
	 *
	 * @param object $model Model using this behavior
	 * @param array $config Configuration settings for $model
	 * @access public
	 */
	function setup(&$model, $config = array()) {
	}

	function generate(&$model, $generator, $options = array()) {
		if (isset($options['default']) && $options['default'] !== '' && $options['default'] !== false && $options['default'] !== null) {
			if (rand(0,10) < 8) {
				return $options['default'];
			}
		}
		if (isset($options['null']) && $options['null']) {
			if (rand(0,10) < 3) {
				return NULL;
			}
		}
		$gen = substr($generator,8);
		$available_generators = DummyGenerator::listGenerators();
		if (in_array($gen, $available_generators)) {
			return DummyGenerator::$generator($options);	
		}        			   
		return null;			
	}

	function specialFieldsReplace(&$Model, $data, $rules) {
		foreach ($rules as $field => $options) {
			if (isset($data[$field])) {
				$variable = false;
				$source_values = array();
				foreach ($options['source'] as $source_field_name) {
					if (isset($data[$source_field_name])) {
						$source_values[] = $data[$source_field_name];
					}
				}
				if (isset($options['rule']) && $options['rule'] == 'combine') {					
					if (!empty($source_values)) {
						$variable = $source_values;
					}	
				} else { // rule one
					if (!empty($source_values)) {
						$variable = $source_values[rand(0,sizeof($source_values)-1)];
					}					
				}
				if ($variable) {
					$data[$field] = $this->generate($Model, 'generate'.$options['generator'], array('variable' =>$variable));
				}								
			}
		}
		return $data;
	}
}
?>
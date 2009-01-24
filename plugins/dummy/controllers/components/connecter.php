<?php
class ConnecterComponent extends Object
{
	public $name = 'Connecter';
	
	function setDb($connection = null)
	{
		if (!$connection) {
			App::import('model', 'Connection');
			$connectionModel = new Connection();
			$connection = $connectionModel->find('first');
		}

		$nydb = $connection['Connection'];
		ConnectionManager::create($nydb['database'], $nydb);
		
		return $nydb['database'];
	}
}
?>
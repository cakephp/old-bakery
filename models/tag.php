<?php
class Tag extends AppModel {

	public $name = 'Tag';
	public $recursive = -1;
	public $hasAndBelongsToMany = array('Article');

	public function create($data = array(), $filterKey = false) {
		if (isset($data[$this->alias]) && isset($data[$this->alias]['name'])) {
			$data[$this->alias]['keyname'] = Inflector::slug($data[$this->alias]['name']);
		} elseif ($data['name']) {
			$data['keyname'] = Inflector::slug($data['name']);
		}
		return parent::create($data,$filterKey);
	}


	/**
	 *
	 * @param string $commalist commaseperated list of tags
	 * @return array idlist of arrays array(id1 => name1, id2 => name2)
	 */
	public function saveArticleTags($commalist = '') {
		if ($commalist == '') return null;
		$tags = explode(',',$commalist);
		if (empty($tags)) return null;
		$existing = $this->find('all', array(
			'conditions' => array('name' => $tags)
		));

		$return = Set::extract($existing,'/Tag/id');

		if (sizeof($existing) == sizeof($tags)) {
			return $return;
		}

		$existing = Set::extract($existing,'/Tag/name');
		foreach ($tags as $tag) {
			if (!in_array($tag, $existing)) {
				$this->create(array('name' => $tag));
				$this->save();
				$return[] = $this->id;
			}
		}
		return $return;
	}
}
?>
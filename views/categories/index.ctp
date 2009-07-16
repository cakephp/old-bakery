<div class="categories index">
<h2><?php __('Categories');?></h2>
<?php
foreach ($categories as $category) {
	$menu->add('cats', array($category['Category']['name'],array('controller'=>'articles','action'=>'index','category_id'=>$category['Category']['id'])));
	if (!empty($category['children'])) {
		foreach ( $category['children'] as $child ) {
			$menu->add(array('cats',$child['Category']['id']), array($child['Category']['name'],array('controller'=>'articles','action'=>'index','category_id'=>$child['Category']['id'])));
			if (!empty($child['children'])) {
				foreach ( $child['children'] as $subchild ) {
					$menu->add(array('cats',$child['Category']['id'],$child['Category']['id']), array($subchild['Category']['name'],array('controller'=>'articles','action'=>'index','category_id'=>$subchild['Category']['id'])));
				}
			}
		}
	}
}

	echo $menu->generate('cats');

	$menu->add('context',array(__('Articles', true), array('controller'=> 'articles', 'action'=>'index')));
	$menu->add('context',array(__('Tags', true), array('controller'=> 'tags', 'action'=>'index')));
?>
</div>
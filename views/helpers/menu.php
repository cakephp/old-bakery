<?php
/**
 *
 * @author Ronny Vindenes
 * @author Alexander Morland
 * @license MIT
 * @modified 17.nov 2008
 * @version 1.0
 */
class MenuHelper extends AppHelper {
	
	var $helpers = array('Html');
	
	var $items = array('main' => array());
	
	/**
	 * Adds a menu item to a target location
	 *
	 * 
	 * @param mixed $target String or Array target notations
	 * @param array $link Array in same format as used by HtmlHelper::link()
	 * @param array $htmlAttributes
	 * 
	 * @param array $options
	 *  @options 'icon'  > $html->image() params
	 *  @options 'class' > <a class="?">
	 *  @options 'li'    > string:class || array('id','class','style')
	 *  @options 'div'	 > string:class || boolean:use || array('id','class','style') 
	 * 
	 * @return boolean successfully added
	 */
	function add($target = 'main', $link = array(), $options = array()) {
		
		if (!is_array($link) || !is_array($options) || !isset($link[0]) || !(is_array($link[0]) || is_string($link[0]))) {
			return false;
		}
		
		if (!isset($link[1])) {
			$link[1] = array();
		}
		
		if (!isset($link[2])) {
			$link[2] = array();
		}
		
		if (!isset($link[3])) {
			$link[3] = false;
		}
		
		if (!isset($link[4])) {
			$link[4] = true;
		}
		
		if (is_array($target)) {
			
			$depth = count($target);
			$menu = &$this->items;
			
			for ($i = 0; $i < $depth; $i++) {
				if (array_key_exists($target[$i], $menu)) {
					$menu = &$menu[$target[$i]];
				} else {
					$menu[$target[$i]] = array(true);
					$menu = &$menu[$target[$i]];
				}
			}
		
		} else {
			$menu = &$this->items[$target];
		}
		
		$menu[] = array($link, $options);
		
		return true;
	}
	
	/**
	 * Adds an element to a target item
	 *
	 * @param mixed $target String or Array target notations
	 * @param string $element Any string
	 * 
	 * @param array $options
	 *  @options 'li'    > string:class || array('id','class','style')
	 *  @options 'div'	 > string:class || boolean:use || array('id','class','style') 
	 * 
	 * @return boolean successfully added
	 */
	function addElement($target = 'main', $element = false, $options = array()) {
		
		if ($element === false) {
			return false;
		}
		
		if (is_array($target)) {
			
			$depth = count($target);
			$menu = &$this->items;
			
			for ($i = 0; $i < $depth; $i++) {
				if (array_key_exists($target[$i], $menu)) {
					$menu = &$menu[$target[$i]];
				} else {
					$menu[$target[$i]] = array(true);
					$menu = &$menu[$target[$i]];
				}
			}
		
		} else {
			$menu = &$this->items[$target];
		}
		
		$menu[] = array(1 => $options, 2 => $element);
		
		return true;
	}
	
	/**
	 * Renders and returns the generated html for the targeted item and its element and children
	 *
	 * @param mixed $source String or Array target notations
	 * 
	 * @param array $options
	 *  @options 'style' > string:predefined style name || boolean:use
	 *  @options 'class' > <ul class="?"><li><ul>..</li></ul>
	 *  @options 'id' 	 > <ul id="?"><li><ul>..</li></ul>
	 *  @options 'ul'    > string:class || array('class','style')
	 *  @options 'div'	 > string:class || boolean:use || array('id','class','style') 
	 *
	 * @return mixed string generated html or false if target doesnt exist
	 */
	function generate($source = 'main', $options = array()) {
		
		$out = '';
		$list = '';
		
		$ulAttributes = array();
		
		/* DOM class attribute for outer UL */
		if (isset($options['class'])) {
			$ulAttributes['class'] = $options['class'];
		} else {
			if (is_array($source)) {
				$ulAttributes['class'] = 'menu_' . $source[count($source) - 1];
			} else {
				$ulAttributes['class'] = 'menu_' . $source;
			}
		}
		
		/* DOM element id for outer UL */
		if (isset($options['id'])) {
			$ulAttributes['id'] = $options['id'];
		}
		
		/* Find source menu */
		if (is_array($source)) {
			
			$depth = count($source);
			$menu = &$this->items;
			
			for ($i = 0; $i < $depth; $i++) {
				if (array_key_exists($source[$i], $menu)) {
					$menu = &$menu[$source[$i]];
				} else {
					return false;
				}
			}
		
		} else {
			if (!isset($this->items[$source])) {
				return false;
			}
			$menu = &$this->items[$source];
		}
		
		/* Generate menu items */
		foreach ($menu as $key => $item) {
			$liAttributes = array();
			$aAttributes = array();
			
			if (isset($item[1]['li'])) {
				$liAttributes = $item[1]['li'];
			}
			
			if (isset($item[0]) && $item[0] === true) {
				$menusource = $source;
				if (!is_array($menusource)) {
					$menusource = array($menusource);
				}
				$menusource[] = $key;
				/* Don't set DOM element id on sub menus */
				if (isset($options['id'])) {
					unset($options['id']);
				}
				$listitem = $this->generate($menusource, $options);
				if (empty($listitem)) {
					continue;
				}
			} elseif (isset($item[0])) {
				if (!isset($item[0][2]['title'])) {
					$item[0][2]['title'] = $item[0][0];
				}
				$listitem = $this->Html->link($item[0][0], $item[0][1], $item[0][2], $item[0][3], $item[0][4]);
			} elseif (isset($item[2])) {
				$listitem = $item[2];
			} else {
				continue;
			}

			if (isset($item[1]['div']) && $item[1]['div'] !== false) {
				if (!is_array($item[1]['div'])) {
					$item[1]['div'] = array();
				}
				$listitem = $this->Html->tag('div', $listitem, $item[1]['div']);
			}
			
			$list .= $this->Html->tag('li', $listitem, $liAttributes);
		}
		
		/* Generate menu */
		$out .= $this->Html->tag('ul', $list, $ulAttributes);
		
		/* Add optional outer div */
		if (isset($options['div']) && $options['div'] !== false) {
			if (!is_array($options['div'])) {
				$options['div'] = array();
			}
			$out = $this->Html->tag('div', $out, $options['div']);
		}
		
		return $out;
	}

}
?>
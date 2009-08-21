<?php
/**
 * AuthHelper for Users plugin.
 *
 * Originally designed for CakePHP Bakery 2.0 and other CakePHP community 
 * applications. This helper belongs to Users plugin.
 *
 * This helper helps getting userdata inside the view and helps with 
 * hiding certain functionalities at view level for certain usergroups.
 *
 * @author Frank de Graaf (Phally)
 * @version 1.0
 * @license -UNKNOWN-
 *
 */
class AuthHelper extends AppHelper {
/**
 * The helpers this helper needs.
 *
 * @var array
 * @access public
 */ 
	public $helpers = array('Session');
	
/**
 * The session key to the Auth data.
 *
 * @var string
 * @access public
 */ 
	public $auth = 'Auth';
	
/**
 * The session key to the user data.
 *
 * @var string
 * @access public
 */ 
	public $user = 'Users.User';
	
/**
 * The session key of the group ID in the userdata.
 *
 * @var string
 * @access public
 */ 
	public $group = 'group_id';
	
/**
 * The default group ID for a guest user who isn't logged in.
 *
 * @var integer
 * @access public
 */ 
	public $guest = 0;

/**
 * The current group ID.
 *
 * @var integer
 * @access private
 */ 	
	private $__type = null;
	
/**
 * CakePHP callback function to set the current group ID.
 *
 * @return void
 * @access public
 */ 
	public function beforeRender() {
		parent::beforeRender();
		$this->__type = $this->logged(true) ? $this->user($this->group) : $this->guest;
	}
	
/**
 * Method to check if a user is logged in.
 *
 * @param boolean $force Force the helper to check the session.
 * @return boolean True if a user is logged in, if not, it returns false.
 * @access public
 */ 
	public function logged($force = false) {
		if ($force) {
			return $this->Session->check($this->auth . '.' . $this->user);
		} else {
			return ($this->__type > $this->guest);
		}
	}

/**
 * Method used to set conditions to hide view content for 
 * certain usergroups.
 *
 * @param integer $for The group ID as the minimum requirement to see the content.
 * @return boolean True if the user has access to that content, else false.
 * @access public
 */ 
	public function visible($for) {
		return ($this->__type >= $for);
	}

/**
 * Method to retreive user data from the session. Similar 
 * usage as AuthComponent::user().
 *
 * @param string $field Optional. Field to retreive from session. Empty returns everything.
 * @return mixed User data.
 * @access public
 */ 
	public function user($field = null) {
		$path = $this->auth;
		
		if (strpos($this->user, '.')) {
			list($plugin, $alias) = explode('.', $this->user);
			$path .= '.' . $plugin;
		} else {
			$alias = $this->user;
		}
		
		if ($field) {
			$path .= '.' . $alias . '.' . $field;
		}
		return $this->Session->read($path);
	}
}
?>
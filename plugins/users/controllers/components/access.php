<?php
/**
 * AccessComponent for Users plugin.
 *
 * Originally designed for CakePHP Bakery 2.0 and other CakePHP community 
 * applications. This component belongs to Users plugin.
 *
 * Implements static permission checking for CakePHP's AuthComponent. This 
 * AccessComponent gets the permissions from a config file. An example for 
 * this config file can be found in:
 * 
 * APP/plugins/users/config/permissions.php.example
 *
 * USAGE:
 * Add the following two components to the AppController:
 * 1. Auth
 * 2. Users.Access
 *
 * EXAMPLE:
 * public $components = array('Auth', 'Users.Access');
 *
 * @author Frank de Graaf (Phally)
 * @version 1.0
 * @license -UNKNOWN-
 *
 */
class AccessComponent extends Object {

/**
 * CakePHP components variable to load components for this class.
 *
 * @var array
 * @access public
 */ 
	public $components = array('Cookie');

/**
 * Filename of the config file holding the permissions (without the .php extension).
 *
 * @var string
 * @access public
 */ 
	public $file = 'permissions';
	
/**
 * Session key of the group ID of the user.
 *
 * @var string
 * @access public
 */ 
	public $group = 'group_id';
	
/**
 * Default group ID for users that aren't login.
 *
 * @var integer
 * @access public
 */ 
	public $guest = 0;
	
/**
 * Use the application salt for hashing.
 *
 * @var boolean
 * @access public
 */ 
	public $salt = true;
	
/**
 * Remember cookie expire time.
 *
 * @var string
 * @access public
 */ 
	public $remember = '+2 weeks';
	
/** 
 * Remember form field which has to be checked.
 *
 * @var string
 * @access public
 */ 
	public $rememberField = 'remember';
	
/**
 * List of permissions from the config file.
 *
 * @var array
 * @access private
 */ 
	private $__permissions = array();
	
/**
 * Reference to the current controller.
 *
 * @var object
 * @access private
 */ 
	private $__controller = null;
	
/**
 * Callback method to initialize the AccessComponent.
 *
 * @param object $controller Instance of the current controller.
 * @return void
 * @access public
 */ 
	public function initialize($controller) {
		if (!isset($controller->Auth)) {
			trigger_error('CakePHP AuthComponent not found in the current controller.', E_USER_ERROR);
		}
		
		$controller->helpers[] = 'Users.Auth';
		
		$this->__controller = $controller;
		
		$this->__loadPermissions();
		$this->__configureAuth();
		
		$this->Cookie->key = Configure::read('Security.salt');
	}
	
/**
 * Method used by CakePHP's AuthComponent to check if a certain user 
 * has access to the current location.
 *
 * @return boolean Whether the user has access or not.
 * @access public
 */ 
	public function isAuthorized() {
		return $this->__check($this->__controller->Auth->user($this->group)); 
	}

/**
 * Method used by CakePHP's AuthComponent to hash passwords on login. This 
 * method is needed to avoid CakePHP from adding the application hash.
 * 
 * @param array $data Form data.
 * @return array Form data with hashed password if one is found.
 * @access public
 */ 
	public function hashPasswords($data) {
		$auth = $this->__controller->Auth;
		if (is_array($data) && isset($data[$auth->userModel])) {
			if (isset($data[$auth->userModel][$auth->fields['username']]) && isset($data[$auth->userModel][$auth->fields['password']])) {
				$data[$auth->userModel][$auth->fields['password']] = Security::hash($data[$auth->userModel][$auth->fields['password']], null, $this->salt);
			}
		}
		return $data;
	}
	
/**
 * Method to login a user on demand. Only available in debug mode.
 *
 * @param string $username The username of the user to login.
 * @return boolean Whether the user was found and logged in.
 * @access public
 */ 
	public function lazyLogin($username) {
		if ((Configure::read('debug') > 0) && (!$this->__controller->Auth->user())) {
			return $this->__controller->Auth->login(ClassRegistry::init($this->__controller->Auth->userModel)->find('first', array(
				'conditions' => array(
					$this->__controller->Auth->fields['username'] => $username
				),
				'recursive' => -1
			)));
		}
		return false;
	}

/**
 * Method to login with data from the remember cookie if it is set.
 *
 * @return boolean Whether the user was found and logged in.
 * @access public
 */ 
	public function cookieLogin() {
		if (!$this->__controller->Auth->user()) {
			if ($data = $this->getRememberCookie()) {
				return $this->__controller->Auth->login($data);
			}
		}
		return false;
	}
	
/**
 * Method to set a remember me cookie for the current user.
 *
 * @param array $data POST data from the login form.
 * @access public
 */ 
	public function setRememberCookie($data) {
		if ($this->__controller->Auth->user() && $data[$this->__controller->Auth->userModel][$this->rememberField]) {
			$this->Cookie->write(
				$this->__controller->Auth->sessionKey,
				array_intersect_key($data[$this->__controller->Auth->userModel], array_flip($this->__controller->Auth->fields)), 
				true, 
				$this->remember
			);
		}
	}
	
/**
 * Method to get a remember me cookie for the current user.
 *
 * @param array $data POST data from the login form.
 * @return array The login data for the user.
 * @access public
 */ 
	public function getRememberCookie() {
		return $this->Cookie->read($this->__controller->Auth->sessionKey);
	}
	
/**
 * Method to delete the remember me cookie. Useful for logout.
 *
 * @access public
 */ 
	public function deleteRememberCookie() {
		$this->Cookie->del($this->__controller->Auth->sessionKey);
	}
	
/**
 * Method to set values to the AuthComponent to make it use this 
 * component for hashing and authorization. Also sets new defaults 
 * for the login urls to point at this plugin and allows public 
 * actions by default.
 *
 * @return void
 * @access private
 */ 
	private function __configureAuth() {
		$auth = $this->__controller->Auth;
		$auth->authorize = 'object';
		$auth->object = $auth->authenticate = $this;
		
		if (!$auth->user()) {
			$auth->authError = __('You need to login first.', true);
		}
		
		if ($this->__check($this->guest, true)) {
			$auth->allow($this->__controller->action);
		}
	}
	
/**
 * Method to check the permission for a current location for a given 
 * usergroup.
 *
 * @param integer $group Group ID to check for.
 * @param boolean $strict Strict mode checks for the exact group, else it checks for the exact group or higher.
 * @return boolean Whether the usergroup has access to the current location.
 * @access private
 */ 
	private function __check($group, $strict = false) {
		$controller = Inflector::camelize($this->__controller->params['controller']);
		if (!empty($this->__controller->params['plugin'])) {
			$controller = Inflector::camelize($this->__controller->params['plugin']) . '.' . $controller;
		}
		$action = $this->__controller->params['action'];
		
		if (isset($this->__permissions[$controller][$action])) {
			if ($strict) {
				return ($group == $this->__permissions[$controller][$action]);
			} else {
				return ($group >= $this->__permissions[$controller][$action]);
			}
		}
		
		return false;
	}
	
/**
 * Method to check for the existence of the configuration file with 
 * the permissions and loads it.
 *
 * @return void
 * @access private
 */ 
	private function __loadPermissions() {
		if (Configure::load($this->file) === false) {
			trigger_error('Permission file ' . APP . 'config' . DS . $this->file . '.php' . ' not found.', E_USER_ERROR);
		} else {
			$this->__permissions = Configure::read('App.permissions');
		}
	}
}
?>
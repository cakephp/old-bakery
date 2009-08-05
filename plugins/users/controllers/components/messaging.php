<?php
class MessagingComponent extends Object {
	public $model = 'Users.Message';
	
	private $__modelInstance = null;
	
	public function send($message = null, $recipients = array(), $sender = null, $title = null, $conversationId = null) {
		return $this->__getModel()->send($message, $recipients, $sender, $title);
	}
	
	private function __getModel() {
		if (!$this->__modelInstance) {
			$this->__modelInstance = ClassRegistry::init($this->model);
		}
		return $this->__modelInstance;
	}
}
?>
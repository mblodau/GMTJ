<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
class GMTJControllerAd extends JController {
	
	function __construct($config = null) {
	
		if( $config == null ) 
			$config = array();
		parent::__construct( $config );
		JRequest::setVar('view', 'ad');
		
		// Explicitly state the tasks we are going to implement
		$this->registerTask('save', 'save');
		$this->registerTask('apply', 'save');
		$this->registerTask('cancel', 'cancel');
	}

	
	function save() {
	
		// Get the model for the ad detail view
		$model = $this->getModel( 'ad' );
		
		// Fetch the fields of the form in the ad detail view
		$data = JRequest::get( 'post', JREQUEST_ALLOWRAW );
		
		// Try to save the ad with the models store function
		if(!$model->store($data)) 
			$msg = JText::_( 'Kunde inte spara annonsen' ); 
		else
			$msg = JText::_( 'Annonsen sparad' );
		
		// "Apply" and "Save" both try to store the record but "Apply" reloads the detail view afterwards while "Save" closes the detail window and redirects back to the list view.
		switch ($this->_task) {
		
			case 'apply':			
				$link = 'index.php?option=com_gmtj&controller=ad&task=edit&cid[]='.$model->_id;
				break;
			case 'save':
			default:
				$link='index.php?option=com_gmtj&controller=ads';
				break;
		}
		
		$this->setRedirect($link,$msg);
	}
	
	function cancel($msg) {
	
		// Just go back to the list view
		$link='index.php?option=com_gmtj';
		$this->setRedirect($link, $msg);
	}

    function display() {
    
		parent::display();
    }
 
}

?>

<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
class GMTJControllerAd extends JController 
{	
	function __construct($config = null) 
	{
		if( $config == null ) 
			$config = array();
		parent::__construct( $config );
		JRequest::setVar('view', 'ad');
		
		// -- Explicitly state the tasks we are going to implement
		$this->registerTask('save', 'save');
		$this->registerTask('apply', 'save');
		$this->registerTask('cancel', 'cancel');
	}

	
	function save() 
	{
		$model = $this->getModel( 'ad' );
		$data = JRequest::get( 'post', JREQUEST_ALLOWRAW );
		
		if(!$model->store($data)) 
			$msg = JText::_( 'Kunde inte spara annonsen' ); 
		else
			$msg = JText::_( 'Annonsen sparad' );
				
		switch ($this->_task) 
		{
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
	
	function cancel($msg)
	{
		$link='index.php?option=com_gmtj';
		$this->setRedirect($link, $msg);
	}

    function display() 
    {
		$link='index.php?option=com_gmtj&controller=ads';
		
		switch($this->_task) 
		{
			case 'edit':
				break;
			case 'add':
				break;
			default:
				$this->setRedirect($link,$msg);
				break;
		}
		
		parent::display();
    }
 
}

?>

<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
// Controller for the ads list view
class GMTJControllerAds extends JController {
	
	function __construct($config = null) {
	
		if( $config == null ) 
			$config = array();
	
		parent::__construct( $config );
	
		JRequest::setVar('view', 'ads');
		
		// Explicitly state the tasks we are going to implement
		$this->registerTask('remove', 'remove');
		$this->registerTask('add', 'add');
		$this->registerTask('edit', 'edit');
		$this->registerTask('publish', 'publish');
		$this->registerTask('unpublish', 'publish');
	}

	
	function add() {
	
		// Redirect to the controller for the ad detail view (controllers/ad.php) and pass on the task "add"
		$this->setRedirect('index.php?option=com_gmtj&controller=ad&task=add');
	}
	
	function edit() {
	
		// Redirect to the controller for the ad detail view (controllers/ad.php) and pass on the id of the selected record.
		$cid = JRequest::getVar('cid', array(),'','array');
		$this->setRedirect('index.php?option=com_gmtj&controller=ad&task=edit&cid[]='.$cid[0]);
	}
	
	function remove() {
	
		// Grab the model for the single ad. (models/ad.php)
		$model = $this->getModel('ad');
		
		// Grab the table class for the ads table. (file: tables/ad.php, table:jos_gmtj_ads)  
		$row = $model->getTable();
		
		// It's possible to select several records for deletion. Grab the whole array with the record id's.
		$cid = JRequest::getVar('cid', array(), '', 'array');
		
		// Loop trough the array and delete each record.
		foreach($cid as $c) 
		{
			// First use the load function from the table class
			$row->load($c);

			// And delete the record with the delete function from the table class
			if( !$row->delete() )
				JError::raiseError(500, $row->getError());
		}
		
		// Redirect back to the list view with a status message.
		$this->setRedirect('index.php?option=com_gmtj', JText::_((count($cid) > 1) ? "Raderade ".count($cid)." händelser" : " Raderade ".count($cid)." händelse"));

	}
	
	function publish() {

		// Function for the publish/unpublish icon all the way to the right in the ads list view
		$link = 'index.php?option=com_gmtj';
		$text = '';
		$cid = JRequest::getVar('cid', array(), '', 'array');
		
		$model	= $this->getModel('ad');
		$row 	= $model->getTable();
		
		// Use the same function for publishing or unpublishing.
		if($this->_task == 'publish') {
		
			$publish = 1;
			$msg = JText::_('Annons publicerad');
			
		} else {
		
			$publish = 0;
			$msg = JText::_('Annons avpublicerad');
		}
		
		// Use tables publish function and throw a status message in case something goes wrong
		if (!$row->publish($cid, $publish, $user->id)) {
		
			$msg = JText::_("Kunde inte publicera/avpublicera annonsen");
		}
		
		// Throw eventual SQL syntax error
		if(mysql_error()) {
		
			JError::raiseWarning(mysql_errno(), mysql_error());
		}
		
		// Redirect back to the list view with a status message
		$this->setRedirect( $link, $msg );
	}

    function display() {

		parent::display();	
	}
}

?>

<?php

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
class GMTJControllerAds extends JController 
{
	
	function __construct($config = null) 
	{
		if( $config == null ) 
			$config = array();
		parent::__construct( $config );
		JRequest::setVar('view', 'ads');
		
		// -- Explicitly state the tasks we are going to implement
		$this->registerTask('remove', 'remove');
		$this->registerTask('add', 'add');
		$this->registerTask('edit', 'edit');
		$this->registerTask('publish', 'publish');
		$this->registerTask('unpublish', 'publish');
	}

	
	function add() 
	{
		$this->setRedirect('index.php?option=com_gmtj&controller=ad&task=add');
	}
	
	function edit() 
	{
		$cid = JRequest::getVar('cid', array(),'','array');
		$this->setRedirect('index.php?option=com_gmtj&controller=ad&task=edit&cid[]='.$cid[0]);
	}
	
	function remove() 
	{
		$model = $this->getModel('ad');
		$row = $model->getTable();
		
		$cid = JRequest::getVar('cid', array(), '', 'array');
		
		foreach($cid as $c) 
		{
			$row->load($c);

			if( !$row->delete() )
				JError::raiseError(500, $row->getError());
		}
		
		$this->setRedirect('index.php?option=com_gmtj', JText::_((count($cid) > 1) ? "Raderade ".count($cid)." händelser" : " Raderade ".count($cid)." händelse"));

	}
	
	function publish() 
	{
		$link = 'index.php?option=com_gmtj';
		$text = '';
		$cid = JRequest::getVar('cid', array(), '', 'array');
		
		$model	= $this->getModel('ad');
		$row 	= $model->getTable();
		
		if($this->_task == 'publish') 
		{
			$publish = 1;
			$text = JText::_('Annons publicerad');
		} 
		else 
		{
			$publish = 0;
			$text = JText::_('Annons avpublicerad');
		}
		
		if (!$row->publish($cid, $publish, $user->id)) 
		{
			$text = JText::_("Kunde inte publicera/avpublicera annonsen");
		}
		
		if(mysql_error()) 
		{
			JError::raiseWarning(mysql_errno(), mysql_error());
		}
		
		$this->setRedirect( $link, $msg );
	}

    function display() 
    {
		parent::display();	
	}
}

?>

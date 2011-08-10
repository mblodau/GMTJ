<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');

class GMTJControllerAds extends JController
{
	function display()
	{
		JRequest::setVar( 'view' , 'ads');

		parent::display();
	}

}
?>

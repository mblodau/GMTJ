<?php
// Note: No special stuff in here. Standard code that can be found in nearly every Joomla component.

// No direct access (security measure)
defined( '_JEXEC' ) or die( 'Restricted access' );
  
// Require specific controller if requested
if( $controller = JRequest::getWord( 'controller', 'ads' ) ) 
{	
	$path = JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';

	if( file_exists( $path ) ) 
        require_once $path;
    else
        $controller = '';
}

// Build a menu for list views
if( $controller == 'ads' ) 
{
	// Note: JText is for adding multi language functionality. Joomla will look in the corresponding language file for a translation. 
	// If we for example add "Annonser=Advertisements" to the english language for com_gmtj Joomla will display the english string instead of the swedish one if the english language is activated in the system.
	JSubMenuHelper::addEntry(JText::_('Annonser'), 'index.php?option=com_gmtj&controller=ads', ($controller == 'ads' ? true : false));
}

$classname    = 'GMTJController'.$controller;
$controller   = new $classname();

$controller->execute( JRequest::getVar('task') );
 
$controller->redirect();

?>

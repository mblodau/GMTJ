<?php
 
// No direct access
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

// -- Build a menu for list views
if( $controller == 'ads' ) 
{
	JSubMenuHelper::addEntry(JText::_('Annonser'), 'index.php?option=com_gmtj&controller=ads', ($controller == 'ads' ? true : false));
}

$classname    = 'GMTJController'.$controller;
$controller   = new $classname();

$controller->execute( JRequest::getVar('task') );
 
$controller->redirect();

?>

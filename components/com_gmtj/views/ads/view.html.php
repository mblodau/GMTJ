<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class GMTJViewAds extends JView
{
	function display( $tpl = null )
	{
		global $mainframe;

		// Get some help
    	require_once(JPATH_COMPONENT.DS.'helpers'.DS.'helper.php' );

		$document =& JFactory::getDocument();

		// Add custom stylesheet
		$document->addStyleSheet('media/com_gmtj/css/frontend.css');
		
		$model =& $this->getModel('ads');

		// Get the ads
		$ads = $model->getAds();
		
		$this->assignRef( "ads", $ads );

		parent::display( $tpl );
	}
}
?>

<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class GMTJViewAd extends JView {

	function display( $tpl = null )	{
	
		global $mainframe;

		// Get some help (will be used in the view template)
    	require_once(JPATH_COMPONENT.DS.'helpers'.DS.'helper.php' );

		$document =& JFactory::getDocument();

		// Add custom stylesheet
		$document->addStyleSheet('media/com_gmtj/css/frontend.css');

		// Get the model for the single ad		
		$model =& $this->getModel('ad');

		// Grab the ad id that got transfered by the link from the ads list view (cid)
		$adId = JRequest::getInt('cid', '');

		// Get the ad
		$ad = $model->getAd($adId);
		
		$this->assignRef( "ad", $ad );

		parent::display( $tpl );
	}
}
?>

<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class GMTJViewAds extends JView {

	function display( $tpl = null )	{
	
		global $mainframe;

		// Get some help (will be used in the view template)
    	require_once(JPATH_COMPONENT.DS.'helpers'.DS.'helper.php' );

		$document =& JFactory::getDocument();

		// Add custom stylesheet
		$document->addStyleSheet('media/com_gmtj/css/frontend.css');
		
		// Get the model for the ad lists.
		$model =& $this->getModel('ads');

		// Get the post. Could contain search values.
		$post  = JRequest::get('post');
				
		// Check if we have some search values
		$checkSearch = $model->checkSearch($post['search']);

		// If we have some search values then run the search and return the ads that fit. Otherwise fetch the standard list of ads.						
		if ($checkSearch) {
		
			$ads = $model->search($post['search']);
			
		} else {
		
			$ads = $model->getAds();
			
		}
		
		$this->assignRef( "ads", $ads );
		
		// Don't need the whole post in the template view. Only pass on eventual search values so that the search fields can be pre filled with the values from an earlier search.
		$this->assignRef( "search", $post['search']);
	
		parent::display( $tpl );
	}
}
?>

<?php

// No direct access
defined('_JEXEC') or die();

jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class GMTJViewAds extends JView {

	function display( $tpl = null ) {
	
		global $option, $mainframe;
		
		$model = $this->getModel();

		// Add a title and some buttons to the toolbar 		
		JToolBarHelper::title( JText::_('Annonser'), 'impressions' );
		JToolBarHelper::editListX();
        JToolBarHelper::deleteList();
        JToolBarHelper::addNewX();
        
        // Note: Standard code for the pagination function of the Joomla framework
		$model->limit = $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$model->limitstart = $mainframe->getUserStateFromRequest($option.'.limitstart', 'limitstart', 0, 'int');
	
		$pagination = new JPagination($model->_count, $model->limitstart, $model->limit);

		// Note: Standard code for the sorting functions of the Joomla framework (sort columns by clicking on the column names)
		$model->filter_order = JRequest::getVar('filter_order', 'id', '', 'string');
		$model->filter_order_dir = JRequest::getVar('filter_order_Dir', 'asc', '', 'string');
		
		$order = new stdClass();
        $order->filter_order = $model->filter_order;
        $order->filter_order_dir = ($model->filter_order_dir == "desc" ? "desc" : "asc");

		// Load the ads
		$ads = $this->get('Ads');

		// Assign the parts that we are going to use in the template for the view (tmpl/default.php)
		$this->assignRef('ads', $ads);
		$this->assignRef('user', $user);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('order', $order);
		
		// Continue in the view template
		parent::display($tpl);
	}
}

?>

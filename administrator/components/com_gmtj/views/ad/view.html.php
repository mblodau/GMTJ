<?php

// No direct access
defined('_JEXEC') or die();
 
jimport('joomla.application.component.view');
jimport('joomla.html.pagination');

class GMTJViewAd extends JView 
{
	function display( $tpl = null ) 
	{
		global $option, $mainframe;
		
		$model = $this->getModel();
		
		$cid = JRequest::getVar( 'cid',  0, '', 'array' );
		$id = $cid[0];
		
		$ad = $model->getData( $id );
		
		// Create the toolbar		
		JToolBarHelper::title(JText::_('Annons'), 'generic');
        JToolBarHelper::save();
        JToolBarHelper::apply();
        JToolBarHelper::cancel();
		
		// Get the user object of the ad owner
		if (!empty($ad->created_by)) {
			
			// We already have an owner and fetch his user details
			$user = JFactory::getUser($ad->created_by);
			
		} else {
		
			// We have no owner (new record) and fetch the details of the user who is creating the record
			$user = JFactory::getUser();
		}
		
		// Create the different kinds of lists for the view
		
		// Create select box for fuel type
		$tmp = array();
		$tmp[] = JHTML::_( 'select.option', 'gas', JText::_('gas'), 'id', 'name' );
		$tmp[] = JHTML::_( 'select.option', 'diesel', JText::_('diesel'), 'id', 'name' );
		$tmp[] = JHTML::_( 'select.option', 'eco', JText::_('eco'), 'id', 'name' );

		$lists['fuel'] = JHTML::_('select.genericlist', $tmp, 'fuel', 'class="inputbox" size="1"', 'id', 'name', $ad->fuel);
		
		
		// Create radio box for published/unpublished
		if (JRequest::getVar( 'task', '' ) == 'add') {
		
			$published_default = 1;
			
		} else {
		
			$published_default = $ad->published;
			
		}

		$lists['published'] = JHTML::_( 'select.booleanlist', 'published', 'class="inputbox"', $published_default );

		$this->assignRef( 'ad', $ad );
		$this->assignRef( 'user', $user);
		$this->assignRef( 'lists', $lists);
		$this->assignRef( 'editor', JFactory::getEditor() );
		
		parent::display( $tpl );
	}
}

?>
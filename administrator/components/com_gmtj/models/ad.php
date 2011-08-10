<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
 
jimport( 'joomla.application.component.model' );

class GMTJModelAd extends JModel 
{
	function getData($id = 0) 
	{
		$this->_id = $id;
		$this->_data = null;
	
		if( empty( $this->_data ) ) 
		{
			$query = 'SELECT ads.* FROM `#__gmtj_ads` AS ads'.
						' WHERE ads.id = '.$this->_id;

			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();

			if( mysql_error() ) 
			{
				JError::raiseWarning( mysql_errno(), mysql_error() );
			}		
		}
	
		if( !$this->_data ) 
		{
        	$this->_data = new stdClass();
       		$this->_data->id = 0;
    	}

		return $this->_data;
	}

	function store($data) 
	{	
		$row = $this->getTable();
		
		// -- If cid exist load the existing row.
		if( $data['cid'][0] ) 
			$row->load( $data['cid'][0] );
		
		// Check if the created datetime stamp is empty and a datetime if necessary
		// Note: Bug in how Joomla calculates the summer and winter time. Had to use the GMT+2 time zone instead of GMT+1 in order to get a 2 hour time offset.
		if (empty($data['created'])) 
		{
			$JApp =& JFactory::getApplication();
	  		$date = JFactory::getDate();
			$date->setOffset($JApp->getCfg('offset'));

			$data['created'] = $date->toFormat();
		}
		
		// Add user id to created_by 
		// For now just the user id of the backend user that created the record. If time permits add some logic for real users.
		if (empty($data['created_by']))
		{
			$user = JFactory::getUser();
			$data['created_by'] = $user->id;
		}	
		
		if( !$row->bind( $data ) ) 
			return false;

		if( !$row->store() ) 
			return false;

		// -- If this was a new row, we got an id from the store() so set it.
		$this->_id = $row->id;

		return true;
	}
}

?>

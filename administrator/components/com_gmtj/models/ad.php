<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
 
jimport( 'joomla.application.component.model' );

class GMTJModelAd extends JModel {

	// Note: The getData function is also just some standard code for fetching single records. Nothing special.	
	function getData($id = 0) {
	
		$this->_id = $id;
		$this->_data = null;
	
		if( empty( $this->_data ) ) {
		
			$query = 'SELECT ads.* FROM `#__gmtj_ads` AS ads'.
						' WHERE ads.id = '.$this->_id;

			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();

			if( mysql_error() ) {
			
				JError::raiseWarning( mysql_errno(), mysql_error() );
			}		
		}
	
		if( !$this->_data ) {
		
        	$this->_data = new stdClass();
       		$this->_data->id = 0;
    	}

		return $this->_data;
	}

	// Note: Here i added some special code. Worth a look.
	function store($data) {	
		
		// Use the table class (tables/ad.php)
		$row = $this->getTable();
		
		// If we come from the list view and want to edit an existing record, we load the record by it's ID
		if( $data['cid'][0] ) 
			$row->load( $data['cid'][0] );
		
		// Add a datetime stamp to the "created" field in table. This field will be used in the frontend for displaying how old the ad is.
		// Note: Bug in how Joomla calculates the summer and winter time. Had to use the GMT+2 time zone instead of GMT+1 in order to get a 2 hour time offset.
		if (empty($data['created'])) {
		
			$JApp =& JFactory::getApplication();
	  		$date = JFactory::getDate();
			$date->setOffset($JApp->getCfg('offset'));

			$data['created'] = $date->toFormat();
		}

		// Grabbing the id of the admin user that created the record and using that as the id of the ad owner.
		// Note: This is just some demo fix for getting some kind of user id into the created_by field which will be used for showing the owner of the add in the fronted part.
		// TODO: Add some real logic for ad owners.
		if (empty($data['created_by']))	{
		
			$user = JFactory::getUser();
			$data['created_by'] = $user->id;
		}	
		
		if( !$row->bind( $data ) ) 
			return false;

		if( !$row->store() ) 
			return false;

		// If this was a new row, we got an id from the store() so set it.
		// Note: We don't need this id in this small demo component at this point in the code. But it is Joomla standard code and can be useful for bigger solutions.
		$this->_id = $row->id;

		return true;
	}
}

?>

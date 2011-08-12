<?php
// Note: Nothing special in here. It's standard code for fetching the records of a table and add the sorting functions of the Joomla framework. (Try clicking on a column name in the admin list view for the ads)
// I haven't used any creativity here. ;-)

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();
 
jimport('joomla.application.component.model');

class GMTJModelAds extends JModel {	

	var $filter_order = 'id';
 	var $filter_order_dir = 'asc';
 	var $limitstart = 0;
 	var $limit = 0;
	
	function getAds() {
	
		global $mainframe, $option;
		
		$db = $this->_db;
		
		$order = ' ORDER BY ads.'.$db->getEscaped( $this->filter_order ).' '.$db->getEscaped( $this->filter_order_dir );
						
		if( empty( $this->_data ) ) {
		
            $query = 'SELECT ads.* from `#__gmtj_ads` as ads';
			
			$query .= $order;
						
			$this->_count = $this->_getListCount( $query );
			$this->_data = $this->_getList( $query, $this->limitstart, $this->limit );
			
			if(mysql_error()) {
			
				JError::raiseWarning(mysql_errno(), mysql_error());
			}
		}

        if( !$this->_data ) 
	        $this->_data = array();
		
	    return $this->_data;
    }

}

?>

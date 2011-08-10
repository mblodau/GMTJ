<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

class TableAd extends JTable 
{	
	var $id = null;
	var $title = null;
	var $description = null;
	var $price = null;
	var $model_year = null;
	var $mileage = null;
	var $fuel = null;
	var $created = null;
	var $created_by = null;
	var $published = 1;
	
	function check()
	{
		// Validation
		if( intval( $this->facs_id ) == 0 )
			return false;
		if( intval( $this->ammount ) == 0 )
			return false;
		return true;
	}
	
	/*
	$createdate =& JFactory::getDate();
	$row->created = $createdate->toUnix();
	*/
	
	function __construct( &$db ) 
	{
		parent::__construct( '#__gmtj_ads', 'id', $db );
	}	
}
?>

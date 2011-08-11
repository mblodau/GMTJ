<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

// Note: Table classes in Joomla are good for saving, loading or deleting single records that are not connected to other tables.
// They are normally used instead of pure SQL queries for these simple actions because it is faster, results in cleaner code and validations 
// plus typecasting can be put into the check() function.
// 
// As soon as there is relationships involved (1:n, n:n) it is better to use SQL queries. Examples for that can be found in the search function of the frontend part of com_gmt. File: components/com_gmtj/models/ads.php

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
	
	}
		
	function __construct( &$db ) 
	{
		parent::__construct( '#__gmtj_ads', 'id', $db );
	}	
}
?>

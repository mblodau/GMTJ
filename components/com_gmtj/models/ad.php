<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

class GMTJModelAd extends JModel {

	// Function for fetching a single ad by its ID. 
	function getAd($id)	{
	
		$db =& $this->_db;

		// Note: the quote function from the database object is there for prevention of SQL injection. It removes characters that are necessary for a SQL query and also puts some quotes around the string. 		
		$query =	'SELECT ad.* FROM #__gmtj_ads AS ad '.
					'WHERE ad.id = '.$db->quote($id);
		
		$db->setQuery( $query );

		$result = $db->loadObject();
		
		if(mysql_error()) {
		
			JError::raiseWarning(mysql_errno(), mysql_error());
		}
		
		return $result;
    }


}

?>
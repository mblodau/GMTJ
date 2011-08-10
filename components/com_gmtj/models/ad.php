<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

class GMTJModelAd extends JModel
{

	function getAd($id) 
	{
		$db =& $this->_db;

		$today = date( 'Y-m-d H:i:s', time() );
		
		$query =	'SELECT ad.* FROM #__gmtj_ads AS ad '.
					'WHERE ad.id = '.$db->quote($id);
		
		$db->setQuery( $query );

		$result = $db->loadObject();
		
		if(mysql_error()) 
		{
			JError::raiseWarning(mysql_errno(), mysql_error());
		}
		
		return $result;
    }


}

?>
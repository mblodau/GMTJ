<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

class GMTJModelAds extends JModel
{
	var $filter_order = 'id';
 	var $filter_order_dir = 'asc';
 	var $limitstart = 0;
 	var $limit = 0;
	
	function getAds() 
	{
		global $mainframe, $option;
		
		$db = $this->_db;
		
		$order = ' ORDER BY ads.'.$db->getEscaped( $this->filter_order ).' '.$db->getEscaped( $this->filter_order_dir );
						
		if( empty( $this->_data ) ) 
		{
            $query = 'SELECT ads.* from `#__gmtj_ads` as ads';
			
			$query .= $order;
						
			$this->_count = $this->_getListCount( $query );
			$this->_data = $this->_getList( $query, $this->limitstart, $this->limit );
			
			if(mysql_error()) 
			{
				JError::raiseWarning(mysql_errno(), mysql_error());
			}
		}

        if( !$this->_data ) 
	        $this->_data = array();
		
	    return $this->_data;
    }
    
    function checkSearch($search) {
    
    	// Note: In this stage the following code is too complex because right now there is only the search string. 
    	// It is a preparation for adding more search parameters like "mileage from", "mileage to", "price from", "price to" and so on.
    	
    	if (!empty($search)) {
    	
	    	foreach ($search AS $value) {
	    	
	    		if (!empty($value)) {
	    		
	    			return true;
	    			
	    		}
	    		
	    	}
	    
	    }

    	return false;
    }
    
    function cleanSearchString($search_string) {
    
    	// Make sure that there's only lower case characters in the string
		$special_chars = strtolower($special_chars);
		
    	// Remove the common words that will just clog up the search results and slow down the query
    	// TODO: Add more common words. This is only a proof-of-concept thingie right now.
    	$common_words = array("och", "om", "varje", "en", "jag");
		
		foreach ($common_words AS $word) {
		
			$search_string = str_replace($word, ' ', $search_string );
			
		}	

		// Get rid of special characters
		$special_chars = array('/','\\','\'','"',',','.','<','>','?',';',':','[',']','{','}','|','=','+','-','_',')','(','*','&','^','%','$','#','@','!','~','`');
		
		foreach ($special_chars AS $char) {
		
			$search_string = str_replace($char, ' ', $search_string);
			
		}
		
		// Need to get rid of unnecessary spaces
    	return trim($search_string);
    }
    
    function splitSearchString($search_string) {

		// Split the search string into words
		$search_string = explode(' ', $search_string);
		
		// Only allow words that are at least 2 characters long
		$cleaned_string = array();
		
		foreach ($search_string AS $value) {
		
			if (strlen($value)>=2) {
			
				$cleaned_string[] = $value;
				
			}	
		}
				   
    	return $cleaned_string;
    }
    
    function search($search) {
    	
    	// General part of the search query
		$db =& $this->_db;

    	$query =	'SELECT ads.* FROM #__gmtj_ads AS ads ';
    	
    	// Clean the search string from special characters and common words
		$search_string = $this->cleanSearchString($search['string']);
		
		// Split the search string into separate words and only allow words with at least two characters
		$search_string = $this->splitSearchString($search_string);
		
    	// Build the WHERE part of the query
    	// Rules: Search for each word in the title and description. Only return a hit if there is a hit for each search word in the title or the description.
    	
    	$i=1;
    	$where = 'WHERE ';
    	
    	foreach ($search_string AS $value) {
    	
    		// Make sure that the AND only gets inserted between the (… OR …) parts for each word. Shouldn't be added to the end.
    		if ($i>1) {
    		
    			$where .=	' AND ';
    		
    		}

    		$where .=	' ( ads.title LIKE "%'.$db->getEscaped($value).'%" OR ads.description LIKE "%'.$db->getEscaped($value).'%" ) ';
    		
    		    		
    		++$i;
    		
    	}
  		
  		// Add one more parameter because we only want to display ads that are published
  		$where .= ' AND ( ads.published = 1 ) ';
  		
  		// Add the WHERE part to the rest of the query
  		$query .= $where;
  			  	
    	$db->setQuery($query);
    	
    	$result = $db->loadObjectList();
    	
    	if(mysql_error()) 
		{
			JError::raiseWarning(mysql_errno(), mysql_error());
		}	
   
  		if( !$result ) {
  		
	        $result = array();
	        
	    }

    	return $result;
    }


}

?>

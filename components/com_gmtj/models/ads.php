<?php
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

class GMTJModelAds extends JModel {

	function getAds() {
	
		global $mainframe, $option;
		
		$db =& $this->_db;

		// Note: The #_ part of the table name gets replaced by the table prefix which is defined in the global configuration of Joomla. (Default is the table prefix "jos")
		// This makes it possible to have the tables for several Joomla sites in the same database.
		$query =	'SELECT ads.* FROM #__gmtj_ads as ads '.
					'ORDER BY ads.created DESC';
	
		$db->setQuery($query);
		
		$result = $db->loadObjectList();
		
		if(mysql_error()) {
		
			JError::raiseWarning(mysql_errno(), mysql_error());
		}
        
	    return $result;
    }
    
    function checkSearch($search) {
    
    	// Note: In this stage the following code is basically too complex because right now there is only the search string. 
    	// It is a preparation for adding more search parameters like "mileage from", "mileage to", "price from", "price to" and so on.
    	
    	if (!empty($search)) {
    	
    		// Loop trough the array that contains possible search parameters and see if any of them have some content.
    		// If no search has been initiated then just use the getAds() function instead of the search() function for fetching the ads. Makes the site faster.
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
		$special_chars = array('"','<','>','?',';','[',']','{','}','|','=','+','-','_',')','(','*','&','^','%','$','#','@','!','~','`');
		
		foreach ($special_chars AS $char) {
		
			// Replace all special chars with a space sign. The space sign has the positive benefit of creating more search words in certain search strings. Like this: "Volkswagen+Passat" becomes "volkswagen passat"
			$search_string = str_replace($char, ' ', $search_string);
			
		}
		
		// Need to get rid of as many unnecessary space signs as possible to make the loop in the splitSearchString() function work a bit less
    	return trim($search_string);
    }
    
    function splitSearchString($search_string) {

		// Split the search string into separate words
		$search_string = explode(' ', $search_string);
		
		// Only allow words that are at least 2 characters long. Would prefer three characters but there could be a lot of searches for cars with just two chars. Like this: "VW Passat"
		$split_string = array();
		
		foreach ($search_string AS $value) {
		
			if (strlen($value)>=2) {
			
				$split_string[] = $value;
				
			}	
		}
				   
    	return $split_string;
    }
    
    function search($search) {
    	
    	$db =& $this->_db;

		// General part of the search query
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

			// Note: The getEscaped() function does nearly the same as the quote() function from before. 
			// It also cleans the string from all dangerous chars. Only difference is that getEscaped doesnt put single quotes around the string. 
			// In this case the quote() function would create syntax errors in the query since we need to have % signs around the strings.
    		$where .=	' ( ads.title LIKE "%'.$db->getEscaped($value).'%" OR ads.description LIKE "%'.$db->getEscaped($value).'%" ) ';
    			    		
    		++$i;
    		
    	}
  		
  		// Add one more parameter because we only want to display ads that are published
  		$where .= ' AND ( ads.published = 1 ) ';
  		
  		// Add the WHERE part to the rest of the query
  		$query .= $where;
  		
  		// Add the ORDER part to the query;
  		$query .= ' ORDER BY ads.created DESC ';
  			  	
    	$db->setQuery($query);
    	
    	$result = $db->loadObjectList();
    	
    	if(mysql_error()) {
    	
			JError::raiseWarning(mysql_errno(), mysql_error());
		}	
   
    	return $result;
    }


}

?>

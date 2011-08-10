<?php
// no direct access
defined('_JEXEC') or die('Restricted access');


class GMTJHelperHelper extends JObject {
	
	function getDate($datetime) {
		
		// Get current datetime with the offset from the Global Configuration
		$JApp =& JFactory::getApplication();
  		$date = JFactory::getDate();
		$date->setOffset($JApp->getCfg('offset'));

		// Build some nicer date values for the following comparison
		$today = 	 date ( 'Y-m-j', strtotime ( $date->toFormat() ) );
		$yesterday = date ( 'Y-m-j', strtotime ( '-1 day' , strtotime ( $date->toFormat() ) ) );
		$created =   date ( 'Y-m-j', strtotime ( $datetime ) );
		
		$date = '';
		// Compare the created date with todays and yesterdays date
		if ($created==$today) {
			
			$date = JText::_('Idag');
				
		} else if ($created==$yesterday) {
		
			$date = JText::_('Igår');
			
		} else {
		
			$date = date ( 'j M', strtotime ( $datetime ) );
		}	
		
		return $date;
	}
	
	function getDateRaw($datetime) {
	
		$result = date ( 'j M', strtotime ( $datetime ) );
		
		return $result;
	}
	
	function getTime($datetime) {
	
		$result = date ( 'H:i', strtotime ( $datetime ) );
		
		return $result;
	}
	
	function getPrice($price) {
	
		// Make the price easier to read by adding a space as thousand separator
		// Since we don't allow any decimals in the price also add a ":-" to the end of the price to make it look more swedish. 
		
		$result = number_format ($price, 0, ',', ' ').':-';
		
		return $result;
	}
	
	function getMileage($mileage) {
		
		// Add a thousand separator to the mileage
		
		$result = number_format ($mileage, 0, ',', ' ');
		
		return $result;
	}
	
}
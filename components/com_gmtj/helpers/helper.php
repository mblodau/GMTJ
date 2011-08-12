<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

// Helper class with a few practical functions that can be useful in more then just one view or model
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
		// Compare the created date with todays and yesterdays date.
		if ($created==$today) {
			
			$date = JText::_('Idag');
				
		} else if ($created==$yesterday) {
		
			$date = JText::_('Igår');
			
		} else {
		
			// j M --> for example: "19 jun"
			$date = date ( 'j M', strtotime ( $datetime ) );
		}	
		
		return $date;
	}
	
	function getDateRaw($datetime) {
	
		// We just want the date in the j M format without any logic about today or yesterday. Being used for date display in the ad view
		$result = date ( 'j M', strtotime ( $datetime ) );
		
		return $result;
	}
	
	function getTime($datetime) {
	
		// Just return the time
		$result = date ( 'H:i', strtotime ( $datetime ) );
		
		return $result;
	}
	
	function getPrice($price) {
	
		// Make the price easier to read by adding a space as thousand separator
		// Since we don't allow any decimals in the price also add a ":-" to the end of the price to give it a swedish touch.
		$result = number_format ($price, 0, ',', ' ').':-';
		
		return $result;
	}
	
	function getMileage($mileage) {
		
		// Add a thousand separator to the mileage
		$result = number_format ($mileage, 0, ',', ' ');
		
		return $result;
	}
	
}
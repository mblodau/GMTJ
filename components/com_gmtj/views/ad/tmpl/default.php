<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Prepare some values 

// Get the ad owners name
$user = JFactory::getUser($this->ad->created_by)->name;

// Get a nicer version of the date (for example: 19 Jun)
$date = GMTJHelperHelper::getDateRaw($this->ad->created);

// Get the time
$time = GMTJHelperHelper::getTime($this->ad->created);

// Get a nice looking price
$price = GMTJHelperHelper::getPrice($this->ad->price);

// Get a nice looking mileage value
$mileage = GMTJHelperHelper::getMileage($this->ad->mileage);
?>

<div class="gmtj_item">

	<h1>
		<?php echo $this->ad->title; ?>
	</h1>
	
	<div class="gmtj_header_info">
		
		<?php echo (JText::_('Säljes av'));?>
		
		<!-- Just put a demo link around the user to display that this could be expanded by calling the search function and returning all ads from the ad owner -->
		<a href="#">
			<?php echo $user; ?>
		</a>
		
		<?php echo (JText::_('sedan').' '.$date.' '.$time); ?>
		
	</div>
	
	<div class="gmtj_item_media">
	
		<!-- Just some placeholder image. No time for adding proper logic that would enable image upload, automatic resizing, storing the image on the server and so on -->
		<img src="images/stories/ads/placeholder.jpg" />
		
	</div>
	
	<div class="gmtj_item_params">
		
		<div class="gmtj_params_col col1">
			<?php echo (JText::_('Pris:')); ?>&nbsp;
			<strong>
				<?php echo $price; ?>
			</strong>
		</div>
		
		<div class="gmtj_params_col col2">
			<?php echo (JText::_('Modellår:')); ?>&nbsp;
			<strong>
				<?php echo $this->ad->model_year; ?>
			</strong>
		</div>
	
		<div class="gmtj_params_col col3">
			<?php echo (JText::_('Miltal:')); ?>&nbsp;
			<strong>
				<?php echo $mileage; ?>
			</strong>
		
		</div>
		
		<div class="gmtj_params_col col4">
			<?php echo (JText::_('Bränsle:')); ?>&nbsp;
			<strong>
				<?php echo (JText::_($this->ad->fuel)); ?>
			</strong>
		
		</div>	
	
	</div>
	
	<div class="gmtj_item_description">
		<?php echo $this->ad->description; ?>
	</div>
</div>
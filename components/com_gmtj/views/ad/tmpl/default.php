<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$user = JFactory::getUser($this->ad->created_by)->name;
$date = GMTJHelperHelper::getDateRaw($this->ad->created);
$time = GMTJHelperHelper::getTime($this->ad->created);
$price = GMTJHelperHelper::getPrice($this->ad->price);
$mileage = GMTJHelperHelper::getMileage($this->ad->mileage);
?>

<div class="gmtj_item">

	<h1>
		<?php echo $this->ad->title; ?>
	</h1>
	
	<div class="gmtj_header_info">
		
		<?php echo (JText::_('Säljes av'));?>
		
		<a href="#">
			<?php echo $user; ?>
		</a>
		
		<?php echo (JText::_('sedan').' '.$date.' '.$time); ?>
		
	</div>
	
	<div class="gmtj_item_media">
	
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
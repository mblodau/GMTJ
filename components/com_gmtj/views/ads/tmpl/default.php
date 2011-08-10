<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/*
echo ("<pre>");
print_r($this->ads);
echo ("</pre>");
*/

?>
<div class="gmtj_list">

	<?php foreach($this->ads AS $ad) { 
	
		$link		= JRoute::_('index.php?option=com_gmtj&controller=ad&task=edit&cid='. $ad->id );

		$date = GMTJHelperHelper::getDate($ad->created);
		$time = GMTJHelperHelper::getTime($ad->created);
		$price = GMTJHelperHelper::getPrice($ad->price);
		
		?>
	
		
		<div class="gmtj_list_item">
			
			<div class="gmtj_item_date">
			
				<span class="gmtj_item_day">
					 <?php echo $date; ?>
				</span>
				<span class="gmtj_item_time">
					<?php echo $time; ?>
				</span>
				
			</div>
			
			<div class="gmtj_item_image">
			
				<a href="<?php echo $link; ?>">
					<img src="images/stories/ads/placeholder_thumbnail.jpg" />
				</a>
				
			</div>
			
			<div class="gmtj_item_info">
				
				<h1>
					<a href="<?php echo $link; ?>">
						<?php echo $ad->title; ?>
					</a>
				</h1>
				
				<p class="gmtj_item_price">
					<?php echo $price; ?>
				</p>
				
			</div>
			
		</div>
		
	<?php } ?>
</div>
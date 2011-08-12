<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div id="gmtj_search">
	<form id="searchForm" action="<?php echo JRoute::_( 'index.php?option=com_gmtj' );?>" method="post" name="searchForm">
		
		<div class="gmtj_search_field">
			<!-- Right now it is pointless that we store the search word in an array. But the idea was that the search[] array would be used for passing on future search values like "price_from", "price_to" and so on.-->
			<input type="text" name="search[string]" id="gmtj_searchword" size="30" maxlength="20" value="<?php echo $this->search['string']; ?>" class="inputbox" />
		</div>
		
		<div class="gmtj_search_button">
			<button name="Search" onclick="this.form.submit();" class="button"><?php echo JText::_( 'Sök' );?></button>
		</div>
		
		<div class="gmtj_search_button">
			<button onclick="document.getElementById('gmtj_searchword').value='';this.form.submit();" class="button"><?php echo JText::_( 'Återställ' );?></button>
		</div>
	
		<input type="hidden" name="option" value="com_gmtj" />
		<input type="hidden" name="task" value="search" />
		<input type="hidden" name="controller" value="ads" />
	</form>
</div>

<div id="gmtj_list">

	<?php foreach($this->ads AS $ad) { 
	
		$link		= JRoute::_('index.php?option=com_gmtj&controller=ad&task=edit&cid='. $ad->id );

		//Prepare some values
		
		// Get a nicer looking date (Idag, Igår, 19 Jun)
		$date = GMTJHelperHelper::getDate($ad->created);
		
		// Get the time
		$time = GMTJHelperHelper::getTime($ad->created);
		
		// Get a nice looking price
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
					<!-- Just some placeholder image. No time for adding proper logic that would enable image upload, automatic resizing, storing the image on the server and so on -->
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
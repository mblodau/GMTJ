<?php
// No direct access
defined('_JEXEC') or die();
?>

<form action="index.php?option=com_gmtj" method="post" name="adminForm">

	<div class="col width-50 left">
	
		<div class="col width-100">
	
			<fieldset class="adminform">
	
				<legend><?php echo JText::_( "Info" ) ?></legend>
	
				<table class="admintable">
					
					<tr>
				    	<td class="key">
				    		<label for="title"><?php echo JText::_( 'Titel' ) ?></label>
				    	</td>
						<td>
							<input type="text" size="50" value="<?=(empty($this->ad->title)) ?  '' : $this->ad->title;?>" name="title" id="title"/>
						</td>
					</tr>
					
					<tr>
				    	<td class="key">
				    		<label for="description"> <?php echo JText::_( 'Beskrivning' ); ?> </label>
				    	</td>
				        <td colspan="3">
				        	<?php echo $this->editor->display('description', $this->ad->description, '100%', '350', '40', '10');?>
				        </td>
				    </tr>
	
				</table>
				
			</fieldset>
			
		</div>
	
		<div style="clear:both;"></div>
		
		<div class="col width-100">
	
			<fieldset class="adminform">
	
				<legend><?=JText::_( "Parametrar" ) ?></legend>
	
				<table class="admintable">
	
					<tr>
				    	<td class="key">
				    		<label for="price"><?php echo JText::_( 'Pris' ) ?></label>
				    	</td>
						<td>
							<input type="text" size="50" value="<?=(empty($this->ad->price)) ?  '' : $this->ad->price;?>" name="price" id="price"/>
						</td>
					</tr>
	
					<tr>
				    	<td class="key">
				    		<label for="model_year"><?php echo JText::_( 'Modellår' ) ?></label>
				    	</td>
						<td>
							<input type="text" size="50" value="<?=(empty($this->ad->model_year)) ?  '' : $this->ad->model_year;?>" name="model_year" id="model_year"/>
						</td>
					</tr>
	
					<tr>
				    	<td class="key">
				    		<label for="mileage"><?php echo JText::_( 'Miltal' ) ?></label>
				    	</td>
						<td>
							<input type="text" size="50" value="<?=(empty($this->ad->mileage)) ?  '' : $this->ad->mileage;?>" name="mileage" id="mileage"/>
						</td>
					</tr>
					
					<tr>
				    	<td class="key">
				    		<label for="fuel"><?php echo JText::_( 'Bränsle' ) ?></label>
				    	</td>
						<td>
							<?php echo (empty($this->lists['fuel'])) ? '' : $this->lists['fuel']; ?>
						</td>
					</tr>
					
				</table>
				
			</fieldset>
			
		</div>
		
		<div style="clear:both;"></div>
		
		<div class="col width-100">
	
			<fieldset class="adminform">
	
				<legend><?php echo JText::_( "Tekniskt info" ) ?></legend>
	
				<table class="admintable">
					
					<tr>
				    	<td class="key">
				    		<label for="created"><?php echo JText::_( 'Skapat' ) ?></label>
				    	</td>
						<td>
							<?php echo (empty($this->ad->created)) ?  '' : $this->ad->created;?>
						</td>
					</tr>
	
					<tr>
				    	<td class="key">
				    		<label for="user_name"><?php echo JText::_( 'Ägare' ) ?></label>
				    	</td>
						<td>
							<?php echo ($this->user->name);?>
						</td>
					</tr>
	
					<tr>
				    	<td class="key">
				    		<label for="published"><?php echo JText::_( 'Aktiv' ) ?></label>
				    	</td>
						<td>
							<?php echo (empty($this->lists['published'])) ? '' : $this->lists['published']; ?>
						</td>
					</tr>
					
					<tr>
				    	<td class="key">
				    		<label for="id"><?php echo JText::_( 'ID' ) ?></label>
				    	</td>
						<td>
							<?php echo (empty($this->ad->id)) ?  '' : $this->ad->id;?>
						</td>
					</tr>
	
				    
				</table>
				
			</fieldset>
			
		</div>
	
	</div>

	<input type="hidden" name="created" value="<?=(empty($this->ad->created)) ?  '' : $this->ad->created;?>"/>
	<input type="hidden" name="created_by" value="<?=(empty($this->ad->created_by)) ?  '' : $this->ad->created_by;?>"/>
	<input type="hidden" name="option" value="com_gmtj" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="controller" value="ad" />
	<input type="hidden" name="cid[]" value="<?php echo $this->ad->id; ?>" />
	
</form>

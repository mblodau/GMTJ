<?php
// Note: The whole structure in this file is standard code for displaying a list view in order to get all the help and extra stuff from the Joomla framework

// No direct access
defined('_JEXEC') or die();
?>

<form action="index.php?option=com_gmtj" method="post" name="adminForm">

<table class="adminlist">
	<thead>
		<th width="25">
			<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->ads ); ?>);" />
		</th>
		<th width="5">
			<?php echo JText::_('#'); ?>
		</th>
		<th width="420" style="text-align: left;">
			<?php echo JHTML::_('grid.sort', 'Titel', 'title', $this->order->filter_order_dir, $this->order->filter_order ); ?>
		</th>
		<th width="420" style="text-align: left;">
			<?php echo JHTML::_('grid.sort', 'Pris', 'price', $this->order->filter_order_dir, $this->order->filter_order ); ?>
		</th>
		<th width="420" style="text-align: left;">
			<?php echo JHTML::_('grid.sort', 'Modellår', 'model_year', $this->order->filter_order_dir, $this->order->filter_order ); ?>
		</th>
		<th width="420" style="text-align: left;">
			<?php echo JHTML::_('grid.sort', 'Miltal', 'mileage', $this->order->filter_order_dir, $this->order->filter_order ); ?>
		</th>
		<th width="420" style="text-align: left;">
			<?php echo JHTML::_('grid.sort', 'Bränsle', 'fuel', $this->order->filter_order_dir, $this->order->filter_order ); ?>
		</th>
		<th width="420" style="text-align: left;">
			<?php echo JHTML::_('grid.sort', 'Skapat', 'created', $this->order->filter_order_dir, $this->order->filter_order ); ?>
		</th>
		<th width="420" style="text-align: left;">
			<?php echo JHTML::_('grid.sort', 'Ägare', 'created_by', $this->order->filter_order_dir, $this->order->filter_order ); ?>
		</th>
		<th width="5">
			<?php echo JHTML::_('grid.sort', 'Aktiv', 'published', $this->order->filter_order_dir, $this->order->filter_order ); ?>
		</th>
		<th width="10">
			<?php echo JHTML::_('grid.sort', 'ID', 'id', $this->order->filter_order_dir, $this->order->filter_order ); ?>
		</th>
	</thead>
<tbody>
<?php
	for( $i=0, $n=count( $this->ads ); $i < $n; $i++ )
	{
		$row		=& $this->ads[$i];

		$checked	= JHTML::_('grid.id', $i, $row->id);
		$link		= JRoute::_('index.php?option=com_gmtj&controller=ad&task=edit&cid[]='. $row->id );
		
		// Get the user object of the ad owner
		if (!empty($row->created_by)) {
			
			// It's nicer to show the name of the ad owner and not just a number
			$user = JFactory::getUser($row->created_by)->name;
			
		} else {
		
			$user = '';
		}

		?>
		<tr class="<?php echo "row".$i%2; ?>">
			<td align="center">
				<?php echo $checked; ?>
			</td>
			<td>
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td>
				<a href="<?php echo $link ?>"><?php echo $row->title ?></a>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->price; ?></a>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->model_year; ?></a>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->mileage; ?></a>
			</td>
			<td>
				<!-- A little trick to display the different options of the enum field for the fuel types in a nicer way. There is a swedish word for each enum parameter in the swedish language file for com_gmtj -->
				<a href="<?php echo $link; ?>"><?php echo JText::_($row->fuel); ?></a>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->created; ?></a>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $user; ?></a>
			</td>
			<td>
				<?php echo JHTML::_('grid.published', $row, $i); ?>
			</td>
			<td>
				<?=$row->id; ?>
			</td>
		</tr>
		<?php
	}
  ?>
</tbody>
<tfoot>
	<tr>
        <td colspan="11">
            <?=$this->pagination->getListFooter(); ?>
        </td>
    </tr>
</tfoot>
</table>

<input type="hidden" name="option" value="com_gmtj" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="ads" />
<input type="hidden" name="filter_order" value="<?php echo $this->order->filter_order; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->order->filter_order_dir; ?>" />
</form>

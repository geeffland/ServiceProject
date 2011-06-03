<?php
/**
 * This view is called for to list all of the Addresses
 *
 * @version		$Id: default.php
 * @package		com_serviceproject
 * @subpackage	admin.views.addresses.tmpl
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers'.DS.'html');
JHtml::_('behavior.tooltip');

$baseurl = JURI::base();
$doc = & JFactory::getDocument();
// Add jQuery
$doc->addScript( $baseurl.'components/com_serviceproject/helpers/js/jquery-1.4.2.min.js');
// Add jQuery UI
$doc->addScript( $baseurl.'components/com_serviceproject/helpers/js/jquery-ui-1.8.5.custom.min.js');
$doc->addStyleSheet( $baseurl.'components/com_serviceproject/helpers/css/start/jquery-ui-1.8.5.custom.css');

$user		= JFactory::getUser();
$filters	= ($this->state->get('filter.search')!='') | ($this->state->get('filter.city')!='') | ($this->state->get('filter.state')!='') | ($this->state->get('filter.zipcode')!='');
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_serviceproject');
$saveOrder	= ($listOrder == 'a.ordering') & ($filters==false);
$cities		= ServiceProjectHelper::getCities(); //array();
$states		= ServiceProjectHelper::getStates(); //array();
$zipcodes	= ServiceProjectHelper::getZipcodes(); //array();
$canCreate	= $user->authorise('core.create',		'com_serviceproject');
$canEdit	= $user->authorise('core.edit',			'com_serviceproject');
$canChange	= $user->authorise('core.edit.state',	'com_serviceproject');
?>
<script type="text/javascript">
	var $j = jQuery.noConflict(); //Set jQuery to No-Conflict mode
	
	$j(function() {
	
		var masteraddr = $j ( "#masteraddress" ),
			allFields = $j( [] ).add( masteraddr ),
			tips = $j( ".validateTips" );
			
		function updateTips( t ) {
			tips
				.text( t)
				.addClass( "ui-state-highlight" );
			setTimeout(function() {
				tips.removeClass( "ui-state-highlight", 1500 )
			} , 500);
		}

		function checkSelection() {
			if (masteraddr.val()==-1) {
				masteraddr.addClass( "ui-state-error" );
				updateTips( "Please select a master address to merge into." );
				return false;
			} else {
				return true;
			}
		}
		
		$j( "#dialog-form").dialog({
			autoOpen: false,
			height: 220,
			width: 600,
			modal: true,
			buttons: {
				"Merge Addresses": function () {
					var bValid = true;
					allFields.removeClass( "ui-state-error" );
					// verify that some master address has been selected
					bValid = bValid && checkSelection();
					if ( bValid ) {
						$j( '#mergemaster' ).val( masteraddr.val() );
						$j( this ).dialog ( "close" );
						submitform('addresses.merge');
					}
				},
				Cancel: function() {
					$j( '#mergemaster' ).val( "" );
					$j( this ).dialog ( "close" );
				}
			},
			close: function() {
				allFields.removeClass( "ui-state-error" );
			}
		});

		$j( "#dialog-message").dialog({
			autoOpen: false,
			width: 500,
			modal: true,
			buttons: {
				Ok: function() {
					$j( this ).dialog ( "close" );
				}
			}
		});
	});
	
	function updateDropDown() {
		var theForm = document.forms["adminForm"], z = 0;
		var bValid = false;
		var numSelected = 0;
		// clear the drop down list
		// add the Select tag
		$j( "select[id$=masteraddress] > option" ).remove();
		$j( '#masteraddress' ).append(
			$j( '<option></option>').val(-1).html("-- Select the Master Address--")
		);
		for(z=0; z<theForm.length; z++){
			if(theForm[z].type == 'checkbox' && theForm[z].name != 'checkall' && theForm[z].checked == true){
				var addrName = $j( "#name-" + theForm[z].id ).text();
				var addrStreet = $j( "#street-" + theForm[z].id ).text();
				var addrCity = $j( "#city-" + theForm[z].id ).text();
				var addrState = $j( "#state-" + theForm[z].id ).text();
				var addrZIP = $j( "#zipcode-" + theForm[z].id ).text();
				var OptionLabel = "";
				if (addrName != "") {
					OptionLabel = addrName + "<br>";
				};
				OptionLabel = OptionLabel + addrStreet + "<br>" + addrCity  + ", " + addrState + " " + addrZIP;
				$j( '#masteraddress' ).append(
					$j( '<option></option>').val(theForm[z].value).html( OptionLabel )
				);
				numSelected = numSelected + 1;
				bValid = true;
			}
		}
		if ( bValid && numSelected > 1) {
			return true;
		} else {
			//alert('Only 1 item is selected.  Nothing to Merge.');
			$j( "#dialog-message" ).dialog( "open" );
			return false;
		}
	}

	//function submitbutton(task)
	Joomla.submitbutton = function(task)
	{
		if (task == "addresses.merge") {
			if ( updateDropDown() ) {
				$j( "#dialog-form" ).dialog( "open" );
			}
		} else {
			submitform(task);
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_serviceproject&view=addresses');?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->state->get('filter.search'); ?>" title="<?php echo JText::_('COM_SERVICEPROJECT_FILTER_ADDRESS_SEARCH_DESC'); ?>" />

			<button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>

		</div>
		<div class="filter-select fltrt">
			<select name="filter_city" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_SERVICEPROJECT_SELECT_CITY');?></option>
				<?php echo JHtml::_('select.options', $cities, 'value', 'text', $this->state->get('filter.city'));?>
			</select>

			<select name="filter_state" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_SERVICEPROJECT_SELECT_STATE');?></option>
				<?php echo JHtml::_('select.options', $states, 'value', 'text', $this->state->get('filter.state'));?>
			</select>

			<select name="filter_zipcode" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_SERVICEPROJECT_SELECT_ZIPCODE');?></option>
				<?php echo JHtml::_('select.options', $zipcodes, 'value', 'text', $this->state->get('filter.zipcode'));?>
			</select>

			<select name="filter_published" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_SERVICEPROJECT_SELECT_PUBLISHED');?></option>
				<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true);?>
			</select>
		</div>
	</fieldset>
	<div class="clr"> </div>

	<table class="adminlist">
		<thead>
			<tr>
				<th width="1%">
					<input type="checkbox" name="checkall-toggle" value="" onclick="checkAll(this)" />
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_ID', 'a.address_id', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_ADDRESSNAME', 'a.addressname', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_STREETADDRESS1', 'a.streetaddress1', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_CITY', 'a.city', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_STATE', 'a.state', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_ZIPCODE', 'a.zipcode', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_HASGPS', 'hasgps', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.published', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
					<?php if ($canOrder) :?>
						<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'addresses.saveorder'); ?>
					<?php endif; ?>

				</th>
				<th width="1%" class="nowrap">
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_DBID', 'a.id', $listDirn, $listOrder); ?>
				</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="15">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) :
			$item->max_ordering = 0; //??
			$canOrderUp = ($item->updatetype == @$this->items[$i-1]->updatetype);
			$canOrderDown = ($item->updatetype == @$this->items[$i+1]->updatetype);
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				</td>
				<td class="center">
					<?php echo (int) $item->address_id; ?>
				</td>
				<td align='center'>
					<?php if ($canEdit) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_serviceproject&task=address.edit&id='.$item->id);?>" id="name-cb<?php echo $i; ?>">
						<?php echo $this->escape($item->addressname); ?></a>
					<?php else : ?>
						<?php echo $this->escape($item->addressname); ?>
					<?php endif; ?>
				</td>
				<td align='center'>
					<?php if ($canEdit) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_serviceproject&task=address.edit&id='.$item->id);?>" id="street-cb<?php echo $i; ?>">
						<?php echo $this->escape($item->streetaddress1); ?></a>
					<?php else : ?>
						<?php echo $this->escape($item->streetaddress1); ?>
					<?php endif; ?>
				</td>
				<td align='center'>
					<?php if ($canEdit) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_serviceproject&task=address.edit&id='.$item->id);?>" id="city-cb<?php echo $i; ?>">
						<?php echo $this->escape($item->city); ?></a>
					<?php else : ?>
						<?php echo $this->escape($item->city); ?>
					<?php endif; ?>
				</td>
				<td align='center'>
					<?php if ($canEdit) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_serviceproject&task=address.edit&id='.$item->id);?>" id="state-cb<?php echo $i; ?>">
						<?php echo $this->escape($item->state); ?></a>
					<?php else : ?>
						<?php echo $this->escape($item->state); ?>
					<?php endif; ?>
				</td>
				<td align='center'>
					<?php if ($canEdit) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_serviceproject&task=address.edit&id='.$item->id);?>" id="zipcode-cb<?php echo $i; ?>">
						<?php echo $this->escape($item->zipcode); ?></a>
					<?php else : ?>
						<?php echo $this->escape($item->zipcode); ?>
					<?php endif; ?>
				</td>
				<td class="center">
					<a class="jgrid" >
						<?php if ($item->hasgps) : ?>
						<span class="state publish"><span class="text">Published</span></span>
						<?php else : ?>
						<span class="state unpublish"><span class="text">Unpublished</span></span>
						<?php endif; ?>
					</a>
				</td>
				<td class="center">
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'addresses.', $canChange); ?>
				</td>
				<td class="order">
					<?php if ($canChange) : ?>
						<?php if ($saveOrder) :?>
							<?php if ($listDirn == 'asc') : ?>
								<span><?php echo $this->pagination->orderUpIcon($i, $canOrderUp, 'addresses.orderup', 'JLIB_HTML_MOVE_UP', $saveOrder); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, $canOrderDown, 'addresses.orderdown', 'JLIB_HTML_MOVE_DOWN', $saveOrder); ?></span>
							<?php elseif ($listDirn == 'descF') :?>
								<span><?php echo $this->pagination->orderUpIcon($i, $canOrderUp, 'addresses.orderdown', 'JLIB_HTML_MOVE_UP', $saveOrder); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, $canOrderDown, 'addresses.orderup', 'JLIB_HTML_MOVE_DOWN', $saveOrder); ?></span>
							<?php endif; ?>
						<?php endif; ?>
						<?php $disabled = $canOrder ?  '' : 'disabled="disabled"'; ?>
						<input type="text" name="order[]" size="5" value="<?php echo $item->ordering;?>" <?php echo $disabled ?> class="text-area-order" />
					<?php else : ?>
						<?php echo $item->ordering; ?>
					<?php endif; ?>
				</td>
				<td class="center">
					<?php echo (int) $item->id; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<input type="hidden" name="mergemaster" id="mergemaster" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>

<div id="dialog-form" title="Select Merged Address (Master)">
	<p class="validateTips">Please Select the Address to merge into:</p>
	<p>NOTE: This will be the remaining address after the merge is copleted.</p>
	<form name="dialog" id="dialog">
		<fieldset>
			<label for="masteraddress">Merged Address </label>
			<select name="masteraddress" id="masteraddress">
			</select>
		</fieldset>
	</form>
</div>

<div id="dialog-message" title="Not enough Addresses selected to Merge">
	<p>Only one address was selected.</p>
	<p>Without two or more addresses selected there is nothing to merge.</p>
</div>
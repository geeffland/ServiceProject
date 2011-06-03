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
//$canOrder	= $user->authorise('core.edit.state', 'com_serviceproject');
//$saveOrder	= ($listOrder == 'a.ordering') & ($filters==false);
$linkmethods= ServiceProjectHelper::getLinkMethods(); //array();
$canregister= ServiceProjectHelper::getCanRegister(); //array();
$canmodify	= ServiceProjectHelper::getCanModify(); //array();
$canaccess	= ServiceProjectHelper::getCanAccess(); //array();
$canCreate	= $user->authorise('core.create',		'com_serviceproject');
$canEdit	= $user->authorise('core.edit',			'com_serviceproject');
$canChange	= $user->authorise('core.edit.state',	'com_serviceproject');
?>
<script type="text/javascript">
	var $j = jQuery.noConflict(); //Set jQuery to No-Conflict mode
	
	$j(function() {
	


	});
	
	//function submitbutton(task)
	Joomla.submitbutton = function(task)
	{
		if (task == "profiles.merge") {
			if ( updateDropDown() ) {
				$j( "#dialog-form" ).dialog( "open" );
			}
		} else {
			submitform(task);
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_serviceproject&view=linkedprofiles');?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->state->get('filter.search'); ?>" title="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />

			<button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>

		</div>
		<div class="filter-select fltrt">
			<select name="filter_linkmethod" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_SERVICEPROJECT_SELECT_LINKMETHOD');?></option>
				<?php echo JHtml::_('select.options', $linkmethods, 'value', 'text', $this->state->get('filter.linkmethod'));?>
			</select>

			<select name="filter_canregister" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_SERVICEPROJECT_SELECT_CANREGISTER');?></option>
				<?php echo JHtml::_('select.options', $canregister, 'value', 'text', $this->state->get('filter.canregister'));?>
			</select>

			<select name="filter_canmodify" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_SERVICEPROJECT_SELECT_CANMODIFY');?></option>
				<?php echo JHtml::_('select.options', $canmodify, 'value', 'text', $this->state->get('filter.canmodify'));?>
			</select>

			<select name="filter_canaccess" class="inputbox" onchange="this.form.submit()">
				<option value=""><?php echo JText::_('COM_SERVICEPROJECT_SELECT_CANACCESS');?></option>
				<?php echo JHtml::_('select.options', $canaccess, 'value', 'text', $this->state->get('filter.canaccess'));?>
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
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_USERID', 'a.user_id', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_USERNAME', 'usr.username', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_PROFILEID', 'a.profile_id', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_PROFILENAME', 'displayname', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_LINKMETHOD', 'a.link_method', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_CANREGISTER', 'a.canregister', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_CANMODIFY', 'a.canmodify', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_CANACCESS', 'a.canaccess', $listDirn, $listOrder); ?>
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
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php echo JHtml::_('grid.id', $i, $item->id); ?>
				</td>
				<td class="center">
					<?php echo (int) $item->id; ?>
				</td>
				<td class="center">
					<span id="userid-cb<?php echo $i; ?>"><?php echo (int) $item->user_id; ?></span>
				</td>
				<td align='center'>
					<?php if ($canEdit) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_serviceproject&task=linkedprofile.edit&id='.$item->id);?>" id="name-cb<?php echo $i; ?>">
						<?php echo $this->escape($item->username); ?></a>
					<?php else : ?>
						<?php echo $this->escape($item->username); ?>
					<?php endif; ?>
				</td>
				<td class="center">
					<span id="profileid-cb<?php echo $i; ?>"><?php echo (int) $item->profile_id; ?></span>
				</td>
				<td align='center'>
					<?php if ($canEdit) : ?>
					<a href="<?php echo JRoute::_('index.php?option=com_serviceproject&task=linkedprofile.edit&id='.$item->id);?>" id="name-cb<?php echo $i; ?>">
						<?php echo $this->escape($item->displayname); ?></a>
					<?php else : ?>
						<?php echo $this->escape($item->displayname); ?>
					<?php endif; ?>
				</td>
				<td align='center'>
					<?php echo ServiceProjectHelper::showLinkMethod($item->link_method); ?>
				</td>
				<td align='center'>
					<?php echo ServiceProjectHelper::showAskAllowDeny($item->canregister, 'COM_SERVICEPROJECT_CANREGISTER', 'COM_SERVICEPROJECT_CANNOTREGISTER'); ?>
				</td>
				<td align='center'>
					<?php echo ServiceProjectHelper::showAskAllowDeny($item->canmodify, 'COM_SERVICEPROJECT_CANMODIFYPROFILE', 'COM_SERVICEPROJECT_CANNOTMODIFYPROFILE'); ?>
				</td>
				<td align='center'>
					<?php echo ServiceProjectHelper::showAskAllowDeny($item->canaccess, 'COM_SERVICEPROJECT_CANACCESS', 'COM_SERVICEPROJECT_CANNOTACCESS'); ?>
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
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
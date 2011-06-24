<?php
/**
 * This view is called for to list all of the roles
 *
 * @version		$Id: default.php
 * @package		com_serviceproject
 * @subpackage	admin.views.projectroles.tmpl
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.DS.'helpers'.DS.'html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');
$baseurl = JURI::base();
$doc = & JFactory::getDocument();
//$doc->addScript( 'http://maps.google.com/maps/api/js?sensor=false');
//$doc->addScript( $baseurl.'components/com_serviceproject/views/address/tmpl/googlemapsapi.js');
//$doc->addStyleSheet( $baseurl.'components/com_serviceproject/helpers/css/start/jquery-ui-1.8.5.custom.css');
$doc->addScript( $baseurl.'components/com_serviceproject/js/jquery.min.js');
$doc->addScript( $baseurl.'components/com_serviceproject/js/jquerybase.js');
$doc->addScript( $baseurl.'components/com_serviceproject/js/ajaxbase.js');
$doc->addScript( $baseurl.'components/com_serviceproject/js/ajax.projectroles.js');

$user	= JFactory::getUser();
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_serviceproject');
$saveOrder	= ($listOrder == 'a.ordering');
$canCreate	= $user->authorise('core.create',		'com_serviceproject');
$canEdit	= $user->authorise('core.edit',			'com_serviceproject');
$canChange	= $user->authorise('core.edit.state',	'com_serviceproject');
?>
<form action="<?php echo JRoute::_('index.php?option=com_serviceproject&view=projectroles');?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->state->get('filter.search'); ?>" title="<?php echo JText::_('COM_SERVICEPROJECT_FILTER_ROLE_SEARCH_DESC'); ?>" />

			<button type="submit" class="btn"><?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?></button>
			<button type="button" onclick="document.id('filter_search').value='';this.form.submit();"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>

		</div>
		<div class="filter-select fltrt">
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
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_ID', 'a.role_id', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_ROLE', 'a.role', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_ROLELEVEL', 'a.role_level', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_CANMODPROJECTS', 'a.canmodifyproject', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_CANMODVOLUNTEERS', 'a.canmodifyvolunteers', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_CANVIEWCONTACTINFO', 'a.canviewcontactinfo', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_ROLELEVELSASSIGNABLE', 'a.rolelevelscanassign', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.published', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
					<?php if ($canOrder) :?>
						<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'projectroles.saveorder'); ?>
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
			$canOrderUp = true;
			$canOrderDown = true;
			?>
			<tr class="row<?php echo $i % 2; ?>">
				<td class="center">
					<?php if ($item->systemid<0) { echo JHtml::_('grid.id', $i, $item->id); }?>
				</td>
				<td class="center">
					<?php echo (int) $item->role_id; ?>
				</td>
				<td>
					<?php if ($canEdit & $item->systemid<0) : ?>
					<a title="<?php echo JText::_($item->description); ?>" href="<?php echo JRoute::_('index.php?option=com_serviceproject&task=projectrole.edit&id='.$item->id);?>">
						<?php echo JText::_($item->role); ?></a>
					<?php else : ?>
					<a title="<?php echo JText::_($item->description); ?>" >
						<?php echo JText::_($item->role); ?></a>
					<?php endif; ?>
				</td>
				<td class="center">
					<?php echo $this->escape($item->role_level); ?><?php if ($item->systemid > 0) { echo ' (SYS)'; }?>
				</td>
				<td class="center">
					<?php echo ServiceProjectHelper::showTrueFalseLink($item->canmodifyproject, 'csp_updateCanModifyProject', 'cmp', $item->id); ?>
				</td>
				<td class="center">
					<?php echo ServiceProjectHelper::showTrueFalseLink($item->canmodifyvolunteers, 'csp_updateCanModifyVolunteers', 'cmv', $item->id); ?>
				</td>
				<td class="center">
					<?php echo ServiceProjectHelper::showTrueFalseLink($item->canviewcontactinfo, 'csp_updateCanViewContactInfo', 'cvc', $item->id, 'COM_SERVICEPROJECT_CANVIEW', 'COM_SERVICEPROJECT_CANNOTVIEW'); ?>
				</td>
				<td class="center">
					<?php echo $this->escape($item->rolelevelscanassign); ?>
				</td>
				<td class="center">
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'projectroles.', $canChange); ?>
				</td>
				<td class="order">
					<?php if ($canChange) : ?>
						<?php if ($saveOrder) :?>
							<?php if ($listDirn == 'asc') : ?>
								<span><?php echo $this->pagination->orderUpIcon($i, $canOrderUp, 'projectroles.orderup', 'JLIB_HTML_MOVE_UP', $saveOrder); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, $canOrderDown, 'projectroles.orderdown', 'JLIB_HTML_MOVE_DOWN', $saveOrder); ?></span>
							<?php elseif ($listDirn == 'descF') :?>
								<span><?php echo $this->pagination->orderUpIcon($i, $canOrderUp, 'projectroles.orderdown', 'JLIB_HTML_MOVE_UP', $saveOrder); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, $canOrderDown, 'projectroles.orderup', 'JLIB_HTML_MOVE_DOWN', $saveOrder); ?></span>
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
	</div>
	<div id="token">
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<?php
/**
 * This view is called for to list all of the UpdateReasons
 *
 * @version		$Id: default.php
 * @package		com_serviceproject
 * @subpackage	admin.views.updatereasons.tmpl
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
$doc->addScript( $baseurl.'components/com_serviceproject/js/jquery.min.js');
$doc->addScript( $baseurl.'components/com_serviceproject/js/jquerybase.js');
$doc->addScript( $baseurl.'components/com_serviceproject/js/ajaxbase.js');
$doc->addScript( $baseurl.'components/com_serviceproject/js/ajax.regstatuses.js');

$user	= JFactory::getUser();
$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$canOrder	= $user->authorise('core.edit.state', 'com_serviceproject');
$saveOrder	= ($listOrder == 'a.ordering');
$canCreate	= $user->authorise('core.create',		'com_serviceproject');
$canEdit	= $user->authorise('core.edit',			'com_serviceproject');
$canChange	= $user->authorise('core.edit.state',	'com_serviceproject');
?>
<form action="<?php echo JRoute::_('index.php?option=com_serviceproject&view=regstatuses');?>" method="post" name="adminForm" id="adminForm">
	<fieldset id="filter-bar">
		<div class="filter-search fltlft">
			<label class="filter-search-lbl" for="filter_search"><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></label>
			<input type="text" name="filter_search" id="filter_search" value="<?php echo $this->state->get('filter.search'); ?>" title="<?php echo JText::_('COM_SERVICEPROJECT_FILTER_REGSTATUS_SEARCH_DESC'); ?>" />

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
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_ID', 'a.status_id', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_REGSTATUS', 'a.status', $listDirn, $listOrder); ?>
				</th>
				<th>
					<?php echo JHtml::_('grid.sort', 'COM_SERVICEPROJECT_HEADING_REGCOUNTED', 'a.counted', $listDirn, $listOrder); ?>
				</th>
				<th width="5%">
					<?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.published', $listDirn, $listOrder); ?>
				</th>
				<th width="10%">
					<?php echo JHtml::_('grid.sort',  'JGRID_HEADING_ORDERING', 'a.ordering', $listDirn, $listOrder); ?>
					<?php if ($canOrder) :?>
						<?php echo JHtml::_('grid.order',  $this->items, 'filesave.png', 'regstatuses.saveorder'); ?>
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
					<?php echo (int) $item->status_id; ?><?php if ($item->systemid > 0) { echo ' (SYS)'; }?>
				</td>
				<td>
					<?php if ($canEdit & $item->systemid<0) : ?>
					<a title="<?php echo JText::_($item->description); ?>" href="<?php echo JRoute::_('index.php?option=com_serviceproject&task=regstatus.edit&id='.$item->id);?>">
						<?php echo JText::_($item->status); ?></a>
					<?php else : ?>
					<a title="<?php echo JText::_($item->description); ?>" >
						<?php echo JText::_($item->status); ?></a>
					<?php endif; ?>
				</td>
				<td class="center">
					<?php echo ServiceProjectHelper::showTrueFalseLink($item->counted, 'csp_updateIsCounted', 'ric', $item->id, 'COM_SERVICEPROJECT_ISCOUNTED', 'COM_SERVICEPROJECT_ISNOTCOUNTED'); ?>
				</td>
				<td class="center">
					<?php echo JHtml::_('jgrid.published', $item->published, $i, 'regstatuses.', $canChange); ?>
				</td>
				<td class="order">
					<?php if ($canChange) : ?>
						<?php if ($saveOrder) :?>
							<?php if ($listDirn == 'asc') : ?>
								<span><?php echo $this->pagination->orderUpIcon($i, $canOrderUp, 'regstatuses.orderup', 'JLIB_HTML_MOVE_UP', $saveOrder); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, $canOrderDown, 'regstatuses.orderdown', 'JLIB_HTML_MOVE_DOWN', $saveOrder); ?></span>
							<?php elseif ($listDirn == 'descF') :?>
								<span><?php echo $this->pagination->orderUpIcon($i, $canOrderUp, 'regstatuses.orderdown', 'JLIB_HTML_MOVE_UP', $saveOrder); ?></span>
								<span><?php echo $this->pagination->orderDownIcon($i, $this->pagination->total, $canOrderDown, 'regstatuses.orderup', 'JLIB_HTML_MOVE_DOWN', $saveOrder); ?></span>
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
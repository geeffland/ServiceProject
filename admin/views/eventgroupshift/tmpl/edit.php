<?php
/**
 * This template is called to edit a RegStatus
 *
 * @version		$Id: edit.php
 * @package		com_serviceproject
 * @subpackage	admin.views.regstatus.tmpl
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the component HTML helpers.
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');

// Load the tooltip behavior.
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('behavior.keepalive');

$baseurl = JURI::base();
$doc = & JFactory::getDocument();
$doc->addStyleSheet( $baseurl.'components/com_serviceproject/helpers/css/start/jquery-ui-1.8.5.custom.css');
$doc->addScript( $baseurl.'components/com_serviceproject/helpers/js/jquery-1.4.2.min.js');
$doc->addScript( $baseurl.'components/com_serviceproject/helpers/js/jquery-ui-1.8.5.custom.min.js');
$doc->addStyleSheet( $baseurl.'components/com_serviceproject/helpers/css/timePicker.css');
$doc->addScript( $baseurl.'components/com_serviceproject/helpers/js/jquery.timePicker.min.js');

$thisEventGroup = $this->form->getValue('eventgroup_id');

$nowDate = new DateTime();
$startdate = $this->form->getValue('startdate');
if ($startdate=='') {
	$curStartDate = date('m/d/Y');
	$curStartTime = "08:00 AM";
} else {
	$sdate = DateTime::createFromFormat('Y-m-d H:i:s', $startdate);
	$curStartDate = $sdate->format('m/d/Y');
	$curStartTime = $sdate->format('h:i A');
}
$enddate = $this->form->getValue('enddate');
if ($enddate=='') {
	$curEndTime = "11:00 AM";
} else {
	$edate = DateTime::createFromFormat('Y-m-d H:i:s', $enddate);
	$curEndTime = $edate->format('h:i A');
}
?>

<script type="text/javascript">
	var $j = jQuery.noConflict(); //Set jQuery to No-Conflict mode
	var oldTime;
	// Set default shift time duration to 3 hours IF Start and End Time are not defined
	var duration = 3 * 60 * 60 * 1000;
	
	$j(function() {
		// Setup Date Picker
		$j( "#startdate" ).datepicker({
			showOn: "button",
			buttonImage: "/j16b/administrator/templates/bluestork/images/system/calendar.png",
			buttonImageOnly: true
		});
		
		// Setup Time Pickers
		$j("#starttime, #endtime").timePicker({
		  show24Hours: false,
		  step: 15});
		
		// Store time used by duration.
		oldTime = $j.timePicker("#starttime").getTime();
    
		// Keep the duration between the two inputs.
		$j("#starttime").change(function() {
		  var starttime = $j.timePicker("#starttime").getTime();
		  var endtime = $j.timePicker("#endtime").getTime();
		  if ($j("#endtime").val()) { // Only update when second input has a value.
			// Calculate duration.
			duration = (endtime - oldTime);
		  }
		// Calculate and update the time in the second input.
		$j.timePicker("#endtime").setTime(new Date(new Date(starttime.getTime() + duration)));
		// reset oldTime
		oldTime = starttime;
		});

	});

	Joomla.submitbutton = function(task)
	{
		if (task == 'eventgroupshift.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
			<?php echo ''; //$this->form->getField('updatereason')->save(); ?>
			submitform(task);
		}
		else {
			alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED'));?>');
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_serviceproject&layout=edit&id='.(int) $this->item->id); ?>" method="post" name="adminForm" id="item-form" class="form-validate">
	<div class="width-60 fltlft">
		<fieldset class="adminform">
		<legend><?php echo empty($this->item->id) ? JText::_('COM_SERVICEPROJECT_NEW_EVENTGROUPSHIFT') : JText::sprintf('COM_SERVICEPROJECT_EDIT_EVENTGROUPSHIFT', $this->item->id); ?></legend>
		<ul class="adminformlist">
		<li><?php echo $this->form->getLabel('eventgroup_id'); ?>
		<?php echo $this->form->getInput('eventgroup_id'); ?></li>

		<li><?php echo $this->form->getLabel('published'); ?>
		<?php echo $this->form->getInput('published'); ?></li>

		<li><?php echo $this->form->getLabel('title'); ?>
		<?php echo $this->form->getInput('title'); ?></li>

		<li><?php echo $this->form->getLabel('description'); ?>
		<?php echo $this->form->getInput('description'); ?></li>

		<li><label id="startdate-lbl" for="startdate" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_EVENTSHIFT_STARTDATE_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_EVENTSHIFT_STARTDATE_DESC') ?>"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_EVENTSHIFT_STARTDATE_LABEL')?></label>
		<input type="text" name="startdate" value="<?php echo $curStartDate; ?>" id="startdate" /></li>

		<li><label id="starttime-lbl" for="starttime" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_EVENTSHIFT_STARTTIME_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_EVENTSHIFT_STARTTIME_DESC') ?>"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_EVENTSHIFT_STARTTIME_LABEL')?></label>
		<input type="text" name="starttime" size="10" value="<?php echo $curStartTime; ?>" id="starttime" /></li>

		<li><label id="endtime-lbl" for="endtime" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_EVENTSHIFT_ENDTIME_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_EVENTSHIFT_ENDTIME_DESC') ?>"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_EVENTSHIFT_ENDTIME_LABEL')?></label>
		<input type="text" name="endtime" size="10" value="<?php echo $curEndTime; ?>" id="endtime" /></li>

		<li><?php echo $this->form->getLabel('id'); ?>
		<?php echo $this->form->getInput('id'); ?></li>

		</ul>
		</fieldset>
	</div>
	
	<div class="width-40 fltrt">
		<?php echo JHtml::_('sliders.start','eventgroup-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

		<?php echo JHtml::_('sliders.panel',JText::_('COM_SERVICEPROJECT_HEADING_UPDATEREASON'), 'eventgroup-updatereason'); ?>
		<fieldset class="adminform">
			<div style="width: 100%;" >
				<ul>
					<li><?php echo $this->form->getLabel('updatereason_id'); ?>
					<?php echo $this->form->getInput('updatereason_id',null, empty($this->item->id) ? '400' :'0'); ?></li>
			
					<li><label id='lbl_previous_updatereason' for='previous_updatereason' style="width:100%"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_PREVUPDATEREASON_LABEL'); ?></label>
					<textarea type="text" id="previous_updatereason" class="inputbox" readonly="readonly" rows="2" cols="50" style="background:#eee none; color:#222; font-stle:italic;"><?php echo JText::_(ServiceProjectHelper::getUpdateReason($this->form->getValue('updatereason_id'))); ?></textarea></a></li>
			
					<li><?php echo $this->form->getLabel('updatecomments'); ?>
					<?php echo $this->form->getInput('updatecomments',null, ''); ?></li>

					<li><label id='lbl_previous_comments' for='previous_comments' style="width:100%"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_PREVUPDATECOMMENTS_LABEL'); ?></label>
					<textarea type="textarea" id="previous_comments" class="inputbox" readonly="readonly" rows="2" cols="50" style="background:#eee none; color:#222; font-stle:italic;"><?php echo $this->form->getValue('updatecomments'); ?></textarea></a></li>
				</ul>
			</div>
		</fieldset>

		<?php echo JHtml::_('sliders.panel',JText::_('COM_SERVICEPROJECT_HEADING_LASTUPDATED'), 'lastupdated'); ?>
		<fieldset class="adminform">
			<div style="width: 100%;" >
				<ul>
					<li><?php echo $this->form->getLabel('last_updated'); ?>
					<?php echo $this->form->getInput('last_updated'); ?></li>
			
					<li><?php echo $this->form->getLabel('last_updated_by'); ?>
					<?php echo $this->form->getInput('last_updated_by'); ?></li>

				</ul>
			</div>
		</fieldset>

		<?php echo JHtml::_('sliders.end'); ?>

			<input type="hidden" name="task" value="" />
			<?php echo JHtml::_('form.token'); ?>
	</div>

<div class="clr"></div>
</form>
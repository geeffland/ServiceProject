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

$nowDate = new DateTime();
$startdate = $this->form->getValue('startdate');
if ($startdate=='') {
	$curStartDate = date('m/d/Y');
	$curStartTime = "12:00 AM";
} else {
	$sdate = DateTime::createFromFormat('Y-m-d H:i:s', $startdate);
	$curStartDate = $sdate->format('m/d/Y');
	$curStartTime = $sdate->format('h:i A');
}
$enddate = $this->form->getValue('enddate');
if ($enddate=='') {
	$curEndDate = date('m/d/Y');
	$curEndTime = "12:00 AM";
} else {
	$edate = DateTime::createFromFormat('Y-m-d H:i:s', $enddate);
	$curEndDate = $edate->format('m/d/Y');
	$curEndTime = $edate->format('h:i A');
}

$registration_startdate = $this->form->getValue('registration_startdate');
if ($registration_startdate=='') {
	$regStartDate = date('m/d/Y');
	$regStartTime = "12:00 AM";
} else {
	$regsdate = DateTime::createFromFormat('Y-m-d H:i:s', $registration_startdate);
	$regStartDate = $regsdate->format('m/d/Y');
	$regStartTime = $regsdate->format('h:i A');
}
$registration_enddate = $this->form->getValue('registration_enddate');
if ($registration_enddate=='') {
	$regEndDate = date('m/d/Y');
	$regEndTime = "12:00 AM";
} else {
	$regedate = DateTime::createFromFormat('Y-m-d H:i:s', $registration_enddate);
	$regEndDate = $regedate->format('m/d/Y');
	$regEndTime = $regedate->format('h:i A');
}

$publish_startdate = $this->form->getValue('publish_startdate');
if ($publish_startdate=='') {
	$pubStartDate = date('m/d/Y');
	$pubStartTime = "12:00 AM";
} else {
	$pubsdate = DateTime::createFromFormat('Y-m-d H:i:s', $publish_startdate);
	$pubStartDate = $pubsdate->format('m/d/Y');
	$pubStartTime = $pubsdate->format('h:i A');
}
$publish_enddate = $this->form->getValue('publish_enddate');
if ($publish_enddate=='') {
	$pubEndDate = date('m/d/Y');
	$pubEndTime = "12:00 AM";
} else {
	$pubedate = DateTime::createFromFormat('Y-m-d H:i:s', $publish_enddate);
	$pubEndDate = $pubedate->format('m/d/Y');
	$pubEndTime = $pubedate->format('h:i A');
}
?>

<script type="text/javascript">
	var $j = jQuery.noConflict(); //Set jQuery to No-Conflict mode
	
	$j(function() {
		// Setup Date Pickers
		$j( "#startdate, #enddate, #registration_startdate, #registration_enddate, #publish_startdate, #publish_enddate" ).datepicker({
			showOn: "button",
			buttonImage: "/j16b/administrator/templates/bluestork/images/system/calendar.png",
			buttonImageOnly: true
		});
		
		// Setup Time Pickers
		$j("#starttime, #endtime, #registration_starttime, #registration_endtime, #publish_starttime, #publish_endtime").timePicker({
		  show24Hours: false,
		  step: 15});
		
	});

	Joomla.submitbutton = function(task)
	{
		if (task == 'eventgroup.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
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
		<legend><?php echo empty($this->item->id) ? JText::_('COM_SERVICEPROJECT_NEW_EVENTGROUP') : JText::sprintf('COM_SERVICEPROJECT_EDIT_EVENTGROUP', $this->item->id); ?></legend>
		<ul class="adminformlist">
		<li><?php echo $this->form->getLabel('eventgroup_id'); ?>
		<?php echo $this->form->getInput('eventgroup_id'); ?></li>

		<li><?php echo $this->form->getLabel('title'); ?>
		<?php echo $this->form->getInput('title'); ?></li>

		<li><?php echo $this->form->getLabel('description'); ?>
		<?php echo $this->form->getInput('description'); ?></li>

		<div class="clr"></div>
		<?php echo $this->form->getLabel('longdescription'); ?>
		<div class="clr"></div>
		<?php echo $this->form->getInput('longdescription'); ?>

		<li><label id="startdate-lbl" for="startdate" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_EVENT_STARTDATE_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_EVENT_STARTDATE_DESC') ?>"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_EVENT_STARTDATE_LABEL')?></label>
		<input type="text" name="startdate" size="15" value="<?php echo $curStartDate; ?>" id="startdate" />
		
<!--		<label id="starttime-lbl" for="starttime" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_EVENT_STARTTIME_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_EVENT_STARTTIME_DESC') ?>"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_EVENT_STARTTIME_LABEL')?></label> -->
		<input type="text" name="starttime" size="10" value="<?php echo $curStartTime; ?>" id="starttime" /></li>

		<li><label id="enddate-lbl" for="enddate" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_EVENT_ENDDATE_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_EVENT_ENDDATE_DESC') ?>"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_EVENT_ENDDATE_LABEL')?></label>
		<input type="text" name="enddate" size="15" value="<?php echo $curEndDate; ?>" id="enddate" />

<!--		<label id="endtime-lbl" for="endtime" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_EVENT_ENDTIME_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_EVENT_ENDTIME_DESC') ?>"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_EVENT_ENDTIME_LABEL')?></label> -->
		<input type="text" name="endtime" size="10" value="<?php echo $curEndTime; ?>" id="endtime" /></li>

		<li><label id="registration_startdate-lbl" for="registration_startdate" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_REGISTRATION_STARTDATE_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_REGISTRATION_STARTDATE_DESC') ?>"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_REGISTRATION_STARTDATE_LABEL')?></label>
		<input type="text" name="registration_startdate" size="15" value="<?php echo $regStartDate; ?>" id="registration_startdate" />
		
<!--		<label id="registration_starttime-lbl" for="registration_starttime" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_REGISTRATION_STARTTIME_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_REGISTRATION_STARTTIME_DESC') ?>"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_REGISTRATION_STARTTIME_LABEL')?></label> -->
		<input type="text" name="registration_starttime" size="10" value="<?php echo $regStartTime; ?>" id="registration_starttime" /></li>

		<li><label id="registration_enddate-lbl" for="registration_enddate" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_REGISTRATION_ENDDATE_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_REGISTRATION_ENDDATE_DESC') ?>"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_REGISTRATION_ENDDATE_LABEL')?></label>
		<input type="text" name="registration_enddate" size="15" value="<?php echo $regEndDate; ?>" id="registration_enddate" />

<!--		<label id="registration_endtime-lbl" for="registration_endtime" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_REGISTRATION_ENDTIME_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_REGISTRATION_ENDTIME_DESC') ?>"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_REGISTRATION_ENDTIME_LABEL')?></label> -->
		<input type="text" name="registration_endtime" size="10" value="<?php echo $regEndTime; ?>" id="registration_endtime" /></li>

		<li><?php echo $this->form->getLabel('id'); ?>
		<?php echo $this->form->getInput('id'); ?></li>

		</ul>
		</fieldset>
	</div>
	
	<div class="width-40 fltrt">
		<?php echo JHtml::_('sliders.start','eventgroup-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

		<?php echo JHtml::_('sliders.panel',JText::_('COM_SERVICEPROJECT_PUBLISHING_DETAILS'), 'publishing-details'); ?>
			<fieldset class="panelform">
				<ul class="adminformlist">
					<li><?php echo $this->form->getLabel('published'); ?>
					<?php echo $this->form->getInput('published'); ?></li>

					<li><label id="publish_startdate-lbl" for="publish_startdate" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_PUBLISH_STARTDATE_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_PUBLISH_STARTDATE_DESC') ?>"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_PUBLISH_STARTDATE_LABEL')?></label>
					<input type="text" name="publish_startdate" size="15" value="<?php echo $pubStartDate; ?>" id="publish_startdate" />
					
			<!--		<label id="publish_starttime-lbl" for="publish_starttime" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_PUBLISH_STARTTIME_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_PUBLISH_STARTTIME_DESC') ?>"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_PUBLISH_STARTTIME_LABEL')?></label> -->
					<input type="text" name="publish_starttime" size="10" value="<?php echo $pubStartTime; ?>" id="publish_starttime" /></li>

					<li><label id="publish_enddate-lbl" for="publish_enddate" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_PUBLISH_ENDDATE_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_PUBLISH_ENDDATE_DESC') ?>"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_PUBLISH_ENDDATE_LABEL')?></label>
					<input type="text" name="publish_enddate" size="15" value="<?php echo $pubEndDate; ?>" id="publish_enddate" />

			<!--		<label id="publish_endtime-lbl" for="publish_endtime" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_PUBLISH_ENDTIME_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_PUBLISH_ENDTIME_DESC') ?>"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_PUBLISH_ENDTIME_LABEL')?></label> -->
					<input type="text" name="publish_endtime" size="10" value="<?php echo $pubEndTime; ?>" id="publish_endtime" /></li>

				</ul>
			</fieldset>

		<?php echo JHtml::_('sliders.panel',JText::_('COM_SERVICEPROJECT_HEADING_UPDATEREASON'), 'eventgroup-updatereason'); ?>
		<fieldset class="adminform">
			<div style="width: 100%;" >
				<ul>
					<li><?php echo $this->form->getLabel('updatereason_id'); ?>
					<?php echo $this->form->getInput('updatereason_id',null, empty($this->item->id) ? '300' :'0'); ?></li>
			
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
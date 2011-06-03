<?php
/**
 * This template is called to edit an Address
 *
 * @version		$Id: edit.php
 * @package		com_serviceproject
 * @subpackage	admin.views.address.tmpl
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
$doc->addScript( 'http://maps.google.com/maps/api/js?sensor=false');
$doc->addScript( $baseurl.'components/com_serviceproject/views/address/tmpl/googlemapsapi.js');
$doc->addStyleSheet( $baseurl.'components/com_serviceproject/helpers/css/start/jquery-ui-1.8.5.custom.css');
$doc->addScript( $baseurl.'components/com_serviceproject/helpers/js/jquery-1.4.2.min.js');
$doc->addScript( $baseurl.'components/com_serviceproject/helpers/js/jquery-ui-1.8.5.custom.min.js');
?>
<script type="text/javascript">
	var $j = jQuery.noConflict(); //Set jQuery to No-Conflict mode
	
	$j(function() {
		$j( "input:button").button();
		<?php echo ServiceProjectHelper::makeStatesAutoComplete('jform_state'); ?>
		<?php echo ServiceProjectHelper::makeCitiesAutoComplete('jform_city'); ?>
		<?php echo ServiceProjectHelper::makeZipcodesAutoComplete('jform_zipcode'); ?>
	});
	
	Joomla.submitbutton = function(task)
	{
		if (task == 'address.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
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
			<legend><?php echo empty($this->item->id) ? JText::_('COM_SERVICEPROJECT_NEW_ADDRESS') : JText::sprintf('COM_SERVICEPROJECT_EDIT_ADDRESS', $this->item->id); ?></legend>
			<ul class="adminformlist">
			<li><?php echo $this->form->getLabel('id'); ?>
			<?php echo $this->form->getInput('id'); ?></li>
	
			<li><?php echo $this->form->getLabel('address_id'); ?>
			<?php echo $this->form->getInput('address_id'); ?></li>
	
			<li><?php echo $this->form->getLabel('published'); ?>
			<?php echo $this->form->getInput('published'); ?></li>
	
			<li><?php echo $this->form->getLabel('addressname'); ?>
			<?php echo $this->form->getInput('addressname'); ?></li>
	
			<li><?php echo $this->form->getLabel('streetaddress1'); ?>
			<?php echo $this->form->getInput('streetaddress1'); ?></li>
	
			<li><?php echo $this->form->getLabel('streetaddress2'); ?>
			<?php echo $this->form->getInput('streetaddress2'); ?></li>
	
			<li><?php echo $this->form->getLabel('city'); ?>
			<?php echo $this->form->getInput('city'); ?></li>
	
			<li><?php echo $this->form->getLabel('state'); ?>
			<?php echo $this->form->getInput('state'); ?></li>
	
			<li><?php echo $this->form->getLabel('zipcode'); ?>
			<?php echo $this->form->getInput('zipcode'); ?></li>
	
			<li><?php echo $this->form->getLabel('latitude'); ?>
			<?php echo $this->form->getInput('latitude'); ?></li>
	
			<li><?php echo $this->form->getLabel('longitude'); ?>
			<?php echo $this->form->getInput('longitude'); ?></li>
	
			<li><?php echo $this->form->getLabel('gm_zoomlevel'); ?>
			<?php echo $this->form->getValue('gm_zoomlevel')=='' ? $this->form->getInput('gm_zoomlevel', null, 17) : $this->form->getInput('gm_zoomlevel'); ?></li>
	
			<li><?php echo $this->form->getLabel('center_latitude'); ?>
			<?php echo $this->form->getInput('center_latitude'); ?></li>
	
			<li><?php echo $this->form->getLabel('center_longitude'); ?>
			<?php echo $this->form->getInput('center_longitude'); ?></li>
	
			</ul>
		</fieldset>
	</div>	
	
	<div class="width-40 fltrt">
		<?php echo JHtml::_('sliders.start','content-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

		<?php echo JHtml::_('sliders.panel',JText::_('COM_SERVICEPROJECT_HEADING_UPDATEREASON'), 'profile-updatereason'); ?>
		<fieldset class="adminform">
			<div style="width: 100%;" >
				<ul>
					<li><?php echo $this->form->getLabel('updatereason_id'); ?>
					<?php echo $this->form->getInput('updatereason_id',null, empty($this->item->id) ? '200' :'0'); ?></li>
			
					<li><label id='lbl_previous_updatereason' for='previous_updatereason' style="width:100%"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_PREVUPDATEREASON_LABEL'); ?></label>
					<textarea type="text" id="previous_updatereason" class="inputbox" readonly="readonly" rows="2" cols="50" style="background:#eee none; color:#222; font-stle:italic;"><?php echo JText::_(ServiceProjectHelper::getUpdateReason($this->form->getValue('updatereason_id'))); ?></textarea></a></li>
			
					<li><?php echo $this->form->getLabel('updatecomments'); ?>
					<?php echo $this->form->getInput('updatecomments',null, ''); ?></li>

					<li><label id='lbl_previous_comments' for='previous_comments' style="width:100%"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_PREVUPDATECOMMENTS_LABEL'); ?></label>
					<textarea type="textarea" id="previous_comments" class="inputbox" readonly="readonly" rows="2" cols="50" style="background:#eee none; color:#222; font-stle:italic;"><?php echo $this->form->getValue('updatecomments'); ?></textarea></a></li>
				</ul>
			</div>
		</fieldset>
		
		<?php echo JHtml::_('sliders.panel',JText::_('COM_SERVICEPROJECT_HEADING_PROFILESUSINGADDRESS').' ('.COUNT($this->profileusingaddress).')', 'profiles-using-address'); ?>
		<fieldset class="adminform">
			<div style="width: 100%;" >
				<ul style="list-style-type: none;"><?php echo JText::_('COM_SERVICEPROJECT_HEADING_PROFILESUSINGADDRESS_NOTE'); ?>
			<?php foreach ($this->profileusingaddress as $key => $profile) {?>
				<li><label for="profile<?php echo $key; ?>"><?php echo $profile; ?></label><input type="hidden" name="checkprofile[<?php echo $key; ?>]" value="off" /><input type="checkbox" id="profile<?php echo $key; ?>" name="checkprofile[<?php echo $key; ?>]" checked="checked" />&nbsp;</li>
			<?php } ?>
				</ul>
			</div>
		</fieldset>
		
		<?php echo JHtml::_('sliders.panel',JText::_('COM_SERVICEPROJECT_HEADING_PROJECTSUSINGADDRESS').' ('.COUNT($this->projectusingaddress).')', 'profiles-using-address'); ?>
		<fieldset class="adminform">
			<div style="width: 100%;" >
				<ul style="list-style-type: none;"><?php echo JText::_('COM_SERVICEPROJECT_HEADING_PROJECTSUSINGADDRESS_NOTE'); ?>
			<?php foreach ($this->projectusingaddress as $key => $project) {?>
				<li><label for="project<?php echo $key; ?>"><?php echo $project; ?></label><input type="hidden" name="checkproject[<?php echo $key; ?>]" value="off" /><input type="checkbox" id="project<?php echo $key; ?>" name="checkproject[<?php echo $key; ?>]" checked="checked" />&nbsp;</li>
			<?php } ?>
				</ul>
			</div>
			<div style="clear: both;"> &nbsp;</br> </div>
		</fieldset>
		
		<?php echo JHtml::_('sliders.panel',JText::_('COM_SERVICEPROJECT_FIELD_MAP_LABEL'), 'googlemap'); ?>
		<fieldset class="adminform">
			<div id="map_canvas" style="width: 100%; height: 300px; border: 1px solid;"></div>
			<div><a><?php echo JText::_('COM_SERVICEPROJECT_FIELD_MARKERDRAG_LABEL'); ?></a></div>
			<div><input type="button" name="googlemapsgeocode" value="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_SHOWADDRESS_LABEL'); ?>" onclick="showAddress();"/></div>
			<div><input type="button" name="googlemapsgeocode" value="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_SHOWLATLNG_LABEL'); ?>" onclick="showLatLng();"/></div>
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
	</div>
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="return" value="<?php echo JRequest::getCmd('return');?>" />
	<?php echo JHtml::_('form.token'); ?>
</form>
<div class="clr"></div>
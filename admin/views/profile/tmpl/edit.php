<?php
/**
 * This template is called to edit a Profile
 *
 * @version		$Id: edit.php
 * @package		com_serviceproject
 * @subpackage	admin.views.profile.tmpl
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
// Add Google Maps and supporting files
$doc->addScript( 'http://maps.google.com/maps/api/js?sensor=false');
$doc->addScript( $baseurl.'components/com_serviceproject/views/profile/tmpl/googlemapsapi.js');
// Add jQuery
$doc->addScript( $baseurl.'components/com_serviceproject/helpers/js/jquery-1.4.2.min.js');
// Add jQuery UI
$doc->addScript( $baseurl.'components/com_serviceproject/helpers/js/jquery-ui-1.8.5.custom.min.js');
$doc->addStyleSheet( $baseurl.'components/com_serviceproject/helpers/css/start/jquery-ui-1.8.5.custom.css');
?>

<script type="text/javascript">
	var $j = jQuery.noConflict(); //Set jQuery to No-Conflict mode
	
	$j(function() {
		$j( "input:button").button();
		<?php echo ServiceProjectHelper::makeAddressesAutoComplete(); ?>
		<?php echo ServiceProjectHelper::makeStatesAutoComplete(); ?>
		<?php echo ServiceProjectHelper::makeCitiesAutoComplete(); ?>
		<?php echo ServiceProjectHelper::makeZipcodesAutoComplete(); ?>

	});
	
	Joomla.submitbutton = function(task)
	{
		if (task == 'profile.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
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
			<legend><?php echo JText::_('COM_SERVICEPROJECT_NAME_LABEL'); ?></legend>	
			<ul class="adminformlist">
			<li><?php echo $this->form->getLabel('id'); ?>
			<?php echo $this->form->getInput('id'); ?></li>
	
			<li><?php echo $this->form->getLabel('profile_id'); ?>
			<?php echo $this->form->getInput('profile_id'); ?></li>
	
			<li><?php echo $this->form->getLabel('published'); ?>
			<?php echo $this->form->getInput('published'); ?></li>
	
			<li><?php echo $this->form->getLabel('firstname'); ?>
			<?php echo $this->form->getInput('firstname'); ?></li>
	
			<li><?php echo $this->form->getLabel('nickname'); ?>
			<?php echo $this->form->getInput('nickname'); ?></li>
	
			<li><?php echo $this->form->getLabel('middlename'); ?>
			<?php echo $this->form->getInput('middlename'); ?></li>
	
			<li><?php echo $this->form->getLabel('lastname'); ?>
			<?php echo $this->form->getInput('lastname'); ?></li>
	
			<li><?php echo $this->form->getLabel('suffix'); ?>
			<?php echo $this->form->getInput('suffix'); ?></li>
			</ul>
		</fieldset>

		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_SERVICEPROJECT_FIELD_ADDRESS_LABEL'); ?></legend>
			<ul class="adminformlist">
			<li>
			</li>
						<li><label id="street1_lbl" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_STREETADDRESS1_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_STREETADDRESS1_DESC'); ?>" for="street1"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_STREETADDRESS1_LABEL'); ?></label>
						<input type="text" name="address[street1]" id="street1" value="<?php echo JText::_($this->address->streetaddress1); ?>" class="inputbox" size="100" /></li>
				
						<li><label id="street2_lbl" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_STREETADDRESS2_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_STREETADDRESS2_DESC'); ?>" for="street2"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_STREETADDRESS2_LABEL'); ?></label>
						<input type="text" name="address[street2]" id="street2" value="<?php echo JText::_($this->address->streetaddress2); ?>" class="inputbox" size="100" /></li>
				
						<li><label id="city_lbl" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_CITY_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_CITY_DESC'); ?>" for="city"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_CITY_LABEL'); ?></label>
						<input type="text" name="address[city]" id="city" value="<?php echo JText::_($this->address->city); ?>" class="inputbox" size="100" /></li>
				
						<li><label id="state_lbl" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_STATE_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_STATE_DESC'); ?>" for="state"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_STATE_LABEL'); ?></label>
						<input type="text" name="address[state]" id="state" value="<?php echo JText::_($this->address->state); ?>" class="inputbox" size="100" /></li>
				
						<li><label id="zipcode_lbl" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_ZIPCODE_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_ZIPCODE_DESC'); ?>" for="zipcode"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_ZIPCODE_LABEL'); ?></label>
						<input type="text" name="address[zipcode]" id="zipcode" value="<?php echo JText::_($this->address->zipcode); ?>" class="inputbox" size="100" /></li>
						
						<li><label id="latitude_lbl" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_LATITUDE_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_LATITUDE_DESC'); ?>" for="latitude"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_LATITUDE_LABEL'); ?></label>
						<input type="text" name="address[latitude]" id="latitude" value="<?php echo JText::_($this->address->latitude); ?>" class="inputbox" size="100" /></li>
						
						<li><label id="longitude_lbl" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_LONGITUDE_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_LONGITUDE_DESC'); ?>" for="longitude"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_LONGITUDE_LABEL'); ?></label>
						<input type="text" name="address[longitude]" id="longitude" value="<?php echo JText::_($this->address->longitude); ?>" class="inputbox" size="100" /></li>
						
						<li><label id="gm_zoomlevel_lbl" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_GMZOOMLEVEL_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_GMZOOMLEVEL_DESC'); ?>" for="gm_zoomlevel"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_GMZOOMLEVEL_LABEL'); ?></label>
						<input type="text" name="address[gm_zoomlevel]" id="gm_zoomlevel" value="<?php echo JText::_($this->address->gm_zoomlevel); ?>" class="inputbox" size="100" /></li>
						
						<li><label id="center_latitude_lbl" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_CENTER_LATITUDE_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_CENTER_LATITUDE_DESC'); ?>" for="center_latitude"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_CENTER_LATITUDE_LABEL'); ?></label>
						<input type="text" name="address[center_latitude]" id="center_latitude" value="<?php echo JText::_($this->address->center_latitude); ?>" class="inputbox" size="100" /></li>
						
						<li><label id="center_longitude_lbl" class="hasTip" title="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_CENTER_LONGITUDE_LABEL').'::'.JText::_('COM_SERVICEPROJECT_FIELD_CENTER_LONGITUDE_DESC'); ?>" for="center_longitude"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_CENTER_LONGITUDE_LABEL'); ?></label>
						<input type="text" name="address[center_longitude]" id="center_longitude" value="<?php echo JText::_($this->address->center_longitude); ?>" class="inputbox" size="100" /></li>
						
				<!--		<input type="button" name="editprofileaddress" value="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_EDITADDRESS_LABEL'); ?>" onclick="editAddress();"/> -->

			</ul>
		</fieldset>
	
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_SERVICEPROJECT_CONTACTINFO_LABEL'); ?></legend>
			<ul class="adminformlist">
			<li><?php echo $this->form->getLabel('emailpreferred'); ?>
			<?php echo $this->form->getInput('emailpreferred'); ?></li>
	
			<li><?php echo $this->form->getLabel('emailhome'); ?>
			<?php echo $this->form->getInput('emailhome'); ?></li>
	
			<li><?php echo $this->form->getLabel('emailwork'); ?>
			<?php echo $this->form->getInput('emailwork'); ?></li>
	
			<li><?php echo $this->form->getLabel('emailother'); ?>
			<?php echo $this->form->getInput('emailother'); ?></li>
	
			<li><?php echo $this->form->getLabel('phonepreferred'); ?>
			<?php echo $this->form->getInput('phonepreferred'); ?></li>
	
			<li><?php echo $this->form->getLabel('phonehome'); ?>
			<?php echo $this->form->getInput('phonehome'); ?></li>
	
			<li><?php echo $this->form->getLabel('phonework'); ?>
			<?php echo $this->form->getInput('phonework'); ?></li>
	
			<li><?php echo $this->form->getLabel('phonecell'); ?>
			<?php echo $this->form->getInput('phonecell'); ?></li>
	
			</ul>
		</fieldset>
	
		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>	
	
	<div class="width-40 fltrt">
		<?php echo JHtml::_('sliders.start','content-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

		<?php echo JHtml::_('sliders.panel',JText::_('COM_SERVICEPROJECT_HEADING_UPDATEREASON'), 'profile-updatereason'); ?>
		<fieldset class="adminform">
			<div style="width: 100%;" >
				<ul>
					<li><?php echo $this->form->getLabel('updatereason_id'); ?>
					<?php echo $this->form->getInput('updatereason_id',null, empty($this->item->id) ? '100' :'0'); ?></li>
			
					<li><label id='lbl_previous_updatereason' for='previous_updatereason' style="width:100%"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_PREVUPDATEREASON_LABEL'); ?></label>
					<textarea type="text" id="previous_updatereason" class="inputbox" readonly="readonly" rows="2" cols="50" style="background:#eee none; color:#222; font-stle:italic;"><?php echo JText::_(ServiceProjectHelper::getUpdateReason($this->form->getValue('updatereason_id'))); ?></textarea></a></li>
			
					<li><?php echo $this->form->getLabel('updatecomments'); ?>
					<?php echo $this->form->getInput('updatecomments',null, ''); ?></li>

					<li><label id='lbl_previous_comments' for='previous_comments' style="width:100%"><?php echo JText::_('COM_SERVICEPROJECT_FIELD_PREVUPDATECOMMENTS_LABEL'); ?></label>
					<textarea type="textarea" id="previous_comments" class="inputbox" readonly="readonly" rows="2" cols="50" style="background:#eee none; color:#222; font-stle:italic;"><?php echo $this->form->getValue('updatecomments'); ?></textarea></a></li>
				</ul>
			</div>
		</fieldset>

		<?php echo JHtml::_('sliders.panel',JText::_('COM_SERVICEPROJECT_FIELD_MAP_LABEL'), 'googlemap'); ?>
		<fieldset class="adminform">
			<legend><?php echo JText::_('COM_SERVICEPROJECT_FIELD_MAP_LABEL'); ?></legend>
			<div id="map_canvas" style="width: 100%; height: 300px; border: 1px solid;"></div>
			<div><a><?php echo JText::_('COM_SERVICEPROJECT_FIELD_MARKERDRAG_LABEL'); ?></a></div>
			<input type="button" name="googlemapsgeocode" value="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_SHOWADDRESS_LABEL'); ?>" onclick="showAddress();"/>
			<input type="button" name="googlemapsgeocode" value="<?php echo JText::_('COM_SERVICEPROJECT_FIELD_SHOWLATLNG_LABEL'); ?>" onclick="showLatLng();"/>
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

</form>
<div class="clr"></div>
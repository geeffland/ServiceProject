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
$doc->addScript( $baseurl.'components/com_serviceproject/helpers/js/sha1-min.js');
$doc->addStyleSheet( $baseurl.'components/com_serviceproject/helpers/css/start/jquery-ui-1.8.5.custom.css');
$doc->addScript( $baseurl.'components/com_serviceproject/helpers/js/jquery-1.4.2.min.js');
$doc->addScript( $baseurl.'components/com_serviceproject/helpers/js/jquery-ui-1.8.5.custom.min.js');

?>

<script type="text/javascript">
	var $j = jQuery.noConflict(); //Set jQuery to No-Conflict mode
	
	$j(function() {
		$j( "input:button").button();
	});

	function generateRemoteKey()
	{
		$user_id = $j("#jform_user_id option:selected").text();
		$profile_id = $j("#jform_profile_id option:selected").text();
		$prekey = $user_id + "-" + $profile_id;
		$key = hex_sha1( $prekey );
		$j( "#jform_remotekey" ).val( $key );
	}

	function submitbutton(task)
	{
		if (task == 'linkedprofile.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
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
	
			<li><?php echo $this->form->getLabel('user_id'); ?>
			<?php echo $this->form->getInput('user_id'); ?></li>
	
			<li><?php echo $this->form->getLabel('profile_id'); ?>
			<?php echo $this->form->getInput('profile_id'); ?></li>
	
			<li><?php echo $this->form->getLabel('link_method'); ?>
			<?php echo $this->form->getInput('link_method'); ?></li>
	
			<li><?php echo $this->form->getLabel('canregister'); ?>
			<?php echo $this->form->getInput('canregister'); ?></li>
	
			<li><?php echo $this->form->getLabel('canmodify'); ?>
			<?php echo $this->form->getInput('canmodify'); ?></li>
	
			<li><?php echo $this->form->getLabel('canaccess'); ?>
			<?php echo $this->form->getInput('canaccess'); ?></li>
	
			<li><?php echo $this->form->getLabel('remotekey'); ?>
			<?php echo $this->form->getInput('remotekey'); ?></li>

			<li><input type="button" name="generatekey" value="<?php echo JText::_('Generate Remote Key'); ?>" onclick="generateRemoteKey();"/></li>
			</ul>
		</fieldset>

		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>	
	
	<div class="width-40 fltrt">
		<?php echo JHtml::_('sliders.start','content-sliders-'.$this->item->id, array('useCookie'=>1)); ?>

		<?php echo JHtml::_('sliders.panel',JText::_('COM_SERVICEPROJECT_HEADING_UPDATEREASON'), 'linkedprofile-updatereason'); ?>
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
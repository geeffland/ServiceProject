<?php
/**
 * This template is called to edit a ProjectRole
 *
 * @version		$Id: edit.php
 * @package		com_serviceproject
 * @subpackage	admin.views.updatereason.tmpl
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
?>

<script type="text/javascript">
	Joomla.submitbutton = function(task)
	{
		if (task == 'projectrole.cancel' || document.formvalidator.isValid(document.id('item-form'))) {
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
		<legend><?php echo empty($this->item->id) ? JText::_('COM_SERVICEPROJECT_NEW_PROJECTROLE') : JText::sprintf('COM_SERVICEPROJECT_EDIT_PROJECTROLE', $this->item->id); ?></legend>
		<ul class="adminformlist">
		<li><?php echo $this->form->getLabel('id'); ?>
		<?php echo $this->form->getInput('id'); ?></li>

		<li><?php echo $this->form->getLabel('role_id'); ?>
		<?php echo $this->form->getInput('role_id', null, empty($this->item->id) ? ServiceProjectHelper::getNewRoleID() : null); ?></li>

		<li><?php echo $this->form->getLabel('published'); ?>
		<?php echo $this->form->getInput('published'); ?></li>

		<li><?php echo $this->form->getLabel('role'); ?>
		<?php echo $this->form->getInput('role'); ?></li>

		<li><?php echo $this->form->getLabel('role_level'); ?>
		<?php echo $this->form->getInput('role_level'); ?></li>

		<li><?php echo $this->form->getLabel('description'); ?>
		<?php echo $this->form->getInput('description'); ?></li>

		<li><?php echo $this->form->getLabel('canmodifyproject'); ?>
		<?php echo $this->form->getInput('canmodifyproject'); ?></li>

		<li><?php echo $this->form->getLabel('canmodifyvolunteers'); ?>
		<?php echo $this->form->getInput('canmodifyvolunteers'); ?></li>

		<li><?php echo $this->form->getLabel('canviewcontactinfo'); ?>
		<?php echo $this->form->getInput('canviewcontactinfo'); ?></li>

		<li><?php echo $this->form->getLabel('rolelevelscanassign'); ?>
		<?php echo $this->form->getInput('rolelevelscanassign'); ?></li>

		</ul>
		</fieldset>

		<input type="hidden" name="task" value="" />
		<?php echo JHtml::_('form.token'); ?>
	</div>

</form>
<div class="clr"></div>
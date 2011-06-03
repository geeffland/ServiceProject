<?php
/**
 * This form field list is called to show the drop-down list for Update Types
 *
 * @version		$Id: updatereasonprofile.php
 * @package		com_serviceproject
 * @subpackage	admin.models.fields
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_categories
 * @since		1.6
 */
class JFormFieldUpdateReasonProfile extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'UpdateReason';

	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	protected function getOptions()
	{
		// Initialize variables.
		$options = array();

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('updatereason_id As value, updatereason As text, ordering');
		$query->from('#__serviceproject_updatereasons AS a');
		$query->order('a.ordering');
		$query->where('a.updatetype = \'profile\'');

		// Get the options.
		$db->setQuery($query);

		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		// translate any language strings
		foreach ($options as & $option) {
			$option->text = JText::_($option->text);
		}

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions('address'), $options);

		array_unshift($options, JHtml::_('select.option', '0', JText::_('COM_SERVICEPROJECT_NO_UPDATEREASON')));

		return $options;
	}
}
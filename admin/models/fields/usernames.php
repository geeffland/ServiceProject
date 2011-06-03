<?php
/**
 * This form field list is called to show the drop-down list for Update Types
 *
 * @version		$Id: updatetype.php
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
class JFormFieldUsernames extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Usernames';

	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	protected function getOptions()
	{
		$results 	= array();
		
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('id, name, username');
		$query->from('#__users AS a');
		$query->order('a.username, a.name');

		// Get the options.
		$db->setQuery($query);

		$results = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		$options 	= array();
		foreach ($results as $row) {
			$value = $row->id;
			$label = '('. $row->id .') '. $row->username .' ['. $row->name . ']';
			$options[]	= JHTML::_( 'select.option', $value, $label);
		}

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
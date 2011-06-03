<?php
/**
 * This form field list is called to show the drop-down list for Event Groups
 *
 * @version		$Id: eventgroupid.php
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
class JFormFieldEventGroupID extends JFormFieldList
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'EventGroupID';

	/**
	 * Method to get the field options.
	 *
	 * @return	array	The field option objects.
	 * @since	1.6
	 */
	protected function getOptions()
	{
		// Initialize variables.
		$results = array();
		$options 	= array();

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('eventgroup_id, title');
		$query->from('#__serviceproject_eventgroups');
		$query->order('ordering ASC');
		$query->where('published=1');

		// Get the options.
		$db->setQuery($query);

		$results = $db->loadObjectList();
		foreach ($results as $row) {
			$options[] = JHTML::_( 'select.option', $row->eventgroup_id, $row->title);
		}

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
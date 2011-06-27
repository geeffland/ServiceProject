<?php
/**
 * This model is called for to list all of the UpdateReasons
 *
 * @version		$Id: updatereason.php
 * @package		com_serviceproject
 * @subpackage	admin.models
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Article model.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_serviceproject
 */
class ServiceProjectModelRegStatus extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages.
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_SERVICEPROJECT';

	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param	object	A record object.
	 *
	 * @return	boolean	True if allowed to delete the record. Defaults to the permission set in the component.
	 * @since	1.6
	 */
	protected function canDelete($record)
	{
		$user = JFactory::getUser();

		return $user->authorise('core.delete', 'com_serviceproject.regstatus.'.(int) $record->id);
	}

	/**
	 * Method to test whether a record can be deleted.
	 *
	 * @param	object	A record object.
	 *
	 * @return	boolean	True if allowed to change the state of the record. Defaults to the permission set in the component.
	 * @since	1.6
	 */
	protected function canEditState($record)
	{
		$user = JFactory::getUser();

		return $user->authorise('core.edit.state', 'com_serviceproject.regstatus.'.(int) $record->id);
	}

	/**
	 * Returns a Table object, always creating it.
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional.
	 * @param	array	Configuration array for model. Optional.
	 *
	 * @return	JTable	A database object
	*/
	public function getTable($type = 'RegStatus', $prefix = 'ServiceProjectTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		Data for the form.
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not.
	 *
	 * @return	mixed	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm('com_serviceproject.regstatus', 'regstatus', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form)) {
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return	mixed	The data for the form.
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_serviceproject.edit.regstatus.data', array());

		if (empty($data)) {
			$data = $this->getItem();
		}

		return $data;
	}

	/**
	 * A protected method to get a set of ordering conditions.
	 *
	 * @param	object	A record object.
	 * @return	array	An array of conditions to add to add to ordering queries.
	 * @since	1.6
	 */
	protected function getReorderConditions($table = null)
	{
		$condition = array();
		$condition[] = 'published >= 0';
		return $condition;
	}

	/**
	 * Method to toggle counted values for Registration Status.
	 *
	 * @param	array	$pks	The ids of the items to activate.
	 *
	 * @return	boolean	True on success.
	 * @since	1.6
	 */
	function toggleRegistrationIsCounted(&$pks, $prefix, &$newValue)
	{
		// Initialise variables.
//		$dispatcher	= JDispatcher::getInstance();	// This is only needed if you are going to trigger events
		$user		= JFactory::getUser();
        // Check if I am a Super Admin
		//$iAmSuperAdmin	= $user->authorise('core.admin'); // This checks if user is a super admin
		$table		= $this->getTable();
		$pks		= (array) $pks;
		
		JPluginHelper::importPlugin('user');

		// Access checks.
		foreach ($pks as $i => $pk)
		{
			if ($table->load($pk)) {
				
				$old	= $table->getProperties();
				$allow	= $user->authorise('core.edit.state', 'com_serviceproject');

				if ($allow) {
					$newValue					= !$table->counted;
					$table->counted	= $newValue;
					// Allow an exception to be thrown.
					try
					{
						// Store the table.
						if (!$table->store()) {
							$this->setError($table->getError());
							return false;
						}

					}
					catch (Exception $e)
					{
						$this->setError($e->getMessage());

						return false;
					}
				}
				else {
					// Prune items that you can't change.
					unset($pks[$i]);
					JError::raiseWarning(403, JText::_('JLIB_APPLICATION_ERROR_EDITSTATE_NOT_PERMITTED'));
				}
			}
		}
		return true;
	}

}
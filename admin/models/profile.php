<?php
/**
 * This model is called for to list a Profile
 *
 * @version		$Id: profile.php
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
class ServiceProjectModelProfile extends JModelAdmin
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

		return $user->authorise('core.delete', 'com_serviceproject.profile.'.(int) $record->id);
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

		return $user->authorise('core.edit.state', 'com_serviceproject.profile.'.(int) $record->id);
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
	public function getTable($type = 'Profile', $prefix = 'ServiceProjectTable', $config = array())
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
		$form = $this->loadForm('com_serviceproject.profile', 'profile', array('control' => 'jform', 'load_data' => $loadData));
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
		$data = JFactory::getApplication()->getUserState('com_serviceproject.edit.profile.data', array());

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
		//$condition[] = 'updatetype = \''. $table->updatetype .'\'';
		$condition[] = 'published >= 0';
		return $condition;
	}

	/**
	 * Method to copy one or more records.
	 *
	 * @param	array	$pks	A list of the primary keys to change.
	 *
	 * @return	boolean	True on success.
	 * @since	1.6
	 */
	public function copy(&$pks)
	{
		// Initialise variables.
		$table		= $this->getTable();
		$pks		= (array) $pks;
		$reasonID	= 1005; // copy profile
		
		// Process each ID selected
		foreach ($pks as $i => $pk) {
			// Attempt to change the state of the records.
			if (!$table->copyrow($pk, $reasonID)) {
				$this->setError($table->getError());
				return false;
			}
		}
		
		return true;
	}
	
	/**
	 * Method to merge two or more records.
	 *
	 * @param	array	$pks	A list of the primary keys to change.
	 *
	 * @return	boolean	True on success.
	 */
	public function merge(&$pks, $masterid)
	{
		if ($masterid=='') {
			$this->setError('No Master ID selected to merge into');
			return false;					
		}
		
		// Initialise variables.
		$table		= $this->getTable();
		$pks		= (array) $pks;
		$reasonID	= 1004; // merge profile
		
		//TODO: modify code below to merge Project or registration info
		$ProfileTable = new ServiceProjectTableProfile($this->_db);

		// Process each ID selected
		foreach ($pks as $i => $pk) {
			// Attempt to change the state of the records.
			if ($pk != $masterid) {
				if ($table->delete($pk, $reasonID, $masterid)) {
					// now update any projects using this profile id
//					$profilesToUpdate = ServiceProjectHelper::getProfileIDsUsingAddress($pk);
//					foreach ( $profilesToUpdate as $profileID ) {
//						$ProfileTable->load($profileID);
//						$ProfileTable->updateaddressid($masterid, $reasonID);
//					}
					// now update any registrations using this profile id
					// linked profiles, etc...
				} else {
					$this->setError($table->getError());
					return false;					
				}
			}
		}
		
		return true;
	}

}
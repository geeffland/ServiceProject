<?php
/**
 * This table is called for changes to the ServiceProject_Profile table
 *
 * @version		$Id: profile.php
 * @package		com_serviceproject
 * @subpackage	admin.tables
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;
// include the archive table
require_once JPATH_COMPONENT.DS.'tables'.DS.'archivelinkedprofile.php';
require_once JPATH_COMPONENT.DS.'helpers'.DS.'serviceproject.php';
require_once JPATH_COMPONENT.DS.'tables'.DS.'address.php';
/**
 * _serviceproject_addresses table
 *
 * @package		com_serviceproject
 * @subpackage	admin.tables
 */
class ServiceProjectTableLinkedProfile extends JTable
{
	protected $tabletype 	= 'LinkedProfile';
	protected $tableprefix 	= 'ServiceProjectTable';
	/**
	 * Constructor
	 *
	 */
	function __construct(&$_db)
	{
		parent::__construct('#__serviceproject_linked_profiles', 'id', $_db);
		//$this->created = JFactory::getDate()->toMySQL();
	}

	/**
	 * Overloaded check function
	 *
	 * @return	boolean
	 * @see		JTable::check
	 */
	public function check()
	{
		
		jimport('joomla.filter.output');

		// Set updatereason
		$this->updatecomments = htmlspecialchars_decode($this->updatecomments, ENT_QUOTES);

		return true;
	}

	/**
	 * Overloaded bind function
	 *
	 * @param	array		$hash named array
	 * @return	null|string	null is operation was satisfactory, otherwise returns an error
	 * @see JTable:bind
	 */
	public function bind($array, $ignore = array())
	{
		
		if (isset($array['params']) && is_array($array['params'])) {
			$registry = new JRegistry();
			$registry->loadArray($array['params']);

			$array['params'] = (string)$registry;
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * method to store a row
	 *
	 * @param boolean $updateNulls True to update fields even if they are null.
	 */
	public function store($updateNulls = false)
	{
		$user = JFactory::getUser();
		$this->last_updated_by = $user->id;
		$this->last_updated = JFactory::getDate()->toMySQL();
	
//		if ($this->id==0) {
//			$this->id = null;
//		}

		if (empty($this->id))
		{
			// New row
			// Set any desired values
			// Store the row
			parent::store($updateNulls);
		} else {
			// Get the old row
			$oldrow = JTable::getInstance($this->tabletype, $this->tableprefix);
			if (!$oldrow->load($this->id) && $oldrow->getError())
			{
				$this->setError($oldrow->getError());
			}
			
			// Add row to archive table
			$ArchiveTable = new ServiceProjectTableArchiveLinkedProfile($this->_db);
			$ArchiveTable->bind($oldrow);
			$ArchiveTable->id = null; // set the id to null so it creates a new row
			$ArchiveTable->store($updateNulls);

			// Store the new row
			parent::store($updateNulls);
		}

		return count($this->getErrors())==0;
	}
	
	/**
	 * method to copy the current row
	 *
	 */
	public function copycurrentrow()
	{
		// 1005 = Copy Profile
		$reasonID = 1005; // copy profile
		return $this->copyrow($this->id, $reasonID);
	}
	/**
	 * method to copy a row
	 *
	 */
	public function copyrow($rowId, $reasonID)
	{
		// create instance to this table
		$CopyTable = JTable::getInstance($this->tabletype, $this->tableprefix);
		// load the current row
		$CopyTable->load($rowId);
		// set the id to null so it creates a new row
		$CopyTable->id	= null;
		// Set Update Reasons
		$CopyTable->updatereason_id = ServiceProjectHelper::getSystemUpdateReasonID($reasonID);
		$CopyTable->updatecomments	= JText::_( ServiceProjectHelper::getUpdateReason($reasonID) ).' ('.$CopyTable->profile_id.')';
		$user = JFactory::getUser();
		$CopyTable->last_updated_by = $user->id;
		$CopyTable->last_updated 	= JFactory::getDate()->toMySQL();
		//store the new row
		$CopyTable->store(false);
		
		return $CopyTable->profile_id;
	}

	/**
	 * Method to wrap the built-in delete function and add an archive transaction before deleting
	 *
	 */
	public function delete($pk = null, $reasonID = 1006, $new_profile_id = 0)
	{
		// exit if the profile is being merged upon itself
		if ($pk == $new_profile_id) {
			return false;
		}
		
		// Get the old row
		$oldrow = JTable::getInstance($this->tabletype, $this->tableprefix);
		if (!$oldrow->load($pk) && $oldrow->getError())
		{
			$this->setError($oldrow->getError());
		}

		// Add row to archive table
		$ArchiveTable = new ServiceProjectTableArchiveProfile($this->_db);
		$ArchiveTable->bind($oldrow);
		$ArchiveTable->id = null; // set the id to null so it creates a new row
		$ArchiveTable->store($updateNulls);

		// Now add another archive row with info about being deleted
		$user = JFactory::getUser();
		$ArchiveTable->last_updated_by 	= $user->id;
		$ArchiveTable->last_updated 	= JFactory::getDate()->toMySQL();
		$ArchiveTable->updatereason_id 	= ServiceProjectHelper::getSystemUpdateReasonID($reasonID);
		if ($reasonID == 1004) {
			// Set Update Reasons to know this was a grouping of profiles
			$ArchiveTable->updatecomments	= JText::_('COM_SERVICEPROJECT_UR_MERGEPROFILE').' ('.$new_profile_id.')';
		} else {
			// Just normal delete
			$ArchiveTable->updatecomments	= JText::_('COM_SERVICEPROJECT_UR_DELETEPROFILE');
		}
		$ArchiveTable->id = null; // set the id to null so it creates a new row
		$ArchiveTable->store($updateNulls);
		
		// Delete the row now
		return parent::delete($pk);
	}
	
	//TODO: Add publish function to add transactions for publish state changes
}
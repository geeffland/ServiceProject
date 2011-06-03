<?php
/**
 * This table is called for changes to the ServiceProject_Addresses table
 *
 * @version		$Id: address.php
 * @package		com_serviceproject
 * @subpackage	admin.tables
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;
// include the archive table
require_once JPATH_COMPONENT.DS.'tables'.DS.'archiveaddress.php';
require_once JPATH_COMPONENT.DS.'tables'.DS.'profile.php';
require_once JPATH_COMPONENT.DS.'helpers'.DS.'serviceproject.php';
/**
 * _serviceproject_addresses table
 *
 * @package		com_serviceproject
 * @subpackage	admin.tables
 */
class ServiceProjectTableAddress extends JTable
{
	protected $tabletype 	= 'Address';
	protected $tableprefix 	= 'ServiceProjectTable';
	/**
	 * Constructor
	 *
	 */
	function __construct(&$_db)
	{
		parent::__construct('#__serviceproject_addresses', 'id', $_db);
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
		
		// Set ordering
		if ($this->published < 0) {
			// Set ordering to 0 if state is archived or trashed
			$this->ordering = 0;
		} else if (empty($this->ordering)) {
			// Set ordering to last if ordering was 0
			$this->ordering = self::getNextOrder('`published`>=0');
		}

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
		//$updateProfiles = '';
		$updateProfiles = array();
		$updateProjects = '';
		$delim 			= '';
		$checkprofile		= JRequest::getVar('checkprofile', array(), 'post', 'array');

		$user = JFactory::getUser();
		$this->last_updated_by = $user->id;
		$this->last_updated = JFactory::getDate()->toMySQL();

		if (empty($this->id))
		{
			$this->address_id 		= ServiceProjectHelper::getNewAddressID();
			// New row
			// Set any desired values
			// Store the row
			parent::store($updateNulls);
			ServiceProjectHelper::setNewAddressID($this->address_id + 1);
		}
		else
		{
			// See if the Address needs to be copied before editing
			$copyBeforeEdit = false;
			foreach ($checkprofile as $key => $status) {
				if ($status=="off") {
					$copyBeforeEdit = true;
					//$updateProfiles = $updateProfiles.$delim.$key;
					$updateProfiles[] = $key;
					$delim = ', ';
				}
			}
			
			// Get the old row
			$oldrow = JTable::getInstance($this->tabletype, $this->tableprefix);
			if (!$oldrow->load($this->id) && $oldrow->getError())
			{
				$this->setError($oldrow->getError());
			}
			
			//copy if needed
			if ($copyBeforeEdit) {
				$UpdateReasonID = 2001;	// Split Address
				// Copy row
				$newaddressid = $this->copycurrentrow();
				// Row is copied now change all profiles and projects that were off to point to new copy
				$ProfileTable = new ServiceProjectTableProfile($this->_db);
				foreach ($updateProfiles as $profileID)
				{
					$ProfileTable->load($profileID);
					$ProfileTable->updateaddressid($newaddressid, $UpdateReasonID);
				}
				//updateProjects
//TODO:				
			}
			// null out fields which did not change from last archive row
			$fieldschanged = true;
/**			$LastArchiveRow = new ServiceProjectTableArchiveAddress($this->_db);
			$table = $LastArchiveRow->getTableName();
			$tablekey = 'address_id';
			$lastarchiveID = ServiceProjectHelper::getLastArchiveID($table, $tablekey, $oldrow->$tablekey);
			//print_r($lastarchiveID);
			//$LastArchiveRow = JTable::getInstance($this->tabletype, $this->tableprefix);
			if (!$LastArchiveRow->load($lastarchiveID) && $LastArchiveRow->getError())
			{
				$this->setError($LastArchiveRow->getError());
			}

			$results = $this->getFields();
			//$dbfields = Array();
			$fieldschanged = false;
			foreach ($results as $key => $value) {
				//$dbfields[] = $key;
				//echo 'key: '.$key;
				//echo ' -- old: '.$oldrow->$key.'<br>';
				//echo ' -- last: '.$LastArchiveRow->$key.'<br>';
				if ($key!='id' & $key!=$tablekey) {
					if ($oldrow->$key == $LastArchiveRow->$key) {
						$oldrow->$key = null;
					} else {
						$fieldschanged = true;
						echo 'changed<br>';
					}
				}
			}
**/
			if ($fieldschanged) {
				// Add row to archive table
				$ArchiveTable = new ServiceProjectTableArchiveAddress($this->_db);
				$ArchiveTable->bind($oldrow);
				$ArchiveTable->id=null; // set the id to null so it creates a new row
				$ArchiveTable->store($updateNulls);
			}
			
			// Store the new row
			parent::store($updateNulls);

			// Need to reorder ?
			if ($oldrow->published>=0 && ($this->published < 0))
			{
				// Reorder the oldrow
				$this->reorder('published>=0');
			}
		}
		return count($this->getErrors())==0;
	}

	/**
	 * method to copy the current row
	 *
	 */
	public function copycurrentrow()
	{
		// 2001 = Split Address
		// 2003 = Copy Address
		$reasonID = 2001; 
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
		$CopyTable->id = null;
		// Set Update Reasons to know this was a split address
		$CopyTable->updatereason_id = ServiceProjectHelper::getSystemUpdateReasonID($reasonID);
		$CopyTable->updatecomments 	= JText::_( ServiceProjectHelper::getSystemUpdateReason($reasonID) ).' ('.$CopyTable->address_id.')';
		$CopyTable->ordering = self::getNextOrder('`published`>=0');
		$user = JFactory::getUser();
		$CopyTable->last_updated_by = $user->id;
		$CopyTable->last_updated 	= JFactory::getDate()->toMySQL();
		//store the new row
		$CopyTable->store(false);
		
		return $CopyTable->address_id;
	}
	
	/**
	 * Method to wrap the built-in delete function and add an archive transaction before deleting
	 *
	 */
	public function delete($pk = null, $reasonID = 2004, $new_address_id = 0)
	{
		// exit if the adress is being merged upon itself
		if ($pk == $new_address_id) {
			return false;
		}
		
		// Get the old row
		$oldrow = JTable::getInstance($this->tabletype, $this->tableprefix);
		if (!$oldrow->load($pk) && $oldrow->getError())
		{
			$this->setError($oldrow->getError());
		}

		// Add row to archive table
		$ArchiveTable = new ServiceProjectTableArchiveAddress($this->_db);
		$ArchiveTable->bind($oldrow);
		$ArchiveTable->id = null; // set the id to null so it creates a new row
		$ArchiveTable->store($updateNulls);

		// Now add another archive row with info about being deleted
		$user = JFactory::getUser();
		$ArchiveTable->last_updated_by 	= $user->id;
		$ArchiveTable->last_updated 	= JFactory::getDate()->toMySQL();
		$ArchiveTable->updatereason_id	= ServiceProjectHelper::getSystemUpdateReasonID($reasonID);
		if ($reasonID == 2002) {
			// Set Update Reasons to know this was a grouping of addresses
			$ArchiveTable->updatecomments	= JText::_('COM_SERVICEPROJECT_UR_MERGEADDRESS').' ('.$new_address_id.')';
		} else {
			// Just normal delete
			$ArchiveTable->updatecomments	= JText::_('COM_SERVICEPROJECT_UR_DELETEADDRESS');
		}
		$ArchiveTable->id = null; // set the id to null so it creates a new row
		$ArchiveTable->store($updateNulls);
		
		// Delete the row now
		return parent::delete($pk);
	}
	
	//TODO: Add publish function to add transactions for publish state changes
}
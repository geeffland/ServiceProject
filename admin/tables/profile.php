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
require_once JPATH_COMPONENT.DS.'tables'.DS.'archiveprofile.php';
require_once JPATH_COMPONENT.DS.'helpers'.DS.'serviceproject.php';
require_once JPATH_COMPONENT.DS.'tables'.DS.'address.php';
/**
 * _serviceproject_addresses table
 *
 * @package		com_serviceproject
 * @subpackage	admin.tables
 */
class ServiceProjectTableProfile extends JTable
{
	protected $tabletype 	= 'Profile';
	protected $tableprefix 	= 'ServiceProjectTable';
	/**
	 * Constructor
	 *
	 */
	function __construct(&$_db)
	{
		parent::__construct('#__serviceproject_profiles', 'id', $_db);
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
/**		if ($this->published < 0) {
			// Set ordering to 0 if state is archived or trashed
			$this->ordering = 0;
		} else if (empty($this->ordering)) {
			// Set ordering to last if ordering was 0
			$this->ordering = self::getNextOrder('`published`>=0');
		}
**/
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

	public function getProfileQtyUsingAddress($address_id)
	{
		// Initialize variables.
		$options = array();

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('count(id) as total');
		$query->from('#__serviceproject_profiles AS a');
		$query->where('address_id='.$address_id);

		// Get the options.
		$db->setQuery($query);

		$qty = $db->loadResult();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		return $qty;
	}

	public function getProjectQtyUsingAddress($address_id)
	{
		// Initialize variables.
/**		$options = array();

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('count(id) as total');
		$query->from('#__serviceproject_projects AS a');
		$query->where('address_id='.$address_id);

		// Get the options.
		$db->setQuery($query);

		$qty = $db->loadResult();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		return $qty; 
*/
		return 0;
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
	
		// Get new Address info
		$checkAddress = isset($_REQUEST['address']);

		$address			= JRequest::getVar('address', array(), 'post', 'array');
		$street1			= trim($address['street1']);
		$street2			= trim($address['street2']);
		$city				= trim($address['city']);
		$state				= trim($address['state']);
		$zipcode			= trim($address['zipcode']);
		$latitude			= trim($address['latitude']);
		$longitude			= trim($address['longitude']);
		$gm_zoomlevel		= trim($address['gm_zoomlevel']);
		$center_latitude	= trim($address['center_latitude']);
		$center_longitude	= trim($address['center_longitude']);
		
		if ($this->id==0) {
			$this->id = null;
		}

		if (empty($this->id))
		{
			$this->profile_id 		= ServiceProjectHelper::getNewProfileID();
			// Check to see if it matches an existing address...  If so get address ID
			if ($checkAddress) {
				$addressID = ServiceProjectHelper::getMatchingAddressId($address);
				if ($addressID=='') {
					// new address so add it
					$this->address_id = $this->addUpdateAddress($address);
				} else {
					// set it to the matching address
					$this->address_id = $addressID;
				}
			}
			// New row
			// Set any desired values
			// Store the row
			parent::store($updateNulls);
			ServiceProjectHelper::setNewProfileID($this->profile_id + 1);
		} else {
			// Get the old row
			$oldrow = JTable::getInstance($this->tabletype, $this->tableprefix);
			if (!$oldrow->load($this->id) && $oldrow->getError())
			{
				$this->setError($oldrow->getError());
			}
			
			// Find out where else this address is used in case it changes
			$qtyProfiles	= $this->getProfileQtyUsingAddress($oldrow->address_id);
			$qtyProjects	= $this->getProjectQtyUsingAddress($oldrow->address_id);
			$qtyUsedAddress	= $qtyProfiles + $qtyProjects;
			
			// Get old address info
			$oldAddress		= ServiceProjectHelper::getAddressById($oldrow->address_id);
			
			// check for Address Differences
			$addressChanged = false;
			if ($street1 != $oldAddress->streetaddress1) {
				$addressChanged = true;
			} elseif ($street2 != $oldAddress->streetaddress2) {			
				$addressChanged = true;
			} elseif ($city != $oldAddress->city) {
				$addressChanged = true;
			} elseif ($state != $oldAddress->state) {
				$addressChanged = true;
			} elseif ($zipcode != $oldAddress->zipcode) {
				$addressChanged = true;
			} elseif ($latitude != $oldAddress->latitude) {
				$addressChanged = true;
			} elseif ($longitude != $oldAddress->longitude) {
				$addressChanged = true;
			} elseif ($gm_zoomlevel != $oldAddress->gm_zoomlevel) {
				$addressChanged = true;
			}
			
			if ($addressChanged) {
				if ($qtyUsedAddress==1) {
					// Now update the address
					$result = $this->addUpdateAddress($address, $this->address_id);
				} else {
					// Check to see if it matches an existing address...  If so get address ID
					$addressID = ServiceProjectHelper::getMatchingAddressId($address);
					if ($addressID=='') {
						// The address is used somewhere else and does not match any others 
						// .... so create a new address and get address ID
						// new address so add it
						$this->address_id = $this->addUpdateAddress($address);
					} else {
						// set it to the matching address
						$this->address_id = $addressID;
					}					
				}
			}
//			$this->updatecomments = $addressChanged ;  // temporary for debugging
			//process Address and see if there is a match in the DB
			// if no match then add a new address
			// then set the correct address_id

			// Add row to archive table
			$ArchiveTable = new ServiceProjectTableArchiveProfile($this->_db);
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
		$CopyTable->updatecomments	= JText::_( ServiceProjectHelper::getSystemUpdateReason($reasonID) ).' ('.$CopyTable->profile_id.')';
		$CopyTable->ordering = self::getNextOrder('`published`>=0');
		$user = JFactory::getUser();
		$CopyTable->last_updated_by = $user->id;
		$CopyTable->last_updated 	= JFactory::getDate()->toMySQL();
		//store the new row
		$CopyTable->store(false);
		
		return $CopyTable->profile_id;
	}

	/**
	 * method to update the address id and create a archive transaction
	 *
	 * @param boolean $updateNulls True to update fields even if they are null.
	 */
	public function addUpdateAddress($address, $id = null)
	{
		$updateNulls = false;
		$AddressTable = new ServiceProjectTableAddress($this->_db);
		$AddressTable->id				= $id;
		$AddressTable->streetaddress1	= trim($address['street1']);
		$AddressTable->streetaddress2	= trim($address['street2']);
		$AddressTable->city				= trim($address['city']);
		$AddressTable->state			= trim($address['state']);
		$AddressTable->zipcode			= trim($address['zipcode']);
		$AddressTable->latitude			= trim($address['latitude']);
		$AddressTable->longitude		= trim($address['longitude']);
		$AddressTable->gm_zoomlevel		= trim($address['gm_zoomlevel']);
		$AddressTable->center_latitude	= trim($address['center_latitude']);
		$AddressTable->center_longitude	= trim($address['center_longitude']);
		$AddressTable->address_id 		= ServiceProjectHelper::getNewAddressID();
		$AddressTable->published		= 1;
		$AddressTable->store($updateNulls);

		return $AddressTable->address_id;
	}
	
	/**
	 * method to update the address id and create a archive transaction
	 *
	 * @param boolean $updateNulls True to update fields even if they are null.
	 */
	public function updateaddressid($newaddressid, $UpdateReasonID=2001, $updateNulls = false)
	{
		if (empty($this->id))
		{
			// No current row... so can't update
			return false;
		}
		else
		{
			// Get the old row
			$oldrow = JTable::getInstance($this->tabletype, $this->tableprefix);
			if (!$oldrow->load($this->id) && $oldrow->getError())
			{
				$this->setError($oldrow->getError());
			}
			
			// Add row to archive table
			$ArchiveTable = new ServiceProjectTableArchiveProfile($this->_db);
			$ArchiveTable->bind($oldrow);
			$ArchiveTable->id = null; // set the id to null so it creates a new row
			$ArchiveTable->store($updateNulls);
			
			$this->address_id = $newaddressid;
			// Set Update Reasons to know this was a split address
			$this->updatereason_id = ServiceProjectHelper::getSystemUpdateReasonID($UpdateReasonID);
			$this->updatecomments=JText::_( ServiceProjectHelper::getUpdateReason($UpdateReasonID) ).' ('.$oldrow->address_id.')';
//			$this->updatecomments=JText::_('COM_SERVICEPROJECT_UR_SPLITADDRESS').' ('.$oldrow->address_id.')';
			$user = JFactory::getUser();
			$this->last_updated_by = $user->id;
			$this->last_updated = JFactory::getDate()->toMySQL();
			// Store the new row
			parent::store(false);

		}
		

		return count($this->getErrors())==0;
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
<?php
/**
 * This table is called for changes to the ServiceProject_EventGroupShifts table
 *
 * @version		$Id: eventgroupshift.php
 * @package		com_serviceproject
 * @subpackage	admin.tables
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;
// include the archive table
require_once JPATH_COMPONENT.DS.'tables'.DS.'archiveeventgroupshift.php';
require_once JPATH_COMPONENT.DS.'helpers'.DS.'serviceproject.php';

/**
 * _serviceproject_registrationstatus table
 *
 * @package		com_serviceproject
 * @subpackage	admin.tables
 */
class ServiceProjectTableEventGroupShift extends JTable
{
	protected $tabletype 	= 'EventGroupShift';
	protected $tableprefix 	= 'ServiceProjectTable';
	/**
	 * Constructor
	 *
	 */
	function __construct(&$_db)
	{
		parent::__construct('#__serviceproject_eventgroupshifts', 'id', $_db);
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
		jimport('joomla.utilities.date');

		// Set updatereason
		$this->updatecomments = htmlspecialchars_decode($this->updatecomments, ENT_QUOTES);
		$sdate			= JRequest::getVar('startdate');
		$stime			= JRequest::getVar('starttime');
		$etime			= JRequest::getVar('endtime');
		//$startdate = new DateTime($sdate);
		$starttime = strtotime($stime); // new DateTime($stime);
		$endtime = strtotime($etime); // new DateTime($etime);
		if ($starttime>$endtime) {
			$enddate = new DateTime($sdate);
			$enddate->add(new DateInterval('P1D'));
			$edate = $enddate->format('Y-m-d');
		} else {
			$edate = $sdate;
		}
		$sdatetime = new JDate(strtotime($sdate . ' ' . $stime));
		$edatetime = new JDate(strtotime($edate . ' ' . $etime));
		
		$this->startdate	= $sdatetime->toMySQL() ;
		$this->enddate		= $edatetime->toMySQL() ;

		// Set ordering
		if ($this->published < 0) {
			// Set ordering to 0 if state is archived or trashed
			$this->ordering = 0;
		} else if (empty($this->ordering)) {
			// Set ordering to last if ordering was 0
			$this->ordering = self::getNextOrder('`eventgroup_id`=' . $this->_db->Quote($this->eventgroup_id).' AND `published`>=0');
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
		$user = JFactory::getUser();
		$this->last_updated_by = $user->id;
		$this->last_updated = JFactory::getDate()->toMySQL();

		if (empty($this->id))
		{
			// New row
			// Set any desired values
			$this->shift_id 		= ServiceProjectHelper::getNewEventGroupShiftID();
			// Store the row
			parent::store($updateNulls);
			ServiceProjectHelper::setNewEventGroupShiftID($this->shift_id + 1);
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
			$ArchiveTable = new ServiceProjectTableArchiveEventGroupShift($this->_db);
			$ArchiveTable->bind($oldrow);
			$ArchiveTable->id=null; // set the id to null so it creates a new row
			$ArchiveTable->store($updateNulls);

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
		// 3001 = Copy Shift
		$reasonID = 3001; 
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
		// Modify Title
		$CopyTable->title = JText::_('COM_SERVICEPROJECT_COPYOF').' '.$CopyTable->title;
		// Set Update Reasons to know this was a split address
		$CopyTable->updatereason_id = ServiceProjectHelper::getSystemUpdateReasonID($reasonID);
		$CopyTable->updatecomments 	= JText::_( ServiceProjectHelper::getSystemUpdateReason($reasonID) ).' ('.$CopyTable->shift_id.')';
		$CopyTable->ordering = self::getNextOrder('`eventgroup_id`=' . $CopyTable->_db->Quote($CopyTable->eventgroup_id).' AND `published`>=0');
		$user = JFactory::getUser();
		$CopyTable->last_updated_by = $user->id;
		$CopyTable->last_updated 	= JFactory::getDate()->toMySQL();
		//store the new row
		$CopyTable->store(false);
		
		return $CopyTable->shift_id;
	}
}
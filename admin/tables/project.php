<?php
/**
 * This table is called for changes to the ServiceProject_Projects table
 *
 * @version		$Id: project.php
 * @package		com_serviceproject
 * @subpackage	admin.tables
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;
// include the archive table
require_once JPATH_COMPONENT.DS.'tables'.DS.'archiveproject.php';
require_once JPATH_COMPONENT.DS.'helpers'.DS.'serviceproject.php';

/**
 * _serviceproject_projects table
 *
 * @package		com_serviceproject
 * @subpackage	admin.tables
 */
class ServiceProjectTableProject extends JTable
{
	protected $tabletype 	= 'Project';
	protected $tableprefix 	= 'ServiceProjectTable';
	/**
	 * Constructor
	 *
	 */
	function __construct(&$_db)
	{
		parent::__construct('#__serviceproject_projects', 'id', $_db);
		//$this->created = JFactory::getDate()->toMySQL();
	}

	/**
	 * Overloaded check function
	 *
	 * @return	boolean
	 * @see		JTable::check
	 */
	function check()
	{
		jimport('joomla.filter.output');
		jimport('joomla.utilities.date');

		if (trim($this->title) == '') {
			$this->setError(JText::_('COM_SERVICEPROJECT_WARNING_PROVIDE_VALID_TITLE'));
			return false;
		}
		
		if (trim(str_replace('&nbsp;', '', $this->shortdescription)) == '') {
			$this->shortdescription = '';
		}
		
		if (trim(str_replace('&nbsp;', '', $this->longdescription)) == '') {
			$this->longdescription = '';
		}
		
		// Set updatereason
		$this->updatecomments = htmlspecialchars_decode($this->updatecomments, ENT_QUOTES);

		$regsdate			= JRequest::getVar('registration_startdate');
		$regstime			= JRequest::getVar('registration_starttime');
		$regedate			= JRequest::getVar('registration_enddate');
		$regetime			= JRequest::getVar('registration_endtime');
		$regsdatetime = new JDate(strtotime($regsdate . ' ' . $regstime));
		$regedatetime = new JDate(strtotime($regedate . ' ' . $regetime));
		$this->registration_startdate	= $regsdatetime->toMySQL() ;
		$this->registration_enddate		= $regedatetime->toMySQL() ;

		$pubsdate			= JRequest::getVar('publish_startdate');
		$pubstime			= JRequest::getVar('publish_starttime');
		$pubedate			= JRequest::getVar('publish_enddate');
		$pubetime			= JRequest::getVar('publish_endtime');
		$pubsdatetime = new JDate(strtotime($pubsdate . ' ' . $pubstime));
		$pubedatetime = new JDate(strtotime($pubedate . ' ' . $pubetime));
		$this->publish_startdate	= $pubsdatetime->toMySQL() ;
		$this->publish_enddate		= $pubedatetime->toMySQL() ;

		// Check the registration down date is not earlier than registration up.
		if (intval($this->registration_enddate) > 0 && $this->registration_enddate < $this->registration_startdate) {
			// Swap the dates.
			$temp = $this->registration_startdate;
			$this->registration_startdate = $this->registration_enddate;
			$this->registration_enddate = $temp;
		}
		
		// Check the publish down date is not earlier than publish up.
		if (intval($this->publish_enddate) > 0 && $this->publish_enddate < $this->publish_startdate) {
			// Swap the dates.
			$temp = $this->publish_startdate;
			$this->publish_startdate = $this->publish_enddate;
			$this->publish_enddate = $temp;
		}

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
	function store($updateNulls = false)
	{
		$user = JFactory::getUser();
		$this->last_updated_by = $user->id;
		$this->last_updated = JFactory::getDate()->toMySQL();

		if (empty($this->id))
		{
			// New row
			// Set any desired values
			$this->project_id 		= ServiceProjectHelper::getNewProjectID();
			// Store the row
			parent::store($updateNulls);
			ServiceProjectHelper::setNewProjectID($this->project_id + 1);
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
			$ArchiveTable = new ServiceProjectTableArchiveProject($this->_db);
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
}
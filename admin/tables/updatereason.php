<?php
/**
 * This table is called for changes to the ServiceProject_UpdateReasons table
 *
 * @version		$Id: updatereason.php
 * @package		com_serviceproject
 * @subpackage	admin.tables
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

require_once JPATH_COMPONENT.DS.'helpers'.DS.'serviceproject.php';

/**
 * _serviceproject_updatereasons table
 *
 * @package		com_serviceproject
 * @subpackage	admin.tables
 */
class ServiceProjectTableUpdatereason extends JTable
{
	protected $tabletype 	= 'UpdateReason';
	protected $tableprefix 	= 'ServiceProjectTable';
	/**
	 * Constructor
	 *
	 */
	function __construct(&$_db)
	{
		parent::__construct('#__serviceproject_updatereasons', 'id', $_db);
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

		// Set updatereason
		$this->updatereason = htmlspecialchars_decode($this->updatereason, ENT_QUOTES);

		// Set ordering
		if ($this->published < 0) {
			// Set ordering to 0 if state is archived or trashed
			$this->ordering = 0;
		} else if (empty($this->ordering)) {
			// Set ordering to last if ordering was 0
			$this->ordering = self::getNextOrder('`updatetype`=' . $this->_db->Quote($this->updatetype).' AND `published`>=0');
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
		if (empty($this->id))
		{
			// New row
			// Set any desired values
			// Store the row
			parent::store($updateNulls);
			ServiceProjectHelper::resetNewUpdateReasonID();
		}
		else
		{
			// Get the old row
			$oldrow = JTable::getInstance($this->tabletype, $this->tableprefix);
			if (!$oldrow->load($this->id) && $oldrow->getError())
			{
				$this->setError($oldrow->getError());
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
}
<?php
/**
 * This table is called for changes to the ServiceProject_Addresses table
 *
 * @version		$Id: archiveaddress.php
 * @package		com_serviceproject
 * @subpackage	admin.tables
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * _serviceproject_archive_addresses table
 *
 * @package		com_serviceproject
 * @subpackage	admin.tables
 */
class ServiceProjectTableArchiveEventGroup extends JTable
{
	protected $tabletype 	= 'ArchiveEventGroup';
	protected $tableprefix 	= 'ServiceProjectTable';
	/**
	 * Constructor
	 *
	 */
	function __construct(&$_db)
	{
		parent::__construct('#__serviceproject_archive_eventgroups', 'id', $_db);
		//$this->created = JFactory::getDate()->toMySQL();
	}

}
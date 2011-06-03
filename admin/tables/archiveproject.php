<?php
/**
 * This table is called for changes to the ServiceProject_Projects table
 *
 * @version		$Id: archiveproject.php
 * @package		com_serviceproject
 * @subpackage	admin.tables
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * _serviceproject_archive_projects table
 *
 * @package		com_serviceproject
 * @subpackage	admin.tables
 */
class ServiceProjectTableArchiveProject extends JTable
{
	protected $tabletype 	= 'ArchiveProject';
	protected $tableprefix 	= 'ServiceProjectTable';
	/**
	 * Constructor
	 *
	 */
	function __construct(&$_db)
	{
		parent::__construct('#__serviceproject_archive_projects', 'id', $_db);
		//$this->created = JFactory::getDate()->toMySQL();
	}

}
<?php
/**
 * This controller is called for by Projects tasks
 *
 * @version		$Id: projects.php
 * @package		com_serviceproject
 * @subpackage	admin.controllers
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Update Reasons list controller class.
 *
 */
class ServiceProjectControllerProjects extends JControllerAdmin
{
	/**
	 * Constructor.
	 *
	 * @param	array An optional associative array of configuration settings.
	 * @see		JController
	 * @since	1.6
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);
		$this->text_prefix="COM_SERVICEPROJECT_PROJECTS";
		// I think this registerTask points a task without a function to a function
		//$this->registerTask('unfeatured',	'featured');
	}

	/**
	 * Proxy for getModel.
	 * @since	1.6
	 */
	public function &getModel($name = 'Project', $prefix = 'ServiceProjectModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
}

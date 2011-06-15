<?php
/**
 * This is the main controller for the ServiceProject Component
 *
 * @version		
 * @package		com_serviceproject
 * @subpackage	admin
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Access check.  Check for "Access Component" Privelleges
if (!JFactory::getUser()->authorise('core.manage', 'com_serviceproject')) {
	return JError::raiseWarning(404, JText::_('COM_SERVICEPROJECT_ADMIN_NOMANAGE'));
}

// Include dependencies... import Joomla Controller Library
jimport('joomla.application.component.controller');

// Get an instance of the controller prefixed by serviceproject (in controller.php)
$controller = JController::getInstance('ServiceProject');
// $prefix='ServiceProject'  $config=array()
// 'base_path' can be defined in $config... default is JPATH_COMPONENT
// $format is word 'format'
// $command is var 'task'... default is 'display'... can be of form 'type.task' AKA 'controller.task'
// Controller in $base_path/controllers/ directory = name.format.php... if format='html' then .format=''... name=$command OR ('task')
// Controller Class = $prefix 'Controller' $type ... default controller defaults to $prefix 'Controller'
// Load and Instantiate the class

// Perform the Request "task"... if no task is specified it will call the "display" function by default
$controller->execute(JRequest::getCmd('task'));
// execute the 'task'... if 'task' is not in taskmap (set via registertask) then defaults to 'display'

// Redirect if set by the controller
$controller->redirect();

?>
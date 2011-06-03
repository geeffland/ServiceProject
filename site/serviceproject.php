<?php
/**
 * @version		
 * @package		ServiceProject
 * @subpackage	com_serviceproject
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Access check.  (For Admin only?)
//if (!JFactory::getUser()->authorise('core.manage', 'com_serviceproject')) {
//	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
//}

// Include dependencies... import Joomla Controller Library
jimport('joomla.application.component.controller');
require_once JPATH_COMPONENT.'/helpers/route.php';
require_once JPATH_COMPONENT.'/helpers/query.php';

// Get an instance of the controller prefixed by ServiceProject (in controller.php)
$controller = JController::getInstance('ServiceProject');
// Perform the Request "task"... if no task is specified it will call the "display" function by default
$controller->execute(JRequest::getCmd('task'));
// Redirect if set by the controller
$controller->redirect();

?>
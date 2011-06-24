<?php
/**
 * @version		
 * @package		com_serviceproject
 * @subpackage	admin
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

//TODO: Check if this is needed... com_weblinks does not have this line
// Include dependencies... import Joomla Controller Library
jimport('joomla.application.component.controller');

/**
 * Component Controller
 *
 * @package		Joomla.Administrator
 * @subpackage	com_serviceproject
 */
class ServiceProjectController extends JController
{
	/** GEE 08-18-2010 
	 * The following sets the default view for this controller.
	 * The base class picks up the $default_view variable if not defined in the URI as 'view' or in $config when constructed
	 * Default View  = $[controller]name . 'View' . $[view]name ... default $[view]name = $[controller]name
	 * Default Layout = 'default' unless defined in URI 'layout'
	 * Default Model = $[controller]name . 'Model' . $[model]name ... default $[model]name = $[controller]name
	 */
	/**
	 * @var		string	The default view.
	 * @since	1.6
	 */
	protected $default_view = 'main';

	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		require_once JPATH_COMPONENT.'/helpers/serviceproject.php';

//		// Load the submenu based on the URI 'view' or the default_view assigned above
//		ServiceProjectHelper::addSubmenu(JRequest::getWord('view', $this->default_view));

		parent::display($cachable);

		return $this;
	}
	
	/**
	 * Proxy for getModel.
	 *
	 * @since	1.6
	 */
	public function getProjectRoleModel($name = 'ProjectRole', $prefix = 'ServiceProjectModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function toggleCanModifyProject()
	{
		// Check for request forgeries. // Disable for now because I don't know how to pass a token thru an Ajax call.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$messages = array();
		$html = array();

		require_once JPATH_COMPONENT.'/helpers/serviceproject.php';
		require_once JPATH_COMPONENT.'/models/projectrole.php';
		// Initialise variables.
		$ids	= JRequest::getVar('cid', array(), '', 'array');
		$prefix	= JRequest::getVar('prefix', '');
		$jsTask	= JRequest::getVar('jstask', '');
		
		if (empty($ids)) {
			$messages[] = JText::_('COM_SERVICEPROJECT_ROLES_NO_ITEM_SELECTED');
		} else {
			// Get the model.
			$model = $this->getProjectRoleModel();

			//cycle thru ids one at a time so html and messages can be collected
			foreach ($ids as $id) {
				// Change the state of the records.
				if (!$model->toggleCanModifyProject($ids, $prefix, $retValue)) {
					$messages[] = $model->getError();
				} else {
					$htmlcode = ServiceProjectHelper::showTrueFalseLink($retValue, $jsTask, $prefix, $id);
					$html[] = array('id'=>$prefix.$id, 'html'=>$htmlcode);
				}
			}
		}
		
		$ReturnResults = array('messages' => $messages, 'htmlcode' => $html);
		$JSONResults = json_encode($ReturnResults);
		echo $JSONResults;
		return true;
	}

	public function toggleCanModifyVolunteers()
	{
		// Check for request forgeries. // Disable for now because I don't know how to pass a token thru an Ajax call.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$messages = array();
		$html = array();

		require_once JPATH_COMPONENT.'/helpers/serviceproject.php';
		require_once JPATH_COMPONENT.'/models/projectrole.php';
		// Initialise variables.
		$ids	= JRequest::getVar('cid', array(), '', 'array');
		$prefix	= JRequest::getVar('prefix', '');
		$jsTask	= JRequest::getVar('jstask', '');
		
		if (empty($ids)) {
			$messages[] = JText::_('COM_SERVICEPROJECT_ROLES_NO_ITEM_SELECTED');
		} else {
			// Get the model.
			$model = $this->getProjectRoleModel();

			//cycle thru ids one at a time so html and messages can be collected
			foreach ($ids as $id) {
				// Change the state of the records.
				if (!$model->toggleCanModifyVolunteers($ids, $prefix, $retValue)) {
					$messages[] = $model->getError();
				} else {
					$htmlcode = ServiceProjectHelper::showTrueFalseLink($retValue, $jsTask, $prefix, $id);
					$html[] = array('id'=>$prefix.$id, 'html'=>$htmlcode);
				}
			}
		}
		
		$ReturnResults = array('messages' => $messages, 'htmlcode' => $html);
		$JSONResults = json_encode($ReturnResults);
		echo $JSONResults;
		return true;
	}

	public function toggleCanViewContactInfo()
	{
		// Check for request forgeries. // Disable for now because I don't know how to pass a token thru an Ajax call.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));
		$messages = array();
		$html = array();

		require_once JPATH_COMPONENT.'/helpers/serviceproject.php';
		require_once JPATH_COMPONENT.'/models/projectrole.php';
		// Initialise variables.
		$ids	= JRequest::getVar('cid', array(), '', 'array');
		$prefix	= JRequest::getVar('prefix', '');
		$jsTask	= JRequest::getVar('jstask', '');
		
		if (empty($ids)) {
			$messages[] = JText::_('COM_SERVICEPROJECT_ROLES_NO_ITEM_SELECTED');
		} else {
			// Get the model.
			$model = $this->getProjectRoleModel();

			//cycle thru ids one at a time so html and messages can be collected
			foreach ($ids as $id) {
				// Change the state of the records.
				if (!$model->toggleCanViewContactInfo($ids, $prefix, $retValue)) {
					$messages[] = $model->getError();
				} else {
					$htmlcode = ServiceProjectHelper::showTrueFalseLink($retValue, $jsTask, $prefix, $id, 'COM_SERVICEPROJECT_CANVIEW', 'COM_SERVICEPROJECT_CANNOTVIEW');
					$html[] = array('id'=>$prefix.$id, 'html'=>$htmlcode);
				}
			}
		}
		
		$ReturnResults = array('messages' => $messages, 'htmlcode' => $html);
		$JSONResults = json_encode($ReturnResults);
		echo $JSONResults;
		return true;
	}

}
<?php
/**
 * This controller is called for by UpdateReason tasks
 *
 * @version		$Id: updatereasons.php
 * @package		com_serviceproject
 * @subpackage	admin.controllers
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * @package		Joomla.Administrator
 * @subpackage	com_serviceproject
 */
class ServiceProjectControllerEventGroup extends JControllerForm
{

//	public function __construct($config = array())
//	{
//		//$this->view_list="regstatuses";
//		parent::__construct($config);
//	}

	/**
	 * Method override to check if you can add a new record.
	 *
	 * @param	array	An array of input data.
	 *
	 * @return	boolean
	 */
	protected function allowAdd($data = array())
	{
		// Initialise variables.
		$user		= JFactory::getUser();
		//$categoryId	= JArrayHelper::getValue($data, 'catid', JRequest::getInt('filter_category_id'), 'int');
		$allow		= null;

		if ($allow === null) {
			// In the absense of better information, revert to the component permissions.
			return parent::allowAdd();
		} else {
			return $allow;
		}
	}

	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param	array	An array of input data.
	 * @param	string	The name of the key for the primary key.
	 *
	 * @return	boolean
	 */
	protected function allowEdit($data = array(), $key = 'id')
	{
		// Initialise variables.
		$user		= JFactory::getUser();
		$recordId	= (int) isset($data[$key]) ? $data[$key] : 0;
		$allow		= null;

		if ($recordId != 0) {
			// Check for permission... look in the #__assests table for matches with name ='com_serviceproject.updatereason.'.$recordId
			// Then read the core.edit permissions
			$allow	= $user->authorise('core.edit', 'com_serviceproject.eventgroup.'.$recordId);
		}
		
		if ($allow === null) {
			// In the absense of better information, revert to the component permissions.
			return parent::allowEdit();
		} else {
			return $allow;
		}
	}
}
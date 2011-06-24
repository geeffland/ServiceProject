<?php
/**
 * This helper draws the Admin Submenus, getActions, and getUpdateTypes
 *
 * @version		$Id: serviceproject.php
 * @package		com_serviceproject
 * @subpackage	admin.helpers
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

/**
 * ServiceProject component helper.
 *
 */
class ServiceProjectHelper
{
	public static $extention = 'com_serviceproject';

	/**
	 * Stack to hold default buttons
	 *
	 * @since	1.6
	 */
	protected static $buttons = array();

	/**
	 * Helper method to generate a button in administrator panel
	 *
	 * @param	array	A named array with keys link, image, text, access and imagePath
	 *
	 * @return	string	HTML for button
	 * @since	1.6
	 */
	public static function button($button)
	{
		if (!empty($button['access'])) {
			if (is_bool($button['access']) && $button['access'] == false) {
				return '';
			}

			// Take each pair of permission, context values.
			for ($i = 0, $n = count($button['access']); $i < $n; $i += 2) {
				if (!JFactory::getUser()->authorise($button['access'][$i], $button['access'][$i+1])) {
					return '';
				}
			}
		}

		if (empty($button['imagePath'])) {
			$template = JFactory::getApplication()->getTemplate();
			$button['imagePath'] = '/templates/'. $template .'/images/header/';
		}

		ob_start();
		require JModuleHelper::getLayoutPath('mod_quickicon', 'default_button');
		$html = ob_get_clean();
		return $html;
	}

	/**
	 * Helper method to return button list.
	 *
	 * This method returns the array by reference so it can be
	 * used to add custom buttons or remove default ones.
	 *
	 * @return	array	An array of buttons
	 * @since	1.6
	 */
	public static function &getButtons()
	{
		if (empty(self::$buttons)) {
			self::$buttons = array(
				array(
					'link' => JRoute::_('index.php?option=com_serviceproject&view=eventgroups'),
					'image' => 'icon-48-extension.png',
					'text' => JText::_('COM_SERVICEPROJECT_SUBMENU_EVENTGROUPS'),
					'access' => array('core.manage', 'com_installer')
				),
				array(
					'link' => JRoute::_('index.php?option=com_serviceproject&view=profiles'),
					'image' => 'icon-48-user.png',
					'text' => JText::_('COM_SERVICEPROJECT_SUBMENU_PROFILES'),
					'access' => array('core.manage', 'com_users')
				),
				array(
					'link' => JRoute::_('index.php?option=com_serviceproject&view=addresses'),
					'image' => 'icon-48-language.png',
					'text' => JText::_('COM_SERVICEPROJECT_SUBMENU_ADDRESSES'),
					'access' => array('core.manage', 'com_languages')
				),
				array(
					'link' => JRoute::_('index.php?option=com_serviceproject&view=reports'),
					'image' => 'icon-48-article.png',
					'text' => JText::_('COM_SERVICEPROJECT_SUBMENU_REPORTS'),
					'access' => array('core.manage', 'com_content')
				),
				array(
					'link' => JRoute::_('index.php?option=com_serviceproject&view=configurations'),
					'image' => 'icon-48-config.png',
					'text' => JText::_('COM_SERVICEPROJECT_SUBMENU_CONFIGURATION'),
					'access' => array('core.manage', 'com_config', 'core.admin', 'com_config')
				),
			);
		}

		return self::$buttons;
	}

	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 */
	public static function addSubmenu($subMenu, $vName)
	{
		switch ($subMenu) {
			case 'main':
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_EVENTGROUPS'),
					'index.php?option=com_serviceproject&view=eventgroups',
					$vName == 'eventgroups');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_PROFILES'),
					'index.php?option=com_serviceproject&view=profiles',
					$vName == 'profiles');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_ADDRESSES'),
					'index.php?option=com_serviceproject&view=addresses',
					$vName == 'addresses');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_REPORTS'),
					'index.php?option=com_serviceproject&view=reports',
					$vName == 'reports');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_CONFIGURATION'),
					'index.php?option=com_serviceproject&view=configurations',
					$vName == 'configurations');
				break;
			case 'eventgroups':
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_EVENTGROUPS'),
					'index.php?option=com_serviceproject&view=eventgroups',
					$vName == 'eventgroups');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_SHIFTS'),
					'index.php?option=com_serviceproject&view=eventgroupshifts',
					$vName == 'eventgroupshifts');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_PROJECTS'),
					'index.php?option=com_serviceproject&view=projects',
					$vName == 'projects');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_ADDRESSES'),
					'index.php?option=com_serviceproject&view=addresses',
					$vName == 'addresses');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_MAIN'),
					'index.php?option=com_serviceproject&view=main',
					$vName == 'main');
				break;
			case 'profiles':
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_REGISTRATIONS'),
					'index.php?option=com_serviceproject&view=registrations',
					$vName == 'registrations');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_LINKEDPROFILES'),
					'index.php?option=com_serviceproject&view=linkedprofiles',
					$vName == 'linkedprofiles');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_PROFILES'),
					'index.php?option=com_serviceproject&view=profiles',
					$vName == 'profiles');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_ADDRESSES'),
					'index.php?option=com_serviceproject&view=addresses',
					$vName == 'addresses');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_MAIN'),
					'index.php?option=com_serviceproject&view=main',
					$vName == 'main');
				break;
			case 'addresses':
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_PROJECTS'),
					'index.php?option=com_serviceproject&view=projects',
					$vName == 'projects');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_PROFILES'),
					'index.php?option=com_serviceproject&view=profiles',
					$vName == 'profiles');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_ADDRESSES'),
					'index.php?option=com_serviceproject&view=addresses',
					$vName == 'addresses');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_MAIN'),
					'index.php?option=com_serviceproject&view=main',
					$vName == 'main');
				break;
			case 'reports':
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_REPORTS'),
					'index.php?option=com_serviceproject&view=reports',
					$vName == 'reports');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_MAIN'),
					'index.php?option=com_serviceproject&view=main',
					$vName == 'main');
				break;
			case 'admin':
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_CONFIGURATION'),
					'index.php?option=com_serviceproject&view=configurations',
					$vName == 'configurations');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_PROJECT_CATEGORIES'),
					'index.php?option=com_serviceproject&view=projectcategories',
					$vName == 'projectcategories');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_PROJECT_SKILLS'),
					'index.php?option=com_serviceproject&view=projectskills',
					$vName == 'projectskills');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_PROJECT_AGERANGES'),
					'index.php?option=com_serviceproject&view=projectageranges',
					$vName == 'projectageranges');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_UPDATEREASONS'),
					'index.php?option=com_serviceproject&view=updatereasons',
					$vName == 'updatereasons');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_PROJECT_ROLES'),
					'index.php?option=com_serviceproject&view=projectroles',
					$vName == 'projectroles');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_REGSTATUS'),
					'index.php?option=com_serviceproject&view=regstatuses',
					$vName == 'regstatuses');
				JSubMenuHelper::addEntry(
					JText::_('COM_SERVICEPROJECT_SUBMENU_MAIN'),
					'index.php?option=com_serviceproject&view=main',
					$vName == 'main');
				break;
		}
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @param	int		The category ID.
	 * @param	int		The article ID.
	 *
	 * @return	JObject
	 */
	public static function getActions($task = 0)
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		if (empty($task)) {
			$assetName = 'com_serviceproject';
		}
		else if ($task='updatereasons') {
			$assetName = 'com_serviceproject';
		}
		else {
			$assetName = 'com_serviceproject';
		}

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action,	$user->authorise($action, $assetName));
		}

		return $result;
	}
	
	public static function getUpdateTypes()
	{
		$updateTypes 	= array();
		$updateTypes[]	= JHTML::_( 'select.option', 'address', JText::_('COM_SERVICEPROJECT_UT_ADDRESS'));
		$updateTypes[]	= JHTML::_( 'select.option', 'profile', JText::_('COM_SERVICEPROJECT_UT_PROFILE'));
		$updateTypes[]	= JHTML::_( 'select.option', 'eventgroup', JText::_('COM_SERVICEPROJECT_UT_EVENTGROUP'));
		$updateTypes[]	= JHTML::_( 'select.option', 'eventgroupshift', JText::_('COM_SERVICEPROJECT_UT_EVENTGROUPSHIFT'));
		return $updateTypes;
	}

	public static function getCities()
	{
		// Initialize variables.
		$options = array();

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('city As value, city As label, city As text');
		$query->from('#__serviceproject_addresses AS a');
		$query->order('a.city');
		$query->group('a.city');
		$query->where('a.city<>""');

		// Get the options.
		$db->setQuery($query);

		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		return $options;
	}

	public static function getStates()
	{
		// Initialize variables.
		$options = array();

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('state As value, state As text');
		$query->from('#__serviceproject_addresses AS a');
		$query->order('a.state');
		$query->group('a.state');
		$query->where('a.state<>""');

		// Get the options.
		$db->setQuery($query);

		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		return $options;
	}

	public static function getZipcodes()
	{
		// Initialize variables.
		$options = array();

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('zipcode As value, zipcode As text');
		$query->from('#__serviceproject_addresses AS a');
		$query->order('a.zipcode');
		$query->group('a.zipcode');
		$query->where('a.zipcode<>""');

		// Get the options.
		$db->setQuery($query);

		$options = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		return $options;
	}

	public static function getSystemUpdateReasonID($updatereason_systemid)
	{
		// Initialize variables.
		$options = array();

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('updatereason_id');
		$query->from('#__serviceproject_updatereasons AS a');
		$query->where('systemid='.$updatereason_systemid);

		// Get the options.
		$db->setQuery($query);

		$updatereason = $db->loadResult();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		return $updatereason;
	}
	
	public static function getSystemUpdateReason($updatereason_systemid)
	{
		// Initialize variables.
		$options = array();

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('updatereason');
		$query->from('#__serviceproject_updatereasons AS a');
		$query->where('systemid='.$updatereason_systemid);

		// Get the options.
		$db->setQuery($query);

		$updatereason = $db->loadResult();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		return $updatereason;
	}
	
	public static function getUpdateReason($updatereason_id)
	{
		// Initialize variables.
		$options = array();
		$updatereason = '';
		if ($updatereason_id!='') {
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);

			$query->select('updatereason');
			$query->from('#__serviceproject_updatereasons AS a');
			$query->where('updatereason_id='.$updatereason_id);

			// Get the options.
			$db->setQuery($query);

			$updatereason = $db->loadResult();

			// Check for a database error.
			if ($db->getErrorNum()) {
				JError::raiseWarning(500, $db->getErrorMsg());
			}
		}
		return $updatereason;
	}
	
	public static function getLinkMethods()
	{
		$linkMethods 	= array();
		$linkMethods[]	= JHTML::_( 'select.option', '1', JText::_('COM_SERVICEPROJECT_LM_ADMIN'));
		$linkMethods[]	= JHTML::_( 'select.option', '2', JText::_('COM_SERVICEPROJECT_LM_REGISTRATION'));
		$linkMethods[]	= JHTML::_( 'select.option', '3', JText::_('COM_SERVICEPROJECT_LM_PROFILE'));
		$linkMethods[]	= JHTML::_( 'select.option', '4', JText::_('COM_SERVICEPROJECT_LM_REMOTE'));
		return $linkMethods;
	}

	public static function getCanRegister()
	{
		$options 	= array();
		$options[]	= JHTML::_( 'select.option', '0', JText::_('COM_SERVICEPROJECT_CANREGISTER_ASK'));
		$options[]	= JHTML::_( 'select.option', '1', JText::_('COM_SERVICEPROJECT_CANREGISTER_ALLOW'));
		$options[]	= JHTML::_( 'select.option', '2', JText::_('COM_SERVICEPROJECT_CANREGISTER_DENY'));
		return $options;
	}

	public static function getCanModify()
	{
		$options 	= array();
		$options[]	= JHTML::_( 'select.option', '0', JText::_('COM_SERVICEPROJECT_CANMODIFY_ASK'));
		$options[]	= JHTML::_( 'select.option', '1', JText::_('COM_SERVICEPROJECT_CANMODIFY_ALLOW'));
		$options[]	= JHTML::_( 'select.option', '2', JText::_('COM_SERVICEPROJECT_CANMODIFY_DENY'));
		return $options;
	}

	public static function getCanAccess()
	{
		$options 	= array();
		$options[]	= JHTML::_( 'select.option', '0', JText::_('COM_SERVICEPROJECT_CANACCESS_ASK'));
		$options[]	= JHTML::_( 'select.option', '1', JText::_('COM_SERVICEPROJECT_CANACCESS_ALLOW'));
		$options[]	= JHTML::_( 'select.option', '2', JText::_('COM_SERVICEPROJECT_CANACCESS_DENY'));
		return $options;
	}

	public static function getEventGroups()
	{
		// Initialize variables.
		$results = array();

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('eventgroup_id, title');
		$query->from('#__serviceproject_eventgroups AS a');

		// Get the options.
		$db->setQuery($query);

		$results = $db->loadObjectList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}
		
		$selectOptions 	= array();
		
		foreach ($results as $row) {
			$value 	= $row->eventgroup_id;
			$label	= $row->title;
			$selectOptions[]	= JHTML::_( 'select.option', $value, $label);
		}

		return $selectOptions;
	}

	public function getEventGroup($eventgroup_id)
	{
		// Initialize variables.
		$options = array();
		$eventgroup = '';
		if ($eventgroup_id!='') {
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);

			$query->select('title');
			$query->from('#__serviceproject_eventgroups AS a');
			$query->where('eventgroup_id='.$eventgroup_id);

			// Get the options.
			$db->setQuery($query);

			$eventgroup = $db->loadResult();

			// Check for a database error.
			if ($db->getErrorNum()) {
				JError::raiseWarning(500, $db->getErrorMsg());
			}
		}
		return $eventgroup;
	}
	
	public function getAddressById($address_id)
	{
		// Initialize variables.
		$options = array();
		
		if ($address_id != '') {
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);

			$query->select('*');
			$query->from('#__serviceproject_addresses AS a');
			$query->where('address_id='.$address_id);

			// Get the options.
			$db->setQuery($query);

			$options = $db->loadObjectList();

			// Check for a database error.
			if ($db->getErrorNum()) {
				JError::raiseWarning(500, $db->getErrorMsg());
			}
		
		} else {
			$options[0]->streetaddress1 = '';
			$options[0]->streetaddress2 = '';
			$options[0]->city = '';
			$options[0]->state = '';
			$options[0]->zipcode = '';
			$options[0]->latitude = '';
			$options[0]->longitude = '';
			$options[0]->gm_zoomlevel = '';
			$options[0]->center_latitude = '';
			$options[0]->center_longitude = '';
		}
		return $options[0];
	}
	
	public function getMatchingAddressId($address)
	{
		// Initialize variables.
		$street1			= trim($address['street1']);
		$street2			= trim($address['street2']);
		$city				= trim($address['city']);
		$state				= trim($address['state']);
		$zipcode			= trim($address['zipcode']);
		$latitude			= trim($address['latitude']);
		$longitude			= trim($address['longitude']);
		$gm_zoomlevel		= trim($address['gm_zoomlevel']);
		$center_latitude	= trim($address['center_latitude']);
		$center_longitude	= trim($address['center_longitude']);

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('address_id');
		$query->from('#__serviceproject_addresses AS a');
		$query->where('streetaddress1="'.$street1.'"');
		$query->where('streetaddress2="'.$street2.'"');
		$query->where('city="'.$city.'"');
		$query->where('state="'.$state.'"');
		$query->where('zipcode="'.$zipcode.'"');
		// Do we want to check lat, long, zoom, etc.

		// Get the options.
		$db->setQuery($query);

		$ID = $db->loadResult();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		return $ID;		
	}
	
	public function getMaxID($key, $tablename) 
	{
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('MAX('.$key.')');
		$query->from($tablename.' AS a');
		// Get the options.
		$db->setQuery($query);
		
		$maxID = $db->loadResult();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
			return false;
		}
		return $maxID;
	}
	
	public function getNewID($configName) 
	{
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('config_value');
		$query->from('#__serviceproject_config AS a');
		$query->where("`config_name` = '".$configName."'");
		// Get the options.
		$db->setQuery($query);
		
		$newID = $db->loadResult();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
			return false;
		}
		return $newID;
	}
	
	public function setNewID($newID, $configName)
	{
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->update('`#__serviceproject_config`');
		$query->set('`config_value` = '.$newID);
		$query->where("`config_name` = '".$configName."'");
		$db->setQuery((string)$query);
		$db->query();
		
		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
			return false;
		}		
		return true;
	}

	public function resetNewID($configName, $key, $tablename)
	{
		$maxID = self::getMaxID($key, $tablename);
		$newID = self::setNewID( ($maxID + 1), $configName);
		return $newID;
	}

	public function getNewAddressID() 
	{
		return self::getNewId('next_address_id');
	}
	
	public function setNewAddressID($newID) 
	{
		return self::setNewId($newID, 'next_address_id');
	}
	
	public function getNewProfileID() 
	{
		return self::getNewId('next_profile_id');
	}
	
	public function setNewProfileID($newID) 
	{
		return self::setNewId($newID, 'next_profile_id');
	}
	
	public function getNewEventGroupID() 
	{
		return self::getNewId('next_eventgroup_id');
	}
	
	public function setNewEventGroupID($newID) 
	{
		return self::setNewId($newID, 'next_eventgroup_id');
	}
	
	public function getNewEventGroupShiftID() 
	{
		return self::getNewId('next_eventgroupshift_id');
	}
	
	public function setNewEventGroupShiftID($newID) 
	{
		return self::setNewId($newID, 'next_eventgroupshift_id');
	}
	
	public function getNewProjectID() 
	{
		return self::getNewId('next_project_id');
	}
	
	public function setNewProjectID($newID) 
	{
		return self::setNewId($newID, 'next_project_id');
	}
	
	public function getNewUpdateReasonID() 
	{
		return self::getNewId('next_updatereason_id');
	}
	
	public function setNewUpdateReasonID($newID) 
	{
		return self::setNewId($newID, 'next_updatereason_id');
	}
	
	public function resetNewUpdateReasonID()
	{
		return self::resetNewId('next_updatereason_id', 'updatereason_id', '#__serviceproject_updatereasons');
	}

	public function getNewRoleID()
	{
		return self::getNewId('next_projectrole_id');
	}
	
	public function setNewRoleID($newID) 
	{
		return self::setNewId($newID, 'next_projectrole_id');
	}

	public function resetNewRoleID()
	{
		return self::resetNewId('next_projectrole_id', 'role_id', '#__serviceproject_projectroles');
	}

	public function getNewStatusID()
	{
		return self::getNewId('next_registrationstatus_id');
	}
	
	public function setNewStatusID($newID) 
	{
		return self::setNewId($newID, 'next_registrationstatus_id');
	}
	
	public function resetNewStatusID()
	{
		return self::resetNewId('next_registrationstatus_id', 'status_id', '#__serviceproject_registrationstatus');
	}

	public function getProfileIDsUsingAddress($address_id)
	{
		// Initialize variables.
		$results = array();

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('id');
		$query->from('#__serviceproject_profiles');
		$query->where('address_id='.$address_id);

		// Get the options.
		$db->setQuery($query);

		$options = $db->loadObjectList();
		foreach ($options as $row) {
			$results[] = $row->id;
		}

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		return $results;
	}

	public function getProfilesUsingAddress($address_id)
	{
		// Initialize variables.
		$results = array();

		if ($address_id!='') {
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);

			$query->select('CONCAT(trim(a.lastname), ", ", trim(a.firstname), " ", trim(LEFT(a.middlename,1)), if(a.suffix="","",CONCAT(" (", trim(a.suffix), ")") ) ) as displayname, id');
			$query->from('#__serviceproject_profiles AS a');
			$query->where('address_id='.$address_id);

			// Get the options.
			$db->setQuery($query);

			$options = $db->loadObjectList();
			foreach ($options as $row) {
				$results[$row->id] = $row->displayname;
			}

			// Check for a database error.
			if ($db->getErrorNum()) {
				JError::raiseWarning(500, $db->getErrorMsg());
			}
		}
		return $results;
	}

	public function getCurrentAddresses()
	{
		// Initialize variables.
		$options = array();

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('addressname as namehtml, streetaddress1 as label, streetaddress1, streetaddress2 as street2html, city, state, zipcode, latitude, longitude, gm_zoomlevel, center_latitude, center_longitude');
		$query->from('#__serviceproject_addresses AS a');
		$query->where('published=1');

		// Get the options.
		$db->setQuery($query);

		$options = $db->loadAssocList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		foreach ($options as &$option) {
			if ($option['street2html'] != '') { 
				$option['street2html']=$option['street2html'].'<br>'; 
			};
			if ($option['namehtml'] != '') {
				$option['namehtml']=$option['namehtml'].'<br>'; 
			};
		}
		
		return "var currentaddresses = ".json_encode($options).";";

	}

	public function makeAddressesAutoComplete()
	{	
		echo self::getCurrentAddresses(); ?>

		$j( "#street1" ).autocomplete({
			minLength: 0,
			source: currentaddresses,
			focus: function ( event, ui ) {
				$j( "#street1" ).val( ui.item.label ); // this is what shows in the input box
				return false;
			},
			select: function( event, ui ) {
				$j( "#street1" ).val( ui.item.label );
				$j( "#street2" ).val( ui.item.streetaddress2 );
				$j( "#city" ).val( ui.item.city );
				$j( "#state" ).val( ui.item.state );
				$j( "#zipcode" ).val( ui.item.zipcode );
				$j( "#latitude" ).val( ui.item.latitude );
				$j( "#longitude" ).val( ui.item.longitude );
				$j( "#gm_zoomlevel" ).val( ui.item.gm_zoomlevel );
				$j( "#center_latitude" ).val( ui.item.center_latitude );
				$j( "#center_longitude" ).val( ui.item.center_longitude );
				return false;
			}
		})
		.data( "autocomplete" )._renderItem = function( ul, item ) {
			return $j( "<li></li>" )
				.data( "item.autocomplete", item)
				.append( "<a>" + item.namehtml + item.streetaddress1 + "<br>" + item.street2html + item.city + ", " + item.state + " " + item.zipcode + "</a>" )
				.appendTo( ul );
		};
		<?php
	}
	
	public function getAllStates()
	{
		// Initialize variables.
		$options = array();

		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('id, name as state, abbreviation,CONCAT(name, " (", abbreviation, ")") as label');
		$query->from('#__serviceproject_states AS a');

		// Get the options.
		$db->setQuery($query);

		$options = $db->loadAssocList();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		return "var allstates = ".json_encode($options).";";

	}

	public function makeStatesAutoComplete($inputID = "state")
	{	
		echo self::getAllStates(); ?>
		
		$j( "#<?php echo $inputID; ?>" ).autocomplete({
			minLength: 0,
			source: allstates,
			focus: function ( event, ui ) {
				$j( "#<?php echo $inputID; ?>" ).val( ui.item.label ); // this is what shows in the input box
				return false;
			},
			select: function( event, ui ) {
				$j( "#<?php echo $inputID; ?>" ).val( ui.item.state );
				return false;
			}
		})
//		.data( "autocomplete" )._renderItem = function( ul, item ) {
//			return $j( "<li></li>" )
//				.data( "item.autocomplete", item)
//				.append( "<a>" + item.label + " (" + item.abbreviation + ")</a>" )
//				.appendTo( ul );
//		};
		<?php
	}
	
	public function getCurrentCities()
	{
		$options = self::getCities();
		return "var currentcities = ".json_encode($options).";";

	}

	public function makeCitiesAutoComplete($inputID = "city")
	{	
		echo self::getCurrentCities(); ?>
		
		$j( "#<?php echo $inputID; ?>" ).autocomplete({
			minLength: 0,
			source: currentcities,
			focus: function ( event, ui ) {
				$j( "#<?php echo $inputID; ?>" ).val( ui.item.label ); // this is what shows in the input box
				return false;
			},
			select: function( event, ui ) {
				$j( "#<?php echo $inputID; ?>" ).val( ui.item.label );
				return false;
			}
		})
		<?php
	}
	
	public function getCurrentZipcodes()
	{
		$options = self::getZipcodes();
		return "var currentzipcodes = ".json_encode($options).";";

	}

	public function makeZipcodesAutoComplete($inputID = "zipcode")
	{	
		echo self::getCurrentZipcodes(); ?>
		
		$j( "#<?php echo $inputID; ?>" ).autocomplete({
			minLength: 0,
			source: currentzipcodes,
			focus: function ( event, ui ) {
				$j( "#<?php echo $inputID; ?>" ).val( ui.item.label ); // this is what shows in the input box
				return false;
			},
			select: function( event, ui ) {
				$j( "#<?php echo $inputID; ?>" ).val( ui.item.label );
				return false;
			}
		})
		<?php
	}

	public function getLastArchiveID($archiveTable, $tableKey, $key)
	{
		// Initialize variables.
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);

		$query->select('id');
		$query->from($archiveTable.' AS a');
		$query->order('last_updated DESC');
		$query->where($tableKey.'='.$key);
		print_r($query);
		// Get the options.
		$db->setQuery($query);
$options = $db->loadObjectList();
echo '<hr>';
print_r($options);
echo '<hr>';
		$id = $db->loadResult();

		// Check for a database error.
		if ($db->getErrorNum()) {
			JError::raiseWarning(500, $db->getErrorMsg());
		}

		return $id;
	}
		
	/**
	 * Method to import a database schema from a file.
	 *
	 * @access	public
	 * @param	object	JDatabase object.
	 * @param	string	Path to the schema file.
	 * @return	boolean	True on success.
	 * @since	1.0
	 */
	public function installSQLfile($sqlfilename)
	{
		$db		= JFactory::getDbo();
		
		// Initialise variables.
		$return = true;

		// Get the contents of the schema file.
		if (!($buffer = file_get_contents($sqlfilename))) {
			$this->setError($db->getErrorMsg());
			return false;
		}

		// Get an array of queries from the schema and process them.
		$queries = $this->_splitQueries($buffer);
		foreach ($queries as $query)
		{
			// Trim any whitespace.
			$query = trim($query);

			// If the query isn't empty and is not a comment, execute it.
			if (!empty($query) && ($query{0} != '#'))
			{
				// Execute the query.
				$db->setQuery($query);
				$db->query();

				// Check for errors.
				if ($db->getErrorNum()) {
					$this->setError($db->getErrorMsg());
					$return = false;
				}
			}
		}

		return $return;
	}

	/**
	 * Method to split up queries from a schema file into an array.
	 *
	 * @access	protected
	 * @param	string	SQL schema.
	 * @return	array	Queries to perform.
	 * @since	1.0
	 */
	function _splitQueries($sql)
	{
		// Initialise variables.
		$buffer		= array();
		$queries	= array();
		$in_string	= false;

		// Trim any whitespace.
		$sql = trim($sql);

		// Remove comment lines.
		$sql = preg_replace("/\n\#[^\n]*/", '', "\n".$sql);

		// Parse the schema file to break up queries.
		for ($i = 0; $i < strlen($sql) - 1; $i ++)
		{
			if ($sql[$i] == ";" && !$in_string) {
				$queries[] = substr($sql, 0, $i);
				$sql = substr($sql, $i +1);
				$i = 0;
			}

			if ($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\") {
				$in_string = false;
			}
			elseif (!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset ($buffer[0]) || $buffer[0] != "\\")) {
				$in_string = $sql[$i];
			}
			if (isset ($buffer[1])) {
				$buffer[0] = $buffer[1];
			}
			$buffer[1] = $sql[$i];
		}

		// If the is anything left over, add it to the queries.
		if (!empty($sql)) {
			$queries[] = $sql;
		}

		return $queries;
	}

	public function showTrueFalse($checkValue, $trueValue='COM_SERVICEPROJECT_CANMODIFY', $falseValue='COM_SERVICEPROJECT_CANNOTMODIFY')
	{
		if ($checkValue==1) { ?>
	<a class="jgrid" title="<?php echo JText::_($trueValue); ?>"><span class="state publish"><span class="text">Published</span></span></a>
<?php		} else { ?>
	<a class="jgrid" title="<?php echo JText::_($falseValue); ?>"><span class="state unpublish"><span class="text">Unpublished</span></span></a>
<?php		}
	}

	public function showTrueFalseLink($checkValue, $ajaxTask='', $prefix='', $id=-1, $trueValue='COM_SERVICEPROJECT_CANMODIFY', $falseValue='COM_SERVICEPROJECT_CANNOTMODIFY')
	{
		//csp_getJSONResponse(varTask, varParams, varData)
		if ($checkValue==1) { 
			$result="<a id='".JText::_($prefix.$id)."' onClick='".JText::_($ajaxTask)."(".JText::_($id).")' class='jgrid' style='cursor:pointer' title='".JText::_($trueValue)."'><span class='state publish'><span class='text'>Published</span></span></a>";
		} else { 
			$result="<a id='".JText::_($prefix.$id)."' onClick='".JText::_($ajaxTask)."(".JText::_($id).")' class='jgrid' style='cursor:pointer' title='".JText::_($falseValue)."'><span class='state unpublish'><span class='text'>Unpublished</span></span></a>";
		}
		return $result;
	}

	public function showAskAllowDeny($checkValue, $trueValue='COM_SERVICEPROJECT_CANMODIFY', $falseValue='COM_SERVICEPROJECT_CANNOTMODIFY', $askValue='COM_SERVICEPROJECT_ASKPROFILE')
	{
		if ($checkValue==0) { ?>
	<a class="jgrid" title="<?php echo JText::_($askValue); ?>"><span class="state pending"><span class="text"><?php echo JText::_('COM_SERVICEPROJECT_ASKPROFILE_ABR'); ?></span></span></a>
<?php		} elseif ($checkValue==1) { ?>
	<a class="jgrid" title="<?php echo JText::_($trueValue); ?>"><span class="state publish"><span class="text">Published</span></span></a>
<?php		} else { ?>
	<a class="jgrid" title="<?php echo JText::_($falseValue); ?>"><span class="state unpublish"><span class="text">Unpublished</span></span></a>
<?php		}
	}
	public function showLinkMethod($checkValue)
	{
		if ($checkValue==1) { ?>
	<span title="<?php echo JText::_('COM_SERVICEPROJECT_LINKMETHOD1'); ?>"><?php echo JText::_('COM_SERVICEPROJECT_LINKMETHOD1_ABR'); ?></span>
<?php		} elseif ($checkValue==2) { ?>
	<span title="<?php echo JText::_('COM_SERVICEPROJECT_LINKMETHOD2'); ?>"><?php echo JText::_('COM_SERVICEPROJECT_LINKMETHOD2_ABR'); ?></span>
<?php		} elseif ($checkValue==3) { ?>
	<span title="<?php echo JText::_('COM_SERVICEPROJECT_LINKMETHOD3'); ?>"><?php echo JText::_('COM_SERVICEPROJECT_LINKMETHOD3_ABR'); ?></span>
<?php		} elseif ($checkValue==4) { ?>
	<span title="<?php echo JText::_('COM_SERVICEPROJECT_LINKMETHOD4'); ?>"><?php echo JText::_('COM_SERVICEPROJECT_LINKMETHOD4_ABR'); ?></span>
<?php		} else { ?>
	<span title="<?php echo JText::_('COM_SERVICEPROJECT_LINKMETHOD0'); ?>"><?php echo JText::_('COM_SERVICEPROJECT_LINKMETHOD0_ABR'); ?></span>
<?php		}
	}

}
?>
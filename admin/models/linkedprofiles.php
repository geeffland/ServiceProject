<?php
/**
 * This model is called for to list all of the Profiles
 *
 * @version		$Id: profiles.php
 * @package		com_serviceproject
 * @subpackage	admin.models
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of article records.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_content
 */
class ServiceProjectModelLinkedProfiles extends JModelList
{
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since	1.6
	 */
	protected function populateState()
	{
		// Initialise variables.
		$app = JFactory::getApplication();
		$session = JFactory::getSession();
		
		// Adjust the context to support modal layouts.
		if ($layout = JRequest::getVar('layout', 'default')) {
			$this->context .= '.'.$layout;
		}

		$search = $app->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$linkmethod = $app->getUserStateFromRequest($this->context.'.filter.linkmethod', 'filter_linkmethod', '');
		$this->setState('filter.linkmethod', $linkmethod);

		$canregister = $app->getUserStateFromRequest($this->context.'.filter.canregister', 'filter_canregister', '');
		$this->setState('filter.canregister', $canregister);

		$canmodify = $app->getUserStateFromRequest($this->context.'.filter.canmodify', 'filter_canmodify', '');
		$this->setState('filter.canmodify', $canmodify);

		$canaccess = $app->getUserStateFromRequest($this->context.'.filter.canaccess', 'filter_canaccess', '');
		$this->setState('filter.canaccess', $canaccess);

		// List state information.
		parent::populateState('a.last_updated', 'desc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param	string		$id	A prefix for the store id.
	 *
	 * @return	string		A store id.
	 * @since	1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id	.= ':'.$this->getState('filter.search');
		$id	.= ':'.$this->getState('filter.linkmethod');
		$id	.= ':'.$this->getState('filter.canregister');
		$id	.= ':'.$this->getState('filter.canmodify');
		$id	.= ':'.$this->getState('filter.canaccess');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select',
				'a.id, a.user_id, a.profile_id, a.link_method, a.canregister, a.canmodify, a.canaccess')
		);
		$query->from('#__serviceproject_linked_profiles AS a');

		// Join the user
		$query->select('usr.name, usr.username');
		$query->join('LEFT', '`#__users` AS usr ON usr.id = a.user_id');

		// Join the Profile
		$query->select('CONCAT(trim(prf.lastname), ", ", trim(prf.firstname), " ", trim(LEFT(prf.middlename,1)), if(prf.suffix="","",CONCAT(" (", trim(prf.suffix), ")") ) ) as displayname');
		$query->join('LEFT', '`#__serviceproject_profiles` AS prf ON prf.profile_id = a.profile_id');

		// Filter by Link Method
		$linkmethod = $this->getState('filter.linkmethod');
		if (!empty($linkmethod)) {
			$query->where('a.link_method = \'' . $db->getEscaped($linkmethod, true) . '\'');
		}

		// Filter by Can Register
		$canregister = $this->getState('filter.canregister');
		if (!empty($canregister) | $canregister=='0') {
			$query->where('a.canregister = \'' . $db->getEscaped($canregister, true) . '\'');
		}

		// Filter by Can Modify
		$canmodify = $this->getState('filter.canmodify');
		if (!empty($canmodify) | $canmodify=='0') {
			$query->where('a.canmodify = \'' . $db->getEscaped($canmodify, true) . '\'');
		}

		// Filter by Can Access
		$canaccess = $this->getState('filter.canaccess');
		if (!empty($canaccess) | $canaccess=='0') {
			$query->where('a.canaccess = \'' . $db->getEscaped($canaccess, true) . '\'');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.id = '.(int) substr($search, 3));
			} else {
				$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
				$query->where('(usr.name LIKE '.$search.' OR usr.username LIKE '.$search.' OR prf.lastname LIKE '.$search.' OR prf.firstname LIKE '.$search.' OR prf.middlename LIKE '.$search.' OR prf.suffix LIKE '.$search.')');
			}
		}
		
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering');
		$orderDirn	= $this->state->get('list.direction');
//		if ($orderCol == 'a.ordering' || $orderCol == 'a.updatetype') {
//			$orderCol = 'a.updatetype '.$orderDirn.', a.ordering';
//		}
		$query->order($db->getEscaped($orderCol.' '.$orderDirn));

		return $query;
	}
}
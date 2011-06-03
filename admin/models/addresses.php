<?php
/**
 * This model is called for to list all of the Addresses
 *
 * @version		$Id: addresses.php
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
class ServiceProjectModelAddresses extends JModelList
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

		$city = $app->getUserStateFromRequest($this->context.'.filter.city', 'filter_city');
		$this->setState('filter.city', $city);

		$state = $app->getUserStateFromRequest($this->context.'.filter.state', 'filter_state');
		$this->setState('filter.state', $state);

		$zipcode = $app->getUserStateFromRequest($this->context.'.filter.zipcode', 'filter_zipcode');
		$this->setState('filter.zipcode', $zipcode);

		$published = $app->getUserStateFromRequest($this->context.'.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);

		// List state information.
		parent::populateState('a.ordering', 'asc');
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
		$id .= ':'.$this->getState('filter.city');
		$id .= ':'.$this->getState('filter.state');
		$id .= ':'.$this->getState('filter.zipcode');
		$id	.= ':'.$this->getState('filter.published');

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
				'a.id, a.address_id, a.addressname, a.streetaddress1, a.streetaddress2, a.city, a.state, a.zipcode, a.published, a.ordering, \'dummy\' as updatetype, if((a.latitude || a.longitude) IS NULL, FALSE, if((a.latitude + a.longitude = 0) , FALSE, TRUE)) as hasgps')
		);
		$query->from('#__serviceproject_addresses AS a');

		// Filter by City.
		$city = $this->getState('filter.city');
		if (!empty($city)) {
			$query->where('a.city = \'' . $db->getEscaped($city, true) . '\'');
		}

		// Filter by State.
		$state = $this->getState('filter.state');
		if (!empty($state)) {
			$query->where('a.state = \'' . $db->getEscaped($state, true) . '\'');
		}

		// Filter by Zipcode.
		$zipcode = $this->getState('filter.zipcode');
		if (!empty($zipcode)) {
			$query->where('a.zipcode = \'' . $db->getEscaped($zipcode, true) . '\'');
		}

		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published)) {
			$query->where('a.published = ' . (int) $published);
		} else if ($published === '') {
			$query->where('(a.published = 0 OR a.published = 1)');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('a.address_id = '.(int) substr($search, 3));
			} else {
				$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
				$query->where('(a.addressname LIKE '.$search.' OR a.streetaddress1 LIKE '.$search.' OR a.streetaddress2 LIKE '.$search.' OR a.city LIKE '.$search.' OR a.state LIKE '.$search.')');
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
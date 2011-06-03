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
class ServiceProjectModelProfiles extends JModelList
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
		parent::populateState('a.lastname', 'asc');
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
				'a.id, a.profile_id, a.firstname, a.middlename, a.lastname, CONCAT(trim(a.lastname), ", ", trim(a.firstname), " ", trim(LEFT(a.middlename,1)), if(a.suffix="","",CONCAT(" (", trim(a.suffix), ")") ) ) as displayname, a.suffix, a.address_id,'
				.' a.emailhome, a.emailwork, a.emailother, a.emailpreferred,'
				.' a.phonehome, a.phonework, a.phonecell, a.phonepreferred, a.published')
		);
		$query->from('#__serviceproject_profiles AS a');

		// Join the address
		$query->select('adr.streetaddress1 AS street, adr.city as city, adr.state as state, adr.zipcode as zipcode');
		$query->join('LEFT', '`#__serviceproject_addresses` AS adr ON adr.address_id = a.address_id');

		// Filter by City.
		$city = $this->getState('filter.city');
		if (!empty($city)) {
			$query->where('adr.city = \'' . $db->getEscaped($city, true) . '\'');
		}

		// Filter by State.
		$state = $this->getState('filter.state');
		if (!empty($state)) {
			$query->where('adr.state = \'' . $db->getEscaped($state, true) . '\'');
		}

		// Filter by Zipcode.
		$zipcode = $this->getState('filter.zipcode');
		if (!empty($zipcode)) {
			$query->where('adr.zipcode = \'' . $db->getEscaped($zipcode, true) . '\'');
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
				$query->where('a.profile_id = '.(int) substr($search, 3));
			} elseif (stripos($search, 'name:') === 0) {
				$search = $db->Quote('%'.$db->getEscaped(substr($search, 5), true).'%');
				$query->where('(a.firstname LIKE '.$search.' OR a.lastname LIKE '.$search.')');
			} elseif (stripos($search, 'first:') === 0) {
				$search = $db->Quote('%'.$db->getEscaped(substr($search, 6), true).'%');
				$query->where('(a.firstname LIKE '.$search.')');
			} elseif (stripos($search, 'last:') === 0) {
				$search = $db->Quote('%'.$db->getEscaped(substr($search, 5), true).'%');
				$query->where('(a.lastname LIKE '.$search.')');
			} else {
				$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
				$query->where('(a.firstname LIKE '.$search.' OR a.lastname LIKE '.$search.' OR a.emailhome LIKE '.$search.' OR a.emailwork LIKE '.$search.' OR a.emailother LIKE '.$search.' OR a.phonehome LIKE '.$search.' OR a.phonework LIKE '.$search.' OR a.phonecell LIKE '.$search.')');
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
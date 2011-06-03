<?php
/**
 * This view is called to list all of the EventGroups
 *
 * @version		$Id: view.html.php
 * @package		com_serviceproject
 * @subpackage	admin.views.eventgroups
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * @package		Joomla.Administrator
 * @subpackage	com_content
 */
class ServiceProjectViewEventGroupShifts extends JView
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		ServiceProjectHelper::addSubmenu('eventgroups', JRequest::getWord('view'));
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal') {
			$this->addToolbar();
		}

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		$state	= $this->get('State');
		$canDo	= ServiceProjectHelper::getActions();
		$baseurl = JURI::base();
		$doc = & JFactory::getDocument();
		$doc->addStyleSheet( $baseurl.'components/com_serviceproject/helpers/css/admintoolbars.css');

		JToolBarHelper::title(JText::_('COM_SERVICEPROJECT_MANAGE_EVENTGROUPSHIFTS'), 'article.png');
		if ($canDo->get('core.create')) {
			JToolBarHelper::custom('eventgroupshift.add', 'new.png', 'new_f2.png','JTOOLBAR_NEW', false);
		}
		if ($canDo->get('core.edit')) {
			JToolBarHelper::custom('eventgroupshift.edit', 'edit.png', 'edit_f2.png','JTOOLBAR_EDIT', true);
			JToolBarHelper::custom('eventgroupshifts.copy', 'e1s-copy', '','COM_SERVICEPROJECT_TOOLBAR_COPY', true);
		}
		if ($canDo->get('core.edit.state')) {
			JToolBarHelper::divider();
			JToolBarHelper::custom('eventgroupshifts.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
			JToolBarHelper::custom('eventgroupshifts.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			JToolBarHelper::divider();
			JToolBarHelper::archiveList('eventgroupshifts.archive','JTOOLBAR_ARCHIVE');
		}
//		if(JFactory::getUser()->authorise('core.manage','com_checkin')) {
//			JToolBarHelper::custom('articles.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
//		}
		if ($state->get('filter.published') == -2 && $canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'eventgroupshifts.delete','JTOOLBAR_EMPTY_TRASH');
		} else if ($canDo->get('core.edit.state')) {
			JToolBarHelper::trash('eventgroupshifts.trash','JTOOLBAR_TRASH');
		}

		if ($canDo->get('core.admin')) {
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_serviceproject');
		}
//		JToolBarHelper::divider();
//		JToolBarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER');
	}
}

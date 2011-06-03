<?php
/**
 * This view is called to list all of the Addresses
 *
 * @version		$Id: view.html.php
 * @package		com_serviceproject
 * @subpackage	admin.views.addresses
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
class ServiceProjectViewLinkedProfiles extends JView
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		ServiceProjectHelper::addSubmenu('profiles', JRequest::getWord('view'));
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

		JToolBarHelper::title(JText::_('COM_SERVICEPROJECT_MANAGE_LINKEDPROFILES'), 'article.png');
		if ($canDo->get('core.create')) {
			JToolBarHelper::custom('linkedprofile.add', 'new.png', 'new_f2.png','JTOOLBAR_NEW', false);
		}
		if ($canDo->get('core.edit')) {
			JToolBarHelper::custom('linkedprofile.edit', 'edit.png', 'edit_f2.png','JTOOLBAR_EDIT', true);
//			JToolBarHelper::custom('linkedprofiles.copy', 'e1s-copy', '','COM_SERVICEPROJECT_TOOLBAR_COPY', true);
//			JToolBarHelper::custom('linkedprofiles.merge', 'e1s-merge', '','COM_SERVICEPROJECT_TOOLBAR_MERGE', true);
		}
//		if ($canDo->get('core.edit.state')) {
//			JToolBarHelper::divider();
//			JToolBarHelper::custom('linkedprofiles.publish', 'publish.png', 'publish_f2.png','JTOOLBAR_PUBLISH', true);
//			JToolBarHelper::custom('linkedprofiles.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
//			JToolBarHelper::divider();
//			JToolBarHelper::archiveList('linkedprofiles.archive','JTOOLBAR_ARCHIVE');
//		}
//		if(JFactory::getUser()->authorise('core.manage','com_checkin')) {
//			JToolBarHelper::custom('articles.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
//		}
//		if ($state->get('filter.published') == -2 && $canDo->get('core.delete')) {
		if ($canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'linkedprofiles.delete','JTOOLBAR_EMPTY_TRASH');
		} else if ($canDo->get('core.edit.state')) {
			JToolBarHelper::trash('linkedprofiles.trash','JTOOLBAR_TRASH');
		}

		if ($canDo->get('core.admin')) {
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_serviceproject');
		}
//		JToolBarHelper::divider();
//		JToolBarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER');
	}
}

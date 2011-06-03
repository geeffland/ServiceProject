<?php
/**
 * This view is called to list all of the UpdateReasons
 *
 * @version		$Id: view.html.php
 * @package		com_serviceproject
 * @subpackage	admin.views.updatereasons
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
class ServiceProjectViewProjectAgeRanges extends JView
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		ServiceProjectHelper::addSubmenu('admin', JRequest::getWord('view'));
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

		JToolBarHelper::title(JText::_('COM_SERVICEPROJECT_MANAGE_PROJECT_AGERANGES'), 'article.png');
		if ($canDo->get('core.create')) {
			JToolBarHelper::custom('projectagerange.add', 'new.png', 'new_f2.png','JTOOLBAR_NEW', false);
		}
		if ($canDo->get('core.edit')) {
			JToolBarHelper::custom('projectagerange.edit', 'edit.png', 'edit_f2.png','JTOOLBAR_EDIT', true);
		}
		if ($canDo->get('core.delete')) {
			JToolBarHelper::deleteList('', 'projectageranges.delete','JTOOLBAR_EMPTY_TRASH');
		}

		if ($canDo->get('core.admin')) {
			JToolBarHelper::divider();
			JToolBarHelper::preferences('com_serviceproject');
		}
//		JToolBarHelper::divider();
//		JToolBarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER');
	}
}

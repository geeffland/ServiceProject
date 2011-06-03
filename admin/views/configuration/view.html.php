<?php
/**
 * This view is called to edit or view an UpdateReason
 *
 * @version		$Id: view.html.php
 * @package		com_serviceproject
 * @subpackage	admin.views.updatereason
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
class ServiceProjectViewConfiguration extends JView
{
	protected $item;
	protected $form;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state	= $this->get('State');
		$this->item		= $this->get('Item');
		$this->form		= $this->get('Form');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		JRequest::setVar('hidemainmenu', true);

		$user		= JFactory::getUser();
		$isNew		= ($this->item->id == 0);
		$canDo		= ServiceProjectHelper::getActions();

		JToolBarHelper::title(JText::_('COM_SERVICEPROJECT_PAGE_'.($isNew ? 'ADD_CONFIGURATION' : 'EDIT_CONFIGURATION')), 'article-add.png');

		// If not checked out, can save the item.
		if ($canDo->get('core.edit') || $canDo->get('core.create')) {
			JToolBarHelper::apply('configuration.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('configuration.save', 'JTOOLBAR_SAVE');
		}
		if ($canDo->get('core.create')) {		
			JToolBarHelper::custom('configuration.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create')) {
			JToolBarHelper::custom('configuration.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
		}
		if (empty($this->item->id))  {
			JToolBarHelper::cancel('configuration.cancel', 'JTOOLBAR_CANCEL');
		} else {
			JToolBarHelper::cancel('configuration.cancel', 'JTOOLBAR_CLOSE');
		}

//		JToolBarHelper::divider();
//		JToolBarHelper::help('JHELP_CONTENT_ARTICLE_MANAGER_EDIT');
	}
}
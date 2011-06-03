<?php
/**
 * @version		$Id: view.html.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Administrator
 * @subpackage	Cpanel
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die;

jimport('joomla.application.component.view');
jimport('joomla.application.module.helper');

/**
 * HTML View class for the Cpanel component
 *
 * @static
 * @package		Joomla.Administrator
 * @subpackage	Cpanel
 * @since 1.0
 */
class ServiceProjectViewMain extends JView
{
	protected $modules = null;

	public function display($tpl = null)
	{
//		/*
//		 * Set the template - this will display cpanel.php
//		 * from the selected admin template.
//		 */
//		JRequest::setVar('tmpl', 'cpanel');
//
//		// Display the cpanel modules
//		$this->modules = JModuleHelper::getModules('cpanel');

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

		$canDo	= ServiceProjectHelper::getActions();
		JToolBarHelper::title(JText::_('COM_SERVICEPROJECT_SUBMENU_MAIN'), 'cpanel.png');
		if ($canDo->get('core.admin')) {
			JToolBarHelper::preferences('com_serviceproject');
			JToolBarHelper::divider();
		}
		//JToolBarHelper::help('JHELP_COMPONENTS_BANNERS_BANNERS');
	}
}
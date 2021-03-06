<?php
/**
 * @version		
 * @package		ServiceProject
 * @subpackage	com_serviceproject
 * @copyright	Copyright (C) 2010 Greg Effland. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include dependencies... import Joomla Controller Library
jimport('joomla.application.component.controller');

/**
 * ServiceProject Component Controller
 *
 * @package		ServiceProject
 * @subpackage	com_everyserve
 * @since		1.5
 */
class ServiceProjectController extends JController
{
	function __construct($config = array())
	{
		// Article frontpage Editor pagebreak proxying:
		if(JRequest::getWord('view') === 'article' && JRequest::getVar('layout') === 'pagebreak') {
			$config['base_path'] = JPATH_COMPONENT_ADMINISTRATOR;
		}
		// Article frontpage Editor article proxying:
		elseif(JRequest::getWord('view') === 'articles' && JRequest::getVar('layout') === 'modal') {
			JHTML::_('stylesheet','system/adminlist.css', array(), true);
			$config['base_path'] = JPATH_COMPONENT_ADMINISTRATOR;
		}

		parent::__construct($config);
	}

	/**
	 * Method to display a view.
	 *
	 * @param	boolean			If true, the view output will be cached
	 * @param	array			An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return	JController		This object to support chaining.
	 * @since	1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$cachable = true;

		// Set the default view name and format from the Request.
		$vName		= JRequest::getWord('view', 'categories');
		JRequest::setVar('view', $vName);

		$user = JFactory::getUser();

		if ($user->get('id') || ($_SERVER['REQUEST_METHOD'] == 'POST' &&
			(($vName = 'category' && JRequest::getVar('layout') != 'blog') || $vName = 'archive' ))) {
			$cachable = false;
		}

		$safeurlparams = array('catid'=>'INT','id'=>'INT','cid'=>'ARRAY','year'=>'INT','month'=>'INT','limit'=>'INT','limitstart'=>'INT',
			'showall'=>'INT','return'=>'BASE64','filter'=>'STRING','filter_order'=>'CMD','filter_order_Dir'=>'CMD','filter-search'=>'STRING','print'=>'BOOLEAN','lang'=>'CMD');

		parent::display($cachable,$safeurlparams);

		return $this;
	}

}
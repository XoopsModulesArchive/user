<?php
/**
 * @version $Id: UserListAction.class.php,v 1.1 2007/05/15 02:34:42 minahito Exp $
 */
if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

require_once XOOPS_MODULE_PATH . '/user/class/AbstractListAction.class.php';
require_once XOOPS_MODULE_PATH . '/user/admin/forms/UserFilterForm.class.php';

class User_UserListAction extends User_AbstractListAction
{
    public function &_getHandler()
    {
        $handler = xoops_getModuleHandler('users');

        return $handler;
    }

    public function &_getFilterForm()
    {
        $filter = new User_UserFilterForm($this->_getPageNavi(), $this->_getHandler());

        return $filter;
    }

    public function _getBaseUrl()
    {
        return './index.php?action=UserList';
    }

    public function executeViewIndex(&$controller, &$xoopsUser, $render)
    {
        $render->setTemplateName('user_list.html');

        $render->setAttribute('objects', $this->mObjects);

        $render->setAttribute('pageNavi', $this->mFilter->mNavi);
    }
}

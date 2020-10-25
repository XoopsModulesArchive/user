<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

require_once XOOPS_MODULE_PATH . '/user/class/AbstractListAction.class.php';
require_once XOOPS_MODULE_PATH . '/user/admin/forms/RanksFilterForm.class.php';

class User_RanksListAction extends User_AbstractListAction
{
    public function &_getHandler()
    {
        $handler = xoops_getModuleHandler('ranks');

        return $handler;
    }

    public function &_getFilterForm()
    {
        $filter = new User_RanksFilterForm($this->_getPageNavi(), $this->_getHandler());

        return $filter;
    }

    public function _getBaseUrl()
    {
        return './index.php?action=RanksList';
    }

    public function executeViewIndex(&$controller, &$xoopsUser, $render)
    {
        $render->setTemplateName('ranks_list.html');

        $render->setAttribute('objects', $this->mObjects);

        $render->setAttribute('pageNavi', $this->mFilter->mNavi);
    }
}

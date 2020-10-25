<?php
/**
 * @version $Id: UserSearchListAction.class.php,v 1.1 2007/05/15 02:34:41 minahito Exp $
 */
if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

require_once XOOPS_MODULE_PATH . '/user/class/AbstractListAction.class.php';
require_once XOOPS_MODULE_PATH . '/user/admin/forms/UserSearchFilterForm.class.php';

class User_UserSearchListAction extends User_AbstractListAction
{
    public function &_getHandler()
    {
        $handler = xoops_getModuleHandler('users_search');

        return $handler;
    }

    public function &_getFilterForm()
    {
        $filter = new User_UserSearchFilterForm($this->_getPageNavi(), $this->_getHandler());

        return $filter;
    }

    public function _getBaseUrl()
    {
        return './index.php?action=UserSearchList';
    }

    public function execute(&$controller, &$xoopsUser)
    {
        return $this->getDefaultView($controller, $xoopsUser);
    }

    public function executeViewIndex($controller, &$xoopsUser, $render)
    {
        $controller->mRoot->mDelegateManager->add(
            'Legacy.Event.Explaceholder.Get.UserPagenaviOtherUrl',
            'User_UserSearchListAction::renderOtherUrlControl'
        );

        $render->setTemplateName('user_search_list.html');

        $render->setAttribute('objects', $this->mObjects);

        $render->setAttribute('pageNavi', $this->mFilter->mNavi);
    }

    public function renderOtherUrlControl(&$buf, $params)
    {
        if (isset($params['pagenavi']) && is_object($params['pagenavi'])) {
            $navi = &$params['pagenavi'];

            $url = $params['url'];

            if (count($navi->mExtra) > 0) {
                $t_arr = [];

                foreach ($navi->mExtra as $key => $value) {
                    $t_arr[] = $key . '=' . urlencode($value);
                }

                if (0 == count($t_arr)) {
                    $buf = $url;

                    return;
                }

                if (false !== mb_strpos($url, '?')) {
                    $buf = $url . '&amp;' . implode('&amp;', $t_arr);
                } else {
                    $buf = $url . '?' . implode('&amp;', $t_arr);
                }
            }
        }
    }
}

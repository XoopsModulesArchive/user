<?php
/**
 * @version $Id: DefaultAction.class.php,v 1.2 2007/06/07 05:27:01 minahito Exp $
 */
if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

/***
 * @internal
 * @public
 * This action shows two forms for login and lostpass. If the current user is
 * logined, forward to the userinfo page.
 */
class User_DefaultAction extends User_Action
{
    public $_mAllowRegister = false;

    public function isSecure()
    {
        return false;
    }

    public function prepare(&$controller, &$xoopsUser, $moduleConfig)
    {
        parent::prepare($controller, $xoopsUser, $moduleConfig);

        $this->_mAllowRegister = $moduleConfig['allow_register'];
    }

    public function getDefaultView(&$controller, $xoopsUser)
    {
        return is_object($xoopsUser) ? USER_FRAME_VIEW_ERROR : USER_FRAME_VIEW_INPUT;
    }

    public function executeViewInput($controller, &$xoopsUser, $render)
    {
        $render->setTemplateName('user_default.html');

        $render->setAttribute('allowRegister', $this->_mAllowRegister);

        if (!empty($_GET['xoops_redirect'])) {
            $root = &$controller->mRoot;

            $textFilter = &$root->getTextFilter();

            $render->setAttribute('redirect_page', $textFilter->toShow(xoops_getrequest('xoops_redirect')));
        }
    }

    public function executeViewError($controller, $xoopsUser, &$render)
    {
        $controller->executeForward('index.php?action=UserInfo&uid=' . $xoopsUser->get('uid'));
    }
}

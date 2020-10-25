<?php
/**
 * @version $Id: UserEditAction.class.php,v 1.1 2007/05/15 02:34:41 minahito Exp $
 */
if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

require_once XOOPS_MODULE_PATH . '/user/class/AbstractEditAction.class.php';
require_once XOOPS_MODULE_PATH . '/user/admin/forms/UserAdminEditForm.class.php';

class User_UserEditAction extends User_AbstractEditAction
{
    public function _getId()
    {
        return xoops_getrequest('uid');
    }

    public function &_getHandler()
    {
        $handler = xoops_getModuleHandler('users');

        return $handler;
    }

    public function _setupActionForm()
    {
        $this->mActionForm = new User_UserAdminEditForm();

        $this->mActionForm->prepare();
    }

    public function _setupObject()
    {
        $id = $this->_getId();

        $this->mObjectHandler = $this->_getHandler();

        $this->mObject = $this->mObjectHandler->get($id);

        if (null === $this->mObject && $this->isEnableCreate()) {
            $root = &XCube_Root::getSingleton();

            $this->mObject = $this->mObjectHandler->create();

            $this->mObject->set('timezone_offset', $root->mContext->getXoopsConfig('server_TZ'));
        }
    }

    public function executeViewInput(&$controller, &$xoopsUser, $render)
    {
        $render->setTemplateName('user_edit.html');

        $render->setAttribute('actionForm', $this->mActionForm);

        //

        // Get some objects for input form.

        //

        $tzoneHandler = xoops_getHandler('timezone');

        $timezones = &$tzoneHandler->getObjects();

        $render->setAttribute('timezones', $timezones);

        $rankHandler = xoops_getModuleHandler('ranks');

        $ranks = &$rankHandler->getObjects(new Criteria('rank_special', 1));

        $render->setAttribute('ranks', $ranks);

        $groupHandler = xoops_getHandler('group');

        $groups = &$groupHandler->getObjects(null, true);

        $groupOptions = [];

        foreach ($groups as $gid => $group) {
            $groupOptions[$gid] = $group->getVar('name');
        }

        $render->setAttribute('groupOptions', $groupOptions);

        //

        // umode option

        //

        $umodeOptions = ['nest' => _NESTED, 'flat' => _FLAT, 'thread' => _THREADED];

        $render->setAttribute('umodeOptions', $umodeOptions);

        //

        // uorder option

        //

        $uorderOptions = [0 => _OLDESTFIRST, 1 => _NEWESTFIRST];

        $render->setAttribute('uorderOptions', $uorderOptions);

        //

        // notify option

        //

        //

        // TODO Because abstract message catalog style is not decided, we load directly.

        //

        $root = &XCube_Root::getSingleton();

        $root->mLanguageManager->loadPageTypeMessageCatalog('notification');

        require_once XOOPS_ROOT_PATH . '/include/notification_constants.php';

        $methodOptions = [
            XOOPS_NOTIFICATION_METHOD_DISABLE => _NOT_METHOD_DISABLE,
            XOOPS_NOTIFICATION_METHOD_PM => _NOT_METHOD_PM,
            XOOPS_NOTIFICATION_METHOD_EMAIL => _NOT_METHOD_EMAIL,
        ];

        $render->setAttribute('notify_methodOptions', $methodOptions);

        $modeOptions = [
            XOOPS_NOTIFICATION_MODE_SENDALWAYS => _NOT_MODE_SENDALWAYS,
            XOOPS_NOTIFICATION_MODE_SENDONCETHENDELETE => _NOT_MODE_SENDONCE,
            XOOPS_NOTIFICATION_MODE_SENDONCETHENWAIT => _NOT_MODE_SENDONCEPERLOGIN,
        ];

        $render->setAttribute('notify_modeOptions', $modeOptions);
    }

    public function executeViewSuccess($controller, &$xoopsUser, &$render)
    {
        $controller->executeForward('./index.php?action=UserList');
    }

    public function executeViewError($controller, &$xoopsUser, &$render)
    {
        $controller->executeRedirect('index.php', 1, _MD_USER_ERROR_DBUPDATE_FAILED);
    }

    public function executeViewCancel($controller, &$xoopsUser, &$render)
    {
        $controller->executeForward('./index.php?action=UserList');
    }
}

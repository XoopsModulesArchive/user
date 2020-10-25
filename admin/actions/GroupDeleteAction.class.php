<?php
/**
 * @version $Id: GroupDeleteAction.class.php,v 1.1 2007/05/15 02:34:42 minahito Exp $
 */
if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

require_once XOOPS_MODULE_PATH . '/user/class/AbstractDeleteAction.class.php';
require_once XOOPS_MODULE_PATH . '/user/admin/forms/GroupAdminDeleteForm.class.php';

class User_GroupDeleteAction extends User_AbstractDeleteAction
{
    public function _getId()
    {
        return xoops_getrequest('groupid');
    }

    public function &_getHandler()
    {
        $handler = xoops_getModuleHandler('groups');

        return $handler;
    }

    public function _setupActionForm()
    {
        $this->mActionForm = new User_GroupAdminDeleteForm();

        $this->mActionForm->prepare();
    }

    public function _doExecute()
    {
        $handler = xoops_getHandler('group');

        $group = $handler->get($this->mObject->get('groupid'));

        $handler = xoops_getHandler('member');

        return $handler->delete($group) ? USER_FRAME_VIEW_SUCCESS : USER_FRAME_VIEW_ERROR;
    }

    public function executeViewInput(&$controller, &$xoopsUser, $render)
    {
        $render->setTemplateName('group_delete.html');

        $render->setAttribute('actionForm', $this->mActionForm);

        $render->setAttribute('object', $this->mObject);
    }

    public function executeViewSuccess($controller, &$xoopsUser, &$render)
    {
        $controller->executeForward('./index.php?action=GroupList');
    }

    public function executeViewError($controller, &$xoopsUser, &$render)
    {
        $controller->executeRedirect('./index.php?action=GroupList', 1, _MD_USER_ERROR_DBUPDATE_FAILED);
    }

    public function executeViewCancel($controller, &$xoopsUser, &$render)
    {
        $controller->executeForward('./index.php?action=GroupList');
    }
}

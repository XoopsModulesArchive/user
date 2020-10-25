<?php
/**
 * @version $Id: UserDeleteAction.class.php,v 1.2 2007/06/07 05:27:01 minahito Exp $
 */
if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

require_once XOOPS_MODULE_PATH . '/user/forms/UserDeleteForm.class.php';

/***
 * @internal
 * This action is for self delete function.
 *
 * Site owner want various procedure to this action. Therefore, this action may
 * have to implement main logic with Delegate only.
 */
class User_UserDeleteAction extends User_Action
{
    public $mActionForm = null;

    public $mObject = null;

    public $mSelfDelete = false;

    public $mSelfDeleteConfirmMessage = '';

    public function prepare($controller, $xoopsUser, $moduleConfig)
    {
        $this->mSelfDelete = $moduleConfig['self_delete'];

        $this->mSelfDeleteConfirmMessage = $moduleConfig['self_delete_confirm'];

        $this->mActionForm = new User_UserDeleteForm();

        $this->mActionForm->prepare();

        //

        // pre condition check

        //

        if (!$this->mSelfDelete) {
            $controller->executeForward(XOOPS_URL . '/');
        }

        if (is_object($xoopsUser)) {
            $handler = xoops_getModuleHandler('users', 'user');

            $this->mObject = $handler->get($xoopsUser->get('uid'));
        }
    }

    public function isSecure()
    {
        return true;
    }

    public function hasPermission(&$controller, $xoopsUser, $moduleConfig)
    {
        if (1 == $xoopsUser->get('uid')) {
            return false;
        }

        return true;
    }

    public function getDefaultView(&$controller, &$xoopsUser)
    {
        return USER_FRAME_VIEW_INPUT;
    }

    /**
     * FIXME: Need FORCE LOGOUT here?
     * @param mixed $controller
     * @param mixed $xoopsUser
     * @return int
     * @return int
     */

    public function execute(&$controller, &$xoopsUser)
    {
        $this->mActionForm->fetch();

        $this->mActionForm->validate();

        if ($this->mActionForm->hasError()) {
            return $this->getDefaultView($controller, $xoopsUser);
        }

        if ($this->_doDelete($controller, $xoopsUser)) {
            XCube_DelegateUtils::call('Legacy.Event.UserDelete', new XCube_Ref($this->mObject));

            return USER_FRAME_VIEW_SUCCESS;
        }

        return USER_FRAME_VIEW_ERROR;
    }

    /**
     * Exection deleting.
     *
     * @param mixed $controller
     * @param mixed $xoopsUser
     * @return bool
     */

    public function _doDelete(&$controller, &$xoopsUser)
    {
        $handler = xoops_getHandler('member');

        if ($handler->deleteUser($xoopsUser)) {
            $handler = xoops_getHandler('online');

            $handler->destroy($this->mObject->get('uid'));

            xoops_notification_deletebyuser($this->mObject->get('uid'));

            return true;
        }

        return false;
    }

    public function executeViewInput(&$controller, &$xoopsUser, $render)
    {
        $render->setTemplateName('user_delete.html');

        $render->setAttribute('object', $this->mObject);

        $render->setAttribute('actionForm', $this->mActionForm);

        $render->setAttribute('self_delete_message', $this->mSelfDeleteConfirmMessage);
    }

    public function executeViewSuccess(&$controller, &$xoopsUser, $render)
    {
        $render->setTemplateName('user_delete_success.html');

        $render->setAttribute('object', $this->mObject);
    }

    public function executeViewError($controller, &$xoopsUser, &$render)
    {
        $controller->executeRedirect(XOOPS_URL . '/', 3, _MD_USER_ERROR_DBUPDATE_FAILED);
    }
}

<?php
/**
 * @version $Id: LostPassAction.class.php,v 1.2 2007/06/07 05:27:01 minahito Exp $
 */
if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

require_once XOOPS_MODULE_PATH . '/user/forms/LostPassEditForm.class.php';
require_once XOOPS_MODULE_PATH . '/user/class/LostPassMailBuilder.class.php';

/***
 * @internal
 * @public
 * The process of lostpass. This action sends a mail even if the input mail
 * address isn't registered in the site. Because displaying error message in
 * such case shows the part of the personal information. We will discuss about
 * this spec.
 */
class User_LostPassAction extends User_Action
{
    /***
     * @var User_LostPassEditForm
     */

    public $mActionForm = null;

    public function prepare(&$controller, &$xoopsUser, $moduleConfig)
    {
        $this->mActionForm = new User_LostPassEditForm();

        $this->mActionForm->prepare();
    }

    public function isSecure()
    {
        return false;
    }

    //// Allow anonymous users only.

    public function hasPermission($controller, &$xoopsUser, $moduleConfig)
    {
        return !$controller->mRoot->mContext->mUser->mIdentity->isAuthenticated();
    }

    public function getDefaultView($controller, &$xoopsUser)
    {
        if ((!isset($_REQUEST['code'])) || (!isset($_REQUEST['email']))) {
            return USER_FRAME_VIEW_INPUT;
        }
  

        return $this->_updatePassword($controller);
    }

    public function _updatePassword($controller)
    {
        $this->mActionForm->fetch();

        $userHandler = xoops_getHandler('user');

        $lostUserArr = &$userHandler->getObjects(new Criteria('email', $this->mActionForm->get('email')));

        if (is_array($lostUserArr) && count($lostUserArr) > 0) {
            $lostUser = &$lostUserArr[0];
        } else {
            return USER_FRAME_VIEW_ERROR;
        }

        $newpass = xoops_makepass();

        $extraVars['newpass'] = $newpass;

        $builder = new User_LostPass2MailBuilder();

        $director = new User_LostPassMailDirector($builder, $lostUser, $controller->mRoot->mContext->getXoopsConfig(), $extraVars);

        $director->contruct();

        $xoopsMailer = &$builder->getResult();

        if (!$xoopsMailer->send()) {
            // $xoopsMailer->getErrors();

            return USER_FRAME_VIEW_ERROR;
        }

        $lostUser->set('pass', md5($newpass), true);

        $userHandler->insert($lostUser, true);

        return USER_FRAME_VIEW_SUCCESS;
    }

    public function execute($controller, &$xoopsUser)
    {
        $this->mActionForm->fetch();

        $this->mActionForm->validate();

        if ($this->mActionForm->hasError()) {
            return USER_FRAME_VIEW_INPUT;
        }

        $userHandler = xoops_getHandler('user');

        $lostUserArr = &$userHandler->getObjects(new Criteria('email', $this->mActionForm->get('email')));

        if (is_array($lostUserArr) && count($lostUserArr) > 0) {
            $lostUser = &$lostUserArr[0];
        } else {
            return USER_FRAME_VIEW_ERROR;
        }

        $builder = new User_LostPass1MailBuilder();

        $director = new User_LostPassMailDirector($builder, $lostUser, $controller->mRoot->mContext->getXoopsConfig());

        $director->contruct();

        $xoopsMailer = &$builder->getResult();

        if (!$xoopsMailer->send()) {
            // $xoopsMailer->getErrors();

            return USER_FRAME_VIEW_ERROR;
        }

        return USER_FRAME_VIEW_SUCCESS;
    }

    public function executeViewInput(&$controller, &$xoopsUser, $render)
    {
        $render->setTemplateName('user_lostpass.html');

        $render->setAttribute('actionForm', $this->mActionForm);
    }

    public function executeViewSuccess($controller, &$xoopsUser, &$render)
    {
        $controller->executeRedirect(XOOPS_URL . '/', 3, _MD_USER_MESSAGE_SEND_PASSWORD);
    }

    public function executeViewError($controller, &$xoopsUser, &$render)
    {
        $controller->executeRedirect(XOOPS_URL . '/', 3, _MD_USER_ERROR_SEND_MAIL);
    }
}

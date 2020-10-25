<?php
/**
 * @version $Id: LegacypageFunctions.class.php,v 1.2 2007/06/07 05:27:37 minahito Exp $
 */
if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

/***
 * @internal
 * This is static functions collection class for legacy pages access.
 */
class User_LegacypageFunctions
{
    /***
     * @internal
     * The process for userinfo.php. This process doesn't execute anything
     * directly. Forward to the controller of the user module.
     */

    public function userinfo()
    {
        //

        // Boot the action frame of the user module directly.

        //

        $root = &XCube_Root::getSingleton();

        $root->mController->executeHeader();

        $root->mController->setupModuleContext('user');

        $root->mLanguageManager->loadModuleMessageCatalog('user');

        require_once XOOPS_MODULE_PATH . '/user/class/ActionFrame.class.php';

        $moduleRunner = new User_ActionFrame(false);

        $moduleRunner->setActionName('UserInfo');

        $root->mController->mExecute->add([&$moduleRunner, 'execute']);

        $root->mController->execute();

        $root->mController->executeView();
    }

    /***
     * @internal
     * The process for edituser.php. This process doesn't execute anything
     * directly. Forward to the controller of the user module.
     */

    public function edituser()
    {
        $actionName = 'EditUser';

        switch (xoops_getrequest('op')) {
            case 'avatarform':
            case 'avatarupload':
                $actionName = 'AvatarEdit';
                break;
            case 'avatarchoose':
                $actionName = 'AvatarSelect';
                break;
        }

        //

        // Boot the action frame of the user module directly.

        //

        $root = &XCube_Root::getSingleton();

        $root->mController->executeHeader();

        $root->mController->setupModuleContext('user');

        $root->mLanguageManager->loadModuleMessageCatalog('user');

        require_once XOOPS_MODULE_PATH . '/user/class/ActionFrame.class.php';

        $moduleRunner = new User_ActionFrame(false);

        $moduleRunner->setActionName($actionName);

        $root->mController->mExecute->add([&$moduleRunner, 'execute']);

        $root->mController->execute();

        $root->mController->executeView();
    }

    /***
     * @internal
     * The process for register.php. This process doesn't execute anything
     * directly. Forward to the controller of the user module.
     */

    public function register()
    {
        $root = &XCube_Root::getSingleton();

        $xoopsUser = &$root->mContext->mXoopsUser;

        if (is_object($xoopsUser)) {
            $root->mController->executeForward(XOOPS_URL);
        }

        //

        // Boot the action frame of the user module directly.

        //

        $root->mController->executeHeader();

        $root->mController->setupModuleContext('user');

        $root->mLanguageManager->loadModuleMessageCatalog('user');

        require_once XOOPS_MODULE_PATH . '/user/class/ActionFrame.class.php';

        $actionName = isset($_REQUEST['action']) ? 'UserRegister_confirm' : 'UserRegister';

        $moduleRunner = new User_ActionFrame(false);

        $moduleRunner->setActionName($actionName);

        $root->mController->mExecute->add([&$moduleRunner, 'execute']);

        $root->mController->execute();

        $root->mController->executeView();
    }

    /***
     * @internal
     * The process for lostpass.php. This process doesn't execute anything
     * directly. If the current user is registered user, kick out to the top
     * page. Else, forward to the lost-pass page.
     */

    public function lostpass()
    {
        $root = &XCube_Root::getSingleton();

        $xoopsUser = &$root->mContext->mXoopsUser;

        if (is_object($xoopsUser)) {
            $root->mController->executeForward(XOOPS_URL);
        }

        //

        // Boot the action frame of the user module directly.

        //

        $root->mController->executeHeader();

        $root->mController->setupModuleContext('user');

        $root->mLanguageManager->loadModuleMessageCatalog('user');

        require_once XOOPS_MODULE_PATH . '/user/class/ActionFrame.class.php';

        $root = &XCube_Root::getSingleton();

        $moduleRunner = new User_ActionFrame(false);

        $moduleRunner->setActionName('LostPass');

        $root->mController->mExecute->add([&$moduleRunner, 'execute']);

        $root->mController->execute();

        $root->mController->executeView();
    }

    /***
     * @internal
     * The process for user.php. This process doesn't execute anything directly.
     * Forward to the controller of the user module.
     */

    public function user()
    {
        $root = &XCube_Root::getSingleton();

        $op = isset($_REQUEST['op']) ? trim(xoops_getrequest('op')) : 'main';

        $xoopsUser = &$root->mContext->mXoopsUser;

        $actionName = 'default';

        switch ($op) {
            case 'login':
                $root->mController->checkLogin();

                return;
            case 'logout':
                $root->mController->logout();

                return;
            case 'main':
                if (is_object($xoopsUser)) {
                    $root->mController->executeForward(XOOPS_URL . '/userinfo.php?uid=' . $xoopsUser->get('uid'));
                }
                break;
            case 'actv':
                $actionName = 'UserActivate';
                break;
            case 'delete':
                $actionName = 'UserDelete';
                break;
        }

        //

        // Boot the action frame of the user module directly.

        //

        $root = &XCube_Root::getSingleton();

        $root->mController->executeHeader();

        $root->mController->setupModuleContext('user');

        $root->mLanguageManager->loadModuleMessageCatalog('user');

        require_once XOOPS_MODULE_PATH . '/user/class/ActionFrame.class.php';

        $moduleRunner = new User_ActionFrame(false);

        $moduleRunner->setActionName($actionName);

        $root->mController->mExecute->add([&$moduleRunner, 'execute']);

        $root->mController->execute();

        $root->mController->executeView();
    }

    public function checkLogin(&$xoopsUser)
    {
        if (is_object($xoopsUser)) {
            return;
        }

        $root = &XCube_Root::getSingleton();

        $root->mLanguageManager->loadModuleMessageCatalog('user');

        $userHandler = xoops_getModuleHandler('users', 'user');

        $criteria = new CriteriaCompo();

        $criteria->add(new Criteria('uname', xoops_getrequest('uname')));

        $criteria->add(new Criteria('pass', md5(xoops_getrequest('pass'))));

        $userArr = &$userHandler->getObjects($criteria);

        if (1 != count($userArr)) {
            return;
        }

        if (0 == $userArr[0]->get('level')) {
            // TODO We should use message "_MD_USER_LANG_NOACTTPADM"

            return;
        }

        $handler = xoops_getHandler('user');

        $user = $handler->get($userArr[0]->get('uid'));

        $xoopsUser = $user;

        //

        // Regist to session

        //

        require_once XOOPS_ROOT_PATH . '/include/session.php';

        xoops_session_regenerate();

        $_SESSION = [];

        $_SESSION['xoopsUserId'] = $xoopsUser->get('uid');

        $_SESSION['xoopsUserGroups'] = $xoopsUser->getGroups();

        //

        // Use 'mysession'

        //

        $xoopsConfig = $root->mContext->mXoopsConfig;

        if ($xoopsConfig['use_mysession'] && '' != $xoopsConfig['session_name']) {
            setcookie($xoopsConfig['session_name'], session_id(), time() + (60 * $xoopsConfig['session_expire']), '/', '', 0);
        }
    }

    public function checkLoginSuccess($xoopsUser)
    {
        if (is_object($xoopsUser)) {
            $handler = xoops_getHandler('user');

            $xoopsUser->set('last_login', time());

            $handler->insert($xoopsUser);
        }
    }

    public function logout(&$successFlag, $xoopsUser)
    {
        $root = &XCube_Root::getSingleton();

        $xoopsConfig = $root->mContext->mXoopsConfig;

        $root->mLanguageManager->loadModuleMessageCatalog('user');

        // Reset session

        $_SESSION = [];

        session_destroy();

        if ($xoopsConfig['use_mysession'] && '' != $xoopsConfig['session_name']) {
            setcookie($xoopsConfig['session_name'], '', time() - 3600, '/', '', 0);
        }

        // clear entry from online users table

        if (is_object($xoopsUser)) {
            $onlineHandler = xoops_getHandler('online');

            $onlineHandler->destroy($xoopsUser->get('uid'));
        }

        $successFlag = true;
    }

    public function misc()
    {
        if ('online' != xoops_getrequest('type')) {
            return;
        }

        require_once XOOPS_MODULE_PATH . '/user/class/ActionFrame.class.php';

        $root = &XCube_Root::getSingleton();

        $root->mController->setupModuleContext('user');

        $actionName = 'MiscOnline';

        $moduleRunner = new User_ActionFrame(false);

        $moduleRunner->setActionName($actionName);

        $root->mController->mExecute->add([&$moduleRunner, 'execute']);

        $root->mController->setDialogMode(true);

        $root->mController->execute();

        $root->mController->executeView();
    }
}

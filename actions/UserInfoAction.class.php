<?php
/**
 * @version $Id: UserInfoAction.class.php,v 1.2 2007/06/07 05:27:01 minahito Exp $
 */
if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

define('USER_USERINFO_MAXHIT', 5);

/***
 * @internal
 * This action shows a information of the target user which is specified by
 * $uid. And display posts of the user with the global search service.
 *
 * [Warning]
 * Now, the global search service can't work because the design of XCube is
 * changed.
 *
 * @todo The global search service can't work.
 */
class User_UserInfoAction extends User_Action
{
    public $mObject = null;

    public $mRankObject = null;

    public $mSearchResults = null;

    public $mSelfDelete = false;

    public $mPmliteURL = null;

    public function prepare(&$controller, &$xoopsUser, $moduleConfig)
    {
        $this->mSelfDelete = $moduleConfig['self_delete'];
    }

    public function isSecure()
    {
        return false;
    }

    public function getDefaultView($controller, $xoopsUser)
    {
        $uid = isset($_GET['uid']) ? (int)xoops_getrequest('uid') : 0;

        $handler = xoops_getHandler('user');

        $this->mObject = $handler->get($uid);

        if (!is_object($this->mObject)) {
            return USER_FRAME_VIEW_ERROR;
        }

        $t_rank = xoops_getrank($this->mObject->get('rank'), $this->mObject->get('posts'));

        $rankHandler = xoops_getModuleHandler('ranks', 'user');

        $this->mRankObject = $rankHandler->get($t_rank['id']);

        $root = &$controller->mRoot;

        $service = &$root->mServiceManager->getService('privateMessage');

        if (null != $service) {
            $client = &$root->mServiceManager->createClient($service);

            $this->mPmliteURL = $client->call('getPmliteUrl', ['fromUid' => is_object($xoopsUser) ? $xoopsUser->get('uid') : 0, 'toUid' => $uid]);
        }

        unset($service);

        $service = &$root->mServiceManager->getService('LegacySearch');

        if (null != $service) {
            $this->mSearchResults = [];

            $client = &$root->mServiceManager->createClient($service);

            $moduleArr = $client->call('getActiveModules', []);

            foreach ($moduleArr as $t_module) {
                $module = [];

                $module['name'] = $t_module['name'];

                $module['mid'] = $t_module['mid'];

                $params['mid'] = $t_module['mid'];

                $params['uid'] = $this->mObject->get('uid');

                $params['maxhit'] = USER_USERINFO_MAXHIT;

                $params['start'] = 0;

                $module['results'] = $client->call('searchItemsOfUser', $params);

                if (count($module['results']) > 0) {
                    $module['has_more'] = (count($module['results']) >= USER_USERINFO_MAXHIT) ? true : false;

                    $this->mSearchResults[] = $module;
                }
            }
        }

        return USER_FRAME_VIEW_SUCCESS;
    }

    /***
     * [Notice]
     * Because XCube_Service class group are changed now, this member function
     * can't get the result of user posts.
     * @param $controller
     * @param $xoopsUser
     * @param $render
     */

    public function executeViewSuccess(&$controller, $xoopsUser, $render)
    {
        $render->setTemplateName('user_userinfo.html');

        $render->setAttribute('thisUser', $this->mObject);

        $render->setAttribute('rank', $this->mRankObject);

        $render->setAttribute('pmliteUrl', $this->mPmliteURL);

        $userSignature = $this->mObject->getShow('user_sig');

        $render->setAttribute('user_signature', $userSignature);

        $render->setAttribute('searchResults', $this->mSearchResults);

        //

        // set flags.

        //

        $user_ownpage = (is_object($xoopsUser) && $xoopsUser->get('uid') == $this->mObject->get('uid'));

        $render->setAttribute('user_ownpage', $user_ownpage);

        //

        // About 'SELF DELETE'

        //

        $render->setAttribute('self_delete', $this->mSelfDelete);

        if ($user_ownpage && $this->mSelfDelete) {
            $render->setAttribute('enableSelfDelete', true);
        } else {
            $render->setAttribute('enableSelfDelete', false);
        }
    }

    public function executeViewError($controller, &$xoopsUser, &$render)
    {
        $controller->executeForward(XOOPS_URL . '/user.php');
    }
}

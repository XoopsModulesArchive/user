<?php
/**
 * @version $Id: UserSearchAction.class.php,v 1.1 2007/05/15 02:34:41 minahito Exp $
 */
if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

require_once XOOPS_MODULE_PATH . '/user/admin/forms/UserSearchForm.class.php';

class User_UserSearchAction extends User_Action
{
    public $mActionForm = null;

    public function prepare(&$controller, &$xoopsUser)
    {
        $this->mActionForm = new User_UserSearchForm();

        $this->mActionForm->prepare();
    }

    public function getDefaultView(&$controller, &$xoopsUser)
    {
        $this->mActionForm->fetch();

        return USER_FRAME_VIEW_INPUT;
    }

    public function executeViewInput(&$controller, &$xoopsUser, $render)
    {
        $render->setTemplateName('user_search.html');

        $render->setAttribute('actionForm', $this->mActionForm);

        $groupHandler = xoops_getHandler('group');

        $groups = &$groupHandler->getObjects(null, true);

        $groupOptions = [];

        foreach ($groups as $gid => $group) {
            $groupOptions[$gid] = $group->getVar('name');
        }

        $render->setAttribute('groupOptions', $groupOptions);
    }
}

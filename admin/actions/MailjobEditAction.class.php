<?php
/**
 * @version $Id: MailjobEditAction.class.php,v 1.2 2007/06/05 05:32:54 minahito Exp $
 */
if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

require_once XOOPS_ROOT_PATH . '/core/XCube_PageNavigator.class.php';

require_once XOOPS_MODULE_PATH . '/user/class/AbstractEditAction.class.php';
require_once XOOPS_MODULE_PATH . '/user/admin/forms/MailjobAdminEditForm.class.php';
require_once XOOPS_MODULE_PATH . '/user/admin/forms/UserSearchFilterForm.class.php';

class User_MailjobEditAction extends User_AbstractEditAction
{
    public $mPageNavi = null;

    public $mFilter = null;

    public function _getId()
    {
        return xoops_getrequest('mailjob_id');
    }

    public function &_getHandler()
    {
        $handler = xoops_getModuleHandler('mailjob');

        return $handler;
    }

    public function _setupActionForm()
    {
        $this->mActionForm = new User_MailjobAdminEditForm();

        $this->mActionForm->prepare();

        $this->mPageNavi = new XCube_PageNavigator('./index?action=MailjobEdit', XCUBE_PAGENAVI_START | XCUBE_PAGENAVI_PERPAGE);

        $this->mFilter = new User_UserSearchFilterForm($this->mPageNavi, xoops_getModuleHandler('users_search', 'user'));

        $this->mFilter->fetch();

        $root = &XCube_Root::getSingleton();

        $root->mDelegateManager->add('Legacy.Event.Explaceholder.Get.UserPagenaviHidden', 'User_MailjobEditAction::renderHiddenControl');
    }

    public function execute(&$controller, &$xoopsUser)
    {
        if (null != xoops_getrequest('_form_control_cancel')) {
            return USER_FRAME_VIEW_CANCEL;
        }

        $isNew = $this->mObject->isNew();

        $ret = parent::execute($controller, $xoopsUser);

        if (USER_FRAME_VIEW_SUCCESS == $ret && $isNew) {
            $handler = xoops_getModuleHandler('users_search');

            $uidArr = $handler->getUids($this->mFilter->getCriteria(0, 0));

            $handler = xoops_getModuleHandler('mailjob_link');

            foreach ($uidArr as $uid) {
                $obj = $handler->create();

                $obj->set('mailjob_id', $this->mObject->get('mailjob_id'));

                $obj->set('uid', $uid);

                $handler->insert($obj);
            }
        }

        return $ret;
    }

    public function executeViewInput(&$controller, &$xoopsUser, $render)
    {
        $render->setTemplateName('mailjob_edit.html');

        $render->setAttribute('actionForm', $this->mActionForm);

        $render->setAttribute('pageNavi', $this->mPageNavi);

        $render->setAttribute('object', $this->mObject);
    }

    public function executeViewSuccess($controller, &$xoopsUser, &$render)
    {
        $controller->executeForward('./index.php?action=MailjobList');
    }

    public function executeViewError($controller, &$xoopsUser, &$render)
    {
        $controller->executeRedirect('./index.php?action=MailjobList', 1, _MD_USER_ERROR_DBUPDATE_FAILED);
    }

    public function executeViewCancel($controller, &$xoopsUser, &$render)
    {
        $controller->executeForward('./index.php?action=MailjobList');
    }

    public function renderHiddenControl(&$buf, $params)
    {
        if (isset($params['pagenavi']) && is_object($params['pagenavi'])) {
            $navi = &$params['pagenavi'];

            $mask = $params['mask'] ?? null;

            foreach ($navi->mExtra as $key => $value) {
                if ($key != $mask) {
                    $value = htmlspecialchars($value, ENT_QUOTES);

                    $buf .= "<input type=\"hidden\" name=\"${key}\" value=\"${value}\">";
                }
            }
        }
    }
}

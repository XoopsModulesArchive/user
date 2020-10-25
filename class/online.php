<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

class UserOnlineObject extends XoopsSimpleObject
{
    public $mModule = null;

    public function __construct()
    {
        $this->initVar('online_uid', XOBJ_DTYPE_INT, '0', true);

        $this->initVar('online_uname', XOBJ_DTYPE_STRING, '', true, 25);

        $this->initVar('online_updated', XOBJ_DTYPE_INT, '0', true);

        $this->initVar('online_module', XOBJ_DTYPE_INT, '0', true);

        $this->initVar('online_ip', XOBJ_DTYPE_STRING, '', true, 15);
    }

    public function loadModule()
    {
        if ($this->get('online_module')) {
            $handler = xoops_getHandler('module');

            $this->mModule = $handler->get($this->get('online_module'));
        }
    }
}

class UserOnlineHandler extends XoopsObjectGenericHandler
{
    public $mTable = 'online';

    public $mPrimary = '';

    public $mClass = 'UserOnlineObject';
}

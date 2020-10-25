<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

class UserRanksObject extends XoopsSimpleObject
{
    public function __construct()
    {
        $this->initVar('rank_id', XOBJ_DTYPE_INT, 0, true);

        $this->initVar('rank_title', XOBJ_DTYPE_STRING, '', true, 50);

        $this->initVar('rank_min', XOBJ_DTYPE_INT, '0', true);

        $this->initVar('rank_max', XOBJ_DTYPE_INT, '0', true);

        $this->initVar('rank_special', XOBJ_DTYPE_BOOL, '0', true);

        $this->initVar('rank_image', XOBJ_DTYPE_STRING, '', false, 255);
    }
}

class UserRanksHandler extends XoopsObjectGenericHandler
{
    public $mTable = 'ranks';

    public $mPrimary = 'rank_id';

    public $mClass = 'UserRanksObject';

    public function delete(XoopsObject $obj)
    {
        @unlink(XOOPS_UPLOAD_PATH . '/' . $obj->get('rank_image'));

        return parent::delete($obj);
    }
}

<?php

if (!defined('XOOPS_ROOT_PATH')) {
    exit();
}

class User_Module extends Legacy_ModuleAdapter
{
    public function __construct(&$xoopsModule)
    {
        parent::Legacy_ModuleAdapter($xoopsModule);

        $this->mGetAdminMenu = new XCube_Delegate();

        $this->mGetAdminMenu->register('User_Module.getAdminMenu');
    }

    public function getAdminMenu()
    {
        $menu = parent::getAdminMenu();

        $this->mGetAdminMenu->call(new XCube_Ref($menu));

        ksort($menu);

        return $menu;
    }
}
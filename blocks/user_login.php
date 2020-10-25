<?php

function b_user_login_show()
{
    global $xoopsUser;

    if (!$xoopsUser) {
        $block = [];

        $configHandler = xoops_getHandler('config');

        $moduleConfig = &$configHandler->getConfigsByDirname('user');

        if (isset($_COOKIE[$moduleConfig['usercookie']])) {
            $block['unamevalue'] = $_COOKIE[$moduleConfig['usercookie']];
        } else {
            $block['unamevalue'] = '';
        }

        $block['allow_register'] = $moduleConfig['allow_register'];

        $block['use_ssl'] = $moduleConfig['use_ssl'];

        if (1 == $moduleConfig['use_ssl'] && '' != $moduleConfig['sslloginlink']) {
            $block['sslloginlink'] = $moduleConfig['sslloginlink'];
        } else {
            $block['use_ssl'] = 0;

            $block['sslloginlink'] = '';
        }

        return $block;
    }

    return false;
}

<?php

function b_user_online_show()
{
    global $xoopsUser, $xoopsModule;

    $onlineHandler = xoops_getHandler('online');

    // mt_srand((double)microtime() * 1000000);

    // set gc probabillity to 10% for now..

    if (mt_rand(1, 100) < 11) {
        $onlineHandler->gc(300);
    }

    if (is_object($xoopsUser)) {
        $uid = $xoopsUser->getVar('uid');

        $uname = $xoopsUser->getVar('uname');
    } else {
        $uid = 0;

        $uname = '';
    }

    if (is_object($xoopsModule)) {
        $onlineHandler->write($uid, $uname, time(), $xoopsModule->get('mid'), $_SERVER['REMOTE_ADDR']);
    } else {
        //

        // TODO We have to find the best method.

        //

        if (false === mb_strpos(xoops_getenv('REQUEST_URI'), 'misc.php')) {
            $onlineHandler->write($uid, $uname, time(), 0, $_SERVER['REMOTE_ADDR']);
        }
    }

    $onlines = &$onlineHandler->getAll();

    if (false !== $onlines) {
        $total = count($onlines);

        $block = [];

        $guests = 0;

        $members = '';

        $member_list = [];

        for ($i = 0; $i < $total; $i++) {
            if ($onlines[$i]['online_uid'] > 0) {
                $member['uid'] = $onlines[$i]['online_uid'];

                $member['uname'] = $onlines[$i]['online_uname'];

                $member_list[] = $member;
            } else {
                $guests++;
            }
        }

        $block['online_total'] = sprintf(_MB_USER_ONLINEPHRASE, $total);

        if (is_object($xoopsModule)) {
            $mytotal = $onlineHandler->getCount(new Criteria('online_module', $xoopsModule->getVar('mid')));

            $block['online_total'] .= ' (' . sprintf(_MB_USER_ONLINEPHRASEX, $mytotal, $xoopsModule->getVar('name')) . ')';
        }

        $block['online_members'] = $total - $guests;

        $block['online_member_list'] = $member_list;

        $block['online_guests'] = $guests;

        return $block;
    }

    return false;
}

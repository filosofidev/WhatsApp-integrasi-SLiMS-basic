<?php
define('INDEX_AUTH', '1');
require '../../../sysconfig.inc.php';
// IP based access limitation
require LIB.'ip_based_access.inc.php';
do_checkIP('smc');
do_checkIP('smc-membership');
require SB.'admin/default/session.inc.php';
// privileges checking
$can_read = utility::havePrivilege('membership', 'r');
if (!$can_read) { die(); }
require SIMBIO.'simbio_UTILS/simbio_date.inc.php';
require MDLBS.'membership/member_base_lib.inc.php';
// get data
$memberID = $dbs->escape_string(trim($_POST['memberID']));
// create member Instance
$member = new member($dbs, $memberID);
// send whatsapp
$status = $member->sendOverdueNoticeWA();
// get message
echo $message;
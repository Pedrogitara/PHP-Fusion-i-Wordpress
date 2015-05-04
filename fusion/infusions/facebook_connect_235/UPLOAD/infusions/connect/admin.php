<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Developer: Brandon Davis (NetriX)
| Website: PHPFusionMods.com
|  _   _      _        ___  __
| | \ | | ___| |_ _ __(_) \/ /
| |  \| |/ _ \ __| '__| |\  / 
| | |\  |  __/ |_| |  | |/  \ 
| |_| \_|\___|\__|_|  |_/_/\_\
|
| Do not remove the copyright footer without the developers
| consent. You may request the consent of removal by contacting
| me at the following email address: netrix@phpfusionmods.com
|
| Thank You,
| Brandon (NetriX)
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES . "templates/admin_header_mce.php";

include INFUSIONS . "connect/infusion_db.php";

if (!checkrights("FBC") || !$_GET['aid'] || !defined("iAUTH") || $_GET['aid'] != iAUTH || !iADMIN)
{
    redirect("../../index.php") . die("Access Denied");
}

$id = "";
$secret = "";
$sucess = false;
$type ="";
$count = dbcount("(user_id)", DB_USERS, "user_oauth_uid!='0'");

opentable($locale['i_admin_title']);

$admin = dbquery("SELECT * FROM " . DB_FACEBOOK . " LIMIT 0,1");
while ($d = dbarray($admin))
{
    $id = $d['id'];
    $secret = $d['secret'];
    $type = $d['type'];
    $color = $d['color'];
}

if (isset($_POST['update']))
{
    $id = preg_replace('/[^#A-Z0-9 ]/i', '', $_POST['id']);
    $secret = preg_replace('/[^#A-Z0-9 ]/i', '', $_POST['secret']);
    $type = preg_replace('/[^#A-Z0-9 ]/i', '', $_POST['type']);
    $color = preg_replace('/[^#A-Z0-9 ]/i', '', $_POST['color']);
    $query = dbquery("UPDATE " . DB_FACEBOOK . " SET id = '{$id}', secret = '{$secret}', type='{$type}', color='{$color}';");
    $sucess = true;
}

if ($sucess)
{
    echo "<div id='close-message'><div class='admin-message'>{$locale['fb_updated']}</div></div>\n";
}

echo "<form name='form_settings' id='form_settings' method='post' action='" . FUSION_SELF . $aidlink .
    "' enctype='multipart/form-data'>\n";
echo "<table cellpadding='0' cellspacing='1' class='tbl-border center' width='400px;'>\n";
echo "<tr>\n";
echo "<td class='forum-caption'>{$locale['a-set']}</td>\n";
echo "<td class='forum-caption'>{$locale['a-v']}</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td class='tbl1'>{$locale['fb_id']}</td>\n";
echo "<td class='tbl1'><input type='text' class='textbox' name='id' value='{$id}' /></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td class='tbl2'>{$locale['fb_secret']}</td>\n";
echo "<td class='tbl2'><input type='text' class='textbox' name='secret' value='{$secret}' /></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td class='tbl1'>{$locale['login_type']}</td>\n";
echo "<td class='tbl1'>";
echo "<input type='radio' name='type' value='java'" . ($type ==
    "java" ? " checked='checked'" : "") . " />JavaScript";
echo "<input type='radio' name='type' value='php'" . ($type == "php" ?
    " checked='checked'" : "") . " />PHP";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td class='tbl1'>{$locale['color_s']}</td>\n";
echo "<td class='tbl1'>";
echo "<input type='radio' name='color' value='light'" . ($color ==
    "light" ? " checked='checked'" : "") . " />{$locale['light']}";
echo "<input type='radio' name='color' value='dark'" . ($color == "dark" ?
    " checked='checked'" : "") . " />{$locale['dark']}";
echo "</td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td class='tbl1'></td>\n";
echo "<td class='tbl1'><input type='submit' class='button' value='{$locale['fb_update']}' name='update' /></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td class='forum-caption' colspan='2' style='text-align:center;'>";
echo $locale['totalconn']." ".$count;
echo "</td></tr>";
echo "<tr>\n";
echo "<td class='forum-caption' colspan='2' style='text-align:center;'><a href='https://developers.facebook.com/apps' target='_blank'>{$locale['fb_app_link']}</a> | <a href='http://phpfusionmods.com/' target='_blank' />{$locale['fb_app_support']}</a></td>\n";
echo "</tr>\n";
//echo "<tr>\n";
//echo "<td class='tbl1' colspan='2' style='text-align:center;'>";
//$link = 'http://phpfusionmods.com/check.php?id=3&version=2.3.4';
//echo @file_get_contents($link);
//echo "</td>\n</tr>\n";
echo "<tr>\n";
echo "<td class='tbl2' colspan='2' style='text-align:center;'>";
echo $locale['i_title']." v2.3.5 &copy; <a href='http://phpfusionmods.com/' target='_blank'>NetriX</a>";
echo "</td></tr>";
echo "</table>\n";
echo "</form>";
closetable();

require_once THEMES . "templates/footer.php";

?>
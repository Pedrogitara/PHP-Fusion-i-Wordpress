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
+--------------------------------------------------------*
| Copyright 2011 Facebook, Inc.
|
| Licensed under the Apache License, Version 2.0 (the "License"); you may
| not use this file except in compliance with the License. You may obtain
| a copy of the License at
|
| http://www.apache.org/licenses/LICENSE-2.0
|
| Unless required by applicable law or agreed to in writing, software
| distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
| WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
| License for the specific language governing permissions and limitations
| under the License.
|-------------------------------------------------------*/

/**
 * WELCOME TO THE INFUSION... ^_^
 * ---------------------------------------
 * General Rule - You must leave the copyright in tact for this infusion! Leaving the copyright in tact
 * and visible provides a lot of support for my work and ensures that future development and projects pursue.
 * ---------------------------------------
 * Shoutz from NetriX - Enjoy! - PHPFusionMods.com <- Check it!
 */

//header('P3P: CP="CAO PSA OUR"');

require_once "../../maincore.php";
require_once THEMES . "templates/header.php";
include INFUSIONS . "connect/infusion_db.php";

echo "\n\n<!--Facebook Connect Version 2.3.5 || CMS " . $settings['version'] .
    " || PHPFusionMods.com-->\n\n";

add_to_head('<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="-1">
<meta http-equiv="CACHE-CONTROL" content="NO-CACHE">');

$appid = "";
$secret2 = "";
$scope = "email";
$id = 0;
$admin = $settings['admin_activation'];

$query = dbquery("SELECT * FROM " . DB_FACEBOOK . " LIMIT 0,1");
while ($d = dbarray($query)) {
    $appid = $d['id'];
    $secret2 = $d['secret'];
    $type = $d['type'];
    $color_s = $d['color'];
}

require_once "src/facebook.php";

$facebook = new Facebook(array(
    'appId' => $appid,
    'secret' => $secret2,
    ));

$user = $facebook->getUser();

echo "<a href='#show' id='show'></a>";

opentable($locale['fb-login']);


if (isset($_GET['unlink']) && iMEMBER) {
    dbquery("UPDATE " . DB_USERS . " SET user_oauth_uid='0' WHERE user_id='" . $userdata['user_id'] .
        "'");
    redirect(BASEDIR . $settings['opening_page']);
}

if ($user) {
    try {
        // Proceed knowing you have a logged in user who's authenticated.
        $user_profile = $facebook->api('/me');
    }
    catch (FacebookApiException $e) {
        //echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
        $user = null;
    }
}

$e2 = true;

$remember = "";

if ($user) {
    $params = array('next' => $settings['siteurl'] . 'infusions/connect/logout.php');

    /**
     * The un-commented line below provides additional Facebook information pulled from
     * the users account. If you know what your doing, you can obtain the information provided
     * and use it to your own free will.
     */

    // echo htmlspecialchars(print_r($user_profile, true)); // Show Facebook Fields

    if (isset($user_profile['id'])) {
        $id = preg_replace('/[^0-9 ]/i', '', $user_profile['id']);
    } else {
        $id = 0;
        $e[] = $locale['id-fail'];
    }

    (isset($user_profile['username']) ? $user1 = $user_profile['username'] : $user1 = null);
    (isset($user_profile['email']) ? $email1 = $user_profile['email'] : $email1 = null);
    
    $user1 = preg_replace("/[^A-Z-]/i", "", $user1);

    if (iGUEST) {
        $result = dbquery("SELECT user_id, user_salt, user_algo, user_oauth_uid FROM " .
            DB_USERS . "
                           WHERE user_oauth_uid='" . $id .
            "'  AND user_status='0' AND user_actiontime='0'
                           LIMIT 1");
        $result2 = dbquery("SELECT user_id, user_salt, user_algo, user_oauth_uid FROM " .
            DB_USERS . "
                            WHERE user_oauth_uid='" . $id .
            "'  AND user_status='2' AND user_actiontime='0'
                            LIMIT 1");
        if (dbrows($result) == 1) {
            if ($id == 0) {
                redirect(BASEDIR . "index.php") . die();
            }
            $user = dbarray($result);
            Authenticate::setUserCookie($user['user_id'], $user['user_salt'], "sha256", $remember, true);
            redirect(BASEDIR . $settings['opening_page']);
        } elseif (dbrows($result2) == 1) {
            echo $locale['e-7'];
        } else {
            $action_url = FUSION_SELF . (FUSION_QUERY ? "?" . FUSION_QUERY : "");
            if (isset($_GET['redirect']) && strstr($_GET['redirect'], "/")) {
                $action_url = cleanurl(urldecode($_GET['rd']));
            }
            echo "<table cellpadding='5' cellspacing='1' width='100%' class='tbl-border center'>\n<tr>\n";
            echo "<td class='tbl2' width='1%' valign='top'>";
            echo "<img src='https://graph.facebook.com/" . $user .
                "/picture?type=normal' />";
            echo "</td><td class='tbl2' width='99%' valign='top'>";
            $user_profile['name'] = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $user_profile['name']);
            $welcome = str_replace("<!--USERNAME-->", $user_profile['name'], $locale['welcome']);
            $welcome2 = str_replace("<!--URL-->", $facebook->getLogoutUrl($params), $locale['welcome2']);
            echo nl2br($welcome);
            echo nl2br($welcome2);
            echo "</td></tr><tr><td colspan='2' width='100%' class='tbl2'>";
            echo "<table cellpadding='0' cellspacing='1' width='100%' class='tbl-border center'>\n<tr>\n";
            echo "<td class='forum-caption' width='50%'>{$locale['new-account']}</td>\n";
            echo "<td class='forum-caption' width='50%'>{$locale['existing-account']}</td>\n";
            echo "</tr>\n<tr>\n";
            echo "<td class='tbl2' width='50%' valign='top'>\n";
            $e = array();
            if (isset($_POST['register'])) {
                $username = $_POST['user_name'];
                $email = $_POST['user_email'];
                $password1 = $_POST['password'];
                $salt = sha1($password1, substr($password1, 12));
                $password = hash_hmac('sha256', $password1, $salt);
                // Thanks to kruizingaa for pointing out.
                switch ($admin) {
                    case 0:
                        $admin = 0;
                        break;
                    case 1:
                        $admin = 2;
                        break;
                    default:
                        $admin = 0;
                        break;
                }
                // End thanks.
                if ($user && (int)$user_profile['id'] != 0) {
                    $fbid = (int)$user_profile['id'];
                    //$avatar = "";
                    $avatar = (int)$user_profile['id'] . ".jpg";
                    $url = "https://graph.facebook.com/{$fbid}/picture?type=normal";
                    //$img = "";
                    $img = IMAGES . "avatars/{$fbid}.jpg";
                    file_put_contents($img, file_get_contents($url));
                    if (!file_exists(IMAGES . "avatars/{$fbid}.jpg")) {
                        $avatar = "";
                    }

                }

                if ($username == "" || $password1 == "" || $email == "" || $id == "") {
                    $e[] = $locale['e-1'];
                }
                if (!preg_match("/^[-0-9A-Z_@\s]+$/i", $username)) {
                    $e[] = $locale['e-2'];
                }
                if (!preg_match("/^[-0-9A-Z_\.]{1,50}@([-0-9A-Z_\.]+\.){1,50}([0-9A-Z]){2,4}$/i",
                    $email)) {
                    $e[] = $locale['e-3'];
                }
                if (dbcount("(user_id)", DB_USERS, "user_name='$username'") >= 1) {
                    $e[] = $locale['e-4'];
                }
                if (dbcount("(user_id)", DB_USERS, "user_email='$email'") >= 1) {
                    $e[] = $locale['e-5'];
                }
                if (dbcount("(user_id)", DB_USERS, "user_oauth_uid='$id'") >= 1) {
                    $e[] = $locale['e-6'];
                }

                if (empty($e)) {
                    $time = time();
                    $result = dbquery("INSERT INTO " . DB_USERS .
                        " (user_name, user_algo, user_salt, user_password, user_avatar, user_email, user_joined, user_oauth_uid, user_status) VALUES('$username', 'sha256', '$salt', '$password', '$avatar', '$email', '$time', '$id', '$admin')");
                    if (!$result) {
                        echo $locale['reg-fail'];
                        $e2 = true;
                    } elseif ($admin == 2) {
                        echo "<br /><div style='text-align:center; font-weight:bold;'>{$locale['reg-suc']}</div><br />";
                        echo "</td>\n";
                        echo "<td class='tbl2' width='50%'>\n";
                        echo "<br /><div style='text-align:center; font-weight:bold;'>{$locale['reg-activate']}</div><br />";
                        echo "</td>";
                        echo "</tr>\n</table>";
                        $e2 = false;
                    } else {
                        echo "<br /><div style='text-align:center; font-weight:bold;'>{$locale['reg-suc']}</div><br />";
                        Authenticate::setUserCookie(mysql_insert_id(), $salt, "sha256", $remember, true);
                        redirect(BASEDIR . "index.php");
                        echo "</td>\n";
                        echo "<td class='tbl2' width='50%'>\n";
                        echo "<br /><div style='text-align:center; font-weight:bold;'>{$locale['reg-leave']}</div><br />";
                        echo "</td>";
                        echo "</tr>\n</table>";
                        $e2 = false;
                    }
                }
            }
            if ($e2) {
                echo "<form name='registerform' method='post' action='" . $action_url . "'>\n";
                echo "<small>{$locale['no-acc']}</small><br /><br />\n";
                if (!empty($e)) {
                    echo "<div class='admin-message'>{$locale['errors']}</div>\n";
                    foreach ($e as $line) {
                        echo "<div class='block'>{$line}</div>";
                    }
                    echo "<br />\n";
                }
                echo "<strong>{$locale['d-user']}</strong><br />";
                echo "<input type='text' name='user_name' class='textbox' style='width:150px' value='" .
                    $user1 . "' /><br />";
                echo "<strong>{$locale['d-pass']}</strong><br />";
                echo "<input type='password' name='password' class='textbox' style='width:150px' /><br />";
                echo "<strong>{$locale['d-email']}</strong><br />";
                echo "<input type='text' name='user_email' class='textbox' style='width:150px' value='" .
                    $email1 . "' /><br /><br />";
                echo "<input type='submit' name='register' value='{$locale['register']}' class='button' />";
                echo "</form>\n";
                echo "</td>\n";
                echo "<td class='tbl2' valign='top' width='50%'>\n";
                echo "<form name='loginform' method='post' action='" . $action_url . "'>\n";
                echo "<small>{$locale['a-acc']}</small><br /><br />\n";
                echo "<strong>{$locale['username']}</strong><br />";
                echo "<input type='text' name='user_name' class='textbox' style='width:150px' /><br />";
                echo "<strong>{$locale['password']}</strong><br />";
                echo "<input type='password' name='user_pass' class='textbox' style='width:150px' /><br /><br />";
                echo "<input type='submit' name='login' value='{$locale['login']}' class='button' />";
                echo "</form>\n";
                echo "</td>\n";
                echo "</tr>\n</table>";
            }
            echo "</td></tr>";
            echo "<tr><td class='tbl1' align='left' colspan='2'>";
            echo "<div style='float: right;'><a href='http://www.phpfusionmods.com/' title='Facebook Connect Infusion Copyright 2013 NetriX
PHPFusionMods.com' target='_blank'>&copy;</a></div>";
            echo '</td></tr>';
            echo "</table>";
        }
    }

    if (iMEMBER) {
        $error = false;
        if (dbcount("(user_id)", DB_USERS, "user_oauth_uid='$id'") >= 1) {
            $error = true;
        }
        if ($error) {
            echo $locale['e-6'];
            redirect(BASEDIR.$settings['opening_page']);
        } else {
            if ($id == 0) {
                die($locale['id-fail']);
            } else {
                dbquery("UPDATE " . DB_USERS . " SET user_oauth_uid='" . $id .
                    "' WHERE user_id='" . $userdata['user_id'] . "'");
            }
            echo $locale['success'];
        }
    }
} else {

    /**
     * Having errors? Such as but not limited to the Redirect Loop? Un-comment the lines below.
     * Copy and paste all array information into the forums that your seeking support with.
     */

    //echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>'; // Shows Errors (Redirect Loop Solution)
    //die();

    $loginUrl = $facebook->getLoginUrl(array("scope" => "email, user_online_presence, publish_actions, user_website", "redirect_uri" =>
            "http://" . $settings['site_host'] .
            "/infusions/connect/index.php?comeback=true"));
    if (!isset($_GET['comeback']) && !iMEMBER && $type == "php" || isset($_GET['PHP_LOGIN'])) {
        redirect($loginUrl);
    }

?>
<table style='width: 100%'><tr><td>
<div style="text-align: center;">
<?php

    echo $locale['fb_fallback'] . "<br /><br />";

?>
<div id="fb-root"></div>
<fb:login-button size="large" onlogin="Log.info('onlogin callback')" data-scope="email, user_online_presence, publish_actions, user_website">
<?php

    echo $locale['fb_login_button_text'];

?>
</fb:login-button>
<script>
window.fbAsyncInit = function() {
FB.init({
appId: '<?php

    echo $facebook->getAppID()

?>',
cookie: true,
xfbml: true,
oauth: true
});
FB.Event.subscribe('auth.login', function(response) {
window.location.reload();
});
FB.Event.subscribe('auth.logout', function(response) {
window.location.reload();
});
};
(function() {
var e = document.createElement('script'); e.async = true;
e.src = document.location.protocol +
'//connect.facebook.net/en_US/all.js';
document.getElementById('fb-root').appendChild(e);
}());
</script>
<br /><br />
<?php echo $locale['login_php']; ?>
</div>
</td></tr></table>
<?php
}

/**
 * You do not have the rights to remove the copyright below. Any website found in violation will have there host
 * contacted immediately for copyright infringement. Be safe and don't remove. You may reposition this copyright
 * to a more suitable position, yet all text and linkage must remain as-is without being compromised.
 * 
 * - Thanks, NetriX
 */
closetable();

require_once THEMES . "templates/footer.php";

?>

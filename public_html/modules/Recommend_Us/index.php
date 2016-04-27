<?php
/*=======================================================================
 Nuke-Evolution Basic: Enhanced PHP-Nuke Web Portal System
 =======================================================================*/

/************************************************************************/
/* PHP-NUKE: Web Portal System                                          */
/* ===========================                                          */
/*                                                                      */
/* Copyright (c) 2002 by Francisco Burzi                                */
/* http://phpnuke.org                                                   */
/*                                                                      */
/* This program is free software. You can redistribute it and/or modify */
/* it under the terms of the GNU General Public License as published by */
/* the Free Software Foundation; either version 2 of the License.       */
/************************************************************************/
/*         Additional security & Abstraction layer conversion           */
/*                           2003 chatserv                              */
/*      http://www.nukefixes.com -- http://www.nukeresources.com        */
/************************************************************************/

/*****[CHANGES]**********************************************************
-=[Base]=-
      Nuke Patched                             v3.1.0       06/26/2005
 ************************************************************************/

if (!defined('MODULE_FILE')) {
   die('You can\'t access this file directly...');
}

$module_name = basename(dirname(__FILE__));
get_lang($module_name);
$pagetitle = '- '._RECOMMEND;

function RecommendSite() {
    global $user, $cookie, $prefix, $db, $user_prefix, $module_name, $evoconfig;    
    include_once(NUKE_BASE_DIR.'header.php');
    $useGRecaptcha = false;
    
    // Get recaptcha settings
    $recapPriv = $evoconfig['recaptcha_private_key'];
    $recapPub = $evoconfig['recaptcha_public_key'];
    if(isset($recapPriv) && !empty($recapPriv) && isset($recapPub) && !empty($recapPub)){
		$useGRecaptcha = true;
	}
    
    
    title(_RECOMMEND);
    OpenTable();
    echo "<center><span class=\"content\"><strong>"._RECOMMEND."</strong></span></center><br /><br />"
        ."<form action=\"modules.php?name=$module_name\" method=\"post\">"
        ."<input type=\"hidden\" name=\"op\" value=\"SendSite\">";
    if (is_user()) {
        $row = $db->sql_fetchrow($db->sql_query("SELECT username, user_email FROM ".$user_prefix."_users WHERE user_id = '".intval($cookie[0])."'"));
        $yn = stripslashes($row['username']);
        $ye = stripslashes($row['user_email']);
    }
    echo "<strong>"._FYOURNAME." </strong> <input type=\"text\" name=\"yname\" value=\"$yn\"><br /><br />\n"
        ."<strong>"._FYOUREMAIL." </strong> <input type=\"text\" name=\"ymail\" value=\"$ye\"><br /><br /><br />\n"
        ."<strong>"._FFRIENDNAME." </strong> <input type=\"text\" name=\"fname\"><br /><br />\n"
        ."<strong>"._FFRIENDEMAIL." </strong> <input type=\"text\" name=\"fmail\"><br /><br />\n";
        
    if($useGRecaptcha){
		echo "<script src='https://www.google.com/recaptcha/api.js' async defer></script>";
		echo "<div class='g-recaptcha' data-sitekey='" . $recapPub . "' style='display: inline-block'></div><br /><br />";
	}
    
    echo "<input type=submit value="._SEND."><br /><br />\n";
    echo "</form>\n";
    CloseTable();
    include_once(NUKE_BASE_DIR.'footer.php');
}

function SendSite($yname, $ymail, $fname, $fmail) {
    global $sitename, $slogan, $nukeurl, $module_name, $evoconfig;
    $fname = stripslashes(Fix_Quotes(check_html(removecrlf($fname))));
    $fmail = validate_mail(stripslashes(check_html(removecrlf($fmail))));
    $yname = stripslashes(Fix_Quotes(check_html(removecrlf($yname))));
    $ymail = validate_mail(check_html(removecrlf($ymail)));
    $subject = ""._INTSITE." $sitename";
    $message = ""._HELLO." $fname:\n\n"._YOURFRIEND." $yname "._OURSITE." $sitename "._INTSENT."\n\n\n"._FSITENAME." $sitename\n$slogan\n"._FSITEURL." $nukeurl\n";
    if (empty($fname) || empty($fmail) || empty($yname) || empty($ymail)) {
        redirect("modules.php?name=$module_name");
    } else {
		$success = true;
		
		// Get recaptcha settings
		$recapPriv = $evoconfig['recaptcha_private_key'];
		$recapPub = $evoconfig['recaptcha_public_key'];
		if(isset($recapPriv) && !empty($recapPriv) && isset($recapPub) && !empty($recapPub)){
			$useGRecaptcha = true;
		}
		
		if(isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])){
			require_once('includes/classes/recaptcha_v2/autoload.php');
			$recaptcha = new \ReCaptcha\ReCaptcha($evoconfig['recaptcha_private_key']);
			$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_HOST']);
			if (!$resp->isSuccess()) {
				// Failed
				$success = false;
			}
		}else{
			if($useGRecaptcha){
				$success = false;
			}
		}
		
		if($success){		
			evo_mail($fmail, $subject, $message, "FROM: \"$yname\" <$ymail>\nX-Mailer: PHP/" . phpversion());
			redirect("modules.php?name=$module_name&op=SiteSent&fname=$fname");
		}else{
			redirect("modules.php?name=$module_name");
		}
   }
}

function SiteSent($fname) {
    include_once(NUKE_BASE_DIR.'header.php');
    $fname = stripslashes(Fix_Quotes(check_html(removecrlf($fname))));
    OpenTable();
    echo "<center><span class=\"content\">"._FREFERENCE." $fname...<br /><br />"._THANKSREC."</span></center>";
    CloseTable();
    include_once(NUKE_BASE_DIR.'footer.php');
}
switch($op) {

    case "SendSite":
        SendSite($yname, $ymail, $fname, $fmail);
    break;

    case "SiteSent":
        SiteSent($fname);
    break;

    default:
        RecommendSite();
    break;

}

?>

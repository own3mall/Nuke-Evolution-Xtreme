<?php

/************************************************************************
   Nuke-Evolution: Theme Management
   ============================================
   Copyright (c) 2005 by The Nuke-Evolution Team
   Filename      : theme_info.php
   Author        : JeFFb68CAM (www.Evo-Mods.com)
   Version       : 1.0.2
   Date          : 12.20.2005 (mm.dd.yyyy)
   Notes         : Advanced Theme Features for EvoXtreme Theme.
************************************************************************/

if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    exit('Quit trying to hack my website!');
}

$current_theme = basename(dirname(__FILE__));

$param_names = array(
	'Theme Width (Only accepts 80 or 990)<br /><span class="gensmall">80 = 80% | 990 = 990px</span>',
	'Link 1 URL',
	'Link 1 Text',
	'Link 2 URL',
	'Link 2 Text',
	'Link 3 URL',
	'Link 3 Text',
	'Link 4 URL',
	'Link 4 Text',
	'Link 5 URL',
	'Link 5 Text',
	'Header Message',
	'BG Color 1',
	'BG Color 2',
	'BG Color 3',
	'BG Color 4',
	'Text Color 1',
	'Text Color 2'
);
			
$params = array(
	'themewidth',
	'link1',
	'link1text',
	'link2',
	'link2text',
	'link3',
	'link3text',
	'link4',
	'link4text',
	'link5',
	'link5text',
	'hdmessage',
	'bgcolor1',
	'bgcolor2',
	'bgcolor3',
	'bgcolor4',
	'textcolor1',
	'textcolor2'
);

$default = array(
	'80',
	'index.php',
	'Home',
	'modules.php?name=Forums',
	'Forums',
	'modules.php?name=Downloads',
	'Downloads',
	'modules.php?name=Web_Links',
	'Web Links',
	'modules.php?name=Your_Account',
	'Account',
	'Download Nuke Evolution today for a CMS you can enjoy using and sharing with your friends!<br /><br />[ <a href="modules.php?name=Downloads">Download Now</a> ]',
	'#cccccc',
	'#cccccc',
	'#cccccc',
	'#cccccc',
	'#000000',
	'#000000'
);

$ThemeInfo = $core->theme->loadThemeInfo($current_theme, $params, $default);


//
// <!DOCTYPE> settings
//
$core->theme->doctype = 'custom';


//
// Set a custom <html> element for this <!DOCTYPE>
//
$html  = '<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->' . PHP_EOL;
$html .= '<!--[if IE 7]> <html class="no-js ie7 oldie" dir="%dir" lang="%lang"> <![endif]-->' . PHP_EOL;
$html .= '<!--[if IE 8]> <html class="no-js ie8 oldie" dir="%dir" lang="%lang"> <![endif]-->' . PHP_EOL;
$html .= '<!--[if IE 9]> <html class="no-js ie9 oldie" dir="%dir" lang="%lang"> <![endif]-->' . PHP_EOL;
$html .= '<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js" dir="%dir" lang="%lang"> <!--<![endif]-->';


//
// Find setup the custom properties array
//
$core->theme->customProps = array(
	'doctype_r' 	=> 'html5',
	'tags'			=> array(
		'html' => $html
	),
	'replacements'	=> array(
		'tags' => array(
			'html' => array('%dir' => 'ltr', '%lang' => 'en')
		)
	)
);
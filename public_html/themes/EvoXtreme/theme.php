<?php

/**
 * Nuke Evolution Xtreme: Enhanced PHP-Nuke Web Portal System
 * ---------------------------------------------------------------------
 *
 * @filename        theme.php
 * @author          SgtLegend
 * @version         3.0
 * @date            06/08/2011 (DD/MM/YYY)
 * @license         Copyright (c) 2011 SgtLegend under the MIT license
 * @notes           A public theme for use with Nuke Evolution Xtreme
 */

if (realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    exit('Access Denied');
}


$theme_name = basename(dirname(__FILE__));

$more_js .= '<!--[if lt IE 9]>' . "\n";
$more_js .= '    <script type="text/javascript" src="themes/' . $theme_name . '/js/selectivizr-min.js"></script>' . "\n";
$more_js .= '    <script type="text/javascript" src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>' . "\n";
$more_js .= '<![endif]-->' . "\n";
$more_js .= '<script type="text/javascript" src="themes/' . $theme_name . '/js/jquery.color.js"></script>' . "\n";
$more_js .= '<script type="text/javascript" src="themes/' . $theme_name . '/js/main.js"></script>' . "\n";

/************************************************************
 [ Theme Management Section                                 ]
 ************************************************************/
include(NUKE_THEMES_DIR.$theme_name . '/theme_info.php');

/************************************************************
 [ Theme Colors Definition                                  ]
 ************************************************************/
global $ThemeInfo;
$bgcolor1   = $ThemeInfo['bgcolor1'];
$bgcolor2   = $ThemeInfo['bgcolor2'];
$bgcolor3   = $ThemeInfo['bgcolor3'];
$bgcolor4   = $ThemeInfo['bgcolor4'];
$textcolor1 = $ThemeInfo['textcolor1'];
$textcolor2 = $ThemeInfo['textcolor2'];

/************************************************************
 [ OpenTable Functions                                      ]
 ************************************************************/
function OpenTable() {
	echo '<div class="tables-wrap">' . "\n";
	echo '    <div class="clearfix tables-hd">' . "\n";
	echo '        <span class="sides"><span></span></span>' . "\n";
	echo '    </div>' . "\n";
	echo '    <div class="tables-body">' . "\n";
	echo '        <span class="sides"><span></span></span>' . "\n";
	echo '        <div class="clearfix tables-body-content">' . "\n";
}

function OpenTable2() {
    echo '<table border="0" cellspacing="1" cellpadding="0" align="center"><tr><td class="extras">' . "\n";
    echo '<table border="0" cellspacing="1" cellpadding="8"><tr><td>' . "\n";
}

function CloseTable() {
	echo '        </div>' . "\n";
	echo '    </div>' . "\n";
	echo '    <div class="clearfix tables-ft">' . "\n";
	echo '        <span class="sides"><span></span></span>' . "\n";
	echo '    </div>' . "\n";
	echo '</div>' . "\n";
	echo '<!-- /.tables-wrap -->' . "\n";
}

function CloseTable2() {
    echo '</td></tr></table></td></tr></table>' . "\n";
}

/**
 * Adjusts the way the informants name gets ouputted to the page
 *
 * @function FormatStory
 */
function FormatStory($thetext, $notes, $aid, $informant) {
    global $anonymous;
	
	$notes = !empty($notes) ? '<br /><br /><strong>' . _NOTE . '</strong> <em>' . $notes . '</em>' : '';
	
    if ($aid == $informant) {
        echo '<span class="content" color="#505050">' . $thetext . $notes . '</span>';
    } else {
        if (defined('WRITES')) {
            if (!empty($informant)) {
				$boxstuff = is_array($informant) ?
					'<a href="modules.php?name=Your_Account&amp;op=userinfo&amp;username=' . $informant[0] . '">' . $informant[1] . '</a> ':
					'<a href="modules.php?name=Your_Account&amp;op=userinfo&amp;username=' . $informant . '">' . $informant . '</a> ';
            } else {
                $boxstuff = $anonymous . ' ';
            }
			
            $boxstuff .= _WRITES . ' <em>' . $thetext . '</em>' . $notes;
        } else {
            $boxstuff .= $thetext . $notes;
        }
		
        echo '<span class="content" color="#505050">' . $boxstuff . '</span>';
    }
}

/**
 * Controls the output of the theme header including the navigation and
 * user information box
 *
 * @function themeheader
 */
function themeheader() {
    global $sitename, $slogan, $name, $banners, $db, $user_prefix, $prefix, $admin_file, $ThemeInfo, $userinfo;

    // Check if a registered user is logged in
	$username = is_user() ? $userinfo['username'] : _ANONYMOUS;
	
	
	// Setup the welcome information for the user
    if ($username === _ANONYMOUS) {
        $theuser  = 'It appears you are not logged in as a user!<br>Please <a href="modules.php?name=Your_Account">login</a> or <a href="modules.php?name=Your_Account&amp;op=new_user">register</a>.';
    } else {
    	// Get the number of private messages for this user
    	list($uid) = $db->sql_fetchrow($db->sql_query("SELECT user_id FROM " . $user_prefix . "_users WHERE username = '$username'"));
	    $pms       = $db->sql_numrows($db->sql_query("SELECT privmsgs_to_userid FROM " . $prefix . "_bbprivmsgs WHERE privmsgs_to_userid = $uid AND (privmsgs_type = 5 OR privmsgs_type = 1)"));

		$theuser  = 'You have (<a href="modules.php?name=Private_Messages">' . $pms . '</a>) private messages in your inbox<br><br>';
		$theuser .= '<a href="modules.php?name=Profile&amp;mode=editprofile">Edit your profile</a> | ';
		$theuser .= '<a href="modules.php?name=Your_Account&amp;op=logout">Logout</a>';
    }

    // If the user is a site administrator show the required links
    if (is_admin()) {
		$theuser .= ' | <a href="' . $admin_file . '.php">Admin Panel</a>';
		// $theuser .= '&nbsp;|&nbsp;&nbsp;<a href="' . $admin_file . '.php?op=logout">Admin Logout</a>';
	}
	
	// Theme Width
	switch ($ThemeInfo['themewidth']) {
		case '990':
			$width = '990px';
		break;
		case '80':
		default:
			$width = '80%';
	}
	
	?>
	<body>
	
	<!-- The EvoXtreme Theme is a public design and copyright (c) 2011 SgtLegend at darkforgegfx.com (http://www.darkforgegfx.com - admin [at] darkforgegfx [dot] com) -->
	<!-- This theme is being released publicly or and does fall under GPL Rules/Guidelines, but the whole design and images are copyrighted under copyright laws. -->
	<!-- Whole design and/or images are copyrighted (c) 2011 darkforgegfx.com and PVMGarage. All Rights Reserved. -->
	
	<div id="container" style="width: <?php echo $width; ?>;">
	    <header>
			<hgroup class="clearfix">
				<h1><?php echo $sitename; ?></h1>
				<h2><?php echo (!empty($slogan) ? $slogan : '&nbsp;'); ?></h2>
				
				<nav class="clearfix">
					<ul>
						<?php

						for ($i = 1; $i <= 5; $i++) {
							// Match the link against the current URI
							$link = $ThemeInfo['link' . $i];
							$self = substr($_SERVER['REQUEST_URI'], strripos($_SERVER['REQUEST_URI'], '/') + 1);
							$self = empty($self) ? 'index.php' : $self;
							$msel = preg_match('/' . str_replace(array('?'), array('\?'), $link) . '/i', $self) ? ' class="current"' : '';

							echo '<li' . $msel . '><a href="' . $link . '">' . $ThemeInfo['link' . $i . 'text'] . '</a></li>';
						}

						?>
					</ul>
				</nav>
				
				<?php
				if (!empty($banners)) {
				?>
					<div id="header-ads"><?php echo ads(0); ?></div>
				<?php
				}
				?>
			</hgroup>
			
			<section id="user-interact">
				<aside id="welcome-wrap">
					<h3><?php echo _BWEL . ' ' . ((strlen($username) > 15) ? substr($username, 0, 15) . '...' : $username); ?></h3>
					<p>
						<?php echo $theuser; ?>
					</p>
				</aside>
				
				<aside id="message-wrap">
					<h3>Download Nuke Evolution</h3>
					<p><?php echo $ThemeInfo['hdmessage']; ?></p>
				</aside>
			</section>
		</header>
		
	    <div class="clearfix" id="body-wrap" data-role="content">
	<?php

	// Blocks [ Left | Right ]
	// ------------------------------------
	// DO NOT CHANGE ANY CODE BELOW, DOING SO MAY
	// BREAK THE THEME STRUCTURE

	if ((!blocks_visible('left') && !blocks_visible('right')) || (blocks('left', true) == 0 && blocks('right', true) == 0) || (blocks_visible('right') && defined('ADMIN_FILE') && blocks('left', true) == 0)) {
		echo '        <!-- Begin Center Wrap -->' . "\n";
		echo '        <div id="center-wrap-full">' . "\n";
	} else if (blocks_visible('right') && defined('ADMIN_FILE') && blocks('left', true) > 0) {
		echo '        <!-- Begin Left Blocks -->' . "\n";
		echo '        <div id="blocks-left-wrap">' . "\n";
		blocks('left');
		echo '        </div>' . "\n";
		echo '        <!-- End Left Blocks -->' . "\n";
		echo '        <!-- Begin Center Wrap -->' . "\n";
		echo '        <div id="center-wrap-left">' . "\n";
	} else if (blocks_visible('left') && blocks_visible('right') && blocks('left', true) == 0) {
		echo '        <!-- Begin Right Blocks -->' . "\n";
		echo '        <div id="blocks-right-wrap">' . "\n";
		blocks('right');
		echo '        </div>' . "\n";
		echo '        <!-- End Right Blocks -->' . "\n";
		echo '        <!-- Begin Center Wrap -->' . "\n";
		echo '        <div id="center-wrap-right">' . "\n";
	} else if (blocks_visible('left') && blocks_visible('right') && blocks('right', true) == 0) {
		echo '        <!-- Begin Left Blocks -->' . "\n";
		echo '        <div id="blocks-left-wrap">' . "\n";
		blocks('left');
		echo '        </div>' . "\n";
		echo '        <!-- End Left Blocks -->' . "\n";
		echo '        <!-- Begin Center Wrap -->' . "\n";
		echo '        <div id="center-wrap-left">' . "\n";
	} else if (blocks_visible('left') && blocks_visible('right')) {
		echo '        <!-- Begin Right Blocks -->' . "\n";
		echo '        <div id="blocks-right-wrap">' . "\n";
		blocks('right');
		echo '        </div>' . "\n";
		echo '        <!-- End Right Blocks -->' . "\n";
		echo '        <!-- Begin Left Blocks -->' . "\n";
		echo '        <div id="blocks-left-wrap">' . "\n";
		blocks('left');
		echo '        </div>' . "\n";
		echo '        <!-- End Left Blocks -->' . "\n";
		echo '        <!-- Begin Center Wrap -->' . "\n";
		echo '        <div id="center-wrap">' . "\n";
	} else if (blocks_visible('left') && !blocks_visible('right') && blocks('left', true) > 0) {
		echo '        <!-- Begin Left Blocks -->' . "\n";
		echo '        <div id="blocks-left-wrap">' . "\n";
		blocks('left');
		echo '        </div>' . "\n";
		echo '        <!-- End Left Blocks -->' . "\n";
		echo '        <!-- Begin Center Wrap -->' . "\n";
		echo '        <div id="center-wrap-left">' . "\n";
	} else if (!blocks_visible('left') && blocks_visible('right') && blocks('right', true) > 0) {
		echo '        <!-- Begin Right Blocks -->' . "\n";
		echo '        <div id="blocks-right-wrap">' . "\n";
		blocks('right');
		echo '        </div>' . "\n";
		echo '        <!-- End Right Blocks -->' . "\n";
		echo '        <!-- Begin Center Wrap -->' . "\n";
		echo '        <div id="center-wrap-right">' . "\n";
	}
}

/************************************************************
 [ Function themefooter()                                   ]
 ************************************************************/
function themefooter() {
    global $user, $cookie, $banners, $prefix, $db, $admin, $adminmail, $nukeurl, $theme_name, $ThemeInfo;
	
	// Get the nuke evolution footer
	// ----------------------------------
	// DO NOT CHANGE OR REMOVE THIS, DOING SO WILL RESULT
	// IN YOU BEEN MARKED AS A THEME RIPPER/COPYRIGHTS VIOLATOR
	ob_start();
	echo footmsg();
	$contents = ob_get_clean();
	
	?>
	        </div>
	        <!-- /#center-wrap -->
	    </div>
	    <!-- /#body-wrap -->
		
		<footer>
	        <section>
			<?php
				if (!empty($banners)) {
					echo ads(2) . '<br>';
				}
				
				echo $contents;
			?>
	        </section>
			
	        <p>
	            <a href="http://www.darkforgegfx.com" target="_blank" title="EvoXtreme theme designed by SgtLegend, based off an SEO theme by PVMGarage">EvoXtreme theme designed by SgtLegend, based off an SEO theme by PVMGarage</a>
	        </p>
	    </footer>
	</div>
	<!-- /#container -->
	<?php
}

/************************************************************
 [ Function themeindex()                                    ]
 [ This function format the stories on the Homepage         ]
 ************************************************************/
function themeindex($aid, $informant, $time, $title, $counter, $topic, $thetext, $notes, $morelink, $topicname, $topicimage, $topictext, $writes = false) {
    global $anonymous, $tipath, $theme_name, $sid, $ThemeSel, $nukeurl;
	
    if (!empty($topicimage)) {
		$t_image = (file_exists('themes/'.$ThemeSel.'/images/topics/'.$topicimage)) ? 'themes/'.$ThemeSel.'/images/topics/'.$topicimage : $tipath.$topicimage;
        $topic_img = '<td width="25%" align="center" class="extra"><a href="modules.php?name=News&new_topic='.$topic.'"><img src="'.$t_image.'" border="0" alt="'.$topictext.'" title="'.$topictext.'"></a></td>';
    } else {
        $topic_img = '';
    }
	$notes = (!empty($notes)) ? '<br /><br /><strong>'._NOTE.'</strong> '.$notes : '';
    $content = '';
    if ($aid == $informant) {
        $content = $thetext.$notes;
    } else {
        if ($writes) {
            if (!empty($informant)) {
				$content = (is_array($informant)) ? '<a href="modules.php?name=Your_Account&amp;op=userinfo&amp;username='.$informant[0].'">'.$informant[1].'</a> ' : '<a href="modules.php?name=Your_Account&amp;op=userinfo&amp;username='.$informant.'">'.$informant.'</a> ';
            } else {
                $content = $anonymous.' ';
            }
            $content .= _WRITES.' '.$thetext.$notes;
        } else {
            $content .= $thetext.$notes;
        }
    }
	
    $posted = _POSTEDBY.' ';
    $posted .= get_author($aid);
    $posted .= ' '._ON.' '.$time.' ';
    $datetime = substr($morelink, 0, strpos($morelink, '|')-strlen($morelink));
    $morelink = substr($morelink, strlen($datetime)+2);
	?>
	
	<section class="news-story">
		<div class="story-hd">
			<span class="clearfix sides"><span></span></span>
			<h4><?php echo $title; ?></h4>
		</div>
		
		<div class="story-bd">
			<span class="clearfix sides"><span></span></span>
			<article>
			<?php
				echo $content . '<hr />' . $posted . ' ' . $datetime . ' | ' . $morelink;
			?>
			</article>
		</div>
		
		<div class="story-ft">
			<span class="clearfix sides"><span></span></span>
		</div>
	</section>
	
	<?php
	/*echo '			<!-- News Start -->' . "\n";
	echo '			<div class="news-wrap">' . "\n";
	echo '			    <div class="news-hd">' . "\n";
	echo '			        <span class="news-hd-left"></span>' . "\n";
	echo '			        <span class="news-hd-right"></span>' . "\n";
	echo '			        <div class="news-hd-title">'.$title.'</div>' . "\n";
	echo '			    </div>' . "\n";
	echo '			    <div class="news-body">' . "\n";
	echo '			        <span class="news-body-left"></span>' . "\n";
	echo '			        <span class="news-body-right"></span>' . "\n";
	echo '			        <div class="news-body-content">' . "\n";
	echo                        $thetext.'<hr />'.$posted.' '.$datetime.' | '.$morelink;
	echo '			        </div>' . "\n";
	echo '			    </div>' . "\n";
	echo '			    <div class="news-ft">' . "\n";
	echo '			        <span class="news-ft-left"></span>' . "\n";
	echo '			        <span class="news-ft-right"></span>' . "\n";
	echo '			    </div>' . "\n";
	echo '			</div>' . "\n";
	echo '			<!-- News End -->' . "\n";*/
}

/************************************************************
 [ Function themearticle()                                  ]
 ************************************************************/
function themearticle($aid, $informant, $datetime, $title, $thetext, $topic, $topicname, $topicimage, $topictext, $writes = false) {
    global $admin, $sid, $tipath, $theme_name;

	if (!empty($topicimage)) {
		$t_image = (file_exists('themes/'.$ThemeSel.'/images/topics/'.$topicimage)) ? 'themes/'.$ThemeSel.'/images/topics/'.$topicimage : $tipath.$topicimage;
        $topic_img = '<td width="25%" align="center" class="extra"><a href="modules.php?name=News&new_topic='.$topic.'"><img src="'.$t_image.'" border="0" alt="'.$topictext.'" title="'.$topictext.'"></a></td>';
    } else {
        $topic_img = '';
    }
	$notes = (!empty($notes)) ? '<br /><br /><strong>'._NOTE.'</strong> '.$notes : '';
    $content = '';
    if ($aid == $informant) {
        $content = $thetext.$notes;
    } else {
        if ($writes) {
            if (!empty($informant)) {
				$content = (is_array($informant)) ? '<a href="modules.php?name=Your_Account&amp;op=userinfo&amp;username='.$informant[0].'">'.$informant[1].'</a> ' : '<a href="modules.php?name=Your_Account&amp;op=userinfo&amp;username='.$informant.'">'.$informant.'</a> ';
            } else {
                $content = $anonymous.' ';
            }
            $content .= _WRITES.' '.$thetext.$notes;
        } else {
            $content .= $thetext.$notes;
        }
    }
	$posted = _POSTEDON.' '.$datetime.' '._BY.' ';
    $posted .= get_author($aid);

	echo '			<!-- News Start -->' . "\n";
	echo '			<div class="news-wrap">' . "\n";
	echo '			    <div class="news-hd">' . "\n";
	echo '			        <span class="news-hd-left"></span>' . "\n";
	echo '			        <span class="news-hd-right"></span>' . "\n";
	echo '			        <div class="news-hd-title">'.$title.'</div>' . "\n";
	echo '			    </div>' . "\n";
	echo '			    <div class="news-body">' . "\n";
	echo '			        <span class="news-body-left"></span>' . "\n";
	echo '			        <span class="news-body-right"></span>' . "\n";
	echo '			        <div class="news-body-content">' . "\n";
	echo                        $thetext.'<hr />'.$posted.' '.$datetime;
	echo '			        </div>' . "\n";
	echo '			    </div>' . "\n";
	echo '			    <div class="news-ft">' . "\n";
	echo '			        <span class="news-ft-left"></span>' . "\n";
	echo '			        <span class="news-ft-right"></span>' . "\n";
	echo '			    </div>' . "\n";
	echo '			</div>' . "\n";
	echo '			<!-- News End -->' . "\n";
}

/**********************************************************
 [ Centerbox Section                                      ]
 **********************************************************/
function themecenterbox($title, $content) {
    OpenTable();
    echo '<center><span class="option"><strong>'.$title.'</strong></span></center><br />'.$content;
    CloseTable();
}

/**********************************************************
 [ Preview Section                                        ]
 **********************************************************/
function themepreview($title, $hometext, $bodytext='', $notes='') {
    echo '<strong>'.$title.'</strong><br /><br />'.$hometext;
    echo (!empty($bodytext)) ? '<br /><br />'.$bodytext : '';
    echo (!empty($notes)) ? '<br /><br /><strong>'._NOTE.'</strong> <em>'.$notes.'</em>' : '';
}

/**********************************************************
 [ Function themesidebox()                                ]
 **********************************************************/
function themesidebox($title, $content, $bid = 0) {
	echo '<div class="blocks-wrap">' . "\n";
	echo '    <h4>' . $title . '</h4>' . "\n";
	echo '    <div class="blocks-body">' . $content . '</div>' . "\n";
	echo '    <span class="blocks-footer"></span>' . "\n";
	echo '</div>' . "\n";
}
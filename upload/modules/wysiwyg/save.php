<?php

/**
 * This file is part of an ADDON for use with LEPTON Core.
 * This ADDON is released under the GNU GPL.
 * Additional license terms can be seen in the info.php of this module.
 *
 * @module          wysiwyg
 * @author          Ryan Djurovich
 * @author          LEPTON Project
 * @copyright       2004-2010 WebsiteBaker Project
 * @copyright       2010-2017 LEPTON Project 
 * @link            https://www.LEPTON-cms.org
 * @license         http://www.gnu.org/licenses/gpl.html
 * @license_terms   please see info.php of this module
 *
 */

// include class.secure.php to protect this file and the whole CMS!
if (defined('LEPTON_PATH')) {	
	include(LEPTON_PATH.'/framework/class.secure.php'); 
} else {
	$oneback = "../";
	$root = $oneback;
	$level = 1;
	while (($level < 10) && (!file_exists($root.'/framework/class.secure.php'))) {
		$root .= $oneback;
		$level += 1;
	}
	if (file_exists($root.'/framework/class.secure.php')) { 
		include($root.'/framework/class.secure.php'); 
	} else {
		trigger_error(sprintf("[ <b>%s</b> ] Can't include class.secure.php!", $_SERVER['SCRIPT_NAME']), E_USER_ERROR);
	}
}
// end include class.secure.php

// force php not to add slashes if magic_quotes_gps is ON
    $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
    while (list($key, $val) = each($process)) {
        foreach ($val as $k => $v) {
            unset($process[$key][$k]);
            if (is_array($v)) {
                $process[$key][str_replace(array('\\'), '', $k)] = $v;
                $process[] = &$process[$key][str_replace(array('\\'), '', $k)];
            } else {
                $process[$key][str_replace(array('\\'), '', $k)] = str_replace(array('\\'), '', $v);
            }
        }
    }
    unset($process);

// Include admin wrapper script
$update_when_modified = true; // Tells script to update when this page was last updated
require(LEPTON_PATH.'/modules/admin.php');

// Include the functions file
require_once(LEPTON_PATH.'/framework/summary.utf8.php');

/**
 *	Update the mod_wysiwygs table with the contents
 *	
 *	M.f.i	- The database-test for errors should be inside the condition block.
 *			- Additional tests for possible cross-attacks.
 *			- Additional test for the user CAN modify a) this modul conten and b) this section!
 */
if(isset($_POST['content'.$section_id])) {
	$content = addslashes($_POST['content'.$section_id]);

/**
 *	Try to add an \ before the "$" char.
 */
$content = str_replace("\$", "\\\$", $content);

	/**
	 *	searching in $text will be much easier this way?
	 *
	 */
	$text = strip_tags($content);

	$query = "UPDATE `".TABLE_PREFIX."mod_wysiwyg` SET `content` = '".$content."', text ='".$text."' WHERE `section_id` = '".$section_id."'";
	$database->query($query);
	if ($database->is_error()) trigger_error(sprintf('[%s - %s] %s', __FILE__, __LINE__, $database->get_error()), E_USER_ERROR);	
}

$edit_page = ADMIN_URL.'/pages/modify.php?page_id='.$page_id.'#'.SEC_ANCHOR.$section_id;

// Check if there is a database error, otherwise say successful
if($database->is_error()) {
	$admin->print_error($database->get_error(), $js_back);
} else {
	$admin->print_success($MESSAGE['PAGES']['SAVED'], $edit_page );
}

// Print admin footer
$admin->print_footer();

?>
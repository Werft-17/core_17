<?php

/**
 * This file is part of LEPTON Core, released under the GNU GPL
 * Please see LICENSE and COPYING files in your package for details, specially for terms and warranties.
 * 
 * NOTICE:LEPTON CMS Package has several different licenses.
 * Please see the individual license in the header of each single file or info.php of modules and templates.
 *
 *
 * @author          LEPTON Project
 * @copyright       2010-2017 LEPTON Project
 * @link            http://www.LEPTON-cms.org
 * @license         http://www.gnu.org/licenses/gpl.html
 * @license_terms   please see LICENSE and COPYING files in your package
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

// enable custom dashboard
if(file_exists(THEME_PATH .'/backend/start/index.php')) {
	require_once (THEME_PATH .'/backend/start/index.php');
	die();
}
	
// exec initial_page
if(file_exists(LEPTON_PATH .'/modules/initial_page/classes/class.init_page.php') && isset($_SESSION['USER_ID'])) {
	require_once (LEPTON_PATH .'/modules/initial_page/classes/class.init_page.php');
	$ins = new class_init_page($database, $_SESSION['USER_ID'], $_SERVER['SCRIPT_NAME']);
}
require_once(LEPTON_PATH.'/framework/class.admin.php');
$admin = new admin('Start','start');

if(file_exists(THEME_PATH."/globals/lte_globals.php")) require_once(THEME_PATH."/globals/lte_globals.php");
	
//get pages info
$pages = array();
$database->execute_query(
"SELECT * FROM `".TABLE_PREFIX."pages` ORDER BY `modified_when` DESC ",
true,
$pages,
true
);

$last_pmodified = date("d.m.Y - H:i", $pages[0]['modified_when']);
$last_plink = LEPTON_URL.PAGES_DIRECTORY.$pages[0]['link'].PAGE_EXTENSION;
$last_plink = ADMIN_URL.'/pages/modify.php?page_id='.$pages[0]['page_id'];

//$result = print_r($last_plink_intern);

$count_pages = $database->get_one("SELECT COUNT(*) FROM `".TABLE_PREFIX."pages`");
$count_section = $database->get_one("SELECT COUNT(*) FROM `".TABLE_PREFIX."sections` ");
$count_sections = ($count_section -1);




$page_values = array(
	'ADMIN_URL'	=> ADMIN_URL,
	'THEME_URL'	=> THEME_PATH,
	'LEPTON_URL' => LEPTON_URL,
	'count_sections' => $count_sections,
	'count_pages' => $count_pages,
	'last_pmodified' => $last_pmodified,
	'last_plink' => $last_plink,	
	'MESSAGE.PAGES_LAST_MODIFIED'	=> $MESSAGE['PAGES_LAST_MODIFIED']

);

echo $parser->render(
	'@theme/dashboard.lte',
	$page_values
);

$admin->print_footer();

?>
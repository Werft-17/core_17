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

// exec initial_page
if(file_exists(LEPTON_PATH .'/modules/initial_page/classes/class.init_page.php') && isset($_SESSION['USER_ID'])) {
	require_once (LEPTON_PATH .'/modules/initial_page/classes/class.init_page.php');
	$ins = new class_init_page($database, $_SESSION['USER_ID'], $_SERVER['SCRIPT_NAME']);
}
require_once(LEPTON_PATH.'/framework/class.admin.php');
$admin = new admin('Start','start');

$page_values = array(
	'ADMIN_URL'	=> ADMIN_URL,
	'THEME_URL'	=> THEME_URL,
	'LEPTON_URL' => LEPTON_URL,
	'MENU.DASHBOARD'	=> $HEADING['ADMINISTRATION_TOOLS']

);

echo $parser->render(
	'@theme/start.lte',
	$page_values
);

$admin->print_footer();

?>
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

// Make sure people are allowed to access this page
if(MANAGE_SECTIONS != 'enabled') {
	header('Location: '.ADMIN_URL.'/pages/index.php');
	exit(0);
}

require_once(LEPTON_PATH."/include/jscalendar/jscalendar-functions.php");

// Get page id
if(!isset($_GET['page_id']) OR !is_numeric($_GET['page_id'])) {
	header("Location: index.php");
	exit(0);
} else {
	$page_id = $_GET['page_id'];
}

// Create new admin object
require_once(LEPTON_PATH.'/framework/class.admin.php');
$admin = new admin('Pages', 'pages_modify');

// Get perms
$results_array = array();
$database->execute_query(
	"SELECT `admin_groups`,`admin_users` FROM `".TABLE_PREFIX."pages` WHERE `page_id`= '".$page_id."'",
	true,
	$results_array,
	false
);
// echo LEPTON_tools::display( $results_array );

$old_admin_groups = explode(',', $results_array['admin_groups']);
$old_admin_users = explode(',', $results_array['admin_users']);
$in_old_group = FALSE;

foreach($admin->get_groups_id() as $cur_gid){
    if (in_array($cur_gid, $old_admin_groups)) {
        $in_old_group = TRUE;
    }
}
if((!$in_old_group) AND !is_numeric(array_search($admin->get_user_id(), $old_admin_users))) {
	$admin->print_error($MESSAGE['PAGES_INSUFFICIENT_PERMISSIONS']);
}

// Get page details
$results_array = array();
$database->execute_query(
	"SELECT count(*) FROM `".TABLE_PREFIX."pages` WHERE `page_id`='".$page_id."'",
	true,
	$results_array,
	false
);
if($database->is_error()) {
	$admin->print_header();
	$admin->print_error($database->get_error());
}
if(count($results_array) == 0) {
	$admin->print_header();
	$admin->print_error($MESSAGE['PAGES_NOT_FOUND']);
}

// Set module permissions
$module_permissions = $_SESSION['MODULE_PERMISSIONS'];

// Loop through sections
//	Aldus: 2014-10-24 - M.f.i. for new DB functions.
$all_sections = array(); 
$database->execute_query(
	"SELECT `section_id`,`module`,`position` FROM `".TABLE_PREFIX."sections` WHERE `page_id`= '".$page_id."' ORDER BY `position` ASC",
	true,
	$all_sections,
	true
);

foreach( $all_sections as $section)
{
	if(!is_numeric(array_search($section['module'], $module_permissions)))
	{
		// Update the section record with properties
		$section_id = $section['section_id'];
		
		$fields = array(
			'publ_start'	=> 0,
			'publ_end'		=> 0
		);

		//	[1]	Blocks
		if(isset($_POST['block'.$section_id]) AND $_POST['block'.$section_id] != '')
		{
			$fields['block'] = addslashes($_POST['block'.$section_id]);
		}

		//	[2]	Start date
		if( true === isset($_POST['start_date'.$section_id]) )
		{
			$start_date = trim($_POST['start_date'.$section_id]);
			if( ($start_date != "") && ($start_date != 0 ))
			{
				$fields['publ_start'] = jscalendar_to_timestamp( $start_date );
			}
		}

		//	[3] End date
		if( true === isset($_POST['end_date'.$section_id]) )
		{
			$end_date = trim($_POST['end_date'.$section_id]);
			if( ($end_date != "") && ($end_date != 0 ))
			{
				$fields['publ_end'] = jscalendar_to_timestamp( $end_date );
			}
		}
		
		//	[4]	Name of the section
		if (isset($_POST['section_name'][$section_id]))
		{
			$fields['name'] = addslashes($_POST['section_name'][$section_id]);
		}
		
		$database->build_and_execute(
			'update',
			TABLE_PREFIX."sections",
			$fields,
			"`section_id` = ".$section_id
		);
	}
}
	
// Check for error or print success message
if(true === $database->is_error())
{
	$admin->print_error($database->get_error(), ADMIN_URL.'/pages/sections.php?page_id='.$page_id);
}
else
{
	$admin->print_success($MESSAGE['PAGES_SECTIONS_PROPERTIES_SAVED'], ADMIN_URL.'/pages/sections.php?page_id='.$page_id);
}

// Print admin footer
$admin->print_footer();

?>
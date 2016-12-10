<?php

/**
 * This file is part of LEPTON Core, released under the GNU GPL
 * Please see LICENSE and COPYING files in your package for details, specially for terms and warranties.
 *
 * NOTICE:LEPTON CMS Package has several different licenses.
 * Please see the individual license in the header of each single file or info.php of modules and templates.
 *
 * @author          LEPTON Project
 * @copyright       2017 LEPTON Project
 * @link            https://www.LEPTON-cms.org
 * @license         http://www.gnu.org/licenses/gpl.html
 * @license_terms   please see LICENSE and COPYING files in your package
 */

 /* only for direct test purposes 
 require_once('../../../config.php');
global $admin;
if (!is_object($admin))
{
    require_once(LEPTON_PATH . '/framework/class.admin.php');
    $admin = new admin('Addons', 'modules', false, false);
}
 */
// set error level
 ini_set('display_errors', 1);
 error_reporting(E_ALL|E_STRICT);

echo ('<h3>Current process : updating to LEPTON 3.0.0</h3>');

echo ('<h5>Current process : rename database fields</h5>'); 
$database->simple_query('UPDATE `' . TABLE_PREFIX . 'settings` SET `name` =\'mailer_routine\' WHERE `name` =\'mailer_routine\'');
$database->simple_query('UPDATE `' . TABLE_PREFIX . 'settings` SET `name` =\'mailer_default_sendername\' WHERE `name` =\'mailer_default_sendername\'');
$database->simple_query('UPDATE `' . TABLE_PREFIX . 'settings` SET `name` =\'mailer_smtp_host\' WHERE `name` =\'mailer_smtp_host\'');
$database->simple_query('UPDATE `' . TABLE_PREFIX . 'settings` SET `name` =\'mailer_smtp_auth\' WHERE `name` =\'mailer_smtp_auth\'');
$database->simple_query('UPDATE `' . TABLE_PREFIX . 'settings` SET `name` =\'mailer_smtp_username\' WHERE `name` =\'mailer_smtp_username\'');
$database->simple_query('UPDATE `' . TABLE_PREFIX . 'settings` SET `name` =\'mailer_smtp_password\' WHERE `name` =\'mailer_smtp_password\'');
die ('<h5>Rename database fields: successfull</h5>'); 

echo ('<h5>Current process : delete unneeded files</h5>'); 


// keep in mind to rework initialize.php

// delete config_sik
$sik_file = LEPTON_PATH.'/config_sik.php';
if (file_exists($sik_file)) {
	$result = unlink ($sik_file);
	if (false === $result) {
		echo "Cannot delete file ".$sik_file.". Please check file permissions and ownership or delete file manually.";
	}
}
// delete class.database
$database_file = LEPTON_PATH.'/framework/class.database.php';
if (file_exists($database_file)) {
	$result = unlink ($database_file);
	if (false === $result) {
		echo "Cannot delete file ".$database_file.". Please check file permissions and ownership or delete file manually.";
	}
}

echo "<h5>Delete files: successfull</h5>"; 


/**
 *  run upgrade.php of all modified modules
 *
 */
 echo '<h5>Current process : run modules upgrade.php</h5>';  
$upgrade_modules = array(

    "tiny_mce_4"	
);

foreach ($upgrade_modules as $module)
{
    $temp_path = LEPTON_PATH . "/modules/" . $module . "/upgrade.php";

    if (file_exists($temp_path))
        require($temp_path);
}
echo "<h5>run upgrade.php of modified modules: successfull</h5>";


// at last: set db to current release-no
 echo '<h5>set database to new release</h5>';
$database->simple_query('UPDATE `' . TABLE_PREFIX . 'settings` SET `value` =\'3.0.0\' WHERE `name` =\'lepton_version\'');


/**
 *  success message
 */
echo "<h3>update to LEPTON 3.0.0 successfull!</h3><br />"; 

?>

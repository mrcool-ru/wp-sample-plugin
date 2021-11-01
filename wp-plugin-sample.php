<?php

/**
 * Plugin Name: Defiant Test plugin
 * Description: This is a test plugin that logs user login and logout events
 * Version: 0.0.1
 * Author: Nikolay Ivanov
 */ 

 
 // If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	exit;
}

define( 'DEFIANT_TEST_PLUGIN_VERSION', '0.0.1' );

/**
 * Runs during plugin activation.
 */
function activate_defiant_test() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-defiant-test-installer.php';
	Defiant_Test_Installer::activate();
}

/**
 * Runs during plugin deactivation.
 */
function deactivate_defiant_test() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-defiant-test-installer.php';
	Defiant_Test_Installer::deactivate();
}


register_activation_hook( __FILE__, 'activate_defiant_test' );
register_deactivation_hook( __FILE__, 'deactivate_defiant_test' );


 /**
 * Auth logger class initialization.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/class-defiant-test-auth-logger.php';
global $wpdb;
$logger = new Defiant_Test_Auth_Logger($wpdb);
$logger->init();

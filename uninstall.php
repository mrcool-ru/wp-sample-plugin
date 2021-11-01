<?php

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

require_once plugin_dir_path( __FILE__ ) . 'includes/class-defiant-test-installer.php';
Defiant_Test_Installer::unistall();

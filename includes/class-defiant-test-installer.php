<?php

require_once plugin_dir_path( __FILE__ ) . 'class-defiant-test-auth-logger.php';

/**
 * Handles plugin (un)installation and (de)activation
 *
 * This class defines all code necessary to run during the plugin's activation and deactivation.
 *
 * @since      0.0.1
 * @package    Defiant_Test_Plugin
 * @subpackage Defiant_Test_Plugin/includes
 * @author     Nikolay Ivanov mrcool.ru@gmail.com
 */
class Defiant_Test_Installer
{
    public const OPTION_NAME = 'Defiant_Test_Active';
    
    /**
     * Activate plugin callback
     *
     * @since    0.0.1
     * @return void
     */
    public static function activate(): void
    {
        self::initDb();
        update_option(self::OPTION_NAME, 1);
    }

    /**
     * Deactivate plugin callback
     *
     * @since    0.0.1
     * @return void
     */
    public static function deactivate(): void
    {
        update_option(self::OPTION_NAME, 0);
    }
    
    /**
     * Uninstall plugin callback
     *
     * @since    0.0.1
     * @return void
     */
    public static function unistall(): void
    {
        delete_option(self::OPTION_NAME);
        global $wpdb;
        $table = Defiant_Test_Auth_Logger::TABLE_NAME;
        $wpdb->query("DROP TABLE IF EXISTS `$table`");
    }

    /**
     * Creates authorization log table
     *
     * @since    0.0.1
     * @return void
     */
    private static function initDb(): void
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $table = Defiant_Test_Auth_Logger::TABLE_NAME;

        $sql = "CREATE TABLE `$table` (
            id int unsigned NOT NULL AUTO_INCREMENT,
            user_id int unsigned NOT NULL,
            user_login varchar(255) NOT NULL,
            action ENUM('login', 'logout') NOT NULL,
            time timestamp DEFAULT NOW(),
            PRIMARY KEY  (id)
        ) $charset_collate;";

        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $sql );
	}
}

<?php

/**
 * Logs user login and logout events into DB table
 *
 * @since      0.0.1
 * @package    Defiant_Test_Plugin
 * @subpackage Defiant_Test_Plugin/includes
 * @author     Nikolay Ivanov mrcool.ru@gmail.com
 */
class Defiant_Test_Auth_Logger
{
    public const TABLE_NAME = 'dt_auth_log';
    
    private const ACTION_LOGIN = 'login';
    private const ACTION_LOGOUT = 'logout';

    /** @var wpdb WordPress database access abstraction class */
    private $wpdb;

    /**
     * Activate plugin callback
     *
     * @since    0.0.1
     * @param wpdb $wpdb WordPress database access abstraction class.
     *
     */
    public function __construct ($wpdb)
    {
        $this->wpdb = $wpdb;
    }

    /**
     * Registers authorization hooks
     *
     * @return void
     */
    public function init(): void
    {
        add_action('wp_login', [$this, 'logIn'], 10, 2);
        add_action('wp_logout', [$this, 'logOut'], 10, 1);
    }

    /**
     * Logs login action
     *
     * @since    0.0.1
     * @param string $user_login
     * @param WP_User $user
     *
     * @return void
     */
    public function logIn($user_login, $user): void
    {
        $this->logAction(self::ACTION_LOGIN, [
            'user_id'    => $user->ID,
            'user_login' => $user_login,
        ]);
    }

    /**
     * Logs logout action
     *
     * @since    0.0.1
     * @param int $user_id
     *
     * @return void
     */
    public function logOut($user_id): void
    {
        $user = get_user_by('id', $user_id);
        $this->logAction(self::ACTION_LOGOUT, [
            'user_id'    => $user_id,
            'user_login' => $user->get('user_login'),
        ]);
    }

    /**
     * Saves action data into authorization log table
     *
     * @since    0.0.1
     * @param string $action
     * @param array  $data Array(user_id => 1, user_login => login)
     *
     * @return void
     */
    private function logAction(string $action, array $data): void
    {
        $data['action'] = $action;
        $this->wpdb->insert(self::TABLE_NAME, $data);
    }
}

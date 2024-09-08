<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://letowp.dev
 * @since      1.0.0
 *
 * @package    Advanced_Search_Disabler
 * @subpackage Advanced_Search_Disabler/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Advanced_Search_Disabler
 * @subpackage Advanced_Search_Disabler/admin
 * @author     LetoWPDev <info@letowp.dev>
 */
class Advanced_Search_Disabler_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private string $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private string $version;

    private Advanced_Search_Disabler_Settings $settings;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        // Neue Klasse für die Einstellungen initialisieren
        $this->settings = new Advanced_Search_Disabler_Settings($plugin_name);


    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles(): void
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Advanced_Search_Disabler_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Advanced_Search_Disabler_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        //wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/advanced-search-disabler-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts(): void
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Advanced_Search_Disabler_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Advanced_Search_Disabler_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        //wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/advanced-search-disabler-admin.js', array('jquery'), $this->version, false);

    }

    public function register_settings(): void
    {
        // Registrierung von Einstellungen über die neue Klasse
        $this->settings->register_settings();
    }


    public function advanced_search_disabler_menu(): void
    {

        add_options_page(
            esc_html__('Advanced Search Disabler Settings', 'advanced-search-disabler'),
            'Advanced Search Disabler',
            'manage_options',
            $this->plugin_name . '-settings',
            array($this, 'display_options_page')
        );

    }

    public function display_options_page(): void
    {
        $this->settings->display_options_page();
    }

    public function advanced_search_disabler_widget(): void
    {
        unregister_widget('WP_Widget_Search');
    }

    public function advanced_search_disabler_remove_admin_bar_menu_search($wp_admin_bar): void
    {
        if ($wp_admin_bar->get_node('search')) {
            $wp_admin_bar->remove_menu('search');
        }
    }

}

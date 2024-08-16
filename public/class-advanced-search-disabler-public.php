<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://letowp.dev
 * @since      1.0.0
 *
 * @package    Advanced_Search_Disabler
 * @subpackage Advanced_Search_Disabler/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Advanced_Search_Disabler
 * @subpackage Advanced_Search_Disabler/public
 * @author     LetoWPDev <info@letowp.dev>
 */
class Advanced_Search_Disabler_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of the plugin.
     * @param string $version The version of this plugin.
     * @since    1.0.0
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
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

        //wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/advanced-search-disabler-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
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

        //wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/advanced-search-disabler-public.js', array('jquery'), $this->version, false);

    }

    public function advanced_search_disabler_parse_query($query): void
    {

        $options = get_option('advanced_search_disabler_option');

        if (empty($options['disabler_mode']) || $options['disabler_mode'] == 'exclude_post_ids' || current_user_can('manage_options')) {
            return;
        }

        if ($options['disabler_mode'] == 'logged_out_users' && is_user_logged_in()) {
            return;
        }

        if (is_search() & !is_admin()) {

            $query->is_search = false;
            $query->query_vars['s'] = false;
            $query->query['s'] = false;
            $query->set_404();

            if (isset($_GET['s'])) {
                unset($_GET['s']);
            }

            if (isset($_POST['s'])) {
                unset($_POST['s']);
            }

            if (isset($_REQUEST['s'])) {
                unset($_REQUEST['s']);
            }

            status_header(404);
            nocache_headers();

        }
    }

    public function advanced_search_disabler_init(): void
    {

        $options = get_option('advanced_search_disabler_option');

        if (empty($options['disabler_mode']) || $options['disabler_mode'] == 'exclude_post_ids' || current_user_can('manage_options')) {
            return;
        }

        if ($options['disabler_mode'] == 'logged_out_users' && is_user_logged_in()) {
            return;
        }

        //get_search_form
        add_filter('get_search_form', '__return_empty_string', 999);

        //unregister_block_type
        if (function_exists('unregister_block_type') && WP_Block_Type_Registry::get_instance()->is_registered('core/search')) {
            unregister_block_type('core/search');
        }
    }

    public function advanced_search_disabler_pre_get_posts($where, $query)
    {

        $options = get_option('advanced_search_disabler_option');

        if (empty($options['disabler_mode']) || $options['disabler_mode'] != 'exclude_post_ids' || current_user_can('manage_options')) {
            return $where;
        }

        if ($query->is_search() && !is_admin() && !empty($options['exclude_post_ids'])) {
            global $wpdb;

            $post_ids_to_exclude = explode(',', $options['exclude_post_ids']);

            $post_ids_to_exclude = array_map('intval', $post_ids_to_exclude);

            if (!empty($post_ids_to_exclude)) {
                $placeholders = implode(', ', array_fill(0, count($post_ids_to_exclude), '%d'));

                $where .= $wpdb->prepare(" AND {$wpdb->posts}.ID NOT IN ($placeholders)", ...$post_ids_to_exclude);
            }
        }

        return $where;

    }

}

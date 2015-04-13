<?php

/**
 * Theme functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 */
require_once(get_template_directory() . '/inc/responsiveImages.php');
require_once(get_template_directory() . '/inc/tabs.php');

if (!function_exists('gc_basetheme_setup')):

    /**
     * Sets up theme
     */
    function gc_basetheme_setup() {
        /**
         * Make theme available for translation
         * Translations can be filed in the /languages/ directory
         */
        load_theme_textdomain('gc_basetheme', get_template_directory() . '/languages');

        $locale = get_locale();
        $locale_file = get_template_directory() . "/languages/$locale.php";
        if (is_readable($locale_file))
            require_once( $locale_file );

        /**
         * This theme uses wp_nav_menu() in one location.
         */
        register_nav_menus(array(
            'primary' => 'TopBar Menu',
        ));

        //Theme support for thumbnails (posts & pages only)
        add_theme_support('post-thumbnails', array('post', 'page'));

        /**
         * Disable admin bar - it cocks up positionings of foundation tooltips & topbar menu
         */
        show_admin_bar(false);

        /**
         * Editor styles
         */
        add_editor_style();

        /**
         * Add support for Post Formats
         */
        //add_theme_support('post-formats', array('aside', 'audio', 'image', 'status'));

        /**
         * Custom image sizes
         *
         * These should be named to match Foundations media queries as they will be automatically used in
         *  Interchange for responsive images
         *
         * @see http://foundation.zurb.com/docs/components/interchange.html
         *
         */
        add_image_size('small', 640, 9999);
        add_image_size('medium', 1020, 9999);
        add_image_size('large', 1440, 9999);
        add_image_size('xlarge', 1600, 9999);
        //add_image_size('xxlarge', 1600, 9999);
    }

endif; // gc_basetheme_setup

/**
 * Tell WordPress to run gc_basetheme_setup() when the 'after_setup_theme' hook is run.
 */
add_action('after_setup_theme', 'gc_basetheme_setup');


/**
 * Replace the wordpress .sticky class with .wordpress-sticky
 *
 * .sticky conflicts with Foundation 5 Top Bar
 */
if (!function_exists('remove_sticky_class')) :

    function remove_sticky_class($classes) {
        $classes = array_diff($classes, array("sticky"));
        $classes[] = 'wordpress-sticky';
        return $classes;
    }

endif;
add_filter('post_class', 'remove_sticky_class');


/*
 * Add Foundation javascript.
 *
 * @see http://foundation.zurb.com/
 */
if (!function_exists('wf5bt_basetheme_enqueue_scripts')) :
    function wf5bt_basetheme_enqueue_scripts() {
      //App JS for inclusion just before </body> tag
        wp_enqueue_script(
                'appJs', get_stylesheet_directory_uri() . '/js/app.js', array('jquery'), false, true
        );

        // JS for inclusion in the head
        wp_enqueue_script(
                'headJs', get_stylesheet_directory_uri() . '/js/head.js', array('jquery')
        );
    }
endif;

add_action('wp_enqueue_scripts', 'wf5bt_basetheme_enqueue_scripts');

/**
 * Add Foundation menu markup to wordpress generated menus
 *
 * Add Dropdown class to Wordpress submenus
 */
class GC_walker_nav_menu extends Walker_Nav_Menu {

    // add classes to ul sub-menus
    function start_lvl(&$output, $depth) {
        // depth dependent classes
        $indent = ( $depth > 0 ? str_repeat("\t", $depth) : '' ); // code indent
        // build html
        $output .= "\n" . $indent . '<ul class="dropdown">' . "\n";
    }

}

if (!function_exists('wf5bt_menu_set_dropdown')) :

    /**
     * Add Foundation menu markup to wordpress generated menus
     *
     * Add has-dropdown class to parent menu items
     */
    function wf5bt_menu_set_dropdown($sorted_menu_items, $args) {
        $last_top = 0;
        foreach ($sorted_menu_items as $key => $obj) {
            // it is a top lv item?
            if (0 == $obj->menu_item_parent) {
                // set the key of the parent
                $last_top = $key;
            } else {
                $sorted_menu_items[$last_top]->classes['dropdown'] = 'has-dropdown';
            }
        }

        //print_r($sorted_menu_items);
        return $sorted_menu_items;
    }

endif;
add_filter('wp_nav_menu_objects', 'wf5bt_menu_set_dropdown', 10, 2);

/**
 * Add the wf5bt TinyMCE plugins
 */
function wf5bt_add_responsive_image_plugin_js($plugin_array) {
    if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
        $plugin_array['responsiveImagePlugin'] = get_bloginfo('template_url') . '/js/plugins/resplonsiveImagePlugin.js';
    }

    return $plugin_array;
}

add_filter('mce_external_plugins', 'wf5bt_add_responsive_image_plugin_js');


/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 */
function example_add_dashboard_widgets() {

	wp_add_dashboard_widget(
	'wf5bt_dashboard_widget',         // Widget slug.
	'Foundation 5 Base Theme',         // Title.
	'wf5bt_dashboard_widget_function' // Display function.
	);
}
add_action( 'wp_dashboard_setup', 'example_add_dashboard_widgets' );

/**
 * Create the function to output the contents of our Dashboard Widget.
*/
function wf5bt_dashboard_widget_function() {

	// Display whatever it is you want to show.
	echo "<p>You're running the Wordpress Foundation 5 Base Theme. ";
	echo "If you find this theme useful, please consider making a small donation via PayPal.</p>";
	echo "<p><a href='https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=U84T7QHDJH6FQ&lc=GB&item_name=Gareth%20Cooper&item_number=wf5bt&currency_code=GBP&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted' target='_blank' class='button'>Donate via PayPal</a></p>";
}

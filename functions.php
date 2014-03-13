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
require_once(get_template_directory() . '/inc/responsiveImageShortcode.php');

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
if (!function_exists('gc_basetheme_enqueue_scripts')) :

    function gc_basetheme_enqueue_scripts() {
        //Foundation Bootstrap
        wp_enqueue_script(
                'foundation', get_stylesheet_directory_uri() . '/js/foundation.min.js', array('jquery'), false, true
        );
    }

endif;

add_action('wp_enqueue_scripts', 'gc_basetheme_enqueue_scripts');

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

if (!function_exists('GC_menu_set_dropdown')) :

    /**
     * Add Foundation menu markup to wordpress generated menus
     * 
     * Add has-dropdown class to parent menu items
     */
    function GC_menu_set_dropdown($sorted_menu_items, $args) {
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
add_filter('wp_nav_menu_objects', 'GC_menu_set_dropdown', 10, 2);


if (!function_exists('gc_get_image_tag')) :

    /*
     * Manipulate the <img /> tag inserted by the html editor
     * Should output images compatible with foundation interchange
     * @see http://foundation.zurb.com/docs/components/interchange.html
     */

    function gc_get_image_tag($html, $id, $title) {
        $imageSizes = wp_get_attachment_metadata($id);

        //Output our image sizes using interchange for images format
        $dataInterchange = '';
        foreach ($imageSizes['sizes'] as $size => $info) {
            $dataInterchange .= '[';
            $attachment_image_src = wp_get_attachment_image_src($id, $size);
            $dataInterchange .= $attachment_image_src[0] . ', ';
            $dataInterchange .= '(' . $size . ')';
            $dataInterchange .= '],';
        }
        $dataInterchange = substr($dataInterchange, 0, -1);

        //Build the <img /> tag
        $full_size_image_source = wp_get_attachment_image_src($id, 'full');
        $html = sprintf('<img alt="%2$s" data-interchange="%1$s" /><noscript><img src="%3$s"></noscript>', $dataInterchange, $title, $full_size_image_source[0]);

        return $html;
    }

endif;
add_filter('get_image_tag', 'gc_get_image_tag', 10, 3);

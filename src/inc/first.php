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
include_once 'inc/gc_menu_walker.php';

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
     * Add support for Post Formats
     */
    //add_theme_support('post-formats', array('aside', 'audio', 'image', 'status'));

    /**
     * Custom image sizes
     * 
     * Define using:
     *       add_image_size('image-size-name', width, height);
     * e.g.  add_image_size('gc-archive', 600, 9999);
     */
    /**
     * Disable admin bar - it cocks up positionings of foundation tooltips
     */
    //show_admin_bar(false);
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
            'foundation', get_stylesheet_directory_uri() . '/bower_components/foundation/js/foundation.min.js', array('jquery'), false, true
    );
  }

endif;

add_action('wp_enqueue_scripts', 'gc_basetheme_enqueue_scripts');

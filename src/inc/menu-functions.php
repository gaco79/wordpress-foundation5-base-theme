<?php

/**
 * Add Foundation menu markup to wordpress generated menus
 */

/**
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

/**
 * Add has-dropdown class to parent menu items
 */
if (!function_exists('GC_menu_set_dropdown')) :

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

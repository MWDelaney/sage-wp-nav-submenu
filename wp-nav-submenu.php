<?php
namespace App;

/**
 * Get submenu items from a WordPress menu based on parent or sibling
 * Version: 1.0
 * Author: Michael W. Delaney
 * Credit to https://christianvarga.com/how-to-get-submenu-items-from-a-wordpress-menu-based-on-parent-or-sibling/
 * 
 */

// add hook
add_filter( 'wp_nav_menu_objects', function($sorted_menu_items, $args) {
  if ( isset( $args->sub_menu ) ) {
    $root_id = 0;
    
    // find the current menu item
    foreach ( $sorted_menu_items as $menu_item ) {
      if ( $menu_item->current ) {
        // set the root id based on whether the current menu item has a parent or not
        $root_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;
        break;
      }
    }
    
    // find the top level parent
    if ( ! isset( $args->direct_parent ) ) {
      $prev_root_id = $root_id;
      while ( $prev_root_id != 0 ) {
        foreach ( $sorted_menu_items as $menu_item ) {
          if ( $menu_item->ID == $prev_root_id ) {
            $prev_root_id = $menu_item->menu_item_parent;
            // don't set the root_id to 0 if we've reached the top of the menu
            if ( $prev_root_id != 0 ) $root_id = $menu_item->menu_item_parent;
            break;
          } 
        }
      }
    }
    $menu_item_parents = array();
    foreach ( $sorted_menu_items as $key => $item ) {
      // init menu_item_parents
      if ( $item->ID == $root_id ) $menu_item_parents[] = $item->ID;
      if ( in_array( $item->menu_item_parent, $menu_item_parents ) ) {
        // part of sub-tree: keep!
        $menu_item_parents[] = $item->ID;
      } else if ( ! ( isset( $args->show_parent ) && in_array( $item->ID, $menu_item_parents ) ) ) {
        // not part of sub-tree: away with it!
        unset( $sorted_menu_items[$key] );
      }
    }
    if(!$args->show_parent_only) {
      if(count($sorted_menu_items) > 1) {
        return $sorted_menu_items;
      }
      else {
        return array();
      }
    } else {
      return $sorted_menu_items;
    }
  } else {
    return $sorted_menu_items;
  }
}, 10, 2 );

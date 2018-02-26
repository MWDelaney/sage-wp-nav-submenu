# Sage 9 friendly method for getting `wp_nav_menu()` submenu items based on parent or sibling

This package is based entirely on [this code](https://christianvarga.com/how-to-get-submenu-items-from-a-wordpress-menu-based-on-parent-or-sibling/) from [levymetal](https://github.com/levymetal).

The instructions below are also taken from [levymetal](https://github.com/levymetal)'s excellent documentation.

To install, run the following in your Sage9-based theme directory:

```
composer require "mwdelaney/sage-wp-nav-submenu"
```

Include the submenu arguemnts in your wp_nav_menu function:

```php
wp_nav_menu( array(
  'menu'     => 'Menu Name',
  ...
  'sub_menu' => true
) );
```

By default, if you have many nested levels, this code will filter the menu by the absolute top level parent. If you want the menu to drill down dynamically by filtering the menu based on the direct parent, pass a “direct_parent” => true parameter to the wp_nav_menu call.

```php
wp_nav_menu( array(
  'menu'          => 'Menu Name',
  ...
  'sub_menu'      => true,
  'direct_parent' => true
) );
```

If you want to include the parent/root element in the menu, you can pass in a “show_parent” => true parameter to display the root level item.

```php
wp_nav_menu( array(
  'menu'        => 'Menu Name',
  ...
  'sub_menu'    => true,
  'show_parent' => true
) );
```

Of course, you can continue to use the standard wp_nav_menu parameters as well. For example, if you want to limit the number of nested children being displayed, you can use the `depth` parameter. Or of you don’t want the menu to be displayed, you can use the echo parameter.

<?php

/*  Copyright 2013 MarvinLabs (contact@marvinlabs.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/


class CUAR_AdminMenuHelper
{
    private static $MENU_SLUG = 'customer-area';
    private static $MENU_SEPARATOR = '<span class="cuar-menu-divider"></span>';

    /** @var CUAR_Plugin */
    private $plugin;

    /** @var CUAR_AdminAreaAddOn */
    private $aa_addon;

    public function __construct($plugin, $aa_addon)
    {
        $this->plugin = $plugin;
        $this->aa_addon = $aa_addon;

        add_action('admin_menu', array(&$this, 'build_admin_menu'));
    }

    /**
     * Build the administration menu
     */
    public function build_admin_menu()
    {
        // Add the top-level admin menu
        $this->add_main_menu_item();

        $submenus = array(
            $this->get_private_types_menu_items(),
            $this->get_users_menu_items(),
            $this->get_tools_menu_items()
        );

        foreach ($submenus as $submenu_items)
        {
            $separator_added = false;
            foreach ($submenu_items as $item)
            {
                $submenu_page_title = $item['page_title'];
                $submenu_title = $item['title'];
                $submenu_slug = $item['slug'];
                $submenu_function = $item['function'];
                $submenu_capability = $item['capability'];

                if ( !$separator_added)
                {
                    $separator_added = true;
                    $submenu_title = self::$MENU_SEPARATOR . $submenu_title;
                }

                add_submenu_page(self::$MENU_SLUG, $submenu_page_title, $submenu_title,
                    $submenu_capability, $submenu_slug, $submenu_function);
            }
        }
    }

    /**
     * Add the main menu item
     * @return string The main menu item slug
     */
    private function add_main_menu_item()
    {
        add_menu_page(__('WP Customer Area', 'cuar'),
            __('Customer Area', 'cuar'),
            'view-customer-area-menu',
            self::$MENU_SLUG, null, '', '2.1.cuar');

        add_submenu_page(self::$MENU_SLUG,
            __('About WP Customer Area', 'cuar'),
            __('About', 'cuar'),
            'view-customer-area-menu',
            self::$MENU_SLUG,
            array($this->aa_addon, 'print_dashboard')
        );
    }

    /**
     * Get all submenu items corresponding to private content type listing
     * @return array
     */
    private function get_private_types_menu_items()
    {
        $items = array();

        $types = array(
            'content'   => $this->plugin->get_content_types(),
            'container' => $this->plugin->get_container_types()
        );

        foreach ($types as $t => $private_types)
        {
            foreach ($private_types as $type => $desc)
            {
                $post_type = get_post_type_object($type);
                if (current_user_can($post_type->cap->edit_post) || current_user_can($post_type->cap->read_post))
                {
                    $items[] = array(
                        'page_title' => $desc['label-plural'],
                        'title'      => $desc['label-plural'],
                        'slug'       => $type,
                        'function'   => array($this->aa_addon, 'print_' . $t . '_list_page'),
                        'capability' => 'view-customer-area-menu'
                    );
                }
            }
        }

        $items = apply_filters('cuar/core/admin/submenu-items?group=private-types', $items);

        // Sort alphabetically
        usort($items, function ($a, $b)
        {
            return strcmp($a['title'], $b['title']);
        });

        return $items;
    }

    /**
     * Get all submenu items corresponding to user management (groups, CRM, ...)
     * @return array
     */
    private function get_users_menu_items()
    {
        $items = apply_filters('cuar/core/admin/submenu-items?group=users', array());

        // Sort alphabetically
        usort($items, function ($a, $b)
        {
            return strcmp($a['title'], $b['title']);
        });

        return $items;
    }

    /**
     * Get all submenu items corresponding to private content type listing
     * @return array
     */
    private function get_tools_menu_items()
    {
        $items = apply_filters('cuar/core/admin/submenu-items?group=tools', array());

        // Sort alphabetically
        usort($items, function ($a, $b)
        {
            return strcmp($a['title'], $b['title']);
        });

        return $items;
    }
}

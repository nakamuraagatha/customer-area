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

/**
 * Select methods by default
 *
 * @author Vincent Prat @ MarvinLabs
 */
class CUAR_PrivateFilesSelectMethods
{
    /** @var CUAR_Plugin */
    private $plugin;

    public function __construct($plugin)
    {
        $this->plugin = $plugin;

        add_filter('cuar/private-content/files/select-methods', array(&$this, 'register_select_methods'));
        add_action('cuar/private-content/files/render-select-method?id=classic-upload', array(&$this, 'render_classic_upload_form'));
        add_action('cuar/private-content/files/render-select-method?id=ftp-copy', array(&$this, 'render_ftp_copy_form'));
        add_action('cuar/private-content/files/render-select-method?id=ftp-move', array(&$this, 'render_ftp_move_form'));
    }

    /**
     * Add our default methods to select files
     *
     * @param array $methods
     *
     * @return array
     */
    public function register_select_methods($methods)
    {
        $methods['ftp-move'] = array(
            'label'   => __('Move from FTP folder', 'cuar'),
            'caption' =>
                __('Below are the files listed from the FTP folder you have set. Those files will be moved to their final location', 'cuar')
        );

        $methods['classic-upload'] = array(
            'label'   => __('Classic upload', 'cuar'),
            'caption' =>
                __('Select the files you want to upload, they will be processed when you save the post', 'cuar')
        );

        $methods['ftp-copy'] = array(
            'label'   => __('Copy from FTP folder', 'cuar'),
            'caption' =>
                __('Below are the files listed from the FTP folder you have set. Those files will be copied to their final location', 'cuar')
        );

        return $methods;
    }

    public function render_classic_upload_form()
    {
        $template = $this->plugin->get_template_file_path(
            CUAR_INCLUDES_DIR . '/core-addons/private-file',
            'private-files-upload-select-classic-upload.template.php',
            'templates');

        include($template);
    }

    public function render_ftp_move_form() { $this->render_ftp_form('move'); }

    public function render_ftp_copy_form() { $this->render_ftp_form('copy'); }

    private function render_ftp_form($ftp_operation)
    {
        /** @var CUAR_PrivateFileAddOn $pf_addon */
        $pf_addon = $this->plugin->get_addon('private-files');

        $ftp_dir = trailingslashit($pf_addon->get_ftp_path());
        $ftp_files = array();
        if (file_exists($ftp_dir))
        {
            $ftp_files = scandir($ftp_dir);
        }

        $template = $this->plugin->get_template_file_path(
            CUAR_INCLUDES_DIR . '/core-addons/private-file',
            'private-files-upload-select-ftp-folder.template.php',
            'templates');

        include($template);
    }

    /**
     * Supporting function for displaying the dropdown select box
     * for empty FTP upload directory or not.
     * Adapted from http://stackoverflow.com/a/7497848/1177153
     */
    public function is_dir_empty($dir)
    {
        if ( !is_readable($dir)) return null;
        $handle = opendir($dir);
        while (false !== ($entry = readdir($handle)))
        {
            if ($entry != "." && $entry != "..")
            {
                return false;
            }
        }

        return true;
    }
}
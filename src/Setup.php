<?php
/**
 * Setup everything that runs the plugin
 */

namespace WPDisablePage;

class Setup {

    /**
     * Plugin ID
     */
    const PLUGIN_ID = 'WP_Disable_Page';

    /**
     * Plugin Name
     */
    const PLUGIN_NAME = 'WP Disable Page';

    /**
     * Initialization of the plugin
     */
    public function init() {
        \WPDisablePage\Admin\CreateMetaBox::init();
    }

}
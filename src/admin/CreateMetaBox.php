<?php

namespace WPDisablePage\Admin;

class CreateMetaBox {

    /**
     * Available on which post types
     */
    const POST_TYPES = 'page';

    /**
     * Where should the box be displayed?
     */
    const POSITION = 'side';

    /**
     * What order should the box be displayed in
     */
    const PRIORITY = 'core';

    /**
     * Runs all the fancy actions and filters to create our meta box.
     * 
     * @since 07/17/2018
     * @author Tyler Steinhaus
     */
    public function init() {
        add_action( 'add_meta_boxes', array( __CLASS__, 'createMetaBox' ) );
    }

    /**
     * Create the post meta box for our fields.
     * 
     * @since 07/17/2018
     * @author Tyler Steinhaus
     */
    public function createMetaBox() {
        add_meta_box( 
            \WPDisablePage\Setup::PLUGIN_ID, // Metabox ID
            \WPDisablePage\Setup::PLUGIN_NAME, // Metabox Name
            array( __CLASS__, 'createView' ), // Metabox Callback
            self::POST_TYPES, // Metabox Post Types
            self::POSITION, // Metabox Position
            self::PRIORITY // Metabox Priority
        );
    }

    public function createView() {
        require( WPDisablePage_DIR . '/src/templates/admin/meta_box.phtml' );
    }
}
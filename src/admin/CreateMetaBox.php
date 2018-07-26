<?php

namespace WPDisablePage\Admin;

class CreateMetaBox {

    /**
     * Available on which post types
     */
    const POST_TYPES = array( 'post', 'page' );

    /**
     * Where should the box be displayed?
     */
    const POSITION = 'side';

    /**
     * What order should the box be displayed in
     */
    const PRIORITY = 'low';

    /**
     * WP Nonce Action
     */
    const NONCE_ACTION = 'WP_Disable_Page_Save';

    /**
     * WP Nonce Name
     */
    const NONCE_NAME = 'WP_Disable_Page';

    /**
     * Runs all the fancy actions and filters to create our meta box.
     * 
     * @since 07/17/2018
     * @author Tyler Steinhaus
     */
    public function init() {
        add_action( 'add_meta_boxes', array( __CLASS__, 'createMetaBox' ) );
        add_actioN( 'save_post', array( __CLASS__, 'saveMetaData' ) );
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
            apply_filters( strtolower( \WPDisablePage\Setup::PLUGIN_ID ) . '__post_types', self::POST_TYPES ), // Metabox Post Types
            self::POSITION, // Metabox Position
            self::PRIORITY // Metabox Priority
        );
    }

    /**
     * Display's our meta box
     * 
     * @param $post \WP_Post
     * 
     * @since 07/17/2018
     * @author Tyler Steinhaus
     */
    public function createView( \WP_Post $post ) {
        require( WPDisablePage_DIR . '/src/templates/admin/meta_box.phtml' );
    }

    /**
     * Save the post meta data from our plugin
     * 
     * @param $post_id int
     * 
     * @since 07/17/2018
     * @author Tyler Steinhaus
     */
    public function saveMetaData( $post_id ) {
        // Check to see if multiple items should flag so the data isn't saved
        if( 
            !wp_verify_nonce( $_POST[self::NONCE_NAME], self::NONCE_ACTION )
        ) {
            return;
        }

        // Set the data we want to be saved
        $is_disabled = ( isset( $_POST['wp_disable_page__is_disabled'] ) && $_POST['wp_disable_page__is_disabled'] != '' ) ? $_POST['wp_disable_page__is_disabled'] : '0';
        $url = ( isset( $_POST['wp_disable_page__url'] ) && $_POST['wp_disable_page__url'] != '' ) ? $_POST['wp_disable_page__url'] : '';

        // Save the data
        update_post_meta( $post_id, 'wp_disable_page__is_disabled', $is_disabled );
        update_post_meta( $post_id, 'wp_disable_page__url', $url );
    }
} 
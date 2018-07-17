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
        add_action( 'wp', array( __CLASS__, 'setupFrontend' ) );
    }

    /**
     * Figure out if the page needs to redirect or 404.
     * 
     * @since 07/17/2018
     * @author Tyler Steinhaus
     */
    public function setupFrontend() {
        global $post, $wp_query;

        $is_disabled = (bool) get_post_meta( $post->ID, 'wp_disable_page__is_disabled', true );
        if( $is_disabled ) {
            $redirect_url = get_post_meta( $post->ID, 'wp_disable_page__url', true );

            if( !empty( $redirect_url ) ) {
                header("HTTP/1.1 301 Moved Permanently"); 
                header( 'Location: ' . $redirect_url );
            } else {
                $wp_query->set_404();
                status_header( 404 );
                get_template_part( 404 );
            }
        }
    }

}
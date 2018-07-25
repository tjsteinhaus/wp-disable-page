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

        if( !in_array( $post->post_type, \WPDisablePage\Admin\CreateMetaBox::POST_TYPES ) ) {
            return false;
        }

        add_action( 'pre_get_posts', array( __CLASS__, 'modifyWPQuery' ) );

        if( is_single() || is_page() ) {
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

    /**
     * Modify the WP Query so we never see disabled pages
     * 
     * @since 07/18/2018
     * @author Tyler Steinhaus
     */
    public function modifyWPQuery( $query ) {   
        if( !is_admin() ) {
            global $wpdb;

            $exclude_posts = $wpdb->get_col( "SELECT post_id from $wpdb->postmeta WHERE meta_key = 'wp_disable_page__is_disabled' && meta_value = '1'" );

            $query->set( 'post__not_in', $exclude_posts );
        }
    }
}
<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt Disable XML-RPC
 * Plugin URI:        https://www.kntnt.com/
 * Description:       Disables XML-RPC (and pingback).
 * Version:           1.0.0
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */


// Die if XML-RPC request.
if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
    wp_die( __( 'XML-RPC services are disabled on this site.' ), 403 );
}

// Disable XML-RPC by removing all methods.
add_filter( 'xmlrpc_methods', '__return_empty_array', PHP_INT_MAX );

// Don't announce the XML-RPC endpoint for the Really Simple Discovery.
remove_action( 'wp_head', 'rsd_link' );

// Don't announce the XML-RPC endpoint for the Windows Live Writer.
remove_action( 'wp_head', 'wlwmanifest_link');

// Don't announce the XML-RPC endpoint for pingback.
add_filter( 'wp_headers', function ( $headers ) {
    unset( $headers['X-Pingback'] );
    return $headers;
}, PHP_INT_MAX );

// Remove the XML-RPC endpoint for pingback from bloginfo().
add_filter( 'bloginfo_url', function ( $output, $show ) {
    return 'pingback_url' === $show ? false : $output;
}, PHP_INT_MAX, 2 );

// Close pings for all posts.
add_filter( 'pings_open', '__return_false', PHP_INT_MAX, 2 );

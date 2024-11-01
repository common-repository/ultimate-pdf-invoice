<?php
/*
Plugin Name: Ultimate PDF Invoice
Description: Easy and automatically generate and attach customizable PDF Invoices to WooCommerce emails.
Version: 1.0
Author: VJInfotech
Author URI: http://www.vjinfotech.com

*/
if (!defined('ABSPATH'))
    die("Can't load this file directly");

global $wpdb;

// Plugin version
if ( ! defined( 'UPI_PLUGIN_VERSION' ) ) {
	define( 'UPI_PLUGIN_VERSION', '1.0' );
}

// Plugin Folder Path
if ( ! defined( 'UPI_PLUGIN_DIR' ) ) {
	define( 'UPI_PLUGIN_DIR', WP_PLUGIN_DIR.'/'.dirname(plugin_basename( __FILE__ )) );
}

if(is_ssl()){
    define('UPI_PLUGIN_URL', str_replace('http://', 'https://', WP_PLUGIN_URL.'/ultimate-pdf-invoice'));
	define('UPI_CURRENT_PLUGIN_URL', str_replace('http://', 'https://', WP_PLUGIN_URL));
}else{
    define('UPI_PLUGIN_URL', WP_PLUGIN_URL.'/ultimate-pdf-invoice');
	define('UPI_CURRENT_PLUGIN_URL', WP_PLUGIN_URL);
}
	
global $upi_ajaxurl;

$upi_ajaxurl = admin_url('admin-ajax.php');
	
if ( ! defined( 'UPI_CSS_URL' ) )
	define( 'UPI_CSS_URL', UPI_PLUGIN_URL.'/css' );

if ( ! defined( 'UPI_JS_URL' ) )
	define( 'UPI_JS_URL', UPI_PLUGIN_URL.'/js' );
	
if ( ! defined( 'UPI_IMAGES_URL' ) )
	define( 'UPI_IMAGES_URL', UPI_PLUGIN_URL.'/images' );
	
if ( ! defined( 'UPI_CORE_DIR' ) )
	define( 'UPI_CORE_DIR', UPI_PLUGIN_DIR.'/core' );

if ( ! defined( 'UPI_CLASSES_DIR' ) )
	define( 'UPI_CLASSES_DIR', UPI_CORE_DIR.'/classes' );
		
if ( ! defined( 'UPI_VIEW_DIR' ) )
	define( 'UPI_VIEW_DIR', UPI_CORE_DIR.'/views' );

if ( ! defined( 'UPI_LIB_DIR' ) )
	define( 'UPI_LIB_DIR', UPI_PLUGIN_DIR.'/lib' );
	
if ( ! defined( 'UPI_TEXTDOMAIN' ) )
	define( 'UPI_TEXTDOMAIN', 'ultimate-pdf-invoice' );
	
// Plugin site path
if ( ! defined( 'UPI_PLUGIN_SITE' ) ) 
{
	define( 'UPI_PLUGIN_SITE', 'http://www.vjinfotech.com' );	
}	
$wpupload_dir 	= wp_upload_dir();
$upi_upload_dir = $wpupload_dir['basedir'].'/ultimate-pdf-invoice';
$upi_upload_url = $wpupload_dir['baseurl'].'/ultimate-pdf-invoice';

define('UPI_UPLOAD_DIR', $upi_upload_dir);

define('UPI_UPLOAD_URL', $upi_upload_url);

wp_mkdir_p($upi_upload_dir);

global $upi_pdf_invoice, $upi_invoice;
		
if(file_exists(UPI_CLASSES_DIR . '/upi_pdf_invoice.class.php'))
{
	require_once( UPI_CLASSES_DIR . '/upi_pdf_invoice.class.php' );

	$upi_pdf_invoice = new upi_pdf_invoice();	
}
if(file_exists(UPI_CLASSES_DIR . '/upi_invoice.class.php'))
{
	require_once( UPI_CLASSES_DIR . '/upi_invoice.class.php' );

	$upi_invoice = new upi_invoice();	
}
?>
<?php

if (!defined('ABSPATH'))
    die("Can't load this file directly");
	
class upi_pdf_invoice{

	function upi_pdf_invoice()
	{
		register_activation_hook( UPI_PLUGIN_DIR .'/ultimate-pdf-invoice.php',  array('upi_pdf_invoice', 'upi_install_data' ) );
		
		register_uninstall_hook(UPI_PLUGIN_DIR .'/ultimate-pdf-invoice.php', array( 'upi_pdf_invoice', 'upi_uninstall' ) );
		
		global $woocommerce;
    	
		$plugins = get_option('active_plugins');
		
		if(!function_exists('is_plugin_active_for_network'))
		{
			require_once(ABSPATH.'wp-admin/includes/plugin.php');
		}
	
		$required_woo_plugin = 'woocommerce/woocommerce.php';
			
		if (in_array( $required_woo_plugin , $plugins ) || is_plugin_active_for_network($required_woo_plugin)) {
		
			if( class_exists( 'Woocommerce' ) ){
				$this->upi_set_action();
			}else{
				add_action( 'woocommerce_loaded', array( &$this, 'upi_set_action' ) );
			}
		}
		
	}
	
	function upi_set_action()
	{
		add_action( 'plugins_loaded', array( &$this, 'upi_load_textdomain' ) );
		
		add_action( 'admin_enqueue_scripts', array( &$this, 'upi_set_admin_css' ),10);
				
		add_action( 'admin_enqueue_scripts', array( &$this, 'upi_set_admin_js' ),10);
		
		add_action( 'admin_menu', array( &$this, 'upi_set_menu' ) );
		
		add_action('admin_init', array(&$this, 'upi_db_check'));
  		
		add_action( 'admin_head',  array($this, 'upi_hide_all_notice_to_admin_side'), 10000 );
		
		add_filter('admin_footer_text', array(&$this, 'upi_replace_footer_admin'));
				
		add_filter( 'update_footer', array(&$this, 'upi_replace_footer_version'), '1234');
		
  	} 
	
	function upi_install_data()
	{
		
		$upi_plugin_version = get_option('upi_plugin_version');
		
		if( !isset($upi_plugin_version) || $upi_plugin_version ==''  ) 
		{
				global $upi_invoice;
				
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
								
				$charset_collate = '';
		
				if( $wpdb->has_cap( 'collation' ) ){
		
					if( !empty($wpdb->charset) )
						$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
	
					if( !empty($wpdb->collate) )
						$charset_collate .= " COLLATE $wpdb->collate";
				}
				
				update_option('upi_plugin_version', UPI_PLUGIN_VERSION);
				
				$upi_invoice_template = $wpdb->prefix.'upi_invoice_template';
				
				$upi_invoice_template_table = "CREATE TABLE IF NOT EXISTS {$upi_invoice_template}(
									 template_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
									 template_name VARCHAR(50) NOT NULL, 
									 template_key VARCHAR(20) NOT NULL, 
 									 template_options LONGTEXT NOT NULL,
									 create_date DATETIME NOT NULL 
 									 ){$charset_collate}";
				
				dbDelta($upi_invoice_template_table);
				
				$upi_invoice -> upi_install_templates();
 
		}	
		
	}
	
	function upi_db_check()
	{
		global $upi_pdf_invoice;
		
		$upi_plugin_version = get_option('upi_plugin_version');
 	
		if(( !isset($upi_plugin_version) || $upi_plugin_version =='') && is_multisite() ) 
		{
			$upi_pdf_invoice->upi_install_data();
		}
	}
	
	function upi_uninstall()
	{
 					
 			global $wpdb;
			
			if ( is_multisite() ) {	
				
				$blogs = $wpdb->get_results("SELECT blog_id FROM {$wpdb->blogs}", ARRAY_A);
				
				if ($blogs) {
				
					foreach($blogs as $blog) {
					
						switch_to_blog($blog['blog_id']);
						
  						delete_option('upi_plugin_version');
						
						$upi_invoice_template = $wpdb->prefix.'upi_invoice_template';
				 
						$wpdb->query("DROP TABLE IF EXISTS $upi_invoice_template");
						
						delete_option('upi_order_invoice_no');
					}
					restore_current_blog();
				}
				
			} else {		
  						delete_option('upi_plugin_version');
						
						delete_option('upi_order_invoice_no');
						
						$upi_invoice_template = $wpdb->prefix.'upi_invoice_template';
				 
						$wpdb->query("DROP TABLE IF EXISTS $upi_invoice_template");
 			}
		
	}
	
	function upi_load_textdomain()
	{
		load_plugin_textdomain( UPI_TEXTDOMAIN,false,'ultimate-pdf-invoice/languages/' );
	}
	
	function upi_set_admin_css()
	{
		wp_register_style( 'upi_admin_css',UPI_CSS_URL.'/upi_admin.css');
		
		
		if(isset($_REQUEST['post_type']) && $_REQUEST['post_type'] == "shop_order")
		{
			wp_register_style( 'upi_admin_all_css',UPI_CSS_URL.'/upi_admin_all.css');
			
			wp_enqueue_style( 'upi_admin_all_css' );
		}
		
		if(isset($_REQUEST['page']) &&  ($_REQUEST['page'] == 'upi-ultimate-pdf-invoice' || $_REQUEST['page'] == 'upi-invoice-settings' || $_REQUEST['page'] == 'upi-invoice-download-pdf'))
		{
			wp_enqueue_style( 'upi_admin_css' );
		}
		if(isset($_REQUEST['page']) &&  ($_REQUEST['page'] == 'upi-ultimate-pdf-invoice' && isset($_REQUEST['template_id'])))
		{
			if(file_exists(UPI_PLUGIN_DIR.'/css/templates/template_'.$_REQUEST['template_id'].'.css'))
			{
				wp_register_style( 'upi_template_css', UPI_CSS_URL.'/templates/template_'.$_REQUEST['template_id'].'.css');
				
				wp_enqueue_style( 'upi_template_css' );
				
				wp_enqueue_style( 'wp-color-picker');
			}
		}
		
	}
	
	function upi_set_admin_js()
	{
		global $upi_ajaxurl;
		
		wp_register_script( 'upi_admin_js',UPI_JS_URL.'/upi_admin.js');
		
		wp_register_script( 'upi_form_min_js',UPI_JS_URL.'/upi.form.min.js');
				
		if(isset($_REQUEST['page']) &&  ($_REQUEST['page'] == 'upi-ultimate-pdf-invoice' || $_REQUEST['page'] == 'upi-invoice-settings' || $_REQUEST['page'] == 'upi-invoice-download-pdf'))
		{
			wp_enqueue_script( 'jquery' );
			
 			wp_enqueue_script( 'upi_admin_js',array('jquery'));
			
			$upi_is_user_logged = (is_user_logged_in()) ? 1 : 0;
			
			$upi_localize_script_data = array(
			
					'upi_ajax_url' 	=> $upi_ajaxurl,
					
					'upt_site_url'  => site_url(),
					
					'plugin_url'    => UPI_UPLOAD_URL, 
					
					'plugin_dir'	=> UPI_UPLOAD_DIR,
					
					'user_logged_in'=> $upi_is_user_logged
			);
			
			wp_localize_script( 'upi_admin_js', 'upi_invoice_data', $upi_localize_script_data );
 		}
		
		if(isset($_REQUEST['page']) &&  ($_REQUEST['page'] == 'upi-ultimate-pdf-invoice' && isset($_REQUEST['template_id'])))
		{
			wp_enqueue_script( 'upi_form_min_js' ,array('jquery'));
			
			wp_enqueue_script( 'wp-color-picker',array('jquery'));
		}
	}
	
	function upi_hide_all_notice_to_admin_side()
	{
 		if(isset($_REQUEST['page']) &&  ($_REQUEST['page'] == 'upi-ultimate-pdf-invoice' || $_REQUEST['page'] == 'upi-invoice-settings'))
		{
			remove_all_actions( 'admin_notices',10000 );
			
			remove_all_actions( 'all_admin_notices',10000 );
			
			remove_all_actions( 'network_admin_notices',10000 );
			
			remove_all_actions( 'user_admin_notices',10000 );
			
		}
	}
	
	function upi_set_menu()
	{
		global $upi_pdf_invoice, $current_user;
		
		if(current_user_can('administrator')  || is_super_admin())
		{
 			$upi_caps= $upi_pdf_invoice->upi_capabilities();
			
			foreach($upi_caps as $upi_cap => $cap_desc)
			{
				$current_user->add_cap( $upi_cap );
			}
		}
		
  		$menu_place = $upi_pdf_invoice->get_dynamic_position(28.1 , .1);
				
		add_menu_page( __('Ultimate PDF Invoice',UPI_TEXTDOMAIN),  __('Ultimate Invoice',UPI_TEXTDOMAIN), 'upi_manage_invoice', 'upi-ultimate-pdf-invoice', array(&$this,'upi_get_page'),UPI_IMAGES_URL.'/upi_logo.png',(string)$menu_place);

		add_submenu_page( 'upi-ultimate-pdf-invoice', __('Ultimate PDF Invoice',UPI_TEXTDOMAIN), __('Templates',UPI_TEXTDOMAIN), 'upi_manage_invoice', 'upi-ultimate-pdf-invoice', array(&$this,'upi_get_page')) ;
		
		add_submenu_page( 'upi-ultimate-pdf-invoice', __('Settings',UPI_TEXTDOMAIN), __('Settings',UPI_TEXTDOMAIN), 'upi_invoice_settings', 'upi-invoice-settings', array(&$this,'upi_get_page'));
		
		add_submenu_page( 'upi-ultimate-pdf-invoice', __('Download Pdf',UPI_TEXTDOMAIN), __('Download Pdf',UPI_TEXTDOMAIN), 'upi_invoice_download_pdf', 'upi-invoice-download-pdf', array(&$this,'upi_get_page'));
		
  	}
	
	function upi_get_page()
	{
		global $upi_pdf_invoice;
		
		if( isset($_REQUEST['page']) and $_REQUEST['page'] == 'upi-ultimate-pdf-invoice'){	
			
			if( isset($_REQUEST['template_id']) and $_REQUEST['template_id'] != ''){
			
				$upi_pdf_invoice->upi_get_invoice_template();
			}
			else
			{
				$upi_pdf_invoice->upi_get_invoice();
			}
			
		}else if( isset($_REQUEST['page']) and $_REQUEST['page'] == 'upi-invoice-settings' ){	
			
			$upi_pdf_invoice->upi_get_settings();
		}
		else if( isset($_REQUEST['page']) and $_REQUEST['page'] == 'upi-invoice-download-pdf' ){	
			
			$upi_pdf_invoice->upi_get_download_pdf();
		}
		
	}
	
	function upi_capabilities()
	{
		$cap = array(
		
			'upi_manage_invoice' => __('manage woocommerce Ultimate PDF Invoice.', UPI_TEXTDOMAIN),

			'upi_invoice_settings' => __('manage woocommerce Ultimate PDF Invoice settings.', UPI_TEXTDOMAIN),
			
			'upi_invoice_download_pdf' => __('Download pdf invoice.', UPI_TEXTDOMAIN),
		);

		return $cap;
	}
	
	function get_dynamic_position($start, $increment = 0.1)
	{
			foreach ($GLOBALS['menu'] as $key => $menu) {
				$menus_positions[] = $key;
			}
			if (!in_array($start, $menus_positions)) return $start;
			
 			while (in_array($start, $menus_positions)) {
				$start += $increment;
			}
			return $start;
	}
	
	function upi_get_invoice()
	{
		if( file_exists( UPI_VIEW_DIR.'/upi_ultimate_invoice.php' ) ){
			include( UPI_VIEW_DIR.'/upi_ultimate_invoice.php' );
		}
	}
	
	function upi_get_settings()
	{
		if( file_exists( UPI_VIEW_DIR.'/upi_settings.php' ) ){
			include( UPI_VIEW_DIR.'/upi_settings.php' );
		}
	}
	
	function upi_get_invoice_template()
	{
		if( file_exists( UPI_VIEW_DIR.'/upi_template_editor.php' ) ){
			include( UPI_VIEW_DIR.'/upi_template_editor.php' );
		}
	}
	
	function upi_get_download_pdf()
	{
		if( file_exists( UPI_VIEW_DIR.'/upi_template_download_pdf.php' ) ){
			include( UPI_VIEW_DIR.'/upi_template_download_pdf.php' );
		}
	}
	
	function upi_replace_footer_admin()   
	{  
		echo '';
	}  
	
	function upi_replace_footer_version() 
	{
		return '';
	}
	
	function upi_set_time_limit($time)
	{
		$safe_mode = ini_get('safe_mode');
		
		if(!($safe_mode) || strtolower( $safe_mode ) == 'off' )
		{
			@set_time_limit($time);
		}
	}
}
?>
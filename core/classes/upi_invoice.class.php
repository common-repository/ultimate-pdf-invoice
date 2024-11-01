<?php

if (!defined('ABSPATH'))
    die("Can't load this file directly");
	
class upi_invoice{

	function upi_invoice()
	{
		add_action( 'wp_ajax_upi_update_invoice_logo', array( &$this, 'upi_update_invoice_logo' ));
		
		add_action( 'wp_ajax_upi_save_template', array( &$this, 'upi_save_template' ));
		
		add_action( 'wp_ajax_upi_save_invoice_settings', array( &$this, 'upi_save_invoice_settings' ));
		
		add_action( 'init', array( &$this, 'upi_generate_pdf' ));
		
		add_filter('woocommerce_email_attachments', array(&$this, 'upi_attach_invoice_to_email'), 99, 3);
		
		add_action( 'add_meta_boxes', array( &$this, 'upi_order_page_invoice_section' ) );
		
		add_action( 'woocommerce_admin_order_actions_end', array(&$this,'upi_order_list_page_download') );
		
		 add_action('woocommerce_my_account_my_orders_actions', array($this, 'upi_order_customer_list_page_download'), 10, 2);
		
	}
	function upi_install_templates()
	{
		global $wpdb, $upi_invoice;
		
		$template_data = $upi_invoice -> get_template_data();
				
		foreach($template_data as $new_template)
		{			
			$wpdb->insert($wpdb->prefix."upi_invoice_template", $new_template);	
		}
	}
	function get_template_data()
	{
		$template_data = array(
							
							array(
			
								'template_name' 	=> 'Template 1',
								
								'template_options'  => 'a:8:{s:24:"upi_header_logo_settings";a:3:{s:13:"logo_position";s:4:"none";s:10:"logo_image";s:30:"1452608574_upi_sample_logo.png";s:11:"logo_hidden";s:0:"";}s:25:"upi_from_address_settings";a:5:{s:7:"content";s:138:"<b>Example.com</b><br>
Example India Private Limited.<br>
103, Eden Park, #202, demo Road,<br>
Bangalore - 560001.<br>Karnataka. India.";s:8:"position";s:4:"left";s:10:"text_align";s:4:"left";s:9:"font_size";s:2:"18";s:9:"is_hidden";s:0:"";}s:23:"upi_to_address_settings";a:5:{s:7:"content";s:0:"";s:8:"position";s:4:"left";s:10:"text_align";s:4:"left";s:9:"font_size";s:2:"18";s:9:"is_hidden";s:0:"";}s:26:"upi_order_invoice_settings";a:5:{s:5:"title";s:7:"INVOICE";s:9:"font_size";s:2:"16";s:2:"bg";s:7:"#ddbf9f";s:3:"bg1";s:0:"";s:9:"is_hidden";s:0:"";}s:24:"upi_order_total_settings";a:5:{s:5:"title";s:0:"";s:9:"font_size";s:0:"";s:2:"bg";s:0:"";s:3:"bg1";s:0:"";s:9:"is_hidden";s:0:"";}s:28:"upi_product_history_settings";a:5:{s:16:"header_font_size";s:2:"19";s:14:"body_font_size";s:2:"16";s:9:"header_bg";s:7:"#d19268";s:7:"body_bg";s:7:"#e8ab7d";s:9:"is_hidden";s:0:"";}s:25:"upi_footer_upper_settings";a:4:{s:7:"content";s:21:"Thanks for your order";s:10:"text_align";s:6:"center";s:9:"font_size";s:2:"20";s:9:"is_hidden";s:0:"";}s:25:"upi_footer_lower_settings";a:4:{s:7:"content";s:119:"This is an electronically generated invoice requires no signature. Copyright © 2015 Example.com . All rights reserved.";s:10:"text_align";s:6:"center";s:9:"font_size";s:2:"12";s:9:"is_hidden";s:0:"";}}',
								
								'template_key'		=> '1451972063',
								
								'create_date' 		=> current_time('mysql')
							),
							array(
			
								'template_name' 	=> 'Template 2',
								
								'template_options'  => 'a:8:{s:24:"upi_header_logo_settings";a:3:{s:13:"logo_position";s:4:"none";s:10:"logo_image";s:0:"";s:11:"logo_hidden";s:0:"";}s:25:"upi_from_address_settings";a:5:{s:7:"content";s:132:"<b>Example.com</b><br>Example India Private Limited.<br>103, Eden Park, #202, demo Road,<br>Bangalore - 560001.<br>Karnataka. India.";s:8:"position";s:4:"left";s:10:"text_align";s:4:"left";s:9:"font_size";s:2:"16";s:9:"is_hidden";s:0:"";}s:23:"upi_to_address_settings";a:5:{s:7:"content";s:0:"";s:8:"position";s:4:"left";s:10:"text_align";s:4:"left";s:9:"font_size";s:2:"16";s:9:"is_hidden";s:0:"";}s:26:"upi_order_invoice_settings";a:5:{s:5:"title";s:11:"Invoice : #";s:9:"font_size";s:2:"18";s:2:"bg";s:7:"#91c300";s:3:"bg1";s:7:"#a3d512";s:9:"is_hidden";s:0:"";}s:24:"upi_order_total_settings";a:5:{s:5:"title";s:5:"Total";s:9:"font_size";s:2:"18";s:2:"bg";s:7:"#91c300";s:3:"bg1";s:7:"#a3d512";s:9:"is_hidden";s:0:"";}s:28:"upi_product_history_settings";a:5:{s:16:"header_font_size";s:2:"18";s:14:"body_font_size";s:2:"16";s:9:"header_bg";s:7:"#9ec134";s:7:"body_bg";s:7:"#b1d644";s:9:"is_hidden";s:0:"";}s:25:"upi_footer_upper_settings";a:4:{s:7:"content";s:21:"Thanks for your order";s:10:"text_align";s:6:"center";s:9:"font_size";s:2:"20";s:9:"is_hidden";s:0:"";}s:25:"upi_footer_lower_settings";a:4:{s:7:"content";s:119:"This is an electronically generated invoice requires no signature. Copyright © 2015 Example.com . All rights reserved.";s:10:"text_align";s:6:"center";s:9:"font_size";s:2:"12";s:9:"is_hidden";s:0:"";}}',
								
								'template_key'		=> '1451972064',
								
								'create_date' 		=> current_time('mysql')
							),
						);	
						
		return $template_data;
	}
	function upi_update_invoice_logo()
	{
		$return_value = array();
		
		if(isset($_FILES['upi_company_logo']['name']) && $_FILES['upi_company_logo']['name']!="")
		{
			$file_name = time().'_'.sanitize_file_name($_FILES['upi_company_logo']['name']);
			 
			if(move_uploaded_file($_FILES['upi_company_logo']['tmp_name'],UPI_UPLOAD_DIR.'/'.$file_name ))
			{
			
				$file_path = UPI_UPLOAD_URL.'/'.$file_name;
				
				$return_value['message']	= 'success';
				
				$return_value['file_url']	= $file_path;
				
				$return_value['file_name']	= $file_name;
		
				$return_value['message_content']	= __('Changes Saved Successfully.',UPI_TEXTDOMAIN);
			}
			else
			{
				$return_value['message']	= 'error';
				
				$return_value['message_text'] = __('File Not Uploaded. Please check file size for exceeds the limit.',UPI_TEXTDOMAIN);
			}
			
		}
					
		echo json_encode($return_value );
		
		die();
	}
	function upi_save_template()
	{
		global $wpdb;
		
		$return_value = array();
		
		$template_options = array();
		
		$template_id = isset($_POST['template_id'])?(int)sanitize_text_field($_POST['template_id']) : "";

		$template_name = isset($_POST['template_name'])?sanitize_text_field($_POST['template_name']):"";
		
		/*Header image data and settings*/
		
		$upi_header_logo_position = isset($_POST['upi_header_logo_position'])?sanitize_text_field($_POST['upi_header_logo_position']):"";
		
		$upi_header_logo_image = isset($_POST['upi_header_logo_image'])?sanitize_file_name($_POST['upi_header_logo_image']):"";
		
		$upi_header_logo_hidden = isset($_POST['upi_header_logo_hidden']) ?(int)sanitize_text_field($_POST['upi_header_logo_hidden']):"";
		
		$template_options['upi_header_logo_settings'] = array(
		
															'logo_position' => $upi_header_logo_position,
															
															'logo_image' => $upi_header_logo_image,
															
															'logo_hidden' => $upi_header_logo_hidden
														);
		
		
		/*From address data and settings*/
		
		$upi_from_address_content = isset($_POST['upi_from_address_content'])?$_POST['upi_from_address_content']:"";
		
		$upi_from_address_position = isset($_POST['upi_from_address_position'])?sanitize_text_field($_POST['upi_from_address_position']):"";
		
		$upi_from_address_text_align = isset($_POST['upi_from_address_text_align'])?sanitize_text_field($_POST['upi_from_address_text_align']):"";
		
		$upi_from_address_font_size = isset($_POST['upi_from_address_font_size'])?(int)sanitize_text_field($_POST['upi_from_address_font_size']):"";
		
		$upi_from_address_hidden = isset($_POST['upi_from_address_hidden'])?(int)sanitize_text_field($_POST['upi_from_address_hidden']):"";
		
		$template_options['upi_from_address_settings'] = array(
		
															'content' => $upi_from_address_content,
															
															'position' => $upi_from_address_position,
															
															'text_align' => $upi_from_address_text_align,
															
															'font_size' => $upi_from_address_font_size,
															
															'is_hidden' => $upi_from_address_hidden
														);
		
		
		/*To address data and settings*/
		
		$upi_to_address_content = isset($_POST['upi_to_address_content'])?$_POST['upi_to_address_content']:"";
		
		$upi_to_address_position = isset($_POST['upi_to_address_position'])?sanitize_text_field($_POST['upi_to_address_position']):"";
		
		$upi_to_address_text_align = isset($_POST['upi_to_address_text_align'])?sanitize_text_field($_POST['upi_to_address_text_align']):"";
		
		$upi_to_address_font_size = isset($_POST['upi_to_address_font_size'])?(int)sanitize_text_field($_POST['upi_to_address_font_size']):"";
		
		$upi_to_address_hidden = isset($_POST['upi_to_address_hidden'])?(int)sanitize_text_field($_POST['upi_to_address_hidden']):"";
		
		$template_options['upi_to_address_settings'] = array(
		
															'content' => $upi_to_address_content,
															
															'position' => $upi_to_address_position,
															
															'text_align' => $upi_to_address_text_align,
															
															'font_size' => $upi_to_address_font_size,
															
															'is_hidden' => $upi_to_address_hidden
														);
		
		
		/*Order Invoice data and settings*/
		
		$upi_order_invoice_title = isset($_POST['upi_order_invoice_title'])?$_POST['upi_order_invoice_title']:"";
		
		$upi_order_invoice_font_size = isset($_POST['upi_order_invoice_font_size'])?(int)sanitize_text_field($_POST['upi_order_invoice_font_size']):"";
		
		$upi_order_invoice_bg = isset($_POST['upi_order_invoice_bg'])?sanitize_text_field($_POST['upi_order_invoice_bg']):"";
		
		$upi_order_invoice_bg_1 = isset($_POST['upi_order_invoice_bg_1'])?sanitize_text_field($_POST['upi_order_invoice_bg_1']):"";
		
		$upi_order_invoice_hidden = isset($_POST['upi_order_invoice_hidden'])?(int)sanitize_text_field($_POST['upi_order_invoice_hidden']):"";
		
		$template_options['upi_order_invoice_settings'] = array(
		
															'title' => $upi_order_invoice_title,
															
															'font_size' => $upi_order_invoice_font_size,
															
															'bg' => $upi_order_invoice_bg,
															
															'bg1' => $upi_order_invoice_bg_1,
																														
															'is_hidden' => $upi_order_invoice_hidden
														);
		
		/*Order Total data and settings*/
		
		$upi_order_total_title = isset($_POST['upi_order_total_title'])?$_POST['upi_order_total_title']:"";
		
		$upi_order_total_font_size = isset($_POST['upi_order_total_font_size'])?(int)sanitize_text_field($_POST['upi_order_total_font_size']):"";
		
		$upi_order_total_bg = isset($_POST['upi_order_total_bg'])?sanitize_text_field($_POST['upi_order_total_bg']):"";
		
		$upi_order_total_bg_1 = isset($_POST['upi_order_total_bg_1'])?sanitize_text_field($_POST['upi_order_total_bg_1']):"";
		
		$upi_order_total_hidden = isset($_POST['upi_order_total_hidden'])?(int)sanitize_text_field($_POST['upi_order_total_hidden']):"";
		
		$template_options['upi_order_total_settings'] = array(
		
															'title' => $upi_order_total_title,
															
															'font_size' => $upi_order_total_font_size,
															
															'bg' => $upi_order_total_bg,
															
															'bg1' => $upi_order_total_bg_1,
																														
															'is_hidden' => $upi_order_total_hidden
														);
			
				
		/*Table data and settings*/
		
		$upi_product_history_header_font_size = isset($_POST['upi_product_history_header_font_size'])?(int)sanitize_text_field($_POST['upi_product_history_header_font_size']):"";
		
		$upi_product_history_body_font_size = isset($_POST['upi_product_history_body_font_size'])?(int)sanitize_text_field($_POST['upi_product_history_body_font_size']):"";
		
		$upi_product_history_header_bg = isset($_POST['upi_product_history_header_bg'])?sanitize_text_field($_POST['upi_product_history_header_bg']):"";
		
		$upi_product_history_body_bg = isset($_POST['upi_product_history_body_bg'])?sanitize_text_field($_POST['upi_product_history_body_bg']):"";
		
		$upi_product_history_hidden = isset($_POST['upi_product_history_hidden'])?(int)sanitize_text_field($_POST['upi_product_history_hidden']):"";
		
		$template_options['upi_product_history_settings'] = array(
		
															'header_font_size' => $upi_product_history_header_font_size,
															
															'body_font_size' => $upi_product_history_body_font_size,
															
															'header_bg' => $upi_product_history_header_bg,
															
															'body_bg' => $upi_product_history_body_bg,
															
															'is_hidden' => $upi_product_history_hidden
														);
		
		
		/*Footer Upper Section data and settings*/
		
		$upi_footer_upper_content = isset($_POST['upi_footer_upper_content'])?$_POST['upi_footer_upper_content']:"";
		
		$upi_footer_upper_text_align = isset($_POST['upi_footer_upper_text_align'])?sanitize_text_field($_POST['upi_footer_upper_text_align']):"";
		
		$upi_footer_upper_font_size = isset($_POST['upi_footer_upper_font_size'])?(int)sanitize_text_field($_POST['upi_footer_upper_font_size']):"";
		
		$upi_footer_upper_hidden = isset($_POST['upi_footer_upper_hidden'])?(int)sanitize_text_field($_POST['upi_footer_upper_hidden']):"";
		
		$template_options['upi_footer_upper_settings'] = array(
		
															'content' => $upi_footer_upper_content,
															
															'text_align' => $upi_footer_upper_text_align,
															
															'font_size' => $upi_footer_upper_font_size,
															
															'is_hidden' => $upi_footer_upper_hidden
														);
		
		
		/*Footer Lower Section data and settings*/
		
		$upi_footer_lower_content = isset($_POST['upi_footer_lower_content'])?$_POST['upi_footer_lower_content']:"";
		
		$upi_footer_lower_text_align = isset($_POST['upi_footer_lower_text_align'])?sanitize_text_field($_POST['upi_footer_lower_text_align']):"";
		
		$upi_footer_lower_font_size = isset($_POST['upi_footer_lower_font_size'])?(int)sanitize_text_field($_POST['upi_footer_lower_font_size']):"";
		
		$upi_footer_lower_hidden = isset($_POST['upi_footer_lower_hidden'])?(int)sanitize_text_field($_POST['upi_footer_lower_hidden']):"";
		
		$template_options['upi_footer_lower_settings'] = array(
		
															'content' => $upi_footer_lower_content,
															
															'text_align' => $upi_footer_lower_text_align,
															
															'font_size' => $upi_footer_lower_font_size,
															
															'is_hidden' => $upi_footer_lower_hidden
														);
		
		/*template data*/
		
						
		if($template_id !="" && $template_id>0)
		{
			$new_values = array(
			
							'template_name' 	=> $template_name,
							
							'template_options'  => maybe_serialize($template_options),
						);
			
			$res = $wpdb->update($wpdb->prefix.'upi_invoice_template', $new_values, array('template_id' => $template_id));
		}	
		else
		{
			$new_values = array(
			
							'template_name' 	=> $template_name,
							
							'template_options'  => maybe_serialize($template_options),
							
							'template_key'		=> time(),
							
							'create_date' 		=> current_time('mysql')
						);
						
			$res = $wpdb->insert($wpdb->prefix."upi_invoice_template", $new_values);
		}
		
		$return_value['message']	= 'success';
		
		$return_value['message_content']	= __('Changes Saved Successfully.',UPI_TEXTDOMAIN);
			
		echo json_encode($return_value );
		
		die();
	}
	function get_template_by_id($template_id = 0)
	{
		global $wpdb;
		
		if($template_id!="" && (int)$template_id>0)
		{
			$result = $wpdb->get_row($wpdb->prepare("select * from ".$wpdb->prefix."upi_invoice_template where template_id=%d",(int)$template_id));
		
			return $result;	
		}
		else
		{
			return false;
		}
	}
	function get_template_list()
	{
		global $wpdb;
		
		$result = $wpdb->get_results("select `template_id`,`template_name` from ".$wpdb->prefix."upi_invoice_template");
		
		return $result;	
	
	}
	function get_invoice_templates()
	{
		global $wpdb;
		
		$invoice_template = $wpdb->get_results("select `template_id` from ".$wpdb->prefix."upi_invoice_template");
							
		return $invoice_template;
	}	
	function upi_generate_template($template_id) 
	{
		global $upi_invoice;
		
		if(file_exists(UPI_CORE_DIR . "/pdf_templates/template_".$template_id.".php" ) && $template_id!="" && $template_id>0 && file_exists(UPI_CORE_DIR . "/pdf_templates/template_".$template_id.".php"))
		{
			require_once( UPI_LIB_DIR . '/mpdf/mpdf.php' );
			
			include( UPI_CORE_DIR . "/pdf_templates/template_".$template_id.".php");
			
            ob_end_clean ();
			
			$mpdf_options = $upi_invoice->get_mpdf_options();
			
	        $mpdf = new mPDF(
			
		        $mpdf_options['mode'],               // mode
		        $mpdf_options['format'],             // format
		        $mpdf_options['default_font_size'],  // default_font_size
		        $mpdf_options['default_font'],       // default_font
		        $mpdf_options['margin_left'],        // margin_left
		        $mpdf_options['margin_right'],       // margin_right
		        $mpdf_options['margin_top'],         // margin_top
		        $mpdf_options['margin_bottom'],      // margin_bottom
		        $mpdf_options['margin_header'],      // margin_header
		        $mpdf_options['margin_footer'],      // margin_footer
		        $mpdf_options['orientation']         // orientation
				
	        );
			
		   	$mpdf->SetHTMLHeader( $html_header ); 
			
	    	$mpdf->WriteHTML(  $html );
			
			$mpdf->SetHTMLFooter( $html_footer);
			
			$current_time = time();
			
			$new_file_name = UPI_UPLOAD_DIR.'/'.$current_time.'_sample.pdf';
			
	        $mpdf->Output($new_file_name);
			
			header('Content-type: application / pdf');
			
			header('Content-Disposition: attachment; filename="' .$current_time.'_sample.pdf"');
			
			header('Content-Transfer-Encoding: binary');
			
			header('Content-Length: ' . filesize( $new_file_name));
			
			header('Accept-Ranges: bytes');
			
			readfile($new_file_name);
			
		}
    }
	function get_mpdf_options() 
	{
		$mpdf_options = array(
								'mode' => '',
								'format' => '',
								'default_font_size' => 0,
								'default_font' => 'opensans',
								'margin_left' => 0,
								'margin_right' => 0,
								'margin_top' => 0,
								'margin_bottom' => 0,
								'margin_header' => 10,
								'margin_footer' => 10,
								'orientation' => 'P'
							);
		return  $mpdf_options;
			
	}
	function upi_generate_pdf() 
	{
		global $upi_invoice;
		
		$is_preview = isset($_POST['upi_is_preview'])?(int)$_POST['upi_is_preview']:"";
		
		$template_id = isset($_POST['template_id'])?(int)$_POST['template_id']:1;
		
		$custom_invoice = isset($_POST['upi_download_custom_invoice'])?$_POST['upi_download_custom_invoice']:"";
		
		$upi_action = isset($_GET['upi_action'])?$_GET['upi_action']:"";
		
		if($is_preview !="" && $is_preview == '1' && $template_id != "" && $template_id >0)
		{
       	 	$pdf_content = $upi_invoice -> upi_generate_template($template_id );
			
			die();
		}
		else if($custom_invoice !="" && $custom_invoice == '1')
		{
			$upi_invoice_settings = $upi_invoice -> get_invoice_settings();	

			$template_id = isset($upi_invoice_settings['activated_template'])?(int)$upi_invoice_settings['activated_template']:2;

			$order_id = isset($_POST['upi_order_id'])?(int)$_POST['upi_order_id']:"";
			
       	 	$pdf_content = $upi_invoice -> upi_download_invoice_by_id($template_id , $order_id );
			
			die();
		}
		else if($upi_action == "upi_download_invoice" && isset($_GET['post']) && isset($_GET['action']) && $_GET['action'] == "edit" )
		{
			$upi_invoice_settings = $upi_invoice -> get_invoice_settings();	

			$template_id = isset($upi_invoice_settings['activated_template'])?(int)$upi_invoice_settings['activated_template']:2;

			$order_id = isset($_GET['post'])?(int)$_GET['post']:"";
			
       	 	$pdf_content = $upi_invoice -> upi_download_invoice_by_id($template_id , $order_id );
			
			die();
		}
		else if(isset($_GET['upi-action']) && $_GET['upi-action']== "download-customer-invoice" && isset($_GET['upi-order-id']) && $_GET['upi-order-id'] != "" && isset($_GET['upi-check']))
		{
			$order_id = isset($_GET['upi-order-id'])?(int)$_GET['upi-order-id']:"";
			
			$upi_check = isset($_GET['upi-check'])?$_GET['upi-check']:"";
						
			$check = wp_create_nonce($order_id ,'upi_download_customer_invoice', 'upi_check');
			
			if($check == $upi_check)
			{
				$upi_invoice_settings = $upi_invoice -> get_invoice_settings();	
	
				$template_id = isset($upi_invoice_settings['activated_template'])?(int)$upi_invoice_settings['activated_template']:2;
	
				$pdf_content = $upi_invoice -> upi_download_invoice_by_id($template_id , $order_id );
			}
			die();
		}
		
	}
	function get_upi_order_list()
	{
		global $upi_invoice;
		
		$query_args = array(
		
						'posts_per_page' 	=> -1,
						
						'post_type'   		=> 'shop_order',
						
						'post_status' 		=> 'publish',
						
						'orderby' 			=> 'ID',
						
						'order' 			=> 'ASC',
						
						'fields' 			=> 'ids',
						
						);
		if(function_exists('wc_get_order_statuses'))
        {
			
			$query_args['post_status']  =  array_keys($upi_invoice -> get_woo_order_status());
			
		}
								
		$orders_list = get_posts($query_args);
		
		return $orders_list;
	}
	function get_woo_order_status()
	{
		
		$shop_order_status = array();

		if(function_exists('wc_get_order_statuses'))
		{
			$shop_order_status = wc_get_order_statuses();
								
		}	
		else
		{
			$shop_order_status = get_terms( 'shop_order_status', 'orderby=id&hide_empty=1' );
		}	
		
		return $shop_order_status;				
	}
	function get_order_by_id($id = 0)
	{
			
		global $upi_invoice;
			
		$query_args = array(
		
						'posts_per_page' 	=> -1,
						
						'post_type'   		=> 'shop_order',
						
						'post_status' 		=> 'publish',
						
						'post__in'			=> array($id),

						);
						
		if(function_exists('wc_get_order_statuses'))
        {
			if(!empty($order_status))
			{
				$query_args['post_status']  = $order_status;
			}else{
				$query_args['post_status']  =  array_keys($upi_invoice -> get_woo_order_status());
			}
			
			
		}
		else
		{
			if(!empty($order_status))
			{
				$query_args['tax_query']		= array(
													array(
								
														 'taxonomy' =>'shop_order_status',
														 'field' => 'id',
														 'terms' => $order_status
													)
											);
			}
		}
		
		$export_orders = new WP_Query( $query_args );
		
		$order_results = $export_orders->get_posts();
				
		foreach($order_results as $order_result)
		{ 
 			if(function_exists('wc_get_order_statuses'))
			{
				$order = new WC_Order($order_result);
				$items = $order->get_items();
			}
			else
			{
				$order = new WC_Order();
				$order->populate( $order_result );
				$items = $order->get_items();
			}
			
			$order -> product_list = $items;
			
			if(!isset($order->order_custom_fields))
			{
        		$order->order_custom_fields = get_post_meta( $order->id );
        	}
						
			
		}		
		return $order;
	}
	function upi_download_invoice_by_id($template_id = 0,$order_id = 0)
	{
		global $upi_invoice;
		
		if(file_exists(UPI_CORE_DIR . "/pdf_templates/template_".$template_id.".php" ) && $template_id!="" && $template_id>0 && file_exists(UPI_CORE_DIR . "/pdf_templates/template_".$template_id.".php"))
		{
			$invoice_file = $upi_invoice -> generate_invoice_by_order_id($order_id,$template_id);
			
			header('Content-type: application / pdf');
			
			header('Content-Disposition: attachment; filename="'.$invoice_file.'"');
			
			header('Content-Transfer-Encoding: binary');
			
			header('Content-Length: ' . filesize( UPI_UPLOAD_DIR.'/'.$invoice_file));
			
			header('Accept-Ranges: bytes');
			
			readfile(UPI_UPLOAD_DIR.'/'.$invoice_file);
			
		}
	}
	function generate_invoice_by_order_id($order_id=0, $template_id=1)
	{		
		global $upi_invoice;
		
		require_once( UPI_LIB_DIR . '/mpdf/mpdf.php' );
			
		include( UPI_CORE_DIR . "/pdf_templates/template_".$template_id.".php");
		
		ob_end_clean ();
		
		
		$mpdf_options = $upi_invoice -> get_mpdf_options();
		
		$mpdf = new mPDF(
		
			$mpdf_options['mode'],               // mode
			$mpdf_options['format'],             // format
			$mpdf_options['default_font_size'],  // default_font_size
			$mpdf_options['default_font'],       // default_font
			$mpdf_options['margin_left'],        // margin_left
			$mpdf_options['margin_right'],       // margin_right
			$mpdf_options['margin_top'],         // margin_top
			$mpdf_options['margin_bottom'],      // margin_bottom
			$mpdf_options['margin_header'],      // margin_header
			$mpdf_options['margin_footer'],      // margin_footer
			$mpdf_options['orientation']         // orientation
			
		);
		
		$mpdf->SetHTMLHeader( $html_header ); 
		
		$mpdf->WriteHTML(  $html );
		
		$mpdf->SetHTMLFooter( $html_footer);
		
		$current_time = time();
		
		$file_name  = $current_time.'_invoice_'.$order_id.'.pdf';
		
		$mpdf->Output(UPI_UPLOAD_DIR.'/'.$file_name);
		
		return $file_name;
	}
	function upi_save_invoice_settings()
	{
		global $upi_invoice;
				
		$upi_attach_time = isset($_POST['upi_attach_time'])?$_POST['upi_attach_time']:'new_order';
		
		$upi_email_attachment = isset($_POST['upi_email_attachment'])?$_POST['upi_email_attachment']:'enable';
		
		$upi_activated_template = isset($_POST['upi_activated_template'])?(int)$_POST['upi_activated_template']:1;
		
		$upi_invoice_settings = array(
		
									'activated_template' => $upi_activated_template,
									
									'attach_time' => $upi_attach_time,
									
									'email_attachment' => $upi_email_attachment
									
								);
								
		$upi_invoice_settings_data = maybe_serialize($upi_invoice_settings);
		 
		update_option('upi_invoice_settings',$upi_invoice_settings_data);
		
		$return_value = array();
		
		$return_value['message']	= 'success';
		
		$return_value['message_content']	= __('Changes Saved Successfully.',UPI_TEXTDOMAIN);
			
		echo json_encode($return_value );
		
		die();
	}
	function get_invoice_settings()
	{
			
		global $upi_invoice;
		
		$upi_invoice_default_settings = $upi_invoice -> get_invoice_default_settings();
								
		$upi_invoice_settings = maybe_unserialize( get_option('upi_invoice_settings'),$upi_invoice_default_settings);
		
		return $upi_invoice_settings;	
	}
	
	function get_invoice_default_settings()
	{
		$upi_invoice_default_settings = array(
		
									'activated_template' => 2,
									
									'attach_time' => 'new_order',
									
									'email_attachment' => 'enable'
									
								);
								
		$upi_invoice_settings = maybe_serialize($upi_invoice_default_settings);
		
		return $upi_invoice_settings;	
	}
	function upi_attach_invoice_to_email($attachments, $status, $object)
	{
		global $upi_invoice;
		
		if (!$object instanceof WC_Order) 
		{
        	return $attachments;
        }
		
		$invoice_settings = $upi_invoice -> get_invoice_settings();
		
		if ($invoice_settings['email_attachment'] == 'enable' && isset($status) && $status == $invoice_settings['attach_time'])
		{
			$invoice_file = UPI_UPLOAD_DIR.'/'.$upi_invoice -> generate_invoice_by_order_id($object->id , $invoice_settings['activated_template']);
            
			$attachments[] = $invoice_file;
        }
		
		return $attachments;
	}
	function get_invoice_number()
	{
		return get_option('upi_order_invoice_no',0);	
	}
	function upi_order_page_invoice_section()
	{
		global $upi_invoice;
		
		add_meta_box( 'upi_order_page_invoice',
		
		 				__( 'Ultimate PDF Invoice', UPI_TEXTDOMAIN ), 
						
						array($upi_invoice, 'upi_create_meta_box'), 'shop_order', 'side', 'high' );
	}
	function upi_create_meta_box($post)
	{
		$order_id = isset($_GET['post'])?$_GET['post']:"";
		
		$upi_url = admin_url() . 'post.php?post=' . $order_id . '&action=edit&upi_action=upi_download_invoice';
		?>
        
        <a href="<?php echo esc_url($upi_url);?>" class="btn button tips upi_download_invoice_link" data-tip="<?php _e( 'Download Invoice', UPI_TEXTDOMAIN );?>"><?php _e( 'Invoice', UPI_TEXTDOMAIN );?></a>
        
        <?php
		
	}
	function upi_order_list_page_download($order)
	{
		$order_id = $order->id;
		
		$upi_url = admin_url() . 'post.php?post=' . $order_id . '&action=edit&upi_action=upi_download_invoice';
		?>
        
        <a href="<?php echo esc_url( $upi_url);?>" class="btn button tips upi_download_invoice_link" data-tip="<?php _e( 'Download Invoice', UPI_TEXTDOMAIN );?>"></a>
        
        <?php
	}
	function upi_order_customer_list_page_download($actions, $order)
	{		
		$order_id = $order->id;
		
		$check = wp_create_nonce($order_id ,'upi_download_customer_invoice', 'upi_check');
		
		$upi_action_url = add_query_arg('upi-order-id', $order_id ,remove_query_arg('upi-order-id'));
		
		$upi_action_url = remove_query_arg('upi-action',$upi_action_url);
		
		$upi_action_url = add_query_arg('upi-action', 'download-customer-invoice' ,$upi_action_url);
		
		$complete_url = wp_nonce_url($upi_action_url, ''.$order_id, 'upi-check');
	
		$upi_url = esc_url($complete_url);
		
		$actions['upi-invoice'] = array(
				'url' => $upi_url,
				'name' => __('Download Invoice', UPI_TEXTDOMAIN)
			);
		
		return $actions;
	}
	
	function upi_get_subtotal($order) {
		$subtotal = 0;

		foreach ( $order->get_items() as $item ) {
			$subtotal += ( isset( $item['line_subtotal'] ) ) ? $item['line_subtotal'] : 0;
		}

		return apply_filters( 'woocommerce_order_amount_subtotal', (double) $subtotal, $order );
	}
}
?>
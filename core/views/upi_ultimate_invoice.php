<?php 
	if (!defined('ABSPATH'))
    die("Can't load this file directly");
	
	global $upi_pdf_invoice, $upi_invoice;
	
	$invoice_templates = $upi_invoice -> get_invoice_templates();
	
	$current_page = isset($_REQUEST['page'])?$_REQUEST['page']:"";
	
	if($current_page=="")
	{
		die();	
	}
	
	$template_url = get_admin_url().'admin.php?page='.$current_page.'&template_id=';
		
?>
<div class="upi_template_wrapper">
	<div class="upi_template_header_wrapper">
    	<div class="upi_editor_header_bg"></div>
		<div class="upi_template_header_outer">
			<div class="upi_btn_wrapper">
			</div>
		</div>
		<div class="upi_template_header_section">
				<div class="upi_templte_select_title_wrapper">
					<div class="upi_templte_select_title"><?php _e('Please click to select template',UPI_TEXTDOMAIN);?></div>
				</div>
		</div>
	</div>
	<div class="upi_template_list_wrapper">
		<?php foreach($invoice_templates as $invoice_template){?>
			<div class="upi_template_list">
				<a href="<?php echo esc_url($template_url.$invoice_template->template_id);?>" class="upi_template_link"><img class="upi_template_layout_img" src="<?php echo esc_url(UPI_IMAGES_URL.'/template_'.$invoice_template->template_id.'.png');?>"/></a>
			</div>
		<?php }?>
	</div>
</div>
<div class="upi_documantation_links_wrapper">
	<div class="upi_documantation_links_outer">
		<a target="_blank" href="<?php echo UPI_PLUGIN_URL.'/documentation/';?>"><?php _e('Documentation',UPI_TEXTDOMAIN);?></a> |  <a target="_blank" href="http://www.vjinfotech.com/support"><?php _e('Support',UPI_TEXTDOMAIN);?></a>
	</div>
</div>
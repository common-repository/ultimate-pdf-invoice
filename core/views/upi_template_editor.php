<?php 
	if (!defined('ABSPATH'))
    die("Can't load this file directly");
	
global $upi_pdf_invoice, $upi_invoice;

$invoice_templates = $upi_invoice -> get_invoice_templates();

$template_url = get_admin_url().'admin.php?page='.$_REQUEST['page'];

$template_id = isset($_REQUEST['template_id'])?$_REQUEST['template_id']:"";

$template_settings = $upi_invoice -> get_template_by_id($template_id);

$template_options = maybe_unserialize($template_settings->template_options);

$template_name = $template_settings->template_name;

$upi_header_logo_settings = $template_options['upi_header_logo_settings'];

$upi_from_address_settings = $template_options['upi_from_address_settings'];

$upi_to_address_settings = $template_options['upi_to_address_settings'];

$upi_order_invoice_settings = $template_options['upi_order_invoice_settings'];

$upi_product_history_settings = $template_options['upi_product_history_settings'];

$upi_footer_upper_settings = $template_options['upi_footer_upper_settings'];

$upi_footer_lower_settings = $template_options['upi_footer_lower_settings'];

$upi_order_total_settings = $template_options['upi_order_total_settings'];

if(file_exists(UPI_UPLOAD_DIR.'/'.$upi_header_logo_settings['logo_image']) && $upi_header_logo_settings['logo_image'] != "")
{
	$new_file_path = UPI_UPLOAD_URL.'/'.$upi_header_logo_settings['logo_image'];
}
else
{
	$new_file_path = UPI_IMAGES_URL.'/upi_sample_logo.png';
}
?>
<form method="post" action="#" class="upi_preview_frm">
	<input type="hidden" name="template_id" value="<?php echo esc_attr($template_id);?>"  />
    <input type="hidden" name="upi_is_preview" value="1"  />
</form>
<form class="upi_template_editor" action="#" method="post">	
    <div class="upi_template_wrapper">
        <div class="upi_template_header_wrapper">
        	<div class="upi_editor_header_bg"></div>
            <div class="upi_template_header_outer">
                <div class="upi_btn_wrapper">
                    <button class="upi_btn upi_template_save_btn" type="button"><i class="dashicons dashicons-yes upi_btn_icon"></i><?php _e('Save',UPI_TEXTDOMAIN);?></button>
                    <button class="upi_btn upi_template_preview_btn" type="button"><i class="dashicons dashicons-welcome-view-site upi_btn_icon"></i><?php _e('Preview',UPI_TEXTDOMAIN);?></button>
                    <a href="<?php echo esc_url($template_url);?>" class="upi_btn"><i class="dashicons dashicons-no-alt upi_btn_icon"></i><?php _e('Close',UPI_TEXTDOMAIN);?></a>
                </div>
            </div>
            <div class="upi_template_header_section">
                    <div class="upi_templte_select_title_wrapper">
                        <div class="upi_templte_select_title"><input class="upi_template_title_input" autocomplete="off" type="text" value="<?php echo esc_attr($template_name);?>"  name="template_name" /></div>
                    </div>
            </div>
        </div>
        <div class="upi_template_editor_outer_wrapper">
                <?php
                    if(file_exists(UPI_CORE_DIR.'/templates/template_'.$_REQUEST['template_id'].'.php'))
                    {
                        include( UPI_CORE_DIR.'/templates/template_'.$_REQUEST['template_id'].'.php' );
                    }
                    
                ?>
        </div>
	</div>
</form>
<?php /* saving popup box */?>
<div class="upi-info-box">
	<div class="upi-info-overlay"></div>
	<div class="upi-info-holder">
		<div class="upi-info-inner">
			<div class="upi-info-box-msg upi-info-box-saving-data">
            	<i class="upi-info-box-icon dashicons dashicons-admin-generic"></i>
				<?php _e('Saving Template',UPI_TEXTDOMAIN);?>
            </div>
			<div class="upi-info-box-msg upi-info-box-saved-data">
            	<i class="upi-info-box-icon dashicons dashicons-yes"></i>
                <?php _e('Template saved',UPI_TEXTDOMAIN);?>
            </div>
		</div>
	</div>
</div>
<div class="upi_documantation_links_wrapper">
	<div class="upi_documantation_links_outer">
		<a target="_blank" href="<?php echo UPI_PLUGIN_URL.'/documentation/';?>"><?php _e('Documentation',UPI_TEXTDOMAIN);?></a> |  <a target="_blank" href="http://www.vjinfotech.com/support"><?php _e('Support',UPI_TEXTDOMAIN);?></a>
	</div>
</div>
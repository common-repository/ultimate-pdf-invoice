<?php 
	if (!defined('ABSPATH'))
    die("Can't load this file directly");
	
global $upi_invoice;

$order_list = $upi_invoice -> get_upi_order_list();


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
					<div class="upi_templte_select_title"><?php _e('Download Invoice',UPI_TEXTDOMAIN);?></div>
				</div>
		</div>
	</div>
	<div class="upi_template_list_wrapper">
		<form class="upi_generate_custom_invoice_frm" method="post">
        	<input type="hidden" value="1" name="upi_download_custom_invoice" />
        	<div class="upi_custom_invoice_outer_wrapper">
            	<div class="upi_invoice_section_wrapper">
                	<div class="upi_invoice_section_inner"><?php _e('Download',UPI_TEXTDOMAIN);?></div>
                </div>
                <div class="upi_custom_data_wrapper">
                	<div class="upi_custom_data_inner_wrapper">
                    	<div class="upi_custom_data_label"><?php _e('Select Order',UPI_TEXTDOMAIN);?></div>
                         <div class="upi_custom_data_label_desc"><?php _e('Please select any order ID',UPI_TEXTDOMAIN);?></div>
                        <div class="upi_custom_data_input_wrapper">
                        	<select class="upi_custom_select_element" name="upi_order_id">
                            	<?php 
								if(!empty($order_list))
								{
									foreach($order_list as $upi_order)
									{
										echo '<option value="'.esc_attr($upi_order).'">Order #'.esc_html($upi_order).'</option>';
									}
								}
								?>
                            	
                            </select>
                        </div>
                        <div class="upi_custom_invoice_btn_wrapper">
                        	<button class="upi_btn upi_download_custom_invoice_btn" type="submit"><i class="dashicons dashicons-yes upi_btn_icon"></i>Download</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
	</div>
</div>
<div class="upi_documantation_links_wrapper">
	<div class="upi_documantation_links_outer">
		<a target="_blank" href="<?php echo UPI_PLUGIN_URL.'/documentation/';?>"><?php _e('Documentation',UPI_TEXTDOMAIN);?></a> |  <a target="_blank" href="http://www.vjinfotech.com/support"><?php _e('Support',UPI_TEXTDOMAIN);?></a>
	</div>
</div>
<?php 
	if (!defined('ABSPATH'))
    die("Can't load this file directly");
	
global $upi_pdf_invoice, $upi_invoice;

$upi_invoice_settings = $upi_invoice -> get_invoice_settings();	

$upi_template_data = $upi_invoice -> get_template_list();

?>
<div class="upi_template_wrapper">
	<div class="upi_template_header_wrapper">
    	<div class="upi_editor_header_bg"></div>
		<div class="upi_template_header_outer">
			<div class="upi_btn_wrapper">
				<button class="upi_btn upi_settings_save_btn"><i class="dashicons dashicons-yes upi_btn_icon"></i>Save</button>
			</div>
		</div>
		<div class="upi_template_header_section">
				<div class="upi_templte_select_title_wrapper">
					<div class="upi_templte_select_title"><?php _e('Settings',UPI_TEXTDOMAIN);?></div>
				</div>
		</div>
	</div>
	<div class="upi_template_list_wrapper">
		<form class="upi_generate_custom_invoice_frm" method="post">
        	 <div class="upi_custom_invoice_outer_wrapper">
            	<div class="upi_invoice_section_wrapper">
                	<div class="upi_invoice_section_inner"><?php _e('Template',UPI_TEXTDOMAIN);?></div>
                </div>
                <div class="upi_custom_data_wrapper">
                	<div class="upi_custom_data_inner_wrapper">
                    	<div class="upi_custom_data_label"><?php _e('Activate Template',UPI_TEXTDOMAIN);?></div>
                        <div class="upi_custom_data_input_wrapper">
                        	<select class="upi_custom_select_element" name="upi_activated_template">
                            	<?php 
								if(!empty($upi_template_data))
								{
									foreach($upi_template_data as $upi_template)
									{
                            			echo '<option value="'. esc_attr($upi_template->template_id).'"'. selected($upi_template->template_id,$upi_invoice_settings['activated_template'],1).'>'.esc_html($upi_template->template_name).'</option>';
                                     
									}
								}?>
                             </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="upi_custom_invoice_outer_wrapper">
            	<div class="upi_invoice_section_wrapper">
                	<div class="upi_invoice_section_inner"><?php _e('Disable',UPI_TEXTDOMAIN);?></div>
                </div>
                <div class="upi_custom_data_wrapper">
                	<div class="upi_custom_data_inner_wrapper">
                    	<div class="upi_custom_data_label"><?php _e('Email Attachment',UPI_TEXTDOMAIN);?></div>
                        <div class="upi_custom_data_input_wrapper">
                        	<select class="upi_custom_select_element" name="upi_email_attachment">
                            	<option value="enable" <?php selected('enable',$upi_invoice_settings['email_attachment']);?>><?php _e('Attach with Email',UPI_TEXTDOMAIN);?></option>
                                <option value="disable" <?php selected('disable',$upi_invoice_settings['email_attachment']);?>><?php _e('Do not Attach with Email',UPI_TEXTDOMAIN);?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="upi_custom_invoice_outer_wrapper">
            	<div class="upi_invoice_section_wrapper">
                	<div class="upi_invoice_section_inner"><?php _e('Attachment',UPI_TEXTDOMAIN);?></div>
                </div>
                <div class="upi_custom_data_wrapper">
                	<div class="upi_custom_data_inner_wrapper">
                    	<div class="upi_custom_data_label"><?php _e('Attach Invoice',UPI_TEXTDOMAIN);?></div>
                        <div class="upi_custom_data_input_wrapper">
                        	<select class="upi_custom_select_element" name="upi_attach_time">
                            	<option value="new_order" <?php selected('new_order',$upi_invoice_settings['attach_time']);?>><?php _e('For new order',UPI_TEXTDOMAIN);?></option>
                                <option value="customer_processing_order" <?php selected('customer_processing_order',$upi_invoice_settings['attach_time']);?>><?php _e('For processing order',UPI_TEXTDOMAIN);?></option>
                                <option value="customer_completed_order" <?php selected('customer_completed_order',$upi_invoice_settings['attach_time']);?>><?php _e('For completed order',UPI_TEXTDOMAIN);?></option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
	</div>
</div>
<div class="upi-info-box">
	<div class="upi-info-overlay"></div>
	<div class="upi-info-holder">
		<div class="upi-info-inner">
			<div class="upi-info-box-msg upi-info-box-saving-data">
            	<i class="upi-info-box-icon dashicons dashicons-admin-generic"></i>
				<?php _e('Saving Settings',UPI_TEXTDOMAIN);?>
            </div>
			<div class="upi-info-box-msg upi-info-box-saved-data">
            	<i class="upi-info-box-icon dashicons dashicons-yes"></i>
                <?php _e('Settings Saved',UPI_TEXTDOMAIN);?>
            </div>
		</div>
	</div>
</div>
<div class="upi_documantation_links_wrapper">
	<div class="upi_documantation_links_outer">
		<a target="_blank" href="<?php echo UPI_PLUGIN_URL.'/documentation/';?>"><?php _e('Documentation',UPI_TEXTDOMAIN);?></a> |  <a target="_blank" href="http://www.vjinfotech.com/support"><?php _e('Support',UPI_TEXTDOMAIN);?></a>
	</div>
</div>
<?php 
	if (!defined('ABSPATH'))
    die("Can't load this file directly");
	
$upi_invoice_no = $upi_invoice -> get_invoice_number();

$invoice_number = str_pad($upi_invoice_no+1,6,0,STR_PAD_LEFT);

?>
<div class="upi_template_editor_wrapper">
		<div class="upi_invoice_placeholder"></div>
    	<input type="hidden" name="template_id" value="<?php echo esc_attr($template_id);?>"  />
		<div class="upi_template_sections">
			<div class="upi_template_logo_wrapper upi_template_section_settings">
				<div class="upi_template_logo_settings">
					<img style="float:<?php echo esc_attr($upi_header_logo_settings['logo_position']);?>" class="upi_company_logo" src="<?php echo esc_url($new_file_path);?>"/>
				</div>
				<div class="upi_logo_settings upi_btn"><i class="dashicons dashicons-admin-generic upi_settings_btn_icon"></i></div>
				<div class="upi_section_setting_wrapper">
					<div class="upi_section_setting">
						<div class="upi_section_setting_title"><?php _e('Position',UPI_TEXTDOMAIN);?></div>
						<div class="upi_section_setting_element_wrapper">
							<select name="upi_header_logo_position" class="upi_select_element" onchange="upi_change_css_data(this,'upi_company_logo','float');">
                            	<option value="none" <?php selected("none",$upi_header_logo_settings['logo_position']);?>><?php _e('Center',UPI_TEXTDOMAIN);?></option>
                                <option value="left" <?php selected("left",$upi_header_logo_settings['logo_position']);?>><?php _e('Left',UPI_TEXTDOMAIN);?></option>
                                <option value="right" <?php selected("right",$upi_header_logo_settings['logo_position']);?>><?php _e('Right',UPI_TEXTDOMAIN);?></option>
                            </select>
						</div>
					</div>
                    <div class="upi_section_setting">
						<div class="upi_section_setting_title"><?php _e('Choose Image',UPI_TEXTDOMAIN);?></div>
						<div class="upi_section_setting_element_wrapper">
							<input type="file" class="upi_setting_file upi_choose_logo" name="upi_company_logo" />
							<input type="hidden" class="upi_invoice_image" name="upi_header_logo_image"  value="<?php echo esc_attr($upi_header_logo_settings['logo_image']);?>"/>
						</div>
					</div>
					<div class="upi_section_setting">
						<div class="upi_section_setting_title"><?php _e('Hide Section',UPI_TEXTDOMAIN);?></div>
						<div class="upi_section_setting_element_wrapper">
							<input type="checkbox" class="upi_setting_checkbox" name="upi_header_logo_hidden" value="1" <?php checked(1,$upi_header_logo_settings['logo_hidden']);?>/>
						</div>
					</div>
				</div>
			</div>
		</div>
        
        <div class="upi_template_sections">
        	<div class="upi_order_details_wrppar upi_template_section_settings" style="font-size:<?php echo esc_attr($upi_order_invoice_settings['font_size']);?>px;background:<?php echo esc_attr($upi_order_invoice_settings['bg']);?>;">
				<div class="upi_order_data_wrapper">
					<div class="upi_order_data upi_order_invoice_title"><div class="upi_order_invoice_inner_title" style="font-size:<?php echo esc_attr($upi_order_invoice_settings['font_size']);?>px;"><?php echo $upi_order_invoice_settings['title'];?></div><div class="upi_order_invoice_inner_data_title">000999</div></div>
					<div class="upi_order_sample_data upi_order_invoice_payment" style="font-size:<?php echo esc_attr($upi_order_invoice_settings['font_size']);?>px;background:<?php echo esc_attr($upi_order_invoice_settings['bg1']);?>">Order ID : #01</div>
				</div>
				<div class="upi_logo_settings upi_btn"><i class="dashicons dashicons-admin-generic upi_settings_btn_icon"></i></div>	
				<div class="upi_section_setting_wrapper">
						<div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Title',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
								<input type="text" class="upi_setting_input_element" value="<?php echo esc_attr($upi_order_invoice_settings['title']);?>" name="upi_order_invoice_title"  onkeyup="upi_change_element_data(this,'upi_order_invoice_inner_title','content');"/>
							</div>
						</div>
						<div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Font size',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
                            	 <select name="upi_order_invoice_font_size" class="upi_select_element" onchange="upi_change_css_data(this,'upi_order_invoice_payment,.upi_order_invoice_title','font-size');" >
                                 <?php
                                 	for($i=8;$i<40;$i++)
									{
									 	echo "<option ".selected($i,$upi_order_invoice_settings['font_size'],1).' value="'.esc_attr($i).'">'.esc_html($i).' px</option>';
									}
								 ?>
                                </select>
							</div>
						</div>
                        <div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Background',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
								<input type="text" name="upi_order_invoice_bg" class="upi_setting_input_element upi_color_picker" value="<?php echo esc_attr($upi_order_invoice_settings['bg']);?>"  onkeyup="upi_change_element_data(this,'upi_order_invoice_title','content');" upi_bind_class="upi_order_details_wrppar"/>
							</div>
						</div>
                         <div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Background',UPI_TEXTDOMAIN);?> 1</div>
							<div class="upi_section_setting_element_wrapper">
								<input type="text" name="upi_order_invoice_bg_1" class="upi_setting_input_element upi_color_picker" value="<?php echo esc_attr($upi_order_invoice_settings['bg1']);?>"  onkeyup="upi_change_element_data(this,'upi_order_invoice_title','content');" upi_bind_class="upi_order_invoice_payment"/>
							</div>
						</div>
						<div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Hide Section',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
								<input type="checkbox" class="upi_setting_checkbox" value="1" name="upi_order_invoice_hidden" <?php checked(1,$upi_order_invoice_settings['is_hidden']);?>/>
							</div>
						</div>
					</div>
			</div>
        </div>
		<div class="upi_template_sections">
			<div class="upi_company_address_wrapper">
				<div class="upi_company_address_outer upi_template_section_settings">
					<div class="upi_company_address upi_company_address_data">
                    	<div class="upi_from_address"  style=" <?php echo esc_attr('float:'.$upi_from_address_settings['position'].'; text-align: '.$upi_from_address_settings['text_align'].'; font-size: '.$upi_from_address_settings['font_size'].'px;')?>"><?php echo $upi_from_address_settings['content'];?></div>
                     </div>
					<div class="upi_logo_settings upi_btn"><i class="dashicons dashicons-admin-generic upi_settings_btn_icon"></i></div>
					<div class="upi_section_setting_wrapper">
						<div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('From Address',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
								<textarea class="upi_setting_textarea_element" name="upi_from_address_content"  onkeyup="upi_change_element_data(this,'upi_from_address','content');" ><?php echo esc_textarea($upi_from_address_settings['content']);?></textarea>
							</div>
						</div>
                        <div class="upi_section_setting">
                            <div class="upi_section_setting_title"><?php _e('Position',UPI_TEXTDOMAIN);?></div>
                            <div class="upi_section_setting_element_wrapper">
                                <select name="upi_from_address_position" class="upi_select_element" onchange="upi_change_css_data(this,'upi_from_address','float');">
                                    <option value="left" <?php selected("left",$upi_from_address_settings['position']);?>><?php _e('Left',UPI_TEXTDOMAIN);?></option>
                                    <option value="right" <?php selected("right",$upi_from_address_settings['position']);?>><?php _e('Right',UPI_TEXTDOMAIN);?></option>
                                </select>
                            </div>
                        </div>
                        <div class="upi_section_setting">
                            <div class="upi_section_setting_title"><?php _e('Text Align',UPI_TEXTDOMAIN);?></div>
                            <div class="upi_section_setting_element_wrapper">
                                <select name="upi_from_address_text_align" class="upi_select_element" onchange="upi_change_css_data(this,'upi_from_address','text-align');">
                                    <option value="center" <?php selected("center",$upi_from_address_settings['text_align']);?>><?php _e('Center',UPI_TEXTDOMAIN);?></option>
                                    <option value="left" <?php selected("left",$upi_from_address_settings['text_align']);?>><?php _e('Left',UPI_TEXTDOMAIN);?></option>
                                    <option value="right" <?php selected("right",$upi_from_address_settings['text_align']);?>><?php _e('Right',UPI_TEXTDOMAIN);?></option>
                                </select>
                            </div>
                        </div>
						<div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Font size',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
                            	 <select name="upi_from_address_font_size" class="upi_select_element" onchange="upi_change_css_data(this,'upi_from_address','font-size');" >
                                 <?php
                                 	for($i=8;$i<40;$i++)
									{
									 	echo '<option '.selected($i,$upi_from_address_settings['font_size'],1).' value="'.esc_attr($i).'">'.esc_html($i).' px</option>';
									}
								 ?>
                                </select>
							</div>
						</div>
						<div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Hide Section',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
								<input type="checkbox" class="upi_setting_checkbox" value="1" name="upi_from_address_hidden"  <?php checked(1,$upi_from_address_settings['is_hidden']);?>/>
							</div>
						</div>
					</div>
				</div>
			</div>
            <div class="upi_template_invoice_from_wrapper upi_template_section_settings">
				<div class="upi_company_address">
                	<div class="upi_to_address" style=" <?php echo esc_attr('float:'.$upi_to_address_settings['position'].'; text-align: '.$upi_to_address_settings['text_align'].'; font-size: '.$upi_to_address_settings['font_size'].'px;');?>"><b>Demo.com</b><br>Demo India Private Limited.<br>555, Demo Park, demo Road,<br>Bangalore - 560001.<br>Karnataka. India.</div>
                </div>
				<div class="upi_logo_settings upi_btn"><i class="dashicons dashicons-admin-generic upi_settings_btn_icon"></i></div>
				<div class="upi_section_setting_wrapper">
						<div class="upi_section_setting">
                            <div class="upi_section_setting_title"><?php _e('Position',UPI_TEXTDOMAIN);?></div>
                            <div class="upi_section_setting_element_wrapper">
                                <select name="upi_to_address_position" class="upi_select_element" onchange="upi_change_css_data(this,'upi_to_address','float');">
                                   <option value="left" <?php selected("left",$upi_to_address_settings['position']);?>><?php _e('Left',UPI_TEXTDOMAIN);?></option>
                                    <option value="right" <?php selected("right",$upi_to_address_settings['position']);?>><?php _e('Right',UPI_TEXTDOMAIN);?></option>
                                </select>
                            </div>
                        </div>
                        <div class="upi_section_setting">
                            <div class="upi_section_setting_title"><?php _e('Text Align',UPI_TEXTDOMAIN);?></div>
                            <div class="upi_section_setting_element_wrapper">
                                <select name="upi_to_address_text_align" class="upi_select_element" onchange="upi_change_css_data(this,'upi_to_address','text-align');">
                                   <option value="center" <?php selected("center",$upi_to_address_settings['text_align']);?>><?php _e('Center',UPI_TEXTDOMAIN);?></option>
                                   <option value="left" <?php selected("left",$upi_to_address_settings['text_align']);?>><?php _e('Left',UPI_TEXTDOMAIN);?></option>
                                   <option value="right" <?php selected("right",$upi_to_address_settings['text_align']);?>><?php _e('Right',UPI_TEXTDOMAIN);?></option>
                                </select>
                            </div>
                        </div>
						<div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Font size',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
                            	 <select name="upi_to_address_font_size" class="upi_select_element" onchange="upi_change_css_data(this,'upi_to_address','font-size');" >
                                 <?php
                                 	for($i=8;$i<40;$i++)
									{
									 		echo '<option '.selected($i,$upi_to_address_settings['font_size'],1).' value="'.$i.'">'.$i.' px</option>';
									}
								 ?>
                                </select>
							</div>
						</div>
						<div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Hide Section',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
								<input type="checkbox" class="upi_setting_checkbox" value="1" name="upi_to_address_hidden" <?php checked(1,$upi_to_address_settings['is_hidden']);?> />
							</div>
						</div>
					</div>
			</div>
		</div>
		<div class="upi_template_sections upi_product_list_section">
			<div class="upi_product_list_wrapper upi_template_section_settings">
				<table class="upi_product_list" cellpadding="0" cellspacing="0" style="background:<?php echo esc_attr($upi_product_history_settings['body_bg']);?>;">
					<thead>
						<tr class="upi_product_list_header_wrapper">
							<th class="upi_product_list_header" style="background:<?php echo esc_attr($upi_product_history_settings['header_bg']);?>;">Product</th>
							<th class="upi_product_list_header" style="background:<?php echo esc_attr($upi_product_history_settings['header_bg']);?>;">Cost</th>
							<th class="upi_product_list_header" style="background:<?php echo esc_attr($upi_product_history_settings['header_bg']);?>;">Qty</th>
							<th class="upi_product_list_header" style="background:<?php echo esc_attr($upi_product_history_settings['header_bg']);?>;">Total</th>
						</tr>
					</thead>
					<tbody>
						<tr class="upi_product_list_data_wrapper">
							<td class="upi_product_list_data">Woo Album #1</td>
							<td class="upi_product_list_data">$10.00</td>
   							<td class="upi_product_list_data">1</td>
							<td class="upi_product_list_data">$10.00</td>
						</tr>
						<tr class="upi_product_list_data_wrapper">
							<td class="upi_product_list_data">Woo Album #2</td>
							<td class="upi_product_list_data">$5.00</td>
   							<td class="upi_product_list_data">4</td>
							<td class="upi_product_list_data">$20.00</td>
						</tr>
						<tr class="upi_product_list_data_wrapper">
                        	<td class="upi_product_list_data">Woo Album #3</td>
							<td class="upi_product_list_data">$20.00</td>
   							<td class="upi_product_list_data">1</td>
							<td class="upi_product_list_data">$20.00</td>
						</tr>
						<tr class="upi_product_list_data_wrapper">
							<td class="upi_product_list_data">Woo Album #4</td>
							<td class="upi_product_list_data">$10.00</td>
   							<td class="upi_product_list_data">5</td>
							<td class="upi_product_list_data">$50.00</td>
						</tr>
						<tr>
							<td class="upi_product_list_data"></td>
							<td class="upi_product_list_data"></td>
							<td class="upi_product_list_data">Subtotal</td>
							<td class="upi_product_list_data">$100.00</td>
						</tr>
						<tr class="upi_product_list_data_wrapper">
							<td class="upi_product_list_data"></td>
							<td class="upi_product_list_data"></td>
							<td class="upi_product_list_data">Discount</td>
							<td class="upi_product_list_data">$0.00</td>
						</tr>
						<tr>
							<td class="upi_product_list_data"></td>
							<td class="upi_product_list_data"></td>
							<td class="upi_product_list_data">Total</td>
							<td class="upi_product_list_data">$100.00</td>
						</tr>
					</tbody>
				</table>
				<div class="upi_logo_settings upi_btn upi_setting_location_top"><i class="dashicons dashicons-admin-generic upi_settings_btn_icon"></i></div>
				<div class="upi_section_setting_wrapper upi_setting_location_top">
					<div class="upi_section_setting">
                        <div class="upi_section_setting_title"><?php _e('Header Font size',UPI_TEXTDOMAIN);?></div>
                        <div class="upi_section_setting_element_wrapper">
                             <select name="upi_product_history_header_font_size" class="upi_select_element" onchange="upi_change_css_data(this,'upi_product_list_header','font-size');" >
                             <?php
                                for($i=8;$i<40;$i++)
                                {
                                   echo '<option '.selected($i,$upi_product_history_settings['header_font_size'],1).' value="'.esc_attr($i).'">'.esc_html($i).' px</option>';
                                }
                             ?>
                            </select>
                        </div>
                    </div>
                    <div class="upi_section_setting">
                        <div class="upi_section_setting_title"><?php _e('Body Font size',UPI_TEXTDOMAIN);?></div>
                        <div class="upi_section_setting_element_wrapper">
                             <select name="upi_product_history_body_font_size" class="upi_select_element" onchange="upi_change_css_data(this,'upi_product_list_data','font-size');" >
                             <?php
                                for($i=8;$i<40;$i++)
                                {
                                    echo '<option '.selected($i,$upi_product_history_settings['body_font_size'],1).' value="'.esc_attr($i).'">'.esc_html($i).' px</option>';
                                }
                             ?>
                            </select>
                        </div>
                    </div>
					<div class="upi_section_setting">
						<div class="upi_section_setting_title"><?php _e('Header Background',UPI_TEXTDOMAIN);?></div>
						<div class="upi_section_setting_element_wrapper">
							<input type="text" class="upi_setting_input_element upi_color_picker" name="upi_product_history_header_bg" value="<?php echo esc_attr($upi_product_history_settings['header_bg']);?>" upi_bind_class="upi_product_list_header"/>
						</div>
					</div>
					<div class="upi_section_setting">
						<div class="upi_section_setting_title"><?php _e('Body Background',UPI_TEXTDOMAIN);?></div>
						<div class="upi_section_setting_element_wrapper">
							<input type="text" class="upi_setting_input_element upi_color_picker"  name="upi_product_history_body_bg" value="<?php echo esc_attr($upi_product_history_settings['body_bg']);?>" upi_bind_class="upi_product_list"/>
						</div>
					</div>
					<div class="upi_section_setting">
						<div class="upi_section_setting_title"><?php _e('Hide Section',UPI_TEXTDOMAIN);?></div>
						<div class="upi_section_setting_element_wrapper">
							<input type="checkbox" class="upi_setting_checkbox" name="upi_product_history_hidden" value="1" <?php checked(1,$upi_product_history_settings['is_hidden']);?> />
						</div>
					</div>
				</div>
			</div>
		</div>
        <div class="upi_template_sections upi_order_total_section">
        	<div class="upi_order_total_wrapper upi_template_section_settings" style="font-size:<?php echo esc_attr($upi_order_total_settings['font_size']);?>px;background:<?php echo esc_attr($upi_order_total_settings['bg']);?>;">
				<div class="upi_order_data_wrapper">
					<div class="upi_order_data upi_order_total_title" style="font-size:<?php echo esc_attr($upi_order_total_settings['font_size']);?>px;"><?php echo esc_html( $upi_order_total_settings['title']);?></div>
					<div class="upi_order_sample_data upi_order_total_payment" style="font-size:<?php echo esc_attr($upi_order_total_settings['font_size']);?>px;background:<?php echo esc_attr($upi_order_total_settings['bg1']);?>">$100.00</div>
				</div>
				<div class="upi_logo_settings upi_btn upi_setting_location_top"><i class="dashicons dashicons-admin-generic upi_settings_btn_icon"></i></div>	
				<div class="upi_section_setting_wrapper upi_setting_location_top">
						<div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Title',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
								<input type="text" class="upi_setting_input_element" value="<?php echo esc_attr($upi_order_total_settings['title']);?>" name="upi_order_total_title"  onkeyup="upi_change_element_data(this,'upi_order_total_title','content');"/>
							</div>
						</div>
						<div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Font size',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
                            	 <select name="upi_order_total_font_size" class="upi_select_element" onchange="upi_change_css_data(this,'upi_order_total_payment,.upi_order_total_title','font-size');" >
                                 <?php
                                 	for($i=8;$i<40;$i++)
									{
									 	echo "<option ".selected($i,$upi_order_total_settings['font_size'],1).' value="'.esc_attr($i).'">'.esc_html($i).' px</option>';
									}
								 ?>
                                </select>
							</div>
						</div>
                        <div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Background',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
								<input type="text" name="upi_order_total_bg" class="upi_setting_input_element upi_color_picker" value="<?php echo esc_attr($upi_order_total_settings['bg']);?>"  onkeyup="upi_change_element_data(this,'upi_order_total_title','content');" upi_bind_class="upi_order_total_wrapper"/>
							</div>
						</div>
                         <div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Background',UPI_TEXTDOMAIN);?> 1</div>
							<div class="upi_section_setting_element_wrapper">
								<input type="text" name="upi_order_total_bg_1" class="upi_setting_input_element upi_color_picker" value="<?php echo esc_attr($upi_order_total_settings['bg1']);?>"  onkeyup="upi_change_element_data(this,'upi_order_total_title','content');" upi_bind_class="upi_order_total_payment"/>
							</div>
						</div>
						<div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Hide Section',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
								<input type="checkbox" class="upi_setting_checkbox" value="1" name="upi_order_total_hidden" <?php checked(1,$upi_order_total_settings['is_hidden']);?>/>
							</div>
						</div>
					</div>
			</div>
        </div>
		<div class="upi_template_sections">
			<div class="upi_footer_section_wrapper">
				<div class="upi_footer_upper_content_wrapper upi_template_section_settings">
					<div class="upi_footer_upper_content" style=" <?php echo esc_attr('text-align:'.$upi_footer_upper_settings['text_align'].'; font-size:'.$upi_footer_upper_settings['font_size'].'px;');?>"><?php echo $upi_footer_upper_settings['content'];?></div>
					<div class="upi_logo_settings upi_btn upi_setting_location_top"><i class="dashicons dashicons-admin-generic upi_settings_btn_icon"></i></div>
					<div class="upi_section_setting_wrapper upi_setting_location_top">
                    	<div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Content',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
								<textarea class="upi_setting_textarea_element" name="upi_footer_upper_content"  onkeyup="upi_change_element_data(this,'upi_footer_upper_content','content');" ><?php echo esc_textarea($upi_footer_upper_settings['content']);?></textarea>
							</div>
						</div>
                        <div class="upi_section_setting">
                            <div class="upi_section_setting_title"><?php _e('Text Align',UPI_TEXTDOMAIN);?></div>
                            <div class="upi_section_setting_element_wrapper">
                                <select name="upi_footer_upper_text_align" class="upi_select_element" onchange="upi_change_css_data(this,'upi_footer_upper_content','text-align');">
                                    <option value="center" <?php selected("center",$upi_footer_upper_settings['text_align']);?>><?php _e('Center',UPI_TEXTDOMAIN);?></option>
                                    <option value="left" <?php selected("left",$upi_footer_upper_settings['text_align']);?>><?php _e('Left',UPI_TEXTDOMAIN);?></option>
                                    <option value="right" <?php selected("right",$upi_footer_upper_settings['text_align']);?>><?php _e('Right',UPI_TEXTDOMAIN);?></option>
                                </select>
                            </div>
                        </div>
						<div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Font size',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
                            	 <select name="upi_footer_upper_font_size" class="upi_select_element" onchange="upi_change_css_data(this,'upi_footer_upper_content','font-size');" >
                                 <?php
                                 	for($i=8;$i<40;$i++)
									{
									 	echo '<option '.selected($i,$upi_footer_upper_settings['font_size'],1).' value="'.esc_attr($i).'">'.esc_html($i).' px</option>';
									}
								 ?>
                                </select>
							</div>
						</div>
						<div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Hide Section',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
								<input type="checkbox" class="upi_setting_checkbox" name="upi_footer_upper_hidden"  value="1" <?php checked(1,$upi_footer_upper_settings['is_hidden']);?>/>
							</div>
						</div>
                    </div>
				</div>
				<div class="upi_footer_lower_content_wrapper upi_template_section_settings">
					<div class="upi_footer_lower_content" style=" <?php echo esc_attr('text-align:'.$upi_footer_lower_settings['text_align'].'; font-size:'.$upi_footer_lower_settings['font_size'].'px;');?>"><?php echo $upi_footer_lower_settings['content'];?></div>
					<div class="upi_logo_settings upi_btn upi_setting_location_top"><i class="dashicons dashicons-admin-generic upi_settings_btn_icon"></i></div>
					<div class="upi_section_setting_wrapper upi_setting_location_top">
						<div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Content',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
								<textarea class="upi_setting_textarea_element" name="upi_footer_lower_content"  onkeyup="upi_change_element_data(this,'upi_footer_lower_content','content');" ><?php echo esc_textarea($upi_footer_lower_settings['content']);?></textarea>
							</div>
						</div>
                        <div class="upi_section_setting">
                            <div class="upi_section_setting_title"><?php _e('Text Align',UPI_TEXTDOMAIN);?></div>
                            <div class="upi_section_setting_element_wrapper">
                                <select name="upi_footer_lower_text_align" class="upi_select_element" onchange="upi_change_css_data(this,'upi_footer_lower_content','text-align');">
                                   <option value="center" <?php selected("center",$upi_footer_lower_settings['text_align']);?>><?php _e('Center',UPI_TEXTDOMAIN);?></option>
                                    <option value="left" <?php selected("left",$upi_footer_lower_settings['text_align']);?>><?php _e('Left',UPI_TEXTDOMAIN);?></option>
                                    <option value="right" <?php selected("right",$upi_footer_lower_settings['text_align']);?>><?php _e('Right',UPI_TEXTDOMAIN);?></option>
                                </select>
                            </div>
                        </div>
						<div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Font size',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
                            	 <select name="upi_footer_lower_font_size" class="upi_select_element" onchange="upi_change_css_data(this,'upi_footer_lower_content','font-size');" >
                                 <?php
                                 	for($i=8;$i<40;$i++)
									{
									 	echo '<option '.selected($i,$upi_footer_lower_settings['font_size'],1).' value="'.esc_attr($i).'">'.esc_html($i).' px</option>';
									}
								 ?>
                                </select>
							</div>
						</div>
						<div class="upi_section_setting">
							<div class="upi_section_setting_title"><?php _e('Hide Section',UPI_TEXTDOMAIN);?></div>
							<div class="upi_section_setting_element_wrapper">
								<input type="checkbox" class="upi_setting_checkbox" value="1" name="upi_footer_lower_hidden" <?php checked(1,$upi_footer_lower_settings['is_hidden']);?>/>
							</div>
						</div>
                    </div>
				</div>
			</div>
		</div>
</div>
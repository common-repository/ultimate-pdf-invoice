<?php 
	if (!defined('ABSPATH'))
    die("Can't load this file directly");

global $upi_pdf_invoice, $upi_invoice;

$invoice_templates = $upi_invoice -> get_invoice_templates();

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

if(file_exists(UPI_UPLOAD_DIR.'/'.$upi_header_logo_settings['logo_image']) && $upi_header_logo_settings['logo_image'] != "")
{
	$new_file_path = UPI_UPLOAD_URL.'/'.$upi_header_logo_settings['logo_image'];
}
else
{
	$new_file_path = UPI_IMAGES_URL.'/upi_sample_logo.png';
}
$is_preview = isset($_POST['upi_is_preview'])?$_POST['upi_is_preview']:"";

$upi_invoice_no = $upi_invoice -> get_invoice_number();

$invoice_number = str_pad($upi_invoice_no+1,6,0,STR_PAD_LEFT);

if($is_preview=='1')
{
	$order_data =  new stdClass();
	
	$order_data->order_date = '2016-01-01';
	
	$order_data->id = 1;
	
	$order_data->order_custom_fields = array(
											'_payment_method_title' => array('Cash On Delivery'),
											'_cart_discount'=> array(0),
											'_order_total'=> array(100),
										);
	
	$order_data->product_list = array(
									array(
									'name' => 'Woo Logo #1',
									'item_meta' => array('_qty'=>array(1)),
									'line_subtotal' => "10",
									'line_total' => "10",
									'line_tax' => 0
									),
									array(
									'name' => 'Woo Logo #2',
									'item_meta' => array('_qty'=>array(4)),
									'line_subtotal' => "5",
									'line_total' => "20",
									'line_tax' => 0
									),
									array(
									'name' => 'Woo Logo #3',
									'item_meta' => array('_qty'=>array(1)),
									'line_subtotal' => "20",
									'line_total' => "20",
									'line_tax' => 0
									),
									array(
									'name' => 'Woo Logo #4',
									'item_meta' => array('_qty'=>array(5)),
									'line_subtotal' => "10",
									'line_total' => "50",
									'line_tax' => 0
									)
								);
	
	$billing_address = '<b>Demo.com</b><br>Demo India Private Limited.<br>555, Demo Park, demo Road,<br>Bangalore - 560001.<br>Karnataka. India.';
	
	$upi_order_currency = "USD";
	
	$upi_order_subtotal = "100";
	
	$order_id = "01";
}
else
{
	update_option('upi_order_invoice_no',$upi_invoice_no+1);
	
	$order_data = $upi_invoice -> get_order_by_id($order_id);
	
	$billing_address = $order_data->get_formatted_billing_address();
	
	$upi_order_currency = $order_data->get_order_currency();
	
	$upi_order_subtotal = $upi_invoice->upi_get_subtotal($order_data);
}



ob_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
	<link type="text/css" rel="stylesheet" href="<?php echo esc_url(UPI_CSS_URL.'/templates/template_'.$template_id.'.css');?>">
    <style type="text/css">
    	.upi_template_section_settings
		{
			border:none !important;	
		}
		.upi_template_editor_wrapper
		{
			padding-top:0;	
		}
		.upi_template_logo_settings_hidden
		{
		 	visibility:hidden;	
		}
    </style>
</head>

<body>
	<div class="upi_template_editor_wrapper">
    <?php	if($upi_header_logo_settings['logo_hidden']!=1){
            ?>
            
            <div class="upi_template_sections">
                <div class="upi_template_logo_wrapper upi_template_section_settings">
                    <div class="upi_template_logo_settings upi_template_logo_settings_hidden">
                        <img style=" <?php echo esc_attr('float:'.$upi_header_logo_settings['logo_position']);?>;" class="upi_company_logo" src="<?php echo esc_url($new_file_path);?>"/>
                    </div>
                </div>
            </div>
            <?php
            
            }
    	 if($upi_from_address_settings['is_hidden']!=1){?>
            <div class="upi_template_sections">
                <div class="upi_company_address_wrapper">
                    <div class="upi_company_address_outer upi_template_section_settings">
                        <div class="upi_company_address upi_company_address_data" style="position:relative">
                            <div class="upi_from_address" id="upi_manage_position"  style="width:300px;<?php echo esc_attr('float:'.$upi_from_address_settings['position'].'; text-align: '.$upi_from_address_settings['text_align'].'; font-size: '.$upi_from_address_settings['font_size'].'px;');?>"><?php echo $upi_from_address_settings['content'];?></div>
                         </div>
                    </div>
                </div>
            </div>
            <?php }
			
			if($upi_to_address_settings['is_hidden']!=1){?>
            
            <div class="upi_template_sections">
                <div class="upi_template_invoice_from_wrapper upi_template_section_settings">
                    <div class="upi_company_address" style="position:relative;" >
                        <div class="upi_to_address upi_manage_position" style="width:300px;<?php echo esc_attr('float:'.$upi_to_address_settings['position'].'; text-align: '.$upi_to_address_settings['text_align'].'; font-size: '.$upi_to_address_settings['font_size'].'px;');?>">
						<?php echo '<strong>Billing Address</strong><br />'.$billing_address;?></div>
                        
                    </div>
                </div>
                <div class="upi_order_details_wrppar upi_template_section_settings" style="font-size:<?php echo esc_attr($upi_order_invoice_settings['font_size']);?>px;background:<?php echo esc_attr($upi_order_invoice_settings['bg']);?>;">
                    <div class="upi_order_data_header upi_order_invoice_title" ><?php echo $upi_order_invoice_settings['title'];?></div>
                    <div class="upi_order_data_wrapper">
                        <div class="upi_order_data">Order</div>
                        <div class="upi_order_sample_data"><?php echo esc_html($order_data->id);?></div>
                    </div>
                    <div class="upi_order_data_wrapper">
                        <div class="upi_order_data">Invoice date</div>
                        <div class="upi_order_sample_data"><?php echo date('Y-m-d',strtotime(esc_html($order_data->order_date)));?></div>
                    </div>
                    <div class="upi_order_data_wrapper">
                        <div class="upi_order_data">Payment Method</div>
                        <div class="upi_order_sample_data"><?php echo esc_html($order_data->order_custom_fields['_payment_method_title'][0]);?></div>	
                    </div>	
                </div>
                
            </div>
            <?php }
			
			if($upi_product_history_settings['is_hidden']!=1){?>
            <div class="upi_template_sections upi_product_list_section">
                <div class="upi_product_list_wrapper upi_template_section_settings">
                    <table class="upi_product_list" cellpadding="0" cellspacing="0" style="background:<?php echo $upi_product_history_settings['body_bg'];?>;">
                        <thead>
                           <tr class="upi_product_list_header_wrapper">
                                <th class="upi_product_list_header" style="background:<?php echo esc_attr($upi_product_history_settings['header_bg']);?>;">Product</th>
                                <th class="upi_product_list_header" style="background:<?php echo esc_attr($upi_product_history_settings['header_bg']);?>;">Price</th>
                                <th class="upi_product_list_header" style="background:<?php echo esc_attr($upi_product_history_settings['header_bg']);?>;">Qty</th>
                                <th class="upi_product_list_header" style="background:<?php echo esc_attr($upi_product_history_settings['header_bg']);?>;">Total</th>                            </tr>
                        </thead>
                        <tbody>
                        <?php 
							if(!empty($order_data->product_list))
							{
								foreach($order_data->product_list as $product_data)
								{
									if($is_preview=='1')
									{
										
										?>
                                         <tr class="upi_product_list_data_wrapper">
                                            <td class="upi_product_list_data"><?php echo esc_html($product_data['name']);?></td>
                                            
                                            <td class="upi_product_list_data"><?php echo wc_price($product_data['line_subtotal'], array( 'currency' => $upi_order_currency ) );?></td>
                                            
                                            <td class="upi_product_list_data"><?php echo esc_html($product_data['item_meta']['_qty'][0]);?></td>
                                            
                                            <td class="upi_product_list_data"><?php echo wc_price($product_data['line_total'], array( 'currency' => $upi_order_currency ) );?></td>
                                </tr>
                                        
                                        <?php
										
									}
									else
									{
										if(function_exists(get_product))
										{
											$product = get_product($product_data['item_meta']['_product_id'][0]);
										}
										else
										{
											$product = new WC_product($product_data['item_meta']['_product_id'][0]);
										}
										?>
										<tr class="upi_product_list_data_wrapper">
											<td class="upi_product_list_data"><?php echo esc_html($product->get_title());?></td>
											
											<td class="upi_product_list_data"><?php echo wc_price($product->get_price(), array( 'currency' => $upi_order_currency ) );?></td>
											<td class="upi_product_list_data"><?php echo esc_html($product_data['item_meta']['_qty'][0]);?></td>
											
											<td class="upi_product_list_data"><?php echo wc_price($product_data['line_total'], array( 'currency' => $upi_order_currency ) );?></td>
										</tr>
										<?php 
									}
							  	}?>
                            <tr>
                                <td class="upi_product_list_data"></td>
                                <td class="upi_product_list_data"></td>
                                <td class="upi_product_list_data">Subtotal</td>
                                <td class="upi_product_list_data"><?php echo wc_price($upi_order_subtotal, array( 'currency' => $upi_order_currency ) );?></td>
                            </tr>
                            <tr class="upi_product_list_data_wrapper">
                                <td class="upi_product_list_data"></td>
                                <td class="upi_product_list_data"></td>
                                <td class="upi_product_list_data">Cart Discount</td>
                                <td class="upi_product_list_data"><?php echo wc_price($order_data->order_custom_fields['_cart_discount'][0], array( 'currency' => $upi_order_currency ) );?></td>
                            </tr>
                            <tr>
                                <td class="upi_product_list_data"></td>
                                <td class="upi_product_list_data"></td>
                                <td class="upi_product_list_data">Total</td>
                                <td class="upi_product_list_data"><?php echo wc_price($order_data->order_custom_fields['_order_total'][0], array( 'currency' => $upi_order_currency ) );?></td>
                            </tr>
                            <?php 
							}
							?>
                        </tbody>
                    </table>
                </div>
               
            </div>
             <?php }?>
    </div>
</body>
</html>

<?php

$html = ob_get_contents ();
			
ob_end_clean ();

ob_start();

if($upi_header_logo_settings['logo_hidden']!=1){
?>

<div class="upi_template_sections" style="padding:0 40px;">
    <div class="upi_template_logo_wrapper upi_template_section_settings">
        <div class="upi_template_logo_settings">
            <img style="float:<?php echo esc_attr($upi_header_logo_settings['logo_position'])?>;" class="upi_company_logo" src="<?php echo esc_url($new_file_path);?>"/>
        </div>
    </div>
</div>
<?php

}
$html_header = ob_get_contents ();
			
ob_end_clean ();

ob_start();

if($upi_footer_upper_settings['is_hidden']!=1 || $upi_footer_lower_settings['is_hidden']!=1){
?>
<div class="upi_footer_section_wrapper" style="padding:0 40px;">
					<?php if($upi_footer_upper_settings['is_hidden']!=1 ){?>
                    <div class="upi_footer_upper_content_wrapper upi_template_section_settings">
                        <div class="upi_footer_upper_content" style="text-align:<?php echo esc_attr($upi_footer_upper_settings['text_align'].'; font-size:'.$upi_footer_upper_settings['font_size'].'px;');?>"><?php echo $upi_footer_upper_settings['content'];?></div>
                    </div>
                    <?php } if($upi_footer_lower_settings['is_hidden']!=1 ){?>
                    <div class="upi_footer_lower_content_wrapper upi_template_section_settings">
                        <div class="upi_footer_lower_content" style="text-align:<?php echo esc_attr($upi_footer_lower_settings['text_align'].'; font-size:'.$upi_footer_lower_settings['font_size'].'px;');?>"><?php echo $upi_footer_lower_settings['content'];?></div>
                    </div>
                    <?php }?>
                </div>
<?php
}
$html_footer = ob_get_contents ();
			
ob_end_clean ();
?>
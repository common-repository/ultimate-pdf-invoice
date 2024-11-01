jQuery(document).on('click','.upi_template_section_settings',function(){
	jQuery('.upi_settings_selected').removeClass('upi_settings_selected');
	jQuery(this).addClass('upi_settings_selected');
});
jQuery(document).ready(function(){
	
	if ( jQuery.isFunction(jQuery.fn.wpColorPicker) ) {	
		jQuery(".upi_color_picker").wpColorPicker({
			change:function(event,ui){
				jQuery('.'+jQuery(this).attr('upi_bind_class')).css('background',this.value);
			}	
		});	
	}
	
	jQuery('.upi_template_editor').submit(function(e) {	
				e.preventDefault();
				jQuery(this).ajaxSubmit({ 
					target:   '.upi_template_editor_wrapper',						
					url:upi_invoice_data.upi_ajax_url,
					dataType:'json',
					data:{'action':'upi_update_invoice_logo'},
					success:function (response){
						if(response.message=='success')
						{
							if(response.file_url!="")
							{
								jQuery('.upi_company_logo').attr('src',response.file_url);
								
								jQuery('.upi_invoice_image').val(response.file_name);
								
							}
						}
						else
						{
							
						}
	
					},
					resetForm: false 
				}); 
				
				return false; 
	});
	
});
jQuery(document).on('change','.upi_choose_logo',function(){
														 
	jQuery('.upi_template_editor').submit();														
});
function upi_change_element_data($this, $element, $operation)
{
	if($operation=='content')
	{
		jQuery('.'+ $element).html(jQuery($this).val());
	}
	
}
function upi_change_css_data($this, $element, $property)
{
	if($property == 'font-size')
	{
		jQuery('.'+ $element).css($property,jQuery($this).val()+'px');
	}
	else
	{
		jQuery('.'+ $element).css($property,jQuery($this).val());
	}
}
jQuery(document).on('click keyup','html',function(e){
	if(e.keyCode == 27 || (e.keyCode == undefined &&!(jQuery(e.target).hasClass('upi_template_section_settings') || jQuery(e.target).closest('.upi_template_section_settings').length>0 )))
	{
		jQuery('.upi_settings_selected').removeClass('upi_settings_selected');	
	}
	
		
});
jQuery(document).on('click','.upi_template_save_btn',function(){
	
	jQuery('.upi-info-box').addClass('upi-box-loading');
	
	jQuery('.upi-info-box-saving-data').addClass('upi-box-msg');
	
	var form_data = jQuery('.upi_template_editor').serialize();
												 
	jQuery.ajax({
			url:upi_invoice_data.upi_ajax_url,
			type:'POST',
			data:"action=upi_save_template&"+form_data,
			dataType: 'json',
			success:function(results){
				if(results.message == 'success')
				{
					jQuery('.upi-info-box-saving-data').removeClass('upi-box-msg');
					
					jQuery('.upi-info-box-saved-data').addClass('upi-box-msg');
					
					setTimeout(function() {
						jQuery('.upi-info-box').removeClass('upi-box-loading');
						setTimeout(function() {
							jQuery('.upi-info-box-saving-data').removeClass('upi-box-msg');
							jQuery('.upi-info-box-saved-data').removeClass('upi-box-msg');
						}, 800);
					}, 800);
				
					
				}
			}
		});														
});
jQuery(document).on('click','.upi_template_preview_btn',function(){
													 
	jQuery('.upi_preview_frm').submit();
});
jQuery(document).on('click','.upi_settings_save_btn',function(){
	
	jQuery('.upi-info-box').addClass('upi-box-loading');
	
	jQuery('.upi-info-box-saving-data').addClass('upi-box-msg');
	
	var form_data = jQuery('.upi_generate_custom_invoice_frm').serialize();
												 
	jQuery.ajax({
			url:upi_invoice_data.upi_ajax_url,
			type:'POST',
			data:"action=upi_save_invoice_settings&"+form_data,
			dataType: 'json',
			success:function(results){
				if(results.message == 'success')
				{
					jQuery('.upi-info-box-saving-data').removeClass('upi-box-msg');
					
					jQuery('.upi-info-box-saved-data').addClass('upi-box-msg');
					
					setTimeout(function() {
						jQuery('.upi-info-box').removeClass('upi-box-loading');
						setTimeout(function() {
							jQuery('.upi-info-box-saving-data').removeClass('upi-box-msg');
							jQuery('.upi-info-box-saved-data').removeClass('upi-box-msg');
						}, 800);
					}, 800);
				
					
				}
			}
		});														
});
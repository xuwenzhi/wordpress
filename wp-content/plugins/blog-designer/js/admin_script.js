jQuery('document').ready(function(){
   jQuery('#template_ftcolor,#template_bgcolor,#template_alterbgcolor,#template_titlecolor,#template_titlebackcolor,#template_contentcolor,#template_readmorecolor,#template_readmorebackcolor,#template_color').wpColorPicker();
    
   if(jQuery("input[name='rss_use_excerpt']:checked").val() == 1){
        jQuery('tr.excerpt_length').show();
        jQuery('tr.read_more_text').show();
        jQuery('tr.read_more_text_color').show();
        jQuery('tr.read_more_text_background').show();
    }else{
        jQuery('tr.excerpt_length').hide();
        jQuery('tr.read_more_text').hide();
        jQuery('tr.read_more_text_color').hide();
        jQuery('tr.read_more_text_background').hide();
    }
    
        
    jQuery("input[name='template_alternativebackground']").change(function () {        
        if(jQuery(this).val() == 0){
            jQuery('.alternative-color-tr').show();
        }else{
            jQuery('.alternative-color-tr').hide();
        }
    });
        
    if(jQuery('#template_name').val() == 'classical' || jQuery('#template_name').val() == 'spektrum'|| jQuery('#template_name').val() == 'timeline'){
        jQuery('tr.blog-template-tr').hide();
        jQuery('tr.alternative-color-tr').hide();
    }else{        
        jQuery('tr.blog-template-tr').show();
        if(jQuery("input[name='template_alternativebackground']:checked").val() == 0){        
            jQuery('.alternative-color-tr').show();
        }else{        
            jQuery('.alternative-color-tr').hide();
        }
    }
    if(jQuery('#template_name').val() == 'timeline') {
        jQuery('tr.blog-template-tr').hide();
           jQuery('tr.alternative-color-tr').hide();
           jQuery('tr.blog-templatecolor-tr').show();
        }else{            
            jQuery('tr.blog-templatecolor-tr').hide();
        }
    
    jQuery('#template_name').change(function (){
       if(jQuery(this).val() == 'classical' || jQuery(this).val() == 'spektrum') {
           jQuery('tr.blog-template-tr').hide();
           jQuery('tr.alternative-color-tr').hide();
       }else{
           jQuery('tr.blog-template-tr').show();
           if(jQuery("input[name='template_alternativebackground']:checked").val() == 0){        
                jQuery('.alternative-color-tr').show();
            }else{        
                jQuery('.alternative-color-tr').hide();
            }
        }
        if(jQuery('#template_name').val() == 'timeline') {
        jQuery('tr.blog-template-tr').hide();
           jQuery('tr.alternative-color-tr').hide();
           jQuery('tr.blog-templatecolor-tr').show();
        }else{            
            jQuery('tr.blog-templatecolor-tr').hide();
        }
    });
    
    jQuery("input[name='rss_use_excerpt']").change(function () {
        
        if(jQuery(this).val() == 1){
            jQuery('tr.excerpt_length').show();
            jQuery('tr.read_more_text').show();
            jQuery('tr.read_more_text_color').show();
            jQuery('tr.read_more_text_background').show();
        }else{
            jQuery('tr.excerpt_length').hide();
            jQuery('tr.read_more_text').hide();
            jQuery('tr.read_more_text_color').hide();
            jQuery('tr.read_more_text_background').hide();
        }
    }); 
    
});

jQuery(window).load(function(){
   jQuery('#subscribe_thickbox').trigger('click');
   jQuery("#TB_closeWindowButton").click(function() {
        jQuery.post(ajaxurl,
        {
            'action': 'close_tab'
        });
   });
});
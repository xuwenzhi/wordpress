jQuery('document').ready(function () {
    jQuery('#template_ftcolor,#template_bgcolor,#template_alterbgcolor,#template_titlecolor,#template_titlebackcolor,#template_contentcolor,#template_readmorecolor,#template_readmorebackcolor,#template_color').wpColorPicker();

    if (jQuery("input[name='rss_use_excerpt']:checked").val() == 1) {
        jQuery('tr.excerpt_length').show();
        jQuery('tr.read_more_text').show();
        jQuery('tr.read_more_text_color').show();
        jQuery('tr.read_more_text_background').show();
    } else {
        jQuery('tr.excerpt_length').hide();
        jQuery('tr.read_more_text').hide();
        jQuery('tr.read_more_text_color').hide();
        jQuery('tr.read_more_text_background').hide();
    }


    jQuery("input[name='template_alternativebackground']").change(function () {
        if (jQuery(this).val() == 0) {
            jQuery('.alternative-color-tr').show();
        } else {
            jQuery('.alternative-color-tr').hide();
        }
    });

    if (jQuery('#template_name').val() == 'classical' || jQuery('#template_name').val() == 'spektrum' || jQuery('#template_name').val() == 'timeline') {
        jQuery('tr.blog-template-tr').hide();
        jQuery('tr.alternative-color-tr').hide();
    } else {
        jQuery('tr.blog-template-tr').show();
        if (jQuery("input[name='template_alternativebackground']:checked").val() == 0) {
            jQuery('.alternative-color-tr').show();
        } else {
            jQuery('.alternative-color-tr').hide();
        }
    }
    if (jQuery('#template_name').val() == 'timeline') {
        jQuery('tr.blog-template-tr').hide();
        jQuery('tr.alternative-color-tr').hide();
        jQuery('tr.blog-templatecolor-tr').show();
    } else {
        jQuery('tr.blog-templatecolor-tr').hide();
    }

    jQuery('#template_name').change(function () {
        if (jQuery(this).val() == 'classical' || jQuery(this).val() == 'spektrum') {
            jQuery('tr.blog-template-tr').hide();
            jQuery('tr.alternative-color-tr').hide();
        } else {
            jQuery('tr.blog-template-tr').show();
            if (jQuery("input[name='template_alternativebackground']:checked").val() == 0) {
                jQuery('.alternative-color-tr').show();
            } else {
                jQuery('.alternative-color-tr').hide();
            }
        }
        if (jQuery('#template_name').val() == 'timeline') {
            jQuery('tr.blog-template-tr').hide();
            jQuery('tr.alternative-color-tr').hide();
            jQuery('tr.blog-templatecolor-tr').show();
        } else {
            jQuery('tr.blog-templatecolor-tr').hide();
        }
    });

    jQuery("input[name='rss_use_excerpt']").change(function () {

        if (jQuery(this).val() == 1) {
            jQuery('tr.excerpt_length').show();
            jQuery('tr.read_more_text').show();
            jQuery('tr.read_more_text_color').show();
            jQuery('tr.read_more_text_background').show();
        } else {
            jQuery('tr.excerpt_length').hide();
            jQuery('tr.read_more_text').hide();
            jQuery('tr.read_more_text_color').hide();
            jQuery('tr.read_more_text_background').hide();
        }
    });
    
    jQuery('link').each(function(){
        var href = jQuery(this).attr('href');
        if( href.search( 'jquery-ui.css' ) !== -1 || href.search( 'jquery-ui.min.css' ) !== -1 ){
            jQuery(this).remove('link');
        }
    });
    
    jQuery('.bd_theme_plugin li a').click(function (e){
       e.preventDefault();
       jQuery('.bd_theme_plugin li').removeClass('active');
       var $name = jQuery(this).attr('data-toggle');
       jQuery(this).parent('li').addClass('active');
       jQuery('.bd-out-other-work .bd-info-content > div').hide();
       jQuery('#'+$name).show();
    });
    /*Set Default value for each template*/
    jQuery('.bd-form-class .bdp-restore-default').click(function(){
        if (confirm('Do you want to reset data?')) {
            var template = jQuery('#template_name').val();
            if(template == 'classical'){
                jQuery("#display_category_0").prop("checked", true);
                jQuery("#display_category_1").prop("checked", false);
                jQuery("#display_tag_0").prop("checked", true);
                jQuery("#display_tag_1").prop("checked", false);
                jQuery("#display_author_0").prop("checked", true);
                jQuery("#display_author_1").prop("checked", false);     
                jQuery("#display_date_0").prop("checked", true);
                jQuery("#display_date_1").prop("checked", false);
                jQuery("#display_comment_count_0").prop("checked", true);
                jQuery("#display_comment_count_1").prop("checked", false);
                jQuery('#template_ftcolor').iris('color', '#2a97ea');
                jQuery('#template_titlecolor').iris('color', '#222222');
                jQuery('#template_titlebackcolor').iris('color', '#ffffff');
                jQuery("#template_titlefontsize").val("30");
                jQuery("#rss_use_excerpt_0").prop("checked", false);
                jQuery("#rss_use_excerpt_1").prop("checked", true);
                jQuery("#txtExcerptlength").val("50");
                jQuery("#content_fontsize").val("14");
                jQuery("#posts_per_page").val("5");
                jQuery('#template_contentcolor').iris('color', '#999999');
                jQuery('#txtReadmoretext').val('Read More');
                jQuery('#template_readmorecolor').iris('color', '#cecece');
                jQuery('#template_readmorebackcolor').iris('color', '#2e93ea');
                jQuery("#social_icon_style_1").prop("checked", true);
                jQuery("#social_icon_style_0").prop("checked", false);
                jQuery("#facebook_link_0").prop("checked", true);
                jQuery("#facebook_link_1").prop("checked", false);
                jQuery("#twitter_link_0").prop("checked", true);
                jQuery("#twitter_link_1").prop("checked", false);
                jQuery("#google_link_0").prop("checked", true);
                jQuery("#google_link_1").prop("checked", false);
                jQuery("#linkedin_link_0").prop("checked", true);
                jQuery("#linkedin_link_1").prop("checked", false);
                jQuery("#pinterest_link_0").prop("checked", true);
                jQuery("#pinterest_link_1").prop("checked", false);
                jQuery("#instagram_link_0").prop("checked", true);
                jQuery("#instagram_link_1").prop("checked", false);
                jQuery('.buttonset').buttonset();
                /*---------------------------------------------*/
            }
            if(template == 'lightbreeze'){
                jQuery("#display_category_0").prop("checked", true);
                jQuery("#display_category_1").prop("checked", false);
                jQuery("#display_tag_0").prop("checked", true);
                jQuery("#display_tag_1").prop("checked", false);
                jQuery("#display_author_0").prop("checked", true);
                jQuery("#display_author_1").prop("checked", false);     
                jQuery("#display_date_0").prop("checked", true);
                jQuery("#display_date_1").prop("checked", false);
                jQuery("#display_comment_count_0").prop("checked", true);
                jQuery("#display_comment_count_1").prop("checked", false);
                jQuery('#template_bgcolor').iris('color', '#ffffff');
                jQuery("#template_alternativebackground_0").prop("checked", false);
                jQuery("#template_alternativebackground_1").prop("checked", true);
                jQuery('#template_ftcolor').iris('color', '#1eafa6');
                jQuery('#template_titlecolor').iris('color', '#222222');
                jQuery('#template_titlebackcolor').iris('color', '#ffffff');
                jQuery("#template_titlefontsize").val("30");
                jQuery("#rss_use_excerpt_0").prop("checked", false);
                jQuery("#rss_use_excerpt_1").prop("checked", true);
                jQuery("#txtExcerptlength").val("50");
                jQuery("#content_fontsize").val("14");
                jQuery("#posts_per_page").val("5");
                jQuery('#template_contentcolor').iris('color', '#999999');
                jQuery('#txtReadmoretext').val('Continue Reading');
                jQuery('#template_readmorecolor').iris('color', '#f1f1f1');
                jQuery('#template_readmorebackcolor').iris('color', '#1eafa6');
                jQuery("#social_icon_style_1").prop("checked", false);
                jQuery("#social_icon_style_0").prop("checked", true);
                jQuery("#facebook_link_0").prop("checked", true);
                jQuery("#facebook_link_1").prop("checked", false);
                jQuery("#twitter_link_0").prop("checked", true);
                jQuery("#twitter_link_1").prop("checked", false);
                jQuery("#google_link_0").prop("checked", true);
                jQuery("#google_link_1").prop("checked", false);
                jQuery("#linkedin_link_0").prop("checked", true);
                jQuery("#linkedin_link_1").prop("checked", false);
                jQuery("#pinterest_link_0").prop("checked", true);
                jQuery("#pinterest_link_1").prop("checked", false);
                jQuery("#instagram_link_0").prop("checked", true);
                jQuery("#instagram_link_1").prop("checked", false);
                jQuery('.buttonset').buttonset();
                /*---------------------------------------------*/
            }
            if(template == 'spektrum'){
                jQuery("#display_category_0").prop("checked", true);
                jQuery("#display_category_1").prop("checked", false);
                jQuery("#display_tag_0").prop("checked", true);
                jQuery("#display_tag_1").prop("checked", false);
                jQuery("#display_author_0").prop("checked", true);
                jQuery("#display_author_1").prop("checked", false);     
                jQuery("#display_date_0").prop("checked", true);
                jQuery("#display_date_1").prop("checked", false);
                jQuery("#display_comment_count_0").prop("checked", true);
                jQuery("#display_comment_count_1").prop("checked", false);                
                jQuery('#template_ftcolor').iris('color', '#2d7fc1');
                jQuery('#template_titlecolor').iris('color', '#2d7fc1');
                jQuery('#template_titlebackcolor').iris('color', '#ffffff');
                jQuery("#template_titlefontsize").val("30");
                jQuery("#rss_use_excerpt_0").prop("checked", false);
                jQuery("#rss_use_excerpt_1").prop("checked", true);
                jQuery("#txtExcerptlength").val("50");
                jQuery("#content_fontsize").val("14");
                jQuery("#posts_per_page").val("5");
                jQuery('#template_contentcolor').iris('color', '#444');
                jQuery('#txtReadmoretext').val('Go ahead');
                jQuery('#template_readmorecolor').iris('color', '#eaeaea');
                jQuery('#template_readmorebackcolor').iris('color', '#2d7fc1');
                jQuery("#social_icon_style_1").prop("checked", true);
                jQuery("#social_icon_style_0").prop("checked", false);
                jQuery("#facebook_link_0").prop("checked", true);
                jQuery("#facebook_link_1").prop("checked", false);
                jQuery("#twitter_link_0").prop("checked", true);
                jQuery("#twitter_link_1").prop("checked", false);
                jQuery("#google_link_0").prop("checked", true);
                jQuery("#google_link_1").prop("checked", false);
                jQuery("#linkedin_link_0").prop("checked", true);
                jQuery("#linkedin_link_1").prop("checked", false);
                jQuery("#pinterest_link_0").prop("checked", true);
                jQuery("#pinterest_link_1").prop("checked", false);
                jQuery("#instagram_link_0").prop("checked", true);
                jQuery("#instagram_link_1").prop("checked", false);
                jQuery('.buttonset').buttonset();
                /*---------------------------------------------*/
            }
            if(template == 'evolution'){
                jQuery("#display_category_0").prop("checked", true);
                jQuery("#display_category_1").prop("checked", false);
                jQuery("#display_tag_0").prop("checked", true);
                jQuery("#display_tag_1").prop("checked", false);
                jQuery("#display_author_0").prop("checked", true);
                jQuery("#display_author_1").prop("checked", false);     
                jQuery("#display_date_0").prop("checked", true);
                jQuery("#display_date_1").prop("checked", false);
                jQuery("#display_comment_count_0").prop("checked", true);
                jQuery("#display_comment_count_1").prop("checked", false);
                jQuery('#template_bgcolor').iris('color', '#ffffff');
                jQuery("#template_alternativebackground_0").prop("checked", false);
                jQuery("#template_alternativebackground_1").prop("checked", true);
                jQuery('#template_ftcolor').iris('color', '#2eba89');
                jQuery('#template_titlecolor').iris('color', '#222');
                jQuery('#template_titlebackcolor').iris('color', '#ffffff');
                jQuery("#template_titlefontsize").val("30");
                jQuery("#rss_use_excerpt_0").prop("checked", false);
                jQuery("#rss_use_excerpt_1").prop("checked", true);
                jQuery("#txtExcerptlength").val("50");
                jQuery("#content_fontsize").val("14");
                jQuery("#posts_per_page").val("5");
                jQuery('#template_contentcolor').iris('color', '#444444');
                jQuery('#txtReadmoretext').val('Keep Reading');
                jQuery('#template_readmorecolor').iris('color', '#2eba89');
                jQuery('#template_readmorebackcolor').iris('color', '#f1f1f1');
                jQuery("#social_icon_style_1").prop("checked", true);
                jQuery("#social_icon_style_0").prop("checked", false);
                jQuery("#facebook_link_0").prop("checked", true);
                jQuery("#facebook_link_1").prop("checked", false);
                jQuery("#twitter_link_0").prop("checked", true);
                jQuery("#twitter_link_1").prop("checked", false);
                jQuery("#google_link_0").prop("checked", true);
                jQuery("#google_link_1").prop("checked", false);
                jQuery("#linkedin_link_0").prop("checked", true);
                jQuery("#linkedin_link_1").prop("checked", false);
                jQuery("#pinterest_link_0").prop("checked", true);
                jQuery("#pinterest_link_1").prop("checked", false);
                jQuery("#instagram_link_0").prop("checked", true);
                jQuery("#instagram_link_1").prop("checked", false);
                jQuery('.buttonset').buttonset();
                /*---------------------------------------------*/
            }
            if(template == 'timeline'){
                jQuery("#display_category_0").prop("checked", true);
                jQuery("#display_category_1").prop("checked", false);
                jQuery("#display_tag_0").prop("checked", true);
                jQuery("#display_tag_1").prop("checked", false);
                jQuery("#display_author_0").prop("checked", true);
                jQuery("#display_author_1").prop("checked", false);
                jQuery("#display_date_0").prop("checked", true);
                jQuery("#display_date_1").prop("checked", false);
                jQuery("#display_comment_count_0").prop("checked", true);
                jQuery("#display_comment_count_1").prop("checked", false);              
                jQuery('#template_color').iris('color', '#db4c59');
                jQuery('#template_ftcolor').iris('color', '#db4c59');
                jQuery('#template_titlecolor').iris('color', '#222');
                jQuery('#template_titlebackcolor').iris('color', '#ffffff');
                jQuery("#template_titlefontsize").val("30");
                jQuery("#rss_use_excerpt_0").prop("checked", false);
                jQuery("#rss_use_excerpt_1").prop("checked", true);
                jQuery("#txtExcerptlength").val("50");
                jQuery("#content_fontsize").val("14");
                jQuery("#posts_per_page").val("5");
                jQuery('#template_contentcolor').iris('color', '#444');
                jQuery('#txtReadmoretext').val('Read More');
                jQuery('#template_readmorecolor').iris('color', '#db4c59');
                jQuery('#template_readmorebackcolor').iris('color', '#f1f1f1');
                jQuery("#social_icon_style_1").prop("checked", false);
                jQuery("#social_icon_style_0").prop("checked", true);
                jQuery("#facebook_link_0").prop("checked", true);
                jQuery("#facebook_link_1").prop("checked", false);
                jQuery("#twitter_link_0").prop("checked", true);
                jQuery("#twitter_link_1").prop("checked", false);
                jQuery("#google_link_0").prop("checked", true);
                jQuery("#google_link_1").prop("checked", false);
                jQuery("#linkedin_link_0").prop("checked", true);
                jQuery("#linkedin_link_1").prop("checked", false);
                jQuery("#pinterest_link_0").prop("checked", true);
                jQuery("#pinterest_link_1").prop("checked", false);
                jQuery("#instagram_link_0").prop("checked", true);
                jQuery("#instagram_link_1").prop("checked", false);
                jQuery('.buttonset').buttonset();
                /*---------------------------------------------*/
            }
            jQuery('.chosen-select option').prop('selected', false).trigger('chosen:updated');
            jQuery('form.bd-form-class')[0].submit();
        } else {
            return false;
        }          
    });
});

jQuery(window).load(function () {
    jQuery('#subscribe_thickbox').trigger('click');
    jQuery("#TB_closeWindowButton").click(function () {
        jQuery.post(ajaxurl,
                {
                    'action': 'close_tab'
                });
    });
});



jQuery('.bd-form-class .hndle,.bd-form-class .handlediv ').click(function (event) {
    if (jQuery(this).parent('div.postbox').hasClass('closed')) {
        jQuery(this).parent('div.postbox').removeClass('closed');
    } else {
        jQuery(this).parent('div.postbox').addClass('closed');
    }
    var closed = jQuery('.postbox').filter('.closed').map(function () {
        return this.id;
    }).get().join(',');
    jQuery.post(ajaxurl, {
        action: 'bd_closed_bdboxes',
        closed: closed,
        page: 'designer_settings'
    });
});

jQuery(document).ready(function () {
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {allow_single_deselect: true},
        '.chosen-select-no-single': {disable_search_threshold: 10},
        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        '.chosen-select-width': {width: "95%"}
    }
    for (var selector in config) {
        jQuery(selector).chosen(config[selector]);
    }
    jQuery('.buttonset').buttonset();
});

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

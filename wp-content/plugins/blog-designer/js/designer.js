(function ($) {
    var initLayout = function () {
        $('#bgcolorSelector').ColorPicker({
            color: '#0000ff',
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#bgcolorSelector div').css('backgroundColor', '#' + hex);
                $('#template_bgcolor').val('#' + hex);
            }
        });

        $('#ftcolorSelector').ColorPicker({
            color: '#0000ff',
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#ftcolorSelector div').css('backgroundColor', '#' + hex);
                $('#template_ftcolor').val('#' + hex);
            }
        });
        
        $('#titlecolorSelector').ColorPicker({
            color: '#3498db',
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#titlecolorSelector div').css('backgroundColor', '#' + hex);
                $('#template_titlecolor').val('#' + hex);
            }
        });
        
        $('#contentcolorSelector').ColorPicker({
            color: '#3498db',
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#contentcolorSelector div').css('backgroundColor', '#' + hex);
                $('#template_contentcolor').val('#' + hex);
            }
        });
        $('#readmorecolorSelector').ColorPicker({
            color: '#3498db',
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#readmorecolorSelector div').css('backgroundColor', '#' + hex);
                $('#template_readmorecolor').val('#' + hex);
            }
        });
        $('#readmorebackcolorSelector').ColorPicker({
            color: '#3498db',
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#readmorebackcolorSelector div').css('backgroundColor', '#' + hex);
                $('#template_readmorebackcolor').val('#' + hex);
            }
        });
        
        $('#alterbgcolorSelector').ColorPicker({
            color: '#3498db',
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#alterbgcolorSelector div').css('backgroundColor', '#' + hex);
                $('#template_alterbgcolor').val('#' + hex);
            }
        });
        
        $('#titlebackcolorSelector').ColorPicker({
            color: '#3498db',
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#titlebackcolorSelector div').css('backgroundColor', '#' + hex);
                $('#template_titlebackcolor').val('#' + hex);
            }
        });
    };

    EYE.register(initLayout, 'init');



})(jQuery)

jQuery(document).ready(function ($) {
    
    if($("input[name='rss_use_excerpt']:checked").val() == 1){
        $('tr.excerpt_length').show();
        $('tr.read_more_text').show();
        $('tr.read_more_text_color').show();
        $('tr.read_more_text_background').show();
    }else{
        $('tr.excerpt_length').hide();
        $('tr.read_more_text').hide();
        $('tr.read_more_text_color').hide();
        $('tr.read_more_text_background').hide();
    }
    
        
    $("input[name='template_alternativebackground']").change(function () {        
        if($(this).val() == 0){
            $('.alternative-color-tr').show();
        }else{
            $('.alternative-color-tr').hide();
        }
    });
        
    if($('#template_name').val() == 'classical' || $('#template_name').val() == 'spektrum'){
        $('tr.blog-template-tr').hide();
        $('tr.alternative-color-tr').hide();
    }else{        
        $('tr.blog-template-tr').show();
        if($("input[name='template_alternativebackground']:checked").val() == 0){        
            $('.alternative-color-tr').show();
        }else{        
            $('.alternative-color-tr').hide();
        }
    }
    
    $('#template_name').change(function (){
       if($(this).val() == 'classical' || $(this).val() == 'spektrum') {
           $('tr.blog-template-tr').hide();
           $('tr.alternative-color-tr').hide();
       }else{
           $('tr.blog-template-tr').show();
           if($("input[name='template_alternativebackground']:checked").val() == 0){        
                $('.alternative-color-tr').show();
            }else{        
                $('.alternative-color-tr').hide();
            }
        }
    });
    
    
    
    $("input[name='rss_use_excerpt']").change(function () {
        
        if($(this).val() == 1){
            $('tr.excerpt_length').show();
            $('tr.read_more_text').show();
            $('tr.read_more_text_color').show();
            $('tr.read_more_text_background').show();
        }else{
            $('tr.excerpt_length').hide();
            $('tr.read_more_text').hide();
            $('tr.read_more_text_color').hide();
            $('tr.read_more_text_background').hide();
        }
    });
});
<?php
header("Content-type: text/css");
include( '../../../../wp-load.php' );
$settings = get_option("wp_blog_designer_settings");
$background = (isset($settings['template_bgcolor']) && $settings['template_bgcolor'] != '') ? $settings['template_bgcolor'] : "#fff";
$templatecolor = (isset($settings['template_color']) && $settings['template_color'] != '') ? $settings['template_color'] : "#000";
$color = (isset($settings['template_ftcolor']) && $settings['template_ftcolor'] != '') ? $settings['template_ftcolor'] : "#000";
$titlecolor = (isset($settings['template_titlecolor']) && $settings['template_titlecolor'] != '') ? $settings['template_titlecolor'] : "#000";
$contentcolor = (isset($settings['template_contentcolor']) && $settings['template_contentcolor'] != '') ? $settings['template_contentcolor'] : "#000";
$readmorecolor = (isset($settings['template_readmorecolor']) && $settings['template_readmorecolor'] != '') ? $settings['template_readmorecolor'] : "#fff";
$readmorebackcolor = (isset($settings['template_readmorebackcolor']) && $settings['template_readmorebackcolor'] != '') ? $settings['template_readmorebackcolor'] : "#000";
$alterbackground = (isset($settings['template_alterbgcolor']) && $settings['template_alterbgcolor'] != '') ? $settings['template_alterbgcolor'] : "#fff";
$titlebackcolor = (isset($settings['template_titlebackcolor']) && $settings['template_titlebackcolor'] != '') ? $settings['template_titlebackcolor'] : "#fff";
$social_icon_style = get_option('social_icon_style');
$template_alternativebackground = get_option('template_alternativebackground');
$template_titlefontsize = get_option('template_titlefontsize');
$content_fontsize = get_option('content_fontsize');
$custom_css = get_option('custom_css');
?>
/************************************* lightbreeze style *********************************/
<?php if ($template_alternativebackground == '0') { ?>
    .white-content .alternative-back{
        background: <?php echo $alterbackground; ?>;
    }
    .blog_template.alternative-back{
        background: <?php echo $alterbackground; ?>;
    }
    .blog_template.marketer.alternative-back{
        background: <?php echo $alterbackground; ?>;
    }
<?php } ?>
.blog_template{ 
    background:<?php echo $background; ?>;
}
.blog_header h1{ 
    background: <?php echo $titlebackcolor; ?>; 
}
.blog_header h1 a{
    color:<?php echo $titlecolor; ?>;
    font-size: <?php echo $template_titlefontsize . 'px'; ?>;
}
.box-template a.more-tag{
    background-color: <?php echo $readmorebackcolor; ?>;
    color: <?php echo $readmorecolor; ?>; 
}
.box-template a.more-tag:hover{
    background-color: <?php echo $readmorecolor; ?>;
    color: <?php echo $readmorebackcolor; ?>;
}
.box-template .tags{
    font-size: 15px;
    margin-bottom: 7px;
}
.post_content p{ 
    color: <?php echo $contentcolor; ?>; 
    margin-bottom: 5px;
}
.post_content { 
    font-size: <?php echo $content_fontsize . 'px'; ?>; 
}
.meta_data_box .metacats a { 
    color:<?php echo $color; ?>; 
}
.meta_data_box .metacomments a { 
    color:<?php echo $color; ?>; 
}
.tags a { 
    color:<?php echo $color; ?>; 
}
.bdp_blog_template a{
    color:<?php echo $color; ?>; 
}
.bdp_blog_template .categories a{
    color:<?php echo $color; ?>; 
}
.post_content a,.post-content-body a{ 
    color:<?php echo $color; ?>; 
}
.post_content a:hover ,.post-content-body a:hover{
    color:<?php echo $color; ?>;
}
.wl_pagination_box .wl_pagination span, .wl_pagination_box .wl_pagination a{
    background: <?php echo $readmorebackcolor; ?>;
    color:<?php echo $readmorecolor; ?>;
}
.wl_pagination_box .wl_pagination span.current, .wl_pagination_box .wl_pagination a:hover{
    background: <?php echo $color; ?>;
    color:<?php echo $background; ?>;
}
span.category-link a{ 
    color:<?php echo $color; ?>; 
}
.bdp_blog_template.blog_template {
    float: left;
    width: 100%;
    margin-bottom: 20px;
    border-radius: 3px 3px 3px 3px;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.2);
    padding: 15px 15px 15px 15px;
    border: 1px solid #ccc;
}
.bdp_blog_template .blog_header {
    overflow: hidden;
}
.bdp_blog_template .blog_header img {
    box-shadow: none;
    width: 100%;
}
.bdp_blog_template .blog_header h1 {
    display: block;
    padding: 3px 10px;
    margin: 0;
    border-radius: 3px;
    line-height: normal;
}
.bdp_blog_template .blog_header h1 a {
    text-decoration: none;
    
    line-height: 21px;
}
.bdp_blog_template.box-template .tags {
    display: inline-block;
}
.bdp_blog_template.box-template a.more-tag {
    font-size: 14px;
    padding: 5px 10px;
    border-radius: 5px;
    float: right;
}
.bdp_blog_template .meta_data_box {
    float: left;
    margin: 10px 0;
    border-bottom: 1px solid #CCCCCC;
    width: 100%;
    font-style: italic;
}
.bdp_blog_template .meta_data_box [class^="icon-"],
.bdp_blog_template .meta_data_box [class*=" icon-"],
.bdp_blog_template .tags [class^="icon-"],
.bdp_blog_template .tags [class*=" icon-"] {
    background: url(../images/glyphicons-halflings.png ) no-repeat 14px 14px;
    display: inline-block;
    height: 14px;
    line-height: 14px;
    vertical-align: text-top;
    width: 14px;
}
.bdp_blog_template .meta_data_box .metadate {
    float: left;
    padding: 0 10px 0 0;
    font-size: 15px;
}
.bdp_blog_template .meta_data_box .metauser {
    float: left;
    font-size: 15px;
    padding-right: 10px;
}
.bdp_blog_template .meta_data_box .metacats {
    float: left;
    padding: 0 10px 0 0;
    font-size:15px;
}
.bdp_blog_template .meta_data_box .metacats a {
    text-decoration: none;
}
.bdp_blog_template .meta_data_box .metacomments {
    float: left;    
    font-size: 15px;
}
.bdp_blog_template .meta_data_box .metacomments a {
    text-decoration: none;
}
.bdp_blog_template .meta_data_box .icon-author-date {
    background-position: -168px 1px;
    margin-right: 5px;
}
.bdp_blog_template .metadate i {
    margin-right: 5px;
}
.bdp_blog_template .mdate i {
    margin-right: 5px;
}
.bdp_blog_template .meta_data_box span.calendardate {
    color: #6D6D6D;
    margin-left: 18px;
    font-size: 12px;
}
.bdp_blog_template .meta_data_box span.calendardate i {
    margin-right: 5px;
}
.bdp_blog_template .meta_data_box .icon-cats {
    background-position: -49px -47px;
}
.bdp_blog_template .meta_data_box .icon-comment {
    background-position: -241px -119px;
}
.bdp_blog_template .tags {
    padding: 5px 10px;
    border-radius: 3px;   
}
.bdp_blog_template .tags .icon-tags {
    background-position: -25px -47px;
}
.bdp_blog_template .tags a {
    text-decoration: none;
}
.wl_pagination_box.lightbreeze .wl_pagination span,
.wl_pagination_box.lightbreeze .wl_pagination a {
    border-radius: 2px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    display: inline-block;
    padding: 0 8px;
    text-decoration:none;
    margin-right:5px;
}

/******************************** classical style ************************************/

.blog_template.classical {
    background: none;
    border: none;
    border-bottom: 1px dashed rgb(204, 204, 204);
    border-radius: 0px;
    box-shadow: none;
    float: left;
    margin-bottom: 20px;
    padding: 5px;
    width: 100%;
}
.classical .blog_header img {
    box-shadow: none;
    float: left;
    margin-right: 10px;
}
.classical a.more-tag {
    border-radius: 5px;
    font-size: 14px;
    padding: 5px 10px;
    float: right;
}
.classical .blog_header h1 {
    display: block;
    border-radius: 0px;
    padding: 0;
    line-height: normal;
    margin: 0;
}
.blog_header h1 a {
    text-decoration: none;
    
    line-height: 21px;
}
.classical .blog_header .metadatabox {
    border-bottom: none;
    float: none;
    font-size: 13px;
    font-style: italic;
    margin: 5px 0;
    width: 100%;
}
.classical .blog_header .metadatabox .metacomments {
    float: right;
    padding: 2px 5px;
    border-radius: 5px;
}
.classical .blog_header .metadatabox .icon-date {
    background-position: -48px -24px;
    margin-right: 3px;
}

.tags [class^="icon-"],
.tags [class*=" icon-"] {
    background: url(../images/glyphicons-halflings.png ) no-repeat -25px -47px;
    display: inline-block;
    height: 14px;
    line-height: 14px;
    vertical-align: text-top;
    width: 14px;
}

.classical .blog_header .tags {
    background: none;
    border-radius: 0px;
    padding: 0px;
}
.wl_pagination_box {
    float: left;
    width: 100%;
}
.wl_pagination_box .wl_pagination span,
.wl_pagination_box .wl_pagination a {
    display: inline-block;
    padding: 0 8px;
    text-decoration: none;
    margin-right: 5px;
}
.metacomments i {
    margin-right: 2px;
}
.classical .category-link {
    font-size: 14px;
}
.classical a.more-tag{
    background-color: <?php echo $readmorebackcolor; ?>;
    color: <?php echo $readmorecolor; ?>;
    border-radius: 5px;
    font-size: 14px;
    padding: 5px 10px;
    float: right;
}
.classical a.more-tag:hover{
    background-color: <?php echo $readmorecolor; ?>;
    color: <?php echo $readmorebackcolor; ?>;
}
.classical .post_content{
    margin-top: 5px;
    font-size:<?php echo $content_fontsize . 'px'; ?>;
}
.classical .blog_header h1{
    display: block;
    background:  <?php echo $titlebackcolor; ?>;
    border-radius:0px;
    padding:0;
    line-height:normal;
}
.classical .blog_header h1 a{
    color:<?php echo $titlecolor; ?>;
}
.classical .post_content p{
    color: <?php echo $contentcolor; ?>;
}
.classical .blog_header .tags{
    background: none;
    border-radius: 0px;
    padding: 0px;
    color: <?php echo $color; ?>;
}
.classical .blog_header .tags a{
    color: <?php echo $color; ?>;
    font-size: 14px;
}
.wl_pagination_box .wl_pagination span, .wl_pagination_box .wl_pagination a{
    background: <?php echo $readmorebackcolor; ?>;
    display: inline-block;
    padding: 0 8px;
    color:<?php echo $readmorecolor; ?>;
    text-decoration:none;
    margin-right:5px;
}
.wl_pagination_box .wl_pagination span.current, .wl_pagination_box .wl_pagination a:hover{
    background: <?php echo $color; ?>;
    color:<?php echo $background; ?>;
}
span.category-link a{
    color:<?php echo $color; ?>;
}
/******************************** spektrum style ************************************/
.spektrum .date {
    color: <?php echo $background; ?>;
}
.spektrum .number-date {
    color: <?php echo $background; ?>;
}
.spektrum .post-bottom .categories a{
    color: <?php echo $color; ?>;
}   
.spektrum .details a {
    color :<?php echo $readmorecolor; ?>;
}
.spektrum .details a:hover{
    color :<?php echo $readmorebackcolor; ?>;
}
.blog_template.bdp_blog_template.spektrum {
    background: none;
    border: none;
    float: left;
    width: 100%;
    border-radius: 0px;
    box-shadow: none;
    padding: 0px;
    margin-bottom: 0px;
}
.bdp_blog_template.spektrum a.more-tag {
    border-radius: 5px;
    font-size: 14px;
    padding: 4px 10px;
    float: right;
    background: <?php echo $readmorebackcolor; ?>;
    color: <?php echo $readmorecolor; ?>;    
}
.bdp_blog_template.spektrum a.more-tag:hover{
    background: <?php echo $readmorecolor; ?>;
    color: <?php echo $readmorebackcolor; ?>;
}
.social-component.spektrum-social {
    margin-bottom: 30px;
    float: left;
}
.bdp_blog_template.spektrum img {
    box-shadow: none;
    border-radius: 0px;
    float: left;
    width: 100%;
}
.bdp_blog_template.spektrum .date {
    background: #212121 none repeat scroll 0 0;
    box-sizing: border-box;
    display: inline-block;
    float: left;
    font-size: 10px;
    margin: 5px 15px 5px 4px;
    padding: 5px;
    text-align: center;
}
.bdp_blog_template.spektrum .number-date {
    display: block;
    font-size: 20px;
    line-height: 14px;
    background: #212121;
    padding: 3px 5px;
}
.bdp_blog_template.spektrum .blog_header {
    box-shadow: 0 3px 5px rgba(196, 196, 196, 0.3);
    width:100%;
    position: relative;
}
.bdp_blog_template.spektrum .blog_header h1 {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border-radius: 0;
    box-sizing: border-box;
    display: table-row-group;
    line-height: normal;
    margin: 0 0 0 10px;
    padding: 5px 10px 0 0;
}
.bdp_blog_template.spektrum .blog_header h1 a {
    text-decoration: none;
    
    line-height: 21px;
} 
.bdp_blog_template.spektrum .post_content {
    padding: 10px;
    box-shadow: 0 3px 5px rgba(196, 196, 196, 0.3);    
}
.bdp_blog_template.spektrum .post_content p {
    margin: 0;
    padding: 0px;
}
.bdp_blog_template.spektrum .post-bottom {
    box-shadow: 0 -2px 5px rgba(196, 196, 196, 0.3);
    margin: 0 auto;
    padding: 10px 15px;
    clear: both;
    margin: 0px;
    position: relative;
    width: 100%;
    float: left;
}
.bdp_blog_template.spektrum .post-bottom .categories {
    display: inline-block;
    font-size: 14px;
    margin-right: 20px;
    float: left;
}
.bdp_blog_template.spektrum .post-by {
    font-size: 14px;
    margin-right: 15px;
}
.bdp_blog_template.spektrum .tags {
    font-size:14px;
    padding: 5px 10px;
}
.bdp_blog_template.spektrum .tags [class^="icon-"],
.bdp_blog_template.spektrum .tags [class*=" icon-"] {
    background: url(../images/glyphicons-halflings.png ) no-repeat -25px -47px;
    display: inline-block;
    height: 14px;
    line-height: 14px;
    vertical-align: text-top;
    width: 14px;
}
.bdp_blog_template.spektrum .post-bottom .categories a {
    text-decoration: none;
}
.bdp_blog_template.spektrum .post_content a {
    display: none;
}
.bdp_blog_template.spektrum .details a {
    display: inline-block;
    padding: 4px 10px;
    text-decoration: none;
}
.wl_pagination_box.spektrum .wl_pagination span,
.wl_pagination_box.spektrum .wl_pagination a {
    display: inline-block;
    padding: 2px 10px;
    text-decoration: none;
    margin-right: 0px;
}

/******************************** evolution style ************************************/
.marketer .post-title{
    background: <?php echo $titlebackcolor; ?>;
}
.marketer .post-title a{
    color: <?php echo $titlecolor; ?>;
    font-size: <?php echo $template_titlefontsize . 'px'; ?>;
}
.marketer .post-content-body{
    font-size: <?php echo $content_fontsize . 'px'; ?>;
}
.marketer .post-bottom a{
    background: <?php echo $readmorebackcolor; ?>;
    color: <?php echo $readmorecolor; ?>;
}
.marketer .post-bottom a:hover{
    background:<?php echo $readmorecolor; ?>;
    color:<?php echo $readmorebackcolor; ?>;
}
.marketer .post-content-body p{
    color: <?php echo $contentcolor; ?>;
}
.marketer .post-category a{
    color: <?php echo $color; ?>;
}
.marketer .icon_cnt a{
    color: <?php echo $color; ?>;
}
.marketer .blog_header{
    background: <?php echo $background; ?>;
}
.marketer .blog_header h1 a{
    color: <?php echo $color; ?>;
}
.marketer .blog_header .title .metadate a{
    color: <?php echo $color; ?>;
}
.marketer .blog_header .title .metadate span.author, .marketer .blog_header .title .metadate span.time{
    color: <?php echo $color; ?>;
}
.marketer .post_content{
    border:2px solid <?php echo $background; ?>;
}
.marketer .post-bottom .categories {
    color: <?php echo $color; ?>;
}
.marketer .post-bottom .categories a{
    color: <?php echo $color; ?>;
}
.blog_template.marketer.bdp_blog_template {
    float: left;
    width: 100%;
    margin-bottom: 20px;
    border: none;
    border-radius: 0px;
    box-shadow: 0 9px 6px -6px rgba(196, 196, 196, 0.3);
    padding: 10px;
}
.marketer.bdp_blog_template .post-category,
.marketer.bdp_blog_template .post-title,
.post-entry-meta {
    text-align: center;
}
.marketer.bdp_blog_template .post-title {
    margin-bottom: 5px;
    margin-top: 5px;
    padding: 5px 0;
}
.post-image {
    margin-top: 10px;
}
.marketer.bdp_blog_template .post-content-body {
    width: 100%;
    float: left;
    margin-top: 10px;
}
.marketer.bdp_blog_template .author {    
    font-size: 15px;
}
.marketer.bdp_blog_template .post-category a {
    font-size: 15px;
    text-transform: none;
}
.marketer.bdp_blog_template img {
    box-shadow: none;
    border-radius: 0px;
    float: left;
    width: 100%;
}
.marketer.bdp_blog_template .date {
    font-size: 15px;
    margin: 0px;
    text-align: center;    
    padding: 10px;
    width: 9%;
}
.marketer.bdp_blog_template .number-date {
    line-height: 14px;
    padding: 3px 5px;
    font-size: 15px;
}
.marketer.bdp_blog_template .tags {
    font-size: 15px;    
    padding: 5px 10px;
}
.bdp_blog_template .tags [class^="icon-"],
.bdp_blog_template .tags [class*=" icon-"] {
    background: url(../images/glyphicons-halflings.png ) no-repeat -25px -47px;
    display: inline-block;
    height: 14px;
    line-height: 14px;
    vertical-align: text-top;
    width: 14px;
}
.marketer.bdp_blog_template .tags .icon-tags {
    margin-top: 4px;
    background-position: -25px -47px;
}
.marketer.bdp_blog_template .icon_cnt {
    font-size: 15px;
    margin-left: 12px;
}
.marketer.bdp_blog_template .icon_cnt i {
    margin-right: 4px;
}
.marketer.bdp_blog_template .icon_cnt a {
    text-decoration: none;
}
.marketer.bdp_blog_template .blog_header {
    width: 100%;
    position: relative;
}
.marketer.bdp_blog_template .blog_header .title {
    float: left;
    width: 81.5%;
}
.marketer.bdp_blog_template .blog_header h1 {
    background: none;
    border-radius: 0px;
    display: block;
    line-height: normal;
    padding: 6px 10px;
    border-bottom: 1px dotted #CCCCCC;
    margin: 0 0 5px 0;
}
.marketer.bdp_blog_template .blog_header h1 a {
    text-transform: none;
}
.marketer.bdp_blog_template .blog_header .title .metadate {
    font-size: 12px;
    font-style: italic;
    padding: 0 10px;
}
.marketer.bdp_blog_template .blog_header .title .metadate a:hover {
    color: #212121;
    text-decoration: none;
}
.marketer.bdp_blog_template .post_content {
    background: none;
    padding: 10px;
    border-bottom: none;
}
.marketer.bdp_blog_template .post_content p {
    margin: 0;
    padding: 0px;
}
.marketer.bdp_blog_template .post-bottom {
    float: right;
}
.marketer.bdp_blog_template .post-bottom a {
    float: right;
    padding: 5px 10px;
    text-decoration: none;
    border-radius: 5px;
}
.marketer.bdp_blog_template .post-bottom .categories {
    display: inline-block;
    
}
.marketer.bdp_blog_template .post-bottom .categories a {
    text-decoration: none;
}
.marketer.bdp_blog_template .post_content a {
    display: none;
}
.marketer.bdp_blog_template .details a {
    color: inherit;
    display: inline-block;
    float: right;
    padding-right: 10px;
    text-decoration: none;
    
}
.wl_pagination_box.evolution {
    width: 97.5%;
}
.wl_pagination_box.evolution .wl_pagination {
    float: right;
}
.wl_pagination_box.evolution .wl_pagination span,
.wl_pagination_box.evolution .wl_pagination a {
    display: inline-block;
    padding: 2px 10px;
    color: #fff;
    text-decoration: none;
    margin: 0 0 0 8px;
}
.wl_pagination_box.evolution .wl_pagination span {
    color: #fff;
}
.wl_pagination_box.evolution .wl_pagination a {
    color: #fff;
}
/**************************************************/
<?php if ($social_icon_style == 0) { ?>
    .bdp_blog_template .social-component a {
        border-radius: 100%;
    }
<?php } ?>
.bdp_blog_template .social-component a {
    border: 1px solid #cccccc;
    float: left;    
    margin-bottom: 8px;
    margin-right: 8px;
    padding: 8px 0;
    text-align: center;
    width: 38px;
    font-size: 15px;
    line-height:20px;
}
.social-component a.facebook-share:hover{
    background: none repeat scroll 0 0 #3a589d;
    border-color: #3a589d;
    color: #fff;
}
.social-component a.twitter:hover{
    background: none repeat scroll 0 0 #2478ba;
    border-color: #2478ba;
    color: #fff;
}
.social-component a.google:hover{
    background: none repeat scroll 0 0 #dd4e31;
    border-color: #dd4e31;
    color: #fff;
}
.social-component a.linkedin:hover{
    background: none repeat scroll 0 0 #cb2320;
    border-color: #cb2320;
    color: #fff;
}
.social-component a.instagram:hover{
    background: none repeat scroll 0 0 #111111;
    border-color: #111111;
    color: #fff;
}
.social-component a.pinterest:hover{
    background: none repeat scroll 0 0 #cb2320;
    border-color: #cb2320;
    color: #fff;
}

/******************************** timeline style ************************************/

.bdp_blog_template.timeline{
    padding:0;
    box-sizing: border-box;
}
.timeline_bg_wrap:before {
    background: none repeat scroll 0 0 <?php echo $templatecolor; ?>;
    content: "";
    height: 100%;
    left: 50%;
    margin-left: -1px;
    position: absolute;
    top: 0;
    width: 3px;
}
.blog_template.bdp_blog_template.timeline .photo {
    text-align:center;
    margin-bottom: 15px;
}
.timeline_bg_wrap {
    padding: 0 0 50px;
    position: relative;
}
.clearfix:before, 
.clearfix:after {
    content: "";
    display: table;
}
.timeline_bg_wrap .timeline_back {
    margin: 0 auto;
    overflow: hidden;
    position: relative;
    width: 100%;
}
.datetime {
    background: none repeat scroll 0 0 <?php echo $templatecolor; ?>;
    border-radius: 100%;
    color: #fff;
    font-size: 12px;
    height: 70px;
    line-height: 1;
    padding-top: 10px;
    position: absolute;
    text-align: center;
    top: -30px;
    width: 70px;
    z-index: 1;
}
.timeline.blog-wrap:nth-child(2n+1) .datetime {
    left: -30px;
}
.timeline.blog-wrap:nth-child(2n) .datetime {
    left: inherit;
    right: -30px;
}
.timeline .datetime .month {
    font-size:15px;
    color:#fff;
    float:left;
    width:100%;
    padding-bottom:5px;
}
.timeline .datetime .date {
    font-size:30px;
    color:#fff;
    float:left;
    width:100%;
}
.blog_template.bdp_blog_template.timeline.blog-wrap:nth-child(2) {
    margin-top: 100px;
}
.timeline_bg_wrap .timeline_back .timeline.blog-wrap {
    display: block;
    padding-bottom: 45px;
    padding-top: 45px;
    position: relative;
    width: 50%;
}
.timeline_bg_wrap .timeline_back .timeline.blog-wrap:nth-child(2n) {
    clear: right;
    float: right;
    padding-left: 50px;       
    padding-right: 30px;
}
.timeline_bg_wrap .timeline_back .timeline.blog-wrap:nth-child(2n+1) {
    clear: left;
    float: left;
    padding-right: 50px;
    padding-left: 30px;
}
.post_hentry {
    margin: 0 auto;
    padding: 0;
    position: relative;
}
.post_hentry:before {
    background:<?php echo $templatecolor; ?>;
    box-shadow:0 0 0 4px white, 0 1px 0 rgba(0, 0, 0, 0.2) inset, -3px 3px 8px 5px rgba(0, 0, 0, 0.22);
    border-radius: 50%;
    content: "\f040";
    height: 35px;
    position: absolute;
    right: -68px;
    top: 0;
    width: 35px;
    box-sizing: unset;
    font-family: FontAwesome;
    color:#fff;    
    display: block;
    font-family: FontAwesome;
    font-size: 24px;
    text-align: center;    
    line-height: 1.3;    
}

.blog_template.bdp_blog_template.timeline.blog-wrap:nth-child(2n) .post_hentry:before {
    left: -68px;
    right: auto;
}
.bdp_blog_template.blog_template.timeline {
    border: none;
    box-shadow: none;
    margin: 0;
}
.blog_template.bdp_blog_template.timeline.blog-wrap:nth-child(2n+1) .post_content_wrap:before, 
.blog_template.bdp_blog_template.timeline.blog-wrap:nth-child(2n+1) .post_content_wrap:after {
    border-bottom: 8px solid transparent;
    border-left: 8px solid <?php echo $templatecolor; ?>;
    border-top: 8px dashed transparent;
    content: "";
    position: absolute;
    right: -8px;
    top: 13px;
}
.blog_template.bdp_blog_template.timeline.blog-wrap:nth-child(2n) .post_content_wrap:before,
.blog_template.bdp_blog_template.timeline.blog-wrap:nth-child(2n) .post_content_wrap:after {
    border-bottom: 8px solid transparent;
    border-right: 8px solid <?php echo $templatecolor; ?>;
    border-top: 8px dashed transparent;
    content: "";
    left: -8px;
    position: absolute;
    top: 13px;
}
.bdp_blog_template.timeline.blog-wrap:nth-child(2n+1) .post_content_wrap {
    float: right;
    margin-left: 0;
}
.post_content_wrap {
    border-radius: 3px;
    margin: 0;   
    border:1px solid <?php echo $templatecolor; ?>;
    word-wrap: break-word;
    font-weight: normal;
    float: left;
    width: 100%;
}
.blog_template.bdp_blog_template.timeline.blog-wrap .post_wrapper.box-blog {
    float: left;
    padding: 15px;
    width: 100%;
    position: relative;
}
.clearfix:after {
    clear: both;
}
.blog_template.bdp_blog_template.timeline.blog-wrap:nth-child(1),
.blog_template.bdp_blog_template.timeline.blog-wrap:nth-child(2) {
    padding-top: 100px;
}
.blog_template.bdp_blog_template.timeline.blog-wrap.blog_template{
    background:none;
}
.blog-wrap .desc a.desc_content {
    display: block;
    padding: 15px 15px 5px;
    position: relative;
    text-align: center;
}
.blog_footer, .blog_div {
    background: none repeat scroll 0 0 #ffffff;
}
.post_content_wrap .blog_footer {
    border-top: 1px solid <?php echo $templatecolor; ?> ;
    padding-left: 5px;
    width: 100%;
}
.blog_footer span {
    padding: 5px;
    text-transform:none;
    display: inherit;
    font-size: 15px;
}
.date_wrap span{
    text-transform:capitalize;
}
span.leave-reply i,
.blog_footer span i {
    padding-right: 5px;
}
.blog_template.bdp_blog_template.timeline .read_more {
    background: none;
    border-left: none;
    margin: 20px auto;
    transition: all 0.6s ease 0s;
    width: auto;
    text-align:center;
    margin-top:0;
    float:none;
}
.blog_template.bdp_blog_template.timeline .read_more a{
    color:<?php echo $readmorecolor; ?>;
}
.blog_template.bdp_blog_template.timeline .read_more a.btn-more{
    background: <?php echo $readmorebackcolor; ?>;
    padding: 9px 10px;
    border-radius: 3px;
}
.blog_template.bdp_blog_template.timeline .read_more a.btn-more:hover{
    background: <?php echo $readmorecolor; ?>;
    color:<?php echo $readmorebackcolor; ?>;
}
.post-icon {
    background:<?php echo $templatecolor; ?>;
    color: #ffffff;
}
.date_wrap {
    padding-bottom: 5px;
}
.datetime span.month{
    color:#555;
}
.blog_template.bdp_blog_template.timeline.blog-wrap {
    box-sizing: border-box;
}
.blog_template.bdp_blog_template.timeline .blog_footer {
    box-sizing: border-box;
    float: left;
    padding: 15px;
    width: 100%;
}
.blog_template.bdp_blog_template.timeline .social-component.spektrum-social {
    box-sizing: border-box;
    float: left;
    margin-bottom: 0;
    width: 100%;
    margin-top: 20px;
}
.bdp_blog_template.timeline .social-component a {       
    padding: 5px 0;    
    width: 30px;   
    height: 30px;
}
.blog_template.bdp_blog_template.timeline .post_content{
    padding-bottom:10px;
}
.blog_template.bdp_blog_template.timeline .post_content a.more-link{
    display: none;
}
.blog_template.bdp_blog_template.timeline .desc a h3 {
    color:<?php echo $titlecolor; ?>;
    background:<?php echo $titlebackcolor; ?>;
    margin-bottom: 10px;
}
.blog_template.bdp_blog_template.timeline a{
    text-transform:none;
}
.blog_template.bdp_blog_template.timeline.blog-wrap .tags {
    padding: 5px;
}
<?php echo $custom_css; ?>
@media screen and (max-width: 992px){  
    .timeline_bg_wrap:before {
        left: 6%;
    }
    .timeline_bg_wrap .timeline_back .timeline.blog-wrap:nth-child(2n+1) {
        clear: right;
        float: right;
        padding-left: 50px;
        padding-right: 30px;
    }
    .timeline_bg_wrap .timeline_back .timeline.blog-wrap {
        width: 94%;
    }
    .blog_template.bdp_blog_template.timeline.blog-wrap:nth-child(n) .post_hentry:before {
        left: -68px;
        right: auto;
    }
    .blog_template.bdp_blog_template.timeline.blog-wrap:nth-child(2n+1) .post_content_wrap:before, 
    .blog_template.bdp_blog_template.timeline.blog-wrap:nth-child(2n+1) .post_content_wrap:after {
        left: -8px;
        border-right: 8px solid #000000;
        border-left: none;
        right:auto;
    }
    .datetime {        
        height: 60px;        
        width: 60px;        
    }
    .timeline .datetime .month {        
        font-size: 14px;       
    }
    .timeline .datetime .date {        
        font-size: 20px;       
    }
    .timeline.blog-wrap:nth-child(2n+1) .datetime,
    .timeline.blog-wrap:nth-child(2n) .datetime {
        left: inherit;
        right: -30px;
    }    
    .blog_template.bdp_blog_template.timeline.blog-wrap:nth-child(2) {
        margin-top: 0;
        padding-top: 45px;
    }
    .bdp_blog_template.timeline.blog-wrap:nth-child(2n+1) .post_content_wrap {
        float: left;
    }
}
@media screen and (max-width: 550px){ 
    .timeline_bg_wrap:before {
        left: 10%;
    }
    .timeline_bg_wrap .timeline_back .timeline.blog-wrap {
        width: 90%;
    }
}

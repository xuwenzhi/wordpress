<?php
define('NOTIFIER_XML_FILE', 'https://www.solwininfotech.com/documents/assets/plugin_theme.xml');
$response = wp_remote_post(NOTIFIER_XML_FILE);
$body = wp_remote_retrieve_body($response);
$xml = simplexml_load_string($body);
?>
<div class="wrap about-us-section-bd">
    <img style="margin-top: 20px;display: block;" src="<?php echo BLOGDESIGNER_URL.'/images/logo.png'; ?>" alt="Blog Designer Logo" title="Blog Designer Logo" />    
    <div class="bd_text_paypal">
        <div class="bd-text">
            <?php _e('Blog Designer is a step ahead wordpress plugin that allows you to modify blog and single page layouts and design.','wp_blog_designer'); ?>
        </div>        
    </div>    
    <div class="bd-features">
        <div class="bd-info-heading"><?php _e( 'Feature Overview','wp_blog_designer' ); ?></div>
        <div class="bd-info-content">
            <div class="bd-feature-upper">
                <strong class="feature-heading"><i class="fa fa-toggle-on"></i><?php _e('Fully Customizable Admin Interface','wp_blog_designer'); ?></strong>
                <p><?php _e('Plugin will provide easy-to-use and user friendly admin interface.','wp_blog_designer'); ?></p>
            </div>
            <div class="bd-feature-upper">
                <strong class="feature-heading"><i class="fa fa-crosshairs"></i><?php _e('Multiple Browser Compatibility','wp_blog_designer'); ?></strong>
                <p><?php _e('Plugin is compatibility with multiple web browsers like Firefox, Chrome, Safari, Opera.','wp_blog_designer'); ?>
                </p>
            </div>
            <div class="bd-feature-upper">
                <strong class="feature-heading"><i class="fa fa-css3"></i><?php _e('Custom CSS','wp_blog_designer'); ?></strong>
                <p>
                    <?php _e('Support of custom css to override the style of template.','wp_blog_designer'); ?>
                </p>
            </div>            
            <div class="bd-feature-upper">
                <strong class="feature-heading"><i class="fa fa-paperclip"></i><?php _e('Show/Hide post meta fields','wp_blog_designer'); ?></strong>
                <p>
                    <?php _e('Manage post meta of post using show/hide option.','wp_blog_designer'); ?>
                </p>
            </div>
            <div class="bd-feature-upper">
                <strong class="feature-heading"><i class="fa fa-language"></i><?php _e('Multilingual Translation Ready','wp_blog_designer'); ?></strong>
                <p>
                    <?php _e('Blog Designer is ready to use with any language.','wp_blog_designer'); ?>
                </p>
            </div>
            <div class="bd-feature-upper">
                <strong class="feature-heading"><i class="fa fa-th-large"></i><?php _e('15+ Different and Unique Blog Templates','wp_blog_designer'); ?>  <small>(<?php _e(' Pro ','wp_blog_designer'); ?>)</small></strong>
                <p>
                    <?php _e('Plugin will offer 15+ different and unique blog template to make your blog page more attractive.','wp_blog_designer'); ?>
                </p>
            </div>
            <div class="bd-feature-upper">
                <strong class="feature-heading"><i class="fa fa-share-square-o"></i><?php _e('Import & Export Layout','wp_blog_designer'); ?>  <small>(<?php _e(' Pro ','wp_blog_designer'); ?>)</small></strong>
                <p>
                    <?php _e('User can easily import layout and export layout setting.','wp_blog_designer'); ?>
                </p>
            </div>
            <div class="bd-feature-upper">
                <strong class="feature-heading"><i class="fa fa-files-o"></i><?php _e('Duplicate Layout','wp_blog_designer'); ?>  <small>(<?php _e(' Pro ','wp_blog_designer'); ?>)</small></strong>
                <p>
                    <?php _e('Plugin will offer to easily duplicate the layout settings.','wp_blog_designer'); ?>
                </p>
            </div>
            <div class="bd-feature-upper">
                <strong class="feature-heading"><i class="fa fa-file-text-o"></i><?php _e('Support of Single Post Design','wp_blog_designer'); ?>  <small>(<?php _e(' Pro ','wp_blog_designer'); ?>)</small></strong>
                <p>
                    <?php _e('User can change single post design with 15+ different and unique template.','wp_blog_designer'); ?>
                </p>
            </div>
            <div class="bd-feature-upper">
                <strong class="feature-heading"><i class="fa fa-search"></i><?php _e('Live Preview','wp_blog_designer'); ?>  <small>(<?php _e(' Pro ','wp_blog_designer'); ?>)</small></strong>
                <p>
                    <?php _e('User can preview each and every layout at the time of creation and modification.','wp_blog_designer'); ?>
                </p>
            </div>
            <div class="bd-feature-upper">
                <strong class="feature-heading"><i class="fa fa-columns"></i><?php _e('Template with Two, Three and Four Columns','wp_blog_designer'); ?>  <small>(<?php _e(' Pro ','wp_blog_designer'); ?>)</small></strong>
                <p>
                    <?php _e('Plugin provide option to select column for blog design.','wp_blog_designer'); ?>
                </p>
            </div>
            <div class="bd-feature-upper">
                <strong class="feature-heading"><i class="fa fa-spinner"></i><?php _e('Pagination with load more','wp_blog_designer'); ?>  <small>(<?php _e(' Pro ','wp_blog_designer'); ?>)</small></strong>
                <p>
                    <?php _e('Choose pagination type to show next page.','wp_blog_designer'); ?>
                </p>
            </div>
            <div class="bd-feature-upper">
                <a href="http://blogdesigner.solwininfotech.com/features/" target="_blank" class="view-all-features"><?php _e('View All Features'); ?></a>
            </div>
        </div>
    </div>
    <div style="height: 30px;"></div>
    <div class="bd-out-other-work">
        <div class="bd-info-heading"><?php _e( 'Our Other Products','wp_blog_designer' ); ?></div>
        <div class="bd-info-content">
            <ul class="bd_theme_plugin">
                <li class="active"><a href="#" data-toggle="plugins"><?php _e( 'Plugins','wp_blog_designer' ); ?></a></li>
                <li><a href="#" data-toggle="themes"><?php _e( 'Themes','wp_blog_designer' ); ?></a></li>
            </ul>
            <div id="plugins">                
                    <?php                
                    if($xml->plugins){
                        foreach ( $xml->plugins as $single_plugin ) {
                            unset($single_plugin->blog_designer);
                            foreach ( $single_plugin as $value ) { ?>
                                <div class="image_div_upper">
                                    <a href="<?php echo $value->link; ?>" target="_blank">
                                        <img src="<?php echo $value->img; ?>" alt="<?php echo $value->name; ?>">
                                        <div class="bd_theme_plugin_name"><span><?php echo $value->name; ?></span></div>
                                    </a>
                                </div>
                            <?php }
                        }
                    }
                    ?>                
            </div>
            <div id="themes" style="display: none">                
                    <?php                
                    if($xml->themes){
                        foreach ( $xml->themes as $single_theme ) {                            
                            foreach ( $single_theme as $value ) { ?>
                                <div class="image_div_upper">
                                    <a href="<?php echo $value->link; ?>" target="_blank">
                                        <img src="<?php echo $value->img; ?>" alt="<?php echo $value->name; ?>">
                                        <div class="bd_theme_plugin_name"><span><?php echo $value->name; ?></span></div>
                                    </a>
                                </div>
                            <?php }
                        }
                    }
                    ?>                
            </div>
        </div>
    </div>    
</div>
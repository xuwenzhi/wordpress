<?php
/**
  Plugin Name: Blog Designer
  Plugin URI: https://wordpress.org/plugins/blog-designer
  Description: To make your blog design more pretty, attractive and colorful.
  Author: Solwin Infotech
  Author URI: http://www.solwininfotech.com/
  Copyright: Solwin Infotech
  Version: 1.6.2
  Requires at least: 4.0
  Tested up to: 4.4
  License: GPLv2 or later
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
add_action('admin_menu', 'wp_blog_designer_add_menu');
add_action('admin_init', 'wp_blog_designer_reg_function');
add_action('admin_init', 'wp_blog_designer_admin_stylesheet');
add_action('init', 'wp_blog_designer_front_stylesheet');
add_action('admin_init', 'wp_blog_designer_admin_scripts');
add_action('init', 'wp_blog_designer_stylesheet', 20);
add_shortcode('wp_blog_designer', 'wp_blog_designer_views');
add_action('admin_enqueue_scripts', 'mw_enqueue_color_picker');

function mw_enqueue_color_picker($hook_suffix) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('my-script-handle', plugins_url('js/admin_script.js', __FILE__), array('wp-color-picker'), false, true);
}

/**
 * 
 * @return add menu at admin panel
 */
function wp_blog_designer_add_menu() {
    add_menu_page(__('Blog Designer', 'wp_blog_designer'), __('Blog Designer', 'wp_blog_designer'), 'administrator', 'designer_settings', 'wp_blog_designer_menu_function');
    add_submenu_page('designer_settings', __('Blog designer Settings', 'wp_blog_designer'), __('Settings', 'wp_blog_designer'), 'manage_options', 'designer_settings', 'wp_blog_designer_add_menu');
}

/**
 * 
 * @return Loads plugin textdomain
 */
function load_language_files() {
    load_plugin_textdomain('wp_blog_designer', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

add_action('plugins_loaded', 'load_language_files');

/**
 * 
 * @return Set default value
 */
function wp_blog_designer_reg_function() {
    $settings = get_option("wp_blog_designer_settings");
    if (empty($settings)) {
        $settings = array(
            'template_category' => '',
            'template_name' => 'classical',
            'template_bgcolor' => '#ffffff',
            'template_color' => '#db4c59',
            'template_ftcolor' => '#58d658',
            'template_titlecolor' => '#1fab8e',
            'template_contentcolor' => '#7b95a6',
            'template_readmorecolor' => '#2376ad',
            'template_readmorebackcolor' => '#dcdee0',
            'template_alterbgcolor' => '#ffffff',
            'template_titlebackcolor' => '#ffffff',
        );
        update_option("display_category", '0');
        update_option("display_tag", '0');
        update_option("display_author", '0');
        update_option("display_date", '0');
        update_option("facebook_link", '0');
        update_option("twitter_link", '0');
        update_option("google_link", '0');
        update_option("linkedin_link", '0');
        update_option("instagram_link", '0');
        update_option("pinterest_link", '0');
        update_option("display_comment_count", '0');
        update_option("excerpt_length", '75');
        update_option("read_more_text", 'Read More');
        update_option("template_titlefontsize", '35');
        update_option("content_fontsize", '14');
        update_option("wp_blog_designer_settings", $settings);
    }
}

if (isset($_REQUEST['action']) && $_REQUEST['action'] === 'save' && isset($_REQUEST['updated']) && $_REQUEST['updated'] === 'true') {
    update_option("blog_page_display", $_POST['blog_page_display']);
    update_option("posts_per_page", $_POST['posts_per_page']);
    update_option("rss_use_excerpt", $_POST['rss_use_excerpt']);
    update_option("display_date", $_POST['display_date']);
    update_option("display_author", $_POST['display_author']);
    update_option("display_category", $_POST['display_category']);
    update_option("display_tag", $_POST['display_tag']);

    update_option("excerpt_length", $_POST['txtExcerptlength']);
    update_option("read_more_text", $_POST['txtReadmoretext']);

    if (isset($_POST['template_alternativebackground']))
        update_option("template_alternativebackground", $_POST['template_alternativebackground']);
    else
        update_option("template_alternativebackground", '');

    if (isset($_POST['social_icon_style'])) {
        update_option("social_icon_style", $_POST['social_icon_style']);
    }
    if (isset($_POST['facebook_link'])) {
        update_option("facebook_link", $_POST['facebook_link']);
    }
    if (isset($_POST['twitter_link'])) {
        update_option("twitter_link", $_POST['twitter_link']);
    }
    if (isset($_POST['google_link'])) {
        update_option("google_link", $_POST['google_link']);
    }
    if (isset($_POST['dribble_link'])) {
        update_option("dribble_link", $_POST['dribble_link']);
    }
    if (isset($_POST['pinterest_link'])) {
        update_option("pinterest_link", $_POST['pinterest_link']);
    }
    if (isset($_POST['instagram_link'])) {
        update_option("instagram_link", $_POST['instagram_link']);
    }
    if (isset($_POST['linkedin_link'])) {
        update_option("linkedin_link", $_POST['linkedin_link']);
    }
    if (isset($_POST['display_comment_count'])) {
        update_option("display_comment_count", $_POST['display_comment_count']);
    }
    if (isset($_POST['template_titlefontsize'])) {
        update_option("template_titlefontsize", $_POST['template_titlefontsize']);
    }
    if (isset($_POST['content_fontsize'])) {
        update_option("content_fontsize", $_POST['content_fontsize']);
    }

    $templates = array();
    $templates['ID'] = $_POST['blog_page_display'];
    $templates['post_content'] = '[wp_blog_designer]';
    wp_update_post($templates);

    $settings = $_POST;
    $settings = is_array($settings) ? $settings : unserialize($settings);
    $updated = update_option("wp_blog_designer_settings", $settings);
}

/**
 * 
 * @return Display total downloads of plugin
 */
if (!function_exists('get_total_downloads')) {

    function get_total_downloads() {
        // Set the arguments. For brevity of code, I will set only a few fields.        
        $plugins = $response = "";
        $args = array(
            'author' => 'solwininfotech',
            'fields' => array(
                'downloaded' => true,
                'downloadlink' => true
            )
        );
        // Make request and extract plug-in object. Action is query_plugins
        $response = wp_remote_post(
                'http://api.wordpress.org/plugins/info/1.0/', array(
            'body' => array(
                'action' => 'query_plugins',
                'request' => serialize((object) $args)
            )
                )
        );
        if (!is_wp_error($response)) {
            $returned_object = unserialize(wp_remote_retrieve_body($response));
            $plugins = $returned_object->plugins;
        } else {
            
        }
        $current_slug = 'blog-designer';
        if ($plugins) {
            foreach ($plugins as $plugin) {
                if ($current_slug == $plugin->slug) {
                    if ($plugin->downloaded) {
                        ?>
                        <span class="total-downloads">
                            <span class="download-number"><?php echo $plugin->downloaded; ?></span>
                        </span>
                        <?php
                    }
                }
            }
        }
    }

}

/**
 * 
 * @return Display rating of plugin
 */
$wp_version = get_bloginfo('version');
if ($wp_version > 3.8) {
    if (!function_exists('wp_custom_star_rating')) {

        function wp_custom_star_rating($args = array()) {
            $plugins = $response = "";
            $args = array(
                'author' => 'solwininfotech',
                'fields' => array(
                    'downloaded' => true,
                    'downloadlink' => true
                )
            );

            // Make request and extract plug-in object. Action is query_plugins
            $response = wp_remote_post(
                    'http://api.wordpress.org/plugins/info/1.0/', array(
                'body' => array(
                    'action' => 'query_plugins',
                    'request' => serialize((object) $args)
                )
                    )
            );
            if (!is_wp_error($response)) {
                $returned_object = unserialize(wp_remote_retrieve_body($response));
                $plugins = $returned_object->plugins;
            }

            $current_slug = 'blog-designer';
            if ($plugins) {
                foreach ($plugins as $plugin) {
                    if ($current_slug == $plugin->slug) {
                        $rating = $plugin->rating * 5 / 100;
                        if ($rating > 0) {
                            $args = array(
                                'rating' => $rating,
                                'type' => 'rating',
                                'number' => $plugin->num_ratings,
                            );
                            wp_star_rating($args);
                        }
                    }
                }
            }
        }

    }
}

/**
 * 
 * @return Enqueue admin panel required css
 */
function wp_blog_designer_admin_stylesheet() {

    $adminstylesheetURL = plugins_url('css/admin.css', __FILE__);
    $adminstylesheet = dirname(__FILE__) . '/css/admin.css';

    if (file_exists($adminstylesheet)) {
        wp_register_style('wp-blog-designer-admin-stylesheets', $adminstylesheetURL);
        wp_enqueue_style('wp-blog-designer-admin-stylesheets');
    }
}

/**
 * 
 * @return Enqueue front side required css
 */
function wp_blog_designer_front_stylesheet() {

    $fontawesomeiconURL = plugins_url('css/font-awesome.min.css', __FILE__);
    $fontawesomeicon = dirname(__FILE__) . '/css/font-awesome.min.css';
    if (file_exists($fontawesomeicon)) {
        wp_register_style('wp-blog-designer-fontawesome-stylesheets', $fontawesomeiconURL);
        wp_enqueue_style('wp-blog-designer-fontawesome-stylesheets');
    }
}

/**
 * 
 * @return enqueue admin side plugin js
 */
function wp_blog_designer_admin_scripts() {
    wp_enqueue_script('jquery');
}

/**
 * 
 * @return include plugin dynamic css
 */
function wp_blog_designer_stylesheet() {

    if (!is_admin()) {
        $stylesheetURL = plugins_url('css/designer_css.php', __FILE__);
        $stylesheet = dirname(__FILE__) . '/css/designer_css.php';

        if (file_exists($stylesheet)) {
            wp_register_style('wp-blog-designer-stylesheets', $stylesheetURL);
            wp_enqueue_style('wp-blog-designer-stylesheets');
        }
    }
}

/**
 * 
 *  @param type $length
 *  @return int get content length
 */
function custom_excerpt_length($length) {

    if (get_option('excerpt_length') != '') {

        return get_option('excerpt_length');
    } else {

        return 50;
    }
}

add_filter('excerpt_length', 'custom_excerpt_length', 999);

/**
 * @return type
 */
function wp_blog_designer_views() {

    $settings = get_option("wp_blog_designer_settings");
    if (!isset($settings['template_name']) || empty($settings['template_name'])) {
        return '[wp_blog_designer] ' . __('Invalid shortcode', 'wp_blog_designer') . '';
    }

    $theme = $settings['template_name'];
    $cat = '';
    $category = '';
    if (isset($settings['template_category']))
        $cat = $settings['template_category'];

    if (!empty($cat)) {
        foreach ($cat as $catObj):
            $category .= $catObj . ',';
        endforeach;
        $cat = rtrim($category, ',');
    }else {
        $cat = '';
    }

    $posts_per_page = get_option('posts_per_page');
    $paged = blogdesignerpaged();

    $posts = query_posts(array('cat' => $cat, 'posts_per_page' => $posts_per_page, 'paged' => $paged));
    $alter = 1;
    $class = '';
    $alter_class = '';

    if ($theme == 'timeline') {
        ?>
        <div class="timeline_bg_wrap">
            <div class="timeline_back clearfix">
                <?php
            }
            while (have_posts()) : the_post();
                if ($theme == 'classical') {
                    $class = ' classical';
                    wp_classical_template($alter_class);
                } elseif ($theme == 'lightbreeze') {
                    if (get_option('template_alternativebackground') == 0) {
                        if ($alter % 2 == 0) {
                            $alter_class = ' alternative-back';
                        } else {
                            $alter_class = ' ';
                        }
                    }
                    $class = ' lightbreeze';
                    wp_lightbreeze_template($alter_class);
                    $alter ++;
                } elseif ($theme == 'spektrum') {
                    $class = ' spektrum';
                    wp_desgin3_template();
                } elseif ($theme == 'evolution') {
                    if (get_option('template_alternativebackground') == 0) {
                        if ($alter % 2 == 0) {
                            $alter_class = ' alternative-back';
                        } else {
                            $alter_class = ' ';
                        }
                    }
                    $class = ' evolution';
                    wp_evolution_template($alter_class);
                    $alter ++;
                } elseif ($theme == 'timeline') {
                    $class = 'timeline';
                    wp_timeline_template();
                }
            endwhile;
            if ($theme == 'timeline') {
                ?>
            </div>
        </div>
        <?php
    }
    echo '<div class="wl_pagination_box ' . $class . '">';
    designer_pagination();
    echo '</div>';
    wp_reset_query();
}

/**
 * 
 * @global type $post
 * @return html display classical design
 */
function wp_classical_template($alterclass) {
    ?>
    <div class="blog_template bdp_blog_template classical">
        <?php the_post_thumbnail('full'); ?>
        <div class="blog_header">
            <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            <div class="metadatabox">                            
                <?php
                $display_date = get_option('display_date');
                $display_author = get_option('display_author');
                if ($display_author == 0 && $display_date == 0) {
                    ?> 
                    <div class="icon-date"></div><?php _e('Posted by ', 'wp_blog_designer'); ?> <span><?php the_author(); ?></span><?php _e(' on ', 'wp_blog_designer'); ?><?php the_time(__('F d, Y')); ?>

                <?php } elseif ($display_author == 1 && $display_date == 1) { ?>                                                                                                           
                <?php } elseif ($display_author == 0) { ?>
                    <div class="icon-date"></div><?php _e('Posted by ', 'wp_blog_designer'); ?><span><?php the_author(); ?></span>
                <?php } elseif ($display_date == 0) { ?>
                    <div class="icon-date"></div><?php _e('Posted on ', 'wp_blog_designer'); ?><?php the_time(__('F d, Y')); ?>
                    <?php
                }
                if (get_option('display_comment_count') == 0) {
                    ?>                    
                    <div class="metacomments">
                        <i class="fa fa-comment"></i><?php comments_popup_link('0', '1', '%'); ?>
                    </div>
                <?php } ?>
            </div>
            <?php if (get_option('display_category') == 0) { ?>
                <span class="category-link">
                    <?php
                    _e('Category :', 'wp_blog_designer');
                    $categories_list = get_the_category_list(__(', ', 'wp_blog_designer'));
                    if ($categories_list):
                        printf(__(' %2$s', 'wp_blog_designer'), 'entry-utility-prep entry-utility-prep-tag-links', $categories_list);
                        $show_sep = true;
                    endif;
                    ?>
                </span>
            <?php } ?>
            <?php
            if (get_option('display_tag') == 0) {
                $tags_list = get_the_tag_list('', __(', ', 'wp_blog_designer'));
                if ($tags_list):
                    ?>
                    <div class="tags">
                        <div class="icon-tags"></div>
                        <?php
                        printf(__('%2$s', 'wp_blog_designer'), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list);
                        $show_sep = true;
                        ?>
                    </div>
                    <?php
                endif;
            }
            ?>
        </div>
        <div class="post_content">
            <?php if (get_option('rss_use_excerpt') == 0): ?>
                <?php the_content(); ?>
            <?php else: ?>
                <?php
                global $post;
                the_excerpt(__('Continue reading <span class="meta-nav">&rarr;</span>', 'wp_blog_designer'));
                if (get_option('read_more_text') != '') {
                    echo '<a class="more-tag" href="' . get_permalink($post->ID) . '">' . get_option('read_more_text') . ' </a>';
                } else {
                    echo ' <a class="more-tag" href="' . get_permalink($post->ID) . '">' . __("Read More", "wp_blog_designer") . '</a>';
                }
                ?>

            <?php endif; ?>
        </div>
        <?php if ((get_option('facebook_link') == 0) || (get_option('twitter_link') == 0) || (get_option('google_link') == 0) || (get_option('linkedin_link') == 0) || (get_option('instagram_link') == 0) || ( get_option('pinterest_link') == 0 )) { ?>
            <div class="social-component">
                <?php if (get_option('facebook_link') == 0): ?>
                    <a href="<?php echo 'https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink(); ?>" target= _blank class="facebook-share"><i class="fa fa-facebook"></i></a>
                <?php endif; ?>
                <?php if (get_option('twitter_link') == 0): ?>
                    <a href="<?php echo 'http://twitter.com/share?&url=' . get_the_permalink(); ?>" target= _blank class="twitter"><i class="fa fa-twitter"></i></a>
                <?php endif; ?>
                <?php if (get_option('google_link') == 0): ?>
                    <a href="<?php echo 'https://plus.google.com/share?url=' . get_the_permalink(); ?>" target= _blank class="google"><i class="fa fa-google-plus"></i></a>
                <?php endif; ?>
                <?php if (get_option('linkedin_link') == 0): ?>
                    <a href="<?php echo 'http://www.linkedin.com/shareArticle?url=' . get_the_permalink(); ?>" target= _blank class="linkedin"><i class="fa fa-linkedin"></i></a>
                <?php endif; ?>
                <?php if (get_option('instagram_link') == 0): ?>
                    <a href="<?php echo 'mailto:enteryour@addresshere.com?subject=Share and Follow&body=' . get_the_permalink(); ?>" target= _blank class="instagram"><i class="fa fa-envelope-o"></i></a>
                <?php endif; ?>        
                <?php if (get_option('pinterest_link') == 0): ?>
                    <a href="<?php echo '//pinterest.com/pin/create/button/?url=' . get_the_permalink(); ?>" target= _blank class="pinterest"> <i class="fa fa-pinterest"></i></a>
                <?php endif; ?>
            </div>
        <?php } ?>
    </div>
    <?php
}

/**
 * 
 * @global type $post
 * @param type $alterclass
 * @return html display lightbreeze design
 */
function wp_lightbreeze_template($alterclass) {
    ?>
    <div class="blog_template bdp_blog_template box-template active <?php echo $alterclass; ?>">
        <?php the_post_thumbnail('full'); ?>
        <div class="blog_header">
            <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            <div class="meta_data_box">
                <?php
                $display_date = get_option('display_date');
                $display_author = get_option('display_author');
                if ($display_author == 0) {
                    ?> 
                    <div class="metadate">
                        <i class="fa fa-user"></i><?php _e('Posted by ', 'wp_blog_designer'); ?><span><?php the_author(); ?></span><br />                        
                    </div>

                    <?php
                }
                if ($display_date == 0) {
                    ?> 
                    <div class="metauser">
                        <span class="mdate"><i class="fa fa-calendar"></i> <?php the_time(__('F d, Y')); ?></span>
                    </div>
                <?php } ?>   

                <?php if (get_option('display_category') == 0) { ?>
                    <div class="metacats">
                        <div class="icon-cats"></div>
                        <?php
                        $categories_list = get_the_category_list(__(', ', 'wp_blog_designer'));
                        if ($categories_list):
                            printf(__('%2$s', 'wp_blog_designer'), 'entry-utility-prep entry-utility-prep-tag-links', $categories_list);
                            $show_sep = true;
                        endif;
                        ?>
                    </div>
                    <?php
                }
                if (get_option('display_comment_count') == 0) {
                    ?>
                    <div class="metacomments">
                        <div class="icon-comment"></div>
                        <?php comments_popup_link(__('No Comments', 'wp_blog_designer'), __('1 Comment', 'wp_blog_designer'), __('% Comments', 'wp_blog_designer')); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="post_content">
            <?php if (get_option('rss_use_excerpt') == 0): ?>
                <?php the_content(); ?>
            <?php else: ?>
                <?php
                global $post;
                the_excerpt(__('Continue reading <span class="meta-nav">&rarr;</span>', 'wp_blog_designer'));
                if (get_option('read_more_text') != '') {
                    echo '<a class="more-tag" href="' . get_permalink($post->ID) . '">' . get_option('read_more_text') . ' </a>';
                } else {
                    echo ' <a class="more-tag" href="' . get_permalink($post->ID) . '">' . __("Read More", "wp_blog_designer") . '</a>';
                }
                ?>
            <?php endif; ?>
        </div>
        <?php
        if (get_option('display_tag') == 0) {
            $tags_list = get_the_tag_list('', __(', ', 'wp_blog_designer'));
            if ($tags_list):
                ?>
                <div class="tags">
                    <div class="icon-tags"></div>
                    <?php
                    printf(__('%2$s', 'wp_blog_designer'), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list);
                    $show_sep = true;
                    ?>
                </div>
                <?php
            endif;
        }
        if ((get_option('facebook_link') == 0) || (get_option('twitter_link') == 0) || (get_option('google_link') == 0) || (get_option('linkedin_link') == 0) || (get_option('instagram_link') == 0) || ( get_option('pinterest_link') == 0 )) {
            ?>        
            <div class="social-component">
                <?php if (get_option('facebook_link') == 0): ?>
                    <a href="<?php echo 'https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink(); ?>" target= _blank class="facebook-share"><i class="fa fa-facebook"></i></a>
                <?php endif; ?>
                <?php if (get_option('twitter_link') == 0): ?>
                    <a href="<?php echo 'http://twitter.com/share?&url=' . get_the_permalink(); ?>" target= _blank class="twitter"><i class="fa fa-twitter"></i></a>
                <?php endif; ?>
                <?php if (get_option('google_link') == 0): ?>
                    <a href="<?php echo 'https://plus.google.com/share?url=' . get_the_permalink(); ?>" target= _blank class="google"><i class="fa fa-google-plus"></i></a>
                <?php endif; ?>
                <?php if (get_option('linkedin_link') == 0): ?>
                    <a href="<?php echo 'http://www.linkedin.com/shareArticle?url=' . get_the_permalink(); ?>" target= _blank class="linkedin"><i class="fa fa-linkedin"></i></a>
                <?php endif; ?>
                <?php if (get_option('instagram_link') == 0): ?>
                    <a href="<?php echo 'mailto:enteryour@addresshere.com?subject=Share and Follow&body=' . get_the_permalink(); ?>" target= _blank class="instagram"><i class="fa fa-envelope-o"></i></a>
                <?php endif; ?>        
                <?php if (get_option('pinterest_link') == 0): ?>
                    <a href="<?php echo '//pinterest.com/pin/create/button/?url=' . get_the_permalink(); ?>" target= _blank class="pinterest"> <i class="fa fa-pinterest"></i></a>
                <?php endif; ?>
            </div>
        <?php } ?>
    </div>   
    <?php
}

/**
 * 
 * @global type $post
 * @return html display spektrum design
 */
function wp_desgin3_template() {
    ?>

    <div class="blog_template bdp_blog_template spektrum">
        <?php the_post_thumbnail('full'); ?>
        <div class="blog_header">
            <?php if (get_option('display_date') == 0) { ?>
                <span class="date"><span class="number-date"><?php the_time(__('d')); ?></span><?php the_time(__('F')); ?></span>
            <?php } ?>
            <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        </div>
        <div class="post_content">
            <?php if (get_option('rss_use_excerpt') == 0): ?>
                <?php the_content(); ?>
            <?php else: ?>
                <?php the_excerpt(); ?>
            <?php endif; ?>
        </div>
        <div class="post-bottom">
            <?php if (get_option('display_category') == 0) { ?>
                <span class="categories">
                    <?php
                    $categories_list = get_the_category_list(__(', ', 'wp_blog_designer'));
                    if ($categories_list):
                        printf(__('Categories : %2$s', 'wp_blog_designer'), 'entry-utility-prep entry-utility-prep-tag-links', $categories_list);
                        $show_sep = true;
                    endif;
                    ?>
                </span>
            <?php } ?>
            <?php if (get_option('display_author') == 0) { ?>
                <span class="post-by">
                    <div class="icon-author"></div><?php _e('Posted by ', 'wp_blog_designer'); ?><span><?php the_author(); ?></span>
                </span>
            <?php } ?>
            <?php
            if (get_option('display_tag') == 0) {
                $tags_list = get_the_tag_list('', __(', ', 'wp_blog_designer'));
                if ($tags_list):
                    ?>
                    <span class="tags">
                        <div class="icon-tags"></div>
                        <?php
                        printf(__('%2$s', 'wp_blog_designer'), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list);
                        $show_sep = true;
                        ?>
                    </span>
                    <?php
                endif;
            }
            ?>
            <?php if (get_option('rss_use_excerpt') == 1): ?>
                <span class="details">
                    <?php
                    global $post;
                    if (get_option('read_more_text') != '') {
                        echo '<a class="more-tag" href="' . get_permalink($post->ID) . '">' . get_option('read_more_text') . ' </a>';
                    } else {
                        echo ' <a class="more-tag" href="' . get_permalink($post->ID) . '">' . __('Read More', 'wp_blog_designer') . '</a>';
                    }
                    ?>                    
                </span>
            <?php endif; ?>
        </div>
        <?php if ((get_option('facebook_link') == 0) || (get_option('twitter_link') == 0) || (get_option('google_link') == 0) || (get_option('linkedin_link') == 0) || (get_option('instagram_link') == 0) || ( get_option('pinterest_link') == 0 )) { ?>
            <div class="social-component spektrum-social">
                <?php if (get_option('facebook_link') == 0): ?>
                    <a href="<?php echo 'https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink(); ?>" target= _blank class="facebook-share"><i class="fa fa-facebook"></i></a>
                <?php endif; ?>
                <?php if (get_option('twitter_link') == 0): ?>
                    <a href="<?php echo 'http://twitter.com/share?&url=' . get_the_permalink(); ?>" target= _blank class="twitter"><i class="fa fa-twitter"></i></a>
                <?php endif; ?>
                <?php if (get_option('google_link') == 0): ?>
                    <a href="<?php echo 'https://plus.google.com/share?url=' . get_the_permalink(); ?>" target= _blank class="google"><i class="fa fa-google-plus"></i></a>
                <?php endif; ?>
                <?php if (get_option('linkedin_link') == 0): ?>
                    <a href="<?php echo 'http://www.linkedin.com/shareArticle?url=' . get_the_permalink(); ?>" target= _blank class="linkedin"><i class="fa fa-linkedin"></i></a>
                <?php endif; ?>
                <?php if (get_option('instagram_link') == 0): ?>
                    <a href="<?php echo 'mailto:enteryour@addresshere.com?subject=Share and Follow&body=' . get_the_permalink(); ?>" target= _blank class="instagram"><i class="fa fa-envelope-o"></i></a>
                <?php endif; ?>        
                <?php if (get_option('pinterest_link') == 0): ?>
                    <a href="<?php echo '//pinterest.com/pin/create/button/?url=' . get_the_permalink(); ?>" target= _blank class="pinterest"> <i class="fa fa-pinterest"></i></a>
                <?php endif; ?>
            </div>  
        <?php } ?>
    </div>

    <?php
}

/**
 * 
 * @global type $post
 * @param type $alterclass
 * @return html display evolution design
 */
function wp_evolution_template($alterclass) {
    ?>

    <div class="blog_template bdp_blog_template marketer <?php echo $alterclass; ?>">
        <div class="post-category"> 
            <?php
            if (get_option('display_category') == 0) {
                ?>                                    
                <?php
                $categories_list = get_the_category_list(__(', ', 'wp_blog_designer'));
                if ($categories_list):
                    printf(__('%2$s', 'wp_blog_designer'), 'entry-utility-prep entry-utility-prep-tag-links', $categories_list);
                    $show_sep = true;
                endif;
            }
            ?>
        </div>
        <h1 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
        <div class="post-entry-meta">
            <?php if (get_option('display_date') == 0) { ?>
                <span class="date"><span class="number-date"><?php the_time(__('d')); ?></span><?php the_time(__('F')); ?></span>
            <?php } ?>

            <?php if (get_option('display_author') == 0) { ?>
                <span class="author"><?php _e('Posted by ', 'wp_blog_designer'); ?><?php the_author(); ?></span>
                <?php
            }
            if (get_option('display_comment_count') == 0) {
                if (!post_password_required() && ( comments_open() || get_comments_number() )) :
                    ?>
                    <span class="comment"><span class="icon_cnt"><i class="fa fa-comment"></i><?php comments_popup_link('0', '1', '%'); ?></span></span>
                    <?php
                endif;
            }
            if (get_option('display_tag') == 0) {
                $tags_list = get_the_tag_list('', __(', ', 'wp_blog_designer'));
                if ($tags_list):
                    ?>
                    <span class="tags">
                        <div class="icon-tags"></div>
                        <?php
                        printf(__('%2$s', 'wp_blog_designer'), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list);
                        $show_sep = true;
                        ?>
                    </span>
                    <?php
                endif;
            }
            ?>
        </div>
        <div class="post-image">
            <?php the_post_thumbnail('full'); ?>
        </div>
        <div class="post-content-body">
            <?php if (get_option('rss_use_excerpt') == 0): ?>
                <?php the_content(); ?>
            <?php else: ?>
                <?php the_excerpt(); ?>
            <?php endif; ?>
        </div>
        <?php if (get_option('rss_use_excerpt') == 1): ?>
            <div class="post-bottom">
                <?php
                global $post;
                if (get_option('read_more_text') != '') {
                    echo '<a href="' . get_permalink($post->ID) . '">' . get_option('read_more_text') . ' </a>';
                } else {
                    echo ' <a href="' . get_permalink($post->ID) . '">' . __('Read more &raquo;', 'wp_blog_designer') . '</a>';
                }
                ?>
            </div>
        <?php endif; ?>
        <?php if ((get_option('facebook_link') == 0) || (get_option('twitter_link') == 0) || (get_option('google_link') == 0) || (get_option('linkedin_link') == 0) || (get_option('instagram_link') == 0) || ( get_option('pinterest_link') == 0 )) { ?>
            <div class="social-component">
                <?php if (get_option('facebook_link') == 0): ?>
                    <a href="<?php echo 'https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink(); ?>" target= _blank class="facebook-share"><i class="fa fa-facebook"></i></a>
                <?php endif; ?>
                <?php if (get_option('twitter_link') == 0): ?>
                    <a href="<?php echo 'http://twitter.com/share?&url=' . get_the_permalink(); ?>" target= _blank class="twitter"><i class="fa fa-twitter"></i></a>
                <?php endif; ?>
                <?php if (get_option('google_link') == 0): ?>
                    <a href="<?php echo 'https://plus.google.com/share?url=' . get_the_permalink(); ?>" target= _blank class="google"><i class="fa fa-google-plus"></i></a>
                <?php endif; ?>
                <?php if (get_option('linkedin_link') == 0): ?>
                    <a href="<?php echo 'http://www.linkedin.com/shareArticle?url=' . get_the_permalink(); ?>" target= _blank class="linkedin"><i class="fa fa-linkedin"></i></a>
                <?php endif; ?>
                <?php if (get_option('instagram_link') == 0): ?>
                    <a href="<?php echo 'mailto:enteryour@addresshere.com?subject=Share and Follow&body=' . get_the_permalink(); ?>" target= _blank class="instagram"><i class="fa fa-envelope-o"></i></a>
                <?php endif; ?>        
                <?php if (get_option('pinterest_link') == 0): ?>
                    <a href="<?php echo '//pinterest.com/pin/create/button/?url=' . get_the_permalink(); ?>" target= _blank class="pinterest"> <i class="fa fa-pinterest"></i></a>
                <?php endif; ?>
            </div>
        <?php } ?>
    </div>
    <?php
}

/**
 * 
 * @global type $post
 * @return html display timeline design
 */
function wp_timeline_template() {
    ?>
    <div class="blog_template bdp_blog_template timeline blog-wrap">
        <div class="post_hentry ">
            <div class="post_content_wrap">

                <div class="post_wrapper box-blog">
                    <div class="photo">
                        <?php the_post_thumbnail('full'); ?>
                    </div>
                    <div class="desc">
                        <a href="<?php the_permalink(); ?>">
                            <h3 class="entry-title text-center text-capitalize"><?php the_title(); ?></h3>
                        </a>
                        <div class="date_wrap">
                            <?php if (get_option('display_author') == 0) { ?>
                                <span title="Posted By <?php the_author(); ?>">
                                    <i class="fa fa-user"></i>
                                    <span><?php the_author(); ?></span>
                                </span>  
                            <?php } ?>
                            <div class="datetime">
                                <span class="month"><?php the_time(__('M')); ?></span>
                                <span class="date"><?php the_time(__('d')); ?></span>
                            </div>
                        </div>
                        <div class="post_content">
                            <?php if (get_option('rss_use_excerpt') == 0): ?>
                                <?php the_content(); ?>
                            <?php else: ?>
                                <?php the_excerpt(); ?>
                            <?php endif; ?>
                        </div>
                        <?php if (get_option('rss_use_excerpt') == 1): ?>

                            <div class="read_more">
                                <?php
                                global $post;
                                if (get_option('read_more_text') != '') {
                                    echo '<a class="btn-more" href="' . get_permalink($post->ID) . '"><i class="fa fa-plus"></i> ' . get_option('read_more_text') . ' </a>';
                                } else {
                                    echo ' <a class="btn-more" href="' . get_permalink($post->ID) . '"><i class="fa fa-plus"></i> ' . __('Read more &raquo;', 'wp_blog_designer') . '</a>';
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <footer class="blog_footer text-capitalize">

                    <?php if (get_option('display_category') == 0) { ?>
                        <span class="categories">
                            <i class="fa fa-bookmark"></i>
                            <?php
                            $categories_list = get_the_category_list(__(', ', 'wp_blog_designer'));
                            if ($categories_list):
                                printf(__('Categories : %2$s', 'wp_blog_designer'), 'entry-utility-prep entry-utility-prep-tag-links', $categories_list);
                                $show_sep = true;
                            endif;
                            ?>
                        </span>
                    <?php } ?>

                    <?php
                    if (get_option('display_tag') == 0) {
                        $tags_list = get_the_tag_list('', __(', ', 'wp_blog_designer'));
                        if ($tags_list):
                            ?>
                            <span class="tags">                            
                                <i class="fa fa-bookmark"></i>
                                <?php
                                printf(__('Tags : %2$s', 'wp_blog_designer'), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list);
                                $show_sep = true;
                                ?>
                            </span>
                            <?php
                        endif;
                    }
                    ?>

                    <?php if ((get_option('facebook_link') == 0) || (get_option('twitter_link') == 0) || (get_option('google_link') == 0) || (get_option('linkedin_link') == 0) || (get_option('instagram_link') == 0) || ( get_option('pinterest_link') == 0 )) { ?>
                        <div class="social-component spektrum-social">
                            <?php if (get_option('facebook_link') == 0): ?>
                                <a href="<?php echo 'https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink(); ?>" target= _blank class="facebook-share"><i class="fa fa-facebook"></i></a>
                            <?php endif; ?>
                            <?php if (get_option('twitter_link') == 0): ?>
                                <a href="<?php echo 'http://twitter.com/share?&url=' . get_the_permalink(); ?>" target= _blank class="twitter"><i class="fa fa-twitter"></i></a>
                            <?php endif; ?>
                            <?php if (get_option('google_link') == 0): ?>
                                <a href="<?php echo 'https://plus.google.com/share?url=' . get_the_permalink(); ?>" target= _blank class="google"><i class="fa fa-google-plus"></i></a>
                            <?php endif; ?>
                            <?php if (get_option('linkedin_link') == 0): ?>
                                <a href="<?php echo 'http://www.linkedin.com/shareArticle?url=' . get_the_permalink(); ?>" target= _blank class="linkedin"><i class="fa fa-linkedin"></i></a>
                            <?php endif; ?>
                            <?php if (get_option('instagram_link') == 0): ?>
                                <a href="<?php echo 'mailto:enteryour@addresshere.com?subject=Share and Follow&body=' . get_the_permalink(); ?>" target= _blank class="instagram"><i class="fa fa-envelope-o"></i></a>
                            <?php endif; ?>        
                            <?php if (get_option('pinterest_link') == 0): ?>
                                <a href="<?php echo '//pinterest.com/pin/create/button/?url=' . get_the_permalink(); ?>" target= _blank class="pinterest"> <i class="fa fa-pinterest"></i></a>
                            <?php endif; ?>
                        </div>  
                    <?php } ?>
            </div>            
            </footer>
        </div>
    </div>
    <?php
}

/**
 * 
 * @global type $wp_version
 * @return html Display setting options
 */
function wp_blog_designer_menu_function() {
    global $wp_version;
    ?>
    <div class="wrap">
        <h2><?php _e('Blog Designer Settings', 'wp_blog_designer') ?></h2>
        <?php if (isset($_GET['updated']) && 'true' == esc_attr($_GET['updated'])) echo '<div class="updated" ><p>' . __('Designer Settings updated.', 'wp_blog_designer') . '</p></div>'; ?>
        <?php
        $settings = get_option("wp_blog_designer_settings");
        if (isset($_SESSION['success_msg'])) { ?>
            <div class="updated is-dismissible notice settings-error"><?php
                echo '<p>'.$_SESSION['success_msg'].'</p>';
                unset($_SESSION['success_msg']);
                ?></div>
        <?php } ?>
        <form method="post" action="?page=designer_settings&action=save&updated=true" class="bd-form-class">
            <!--script type="text/javascript">jQuery( window ).load( function() { jQuery( "#template_category" ).attr( "multiple", "multiple" );});</script-->
            <div class="wl-pages" >
                <div class="wl-page wl-settings active">
                    <div class="wl-box wl-settings">
                        <h3 class="header"><?php _e('General Settings', 'wp_blog_designer') ?></h3>
                        <table>
                            <tbody>
                                <tr>
                                    <td><?php _e('Blog Page Displays', 'wp_blog_designer') ?></td>
                                    <td>
                                        <?php printf(__('%s', 'wp_blog_designer'), wp_dropdown_pages(array('name' => 'blog_page_display', 'echo' => 0, 'show_option_none' => __('--Select Page--', 'wp_blog_designer'), 'option_none_value' => '0', 'selected' => get_option('blog_page_display')))); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Blog Pages Show at Most', 'wp_blog_designer') ?></td>
                                    <td>
                                        <input name="posts_per_page" type="number" step="1" min="1" id="posts_per_page" value="<?php echo get_option('posts_per_page'); ?>" class="small-text" /> <?php _e('Posts', 'wp_blog_designer'); ?>
                                    </td>
                                </tr>                                
                                <tr>
                                    <td><?php _e('Display Post Category ', 'wp_blog_designer') ?></td>
                                    <td>
                                        <input name="display_category" type="radio" value="0" <?php checked(0, get_option('display_category')); ?>	/> <?php _e('Yes', 'wp_blog_designer'); ?>
                                        <input name="display_category" type="radio" value="1" <?php checked(1, get_option('display_category')); ?> /> <?php _e('No', 'wp_blog_designer'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Display Post Tag ', 'wp_blog_designer') ?></td>
                                    <td>
                                        <input name="display_tag" type="radio" value="0" <?php checked(0, get_option('display_tag')); ?>	/> <?php _e('Yes', 'wp_blog_designer'); ?>
                                        <input name="display_tag" type="radio" value="1" <?php checked(1, get_option('display_tag')); ?> /> <?php _e('No', 'wp_blog_designer'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Display Post Author ', 'wp_blog_designer') ?></td>
                                    <td>
                                        <input name="display_author" type="radio" value="0" <?php checked(0, get_option('display_author')); ?>	/> <?php _e('Yes', 'wp_blog_designer'); ?>
                                        <input name="display_author" type="radio" value="1" <?php checked(1, get_option('display_author')); ?> /> <?php _e('No', 'wp_blog_designer'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Display Post Date ', 'wp_blog_designer') ?></td>
                                    <td>
                                        <input name="display_date" type="radio" value="0" <?php checked(0, get_option('display_date')); ?>	/> <?php _e('Yes', 'wp_blog_designer'); ?>
                                        <input name="display_date" type="radio" value="1" <?php checked(1, get_option('display_date')); ?> /> <?php _e('No', 'wp_blog_designer'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Display Post Comment Count ', 'wp_blog_designer') ?></td>
                                    <td>
                                        <input name="display_comment_count" type="radio" value="0" <?php checked(0, get_option('display_comment_count')); ?>	/> <?php _e('Yes', 'wp_blog_designer'); ?>
                                        <input name="display_comment_count" type="radio" value="1" <?php checked(1, get_option('display_comment_count')); ?> /> <?php _e('No', 'wp_blog_designer'); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h3 class="header"><?php _e('Standard Settings', 'wp_blog_designer') ?></h3>
                        <table>
                            <tbody>
                                <tr>
                                    <td><?php _e('Blog Post Categories', 'wp_blog_designer') ?></td>
                                    <td>
                                        <?php $categories = get_categories(array('child_of' => '', 'hide_empty' => 1)); ?>
                                        <select name="template_category[]" id="template_category" multiple="multiple">
                                            <option><?php _e('-- Select Category --', 'wp_blog_designer'); ?></option>
                                            <?php foreach ($categories as $categoryObj): ?>
                                                <option value="<?php echo $categoryObj->term_id; ?>" <?php
                                                if (@in_array($categoryObj->term_id, $settings['template_category'])) {
                                                    echo 'selected="selected"';
                                                }
                                                ?>><?php echo $categoryObj->name; ?></option>
                                                    <?php endforeach; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Blog Designs', 'wp_blog_designer') ?></td>
                                    <td>
                                        <select name="template_name" id="template_name">
                                            <option value=""><?php _e('---select---', 'wp_blog_designer'); ?></option>
                                            <option value="classical" <?php if ($settings["template_name"] == 'classical') { ?> selected="selected"<?php } ?>><?php _e('Classical Desgin', 'wp_blog_designer'); ?></option>
                                            <option value="lightbreeze" <?php if ($settings["template_name"] == 'lightbreeze') { ?> selected="selected"<?php } ?>><?php _e('Light Breeze Design', 'wp_blog_designer'); ?></option>
                                            <option value="spektrum" <?php if ($settings["template_name"] == 'spektrum') { ?> selected="selected"<?php } ?>><?php _e('Spektrum Design', 'wp_blog_designer'); ?></option>
                                            <option value="evolution" <?php if ($settings["template_name"] == 'evolution') { ?> selected="selected"<?php } ?>><?php _e('Evolution Design', 'wp_blog_designer'); ?></option>
                                            <option value="timeline" <?php if ($settings["template_name"] == 'timeline') { ?> selected="selected"<?php } ?>><?php _e('Timeline Design', 'wp_blog_designer'); ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="blog-templatecolor-tr">
                                    <td><?php _e('Blog Posts Template Color', 'wp_blog_designer') ?></td>
                                    <td>                                        
                                        <input type="text" name="template_color" id="template_color" value="<?php echo $settings["template_color"]; ?>"/>                                        
                                    </td>
                                </tr>
                                <tr class="blog-template-tr">
                                    <td><?php _e('Background Color for Blog Posts', 'wp_blog_designer') ?></td>
                                    <td>                                        
                                        <input type="text" name="template_bgcolor" id="template_bgcolor" value="<?php echo $settings["template_bgcolor"]; ?>"/>                                        
                                    </td>
                                </tr>
                                <tr class="blog-template-tr">
                                    <td><?php _e('Alternative Background Color', 'wp_blog_designer'); ?></td>
                                    <td>
                                        <input type="radio" value="0" name="template_alternativebackground" <?php checked(0, get_option('template_alternativebackground')); ?>	/> <?php _e('Yes', 'wp_blog_designer'); ?>
                                        <input type="radio" value="1" name="template_alternativebackground" <?php checked(1, get_option('template_alternativebackground')); ?>	/> <?php _e('No', 'wp_blog_designer'); ?>
                                    </td>                                    
                                </tr>
                                <tr class="alternative-color-tr">
                                    <td><?php _e('Choose Alternative Background Color', 'wp_blog_designer') ?></td>
                                    <td>                                        
                                        <input type="text" name="template_alterbgcolor" id="template_alterbgcolor" value="<?php echo $settings["template_alterbgcolor"]; ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Choose Link Color', 'wp_blog_designer') ?></td>
                                    <td>                                        
                                        <input type="text" name="template_ftcolor" id="template_ftcolor" value="<?php echo $settings["template_ftcolor"]; ?>" data-default-color="<?php echo $settings["template_ftcolor"]; ?>"/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>                        
                        <h3 class="header"><?php _e('Title Settings', 'wp_blog_designer') ?></h3>
                        <table>
                            <tbody>
                                <tr>
                                    <td><?php _e('Post Title Color', 'wp_blog_designer') ?></td>
                                    <td>                                        
                                        <input type="text" name="template_titlecolor" id="template_titlecolor" value="<?php echo $settings["template_titlecolor"]; ?>"/>
                                    </td>
                                </tr>                                
                                <tr>
                                    <td><?php _e('Post Title Background Color', 'wp_blog_designer') ?></td>
                                    <td>                                        
                                        <input type="text" name="template_titlebackcolor" id="template_titlebackcolor" value="<?php echo $settings["template_titlebackcolor"]; ?>"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Post Title Font Size', 'wp_blog_designer') ?></td>
                                    <td>
                                        <select name="template_titlefontsize" id="template_titlefontsize">
                                            <?php for ($i = 10; $i <= 100; $i++) { ?>
                                                <option value="<?php echo $i; ?>" <?php if (get_option('template_titlefontsize') == $i) { ?> selected="selected"<?php } ?>><?php echo $i . 'px'; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h3 class="header"><?php _e('Content Settings', 'wp_blog_designer') ?></h3>
                        <table>
                            <tbody>
                                <tr>
                                    <td><?php _e('For each Article in a Feed, Show ', 'wp_blog_designer') ?></td>
                                    <td class="rss_use_excerpt">
                                        <input name="rss_use_excerpt" type="radio" value="0" <?php checked(0, get_option('rss_use_excerpt')); ?>	/> <?php _e('Full Text', 'wp_blog_designer'); ?>
                                        <input name="rss_use_excerpt" type="radio" value="1" <?php checked(1, get_option('rss_use_excerpt')); ?> /> <?php _e('Summary', 'wp_blog_designer'); ?>
                                    </td>
                                </tr>
                                <tr class="excerpt_length">
                                    <td><?php _e('Post Content Length', 'wp_blog_designer') ?></td>
                                    <td >
                                        <input type="text" name="txtExcerptlength" value="<?php echo get_option('excerpt_length'); ?>" placeholder="Enter excerpt length">
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Post Content Font Size', 'wp_blog_designer') ?></td>
                                    <td>
                                        <select name="content_fontsize" id="content_fontsize">
                                            <?php for ($i = 10; $i <= 100; $i++) { ?>
                                                <option value="<?php echo $i; ?>" <?php if (get_option('content_fontsize') == $i) { ?> selected="selected"<?php } ?>><?php echo $i . 'px'; ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Post Content Color', 'wp_blog_designer') ?></td>
                                    <td>                                        
                                        <input type="text" name="template_contentcolor" id="template_contentcolor" value="<?php echo $settings["template_contentcolor"]; ?>"/>
                                    </td>
                                </tr>
                                <tr class="read_more_text">
                                    <td><?php _e('Read More Text', 'wp_blog_designer') ?></td>
                                    <td>
                                        <input type="text" name="txtReadmoretext" value="<?php echo get_option('read_more_text'); ?>" placeholder="Enter read more text">
                                    </td>
                                </tr>
                                <tr class="read_more_text_color">
                                    <td><?php _e('Read More Text Color', 'wp_blog_designer') ?></td>
                                    <td>                                        
                                        <input type="text" name="template_readmorecolor" id="template_readmorecolor" value="<?php echo $settings["template_readmorecolor"]; ?>"/>
                                    </td>
                                </tr>
                                <tr class="read_more_text_background">
                                    <td><?php _e('Read More Text Background Color', 'wp_blog_designer') ?></td>
                                    <td>                                        
                                        <input type="text" name="template_readmorebackcolor" id="template_readmorebackcolor" value="<?php echo $settings["template_readmorebackcolor"]; ?>"/>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <h3 class="header"><?php _e('Social Settings', 'wp_blog_designer') ?></h3>
                        <table>
                            <tbody>
                                <tr>
                                    <td><?php _e('Shape of Social Icon', 'wp_blog_designer') ?></td>
                                    <td>                                        
                                        <input name="social_icon_style" type="radio" value="0" checked="checked" <?php checked(0, get_option('social_icon_style')); ?>	/> <?php _e('Circle', 'wp_blog_designer'); ?>
                                        <input name="social_icon_style" type="radio" value="1" <?php checked(1, get_option('social_icon_style')); ?> /> <?php _e('Square', 'wp_blog_designer'); ?>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Facebook Share Link', 'wp_blog_designer') ?></td>
                                    <td>                                        
                                        <input name="facebook_link" type="radio" value="0" <?php checked(0, get_option('facebook_link')); ?>	/> <?php _e('Yes', 'wp_blog_designer'); ?>
                                        <input name="facebook_link" type="radio" value="1" <?php checked(1, get_option('facebook_link')); ?> /> <?php _e('No', 'wp_blog_designer'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Twitter Share Link', 'wp_blog_designer') ?></td>
                                    <td>                                        
                                        <input name="twitter_link" type="radio" value="0" <?php checked(0, get_option('twitter_link')); ?>	/> <?php _e('Yes', 'wp_blog_designer'); ?>
                                        <input name="twitter_link" type="radio" value="1" <?php checked(1, get_option('twitter_link')); ?> /> <?php _e('No', 'wp_blog_designer'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Google+ Share Link', 'wp_blog_designer') ?></td>
                                    <td>                                        
                                        <input name="google_link" type="radio" value="0" <?php checked(0, get_option('google_link')); ?>	/> <?php _e('Yes', 'wp_blog_designer'); ?>
                                        <input name="google_link" type="radio" value="1" <?php checked(1, get_option('google_link')); ?> /> <?php _e('No', 'wp_blog_designer'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Linkedin Share Link', 'wp_blog_designer') ?></td>
                                    <td>
                                        <input name="linkedin_link" type="radio" value="0" <?php checked(0, get_option('linkedin_link')); ?>	/> <?php _e('Yes', 'wp_blog_designer'); ?>
                                        <input name="linkedin_link" type="radio" value="1" <?php checked(1, get_option('linkedin_link')); ?> /> <?php _e('No', 'wp_blog_designer'); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php _e('Share Via Mail', 'wp_blog_designer') ?></td>
                                    <td>
                                        <input name="instagram_link" type="radio" value="0" <?php checked(0, get_option('instagram_link')); ?>	/> <?php _e('Yes', 'wp_blog_designer'); ?>
                                        <input name="instagram_link" type="radio" value="1" <?php checked(1, get_option('instagram_link')); ?> /> <?php _e('No', 'wp_blog_designer'); ?>
                                    </td>
                                </tr>                                

                                <tr>
                                    <td><?php _e('Pinterest Share link', 'wp_blog_designer') ?></td>
                                    <td>
                                        <input name="pinterest_link" type="radio" value="0" <?php checked(0, get_option('pinterest_link')); ?>	/> <?php _e('Yes', 'wp_blog_designer'); ?>
                                        <input name="pinterest_link" type="radio" value="1" <?php checked(1, get_option('pinterest_link')); ?> /> <?php _e('No', 'wp_blog_designer'); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>                             
            <div class="inner">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes', 'wp_blog_designer'); ?>" />
                <p class="wl-saving-warning"></p>
                <div class="clear"></div>
            </div>            
        </form>
        <div class="bd-admin-sidebar">
            <div class="bd-help">
                <h2><?php _e('Help to improve this plugin!', 'wp_blog_designer'); ?></h2>
                <span><?php _e('Enjoyed this plugin?', 'wp_blog_designer'); ?></span>
                <span><?php _e(' You can help by', 'wp_blog_designer'); ?>
                    <a href="https://wordpress.org/support/view/plugin-reviews/blog-designer" target="_blank">
                        <?php _e(' rating this plugin on wordpress.org', 'wp_blog_designer'); ?>
                    </a>                    
                </span>
                <div class="bd-total-download">
                    <?php _e('Downloads:', 'wp_blog_designer'); ?><?php get_total_downloads(); ?>
                    <?php
                    if ($wp_version > 3.8) {
                        wp_custom_star_rating();
                    }
                    ?>
                </div>
            </div>
            <div class="bd-support">
                <h3><?php _e('Need Support?', 'wp_blog_designer'); ?></h3>
                <span><?php _e('Check out the', 'wp_blog_designer') ?>
                    <a href="https://wordpress.org/plugins/blog-designer/faq/" target="_blank"><?php _e('FAQs', 'wp_blog_designer'); ?></a>
                    <?php _e('and', 'wp_blog_designer') ?>
                    <a href="https://wordpress.org/support/plugin/blog-designer" target="_blank"><?php _e('Support Forums', 'wp_blog_designer') ?></a>
                </span>
            </div>
            <div class="bd-support">
                <h3><?php _e('Share & Follow Us', 'wp_blog_designer'); ?></h3>
                <!-- Twitter -->
                <div style='display:block;margin-bottom:8px;'>
                    <a href="https://twitter.com/solwininfotech" class="twitter-follow-button" data-show-count="true" data-show-screen-name="true" data-dnt="true">Follow @solwininfotech</a>                    
                    <script>!function (d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                            if (!d.getElementById(id)) {
                                js = d.createElement(s);
                                js.id = id;
                                js.src = p + '://platform.twitter.com/widgets.js';
                                fjs.parentNode.insertBefore(js, fjs);
                            }
                        }(document, 'script', 'twitter-wjs');</script>
                </div>
                <!-- Facebook -->
                <div style='display:block;margin-bottom:10px;'>
                    <div id="fb-root"></div>
                    <script>(function (d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id))
                                return;
                            js = d.createElement(s);
                            js.id = id;
                            js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.5";
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));</script>
                    <div class="fb-share-button" data-href="https://wordpress.org/plugins/blog-designer/" data-layout="button_count"></div>
                </div>               
                <!-- Google Plus -->
                <div style='display:block;margin-bottom:8px;'>
                    <!-- Place this tag where you want the +1 button to render. -->
                    <div class="g-plusone" data-href="https://wordpress.org/plugins/blog-designer/"></div>
                    <!-- Place this tag after the last +1 button tag. -->
                    <script type="text/javascript">
                        (function () {
                            var po = document.createElement('script');
                            po.type = 'text/javascript';
                            po.async = true;
                            po.src = 'https://apis.google.com/js/platform.js';
                            var s = document.getElementsByTagName('script')[0];
                            s.parentNode.insertBefore(po, s);
                        })();
                    </script>
                </div>
                <div style='display:block;margin-bottom:8px;'>
                    <script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
                    <script type="IN/Share" data-url="https://wordpress.org/plugins/blog-designer/" data-counter="right" data-showzero="true"></script>
                </div>
            </div>
            <div class="useful_plugins">
                <h3><?php _e('Our Other Works', 'wp_blog_designer'); ?></h3>
                <ul class="plugins_list">
                    <li>
                        <span class="plugin_img">
                            <img src="http://www.solwininfotech.com/wp-content/uploads/2015/10/avartan-slider-300x300.png" />
                        </span>
                        <span>
                            <a href="http://www.solwininfotech.com/product/wordpress-plugins/avartan-slider/" target="_blank"><?php _e('Avartan Premium Slider Plugin', 'wp_blog_designer'); ?></a>
                        </span>
                        <span class="plugins_content">
                            <?php _e('Avartan Slider is a great way to create stunning text, image, video and shortcode slider for your beautiful WordPress websites and give them wow factor.', 'wp_blog_designer'); ?>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <?php
}

/**
 * 
 * @param type $args
 * @return type Display Pagination
 */
function designer_pagination($args = array()) {

    if (!is_array($args)) {
        $argv = func_get_args();
        $args = array();
        foreach (array('before', 'after', 'options') as $i => $key)
            $args[$key] = $argv[$i];
    }
    $args = wp_parse_args($args, array(
        'before' => '',
        'after' => '',
        'options' => array(),
        'query' => $GLOBALS['wp_query'],
        'type' => 'posts',
        'echo' => true
    ));

    extract($args, EXTR_SKIP);
    $instance = new BDesigner($args);

    list( $posts_per_page, $paged, $total_pages ) = $instance->get_pagination_args();

    if (1 == $total_pages && isset($options['always_show']) && !$options['always_show'])
        return;

    $pages_to_show = 100;
    $larger_page_to_show = 3;
    $larger_page_multiple = 10;
    $pages_to_show_minus_1 = $pages_to_show - 1;
    $half_page_start = floor($pages_to_show_minus_1 / 2);
    $half_page_end = ceil($pages_to_show_minus_1 / 2);
    $start_page = $paged - $half_page_start;

    if ($start_page <= 0)
        $start_page = 1;

    $end_page = $paged + $half_page_end;

    if (( $end_page - $start_page ) != $pages_to_show_minus_1)
        $end_page = $start_page + $pages_to_show_minus_1;

    if ($end_page > $total_pages) {
        $start_page = $total_pages - $pages_to_show_minus_1;
        $end_page = $total_pages;
    }

    if ($start_page < 1)
        $start_page = 1;

    $out = '';
    $options['style'] = 1;
    $options['pages_text'] = 'Page %CURRENT_PAGE% of %TOTAL_PAGES%';
    $options['current_text'] = '%PAGE_NUMBER%';
    $options['page_text'] = '%PAGE_NUMBER%';
    $options['first_text'] = '&laquo; First';
    $options['last_text'] = 'Last &raquo;';
    $options['prev_text'] = '';
    $options['next_text'] = '';
    $options['dotright_text'] = '';

    switch (intval($options['style'])) {


        // Normal
        case 1:
            // Text
            if (!empty($options['pages_text'])) {
                $pages_text = str_replace(
                        array("%CURRENT_PAGE%", "%TOTAL_PAGES%"), array(number_format_i18n($paged), number_format_i18n($total_pages)), $options['pages_text']);
                $out .= "<span class='pages'>$pages_text</span>";
            }

            if ($start_page >= 2 && $pages_to_show < $total_pages) {
                // First
                $first_text = str_replace('%TOTAL_PAGES%', number_format_i18n($total_pages), $options['first_text']);
                $out .= $instance->get_single(1, 'first', $first_text, '%TOTAL_PAGES%');
            }

            // Previous
            if ($paged > 1 && !empty($options['prev_text']))
                $out .= $instance->get_single($paged - 1, 'previouspostslink', $options['prev_text']);

            if ($start_page >= 2 && $pages_to_show < $total_pages) {
                if (!empty($options['dotleft_text']))
                    $out .= "<span class='extend'>{$options['dotleft_text']}</span>";
            }

            // Smaller pages
            $larger_pages_array = array();
            if ($larger_page_multiple)
                for ($i = $larger_page_multiple; $i <= $total_pages; $i+= $larger_page_multiple)
                    $larger_pages_array[] = $i;

            $larger_page_start = 0;
            foreach ($larger_pages_array as $larger_page) {
                if ($larger_page < ($start_page - $half_page_start) && $larger_page_start < $larger_page_to_show) {
                    $out .= $instance->get_single($larger_page, 'smaller page', $options['page_text']);
                    $larger_page_start++;
                }
            }

            if ($larger_page_start)
                $out .= "<span class='extend'>{$options['dotleft_text']}</span>";

            // Page numbers
            $timeline = 'smaller';
            foreach (range($start_page, $end_page) as $i) {
                if ($i == $paged && !empty($options['current_text'])) {
                    $current_page_text = str_replace('%PAGE_NUMBER%', number_format_i18n($i), $options['current_text']);
                    $out .= "<span class='current'>$current_page_text</span>";
                    $timeline = 'larger';
                } else {
                    $out .= $instance->get_single($i, "page $timeline", $options['page_text']);
                }
            }

            // Large pages
            $larger_page_end = 0;
            $larger_page_out = '';
            foreach ($larger_pages_array as $larger_page) {
                if ($larger_page > ($end_page + $half_page_end) && $larger_page_end < $larger_page_to_show) {
                    $larger_page_out .= $instance->get_single($larger_page, 'larger page', $options['page_text']);
                    $larger_page_end++;
                }
            }

            if ($larger_page_out) {
                $out .= "<span class='extend'>{$options['dotright_text']}</span>";
            }
            $out .= $larger_page_out;

            if ($end_page < $total_pages) {
                if (!empty($options['dotright_text']))
                    $out .= "<span class='extend'>{$options['dotright_text']}</span>";
            }

            // Next
            if ($paged < $total_pages && !empty($options['next_text']))
                $out .= $instance->get_single($paged + 1, 'nextpostslink', $options['next_text']);

            if ($end_page < $total_pages) {
                // Last
                $out .= $instance->get_single($total_pages, 'last', $options['last_text'], '%TOTAL_PAGES%');
            }
            break;

        // Dropdown
        case 2:
            $out .= '<form action="" method="get">' . "\n";
            $out .= '<select size="1" onchange="document.location.href = this.options[this.selectedIndex].value;">' . "\n";

            foreach (range(1, $total_pages) as $i) {
                $page_num = $i;
                if ($page_num == 1)
                    $page_num = 0;

                if ($i == $paged) {
                    $current_page_text = str_replace('%PAGE_NUMBER%', number_format_i18n($i), $options['current_text']);
                    $out .= '<option value="' . esc_url($instance->get_url($page_num)) . '" selected="selected" class="current">' . $current_page_text . "</option>\n";
                } else {
                    $page_text = str_replace('%PAGE_NUMBER%', number_format_i18n($i), $options['page_text']);
                    $out .= '<option value="' . esc_url($instance->get_url($page_num)) . '">' . $page_text . "</option>\n";
                }
            }

            $out .= "</select>\n";
            $out .= "</form>\n";
            break;
    }
    $out = $before . "<div class='wl_pagination'>\n$out\n</div>" . $after;

    $out = apply_filters('designer_pagination', $out);

    if (!$echo)
        return $out;

    echo $out;
}

class BDesigner {

    protected $args;

    function __construct($args) {
        $this->args = $args;
    }

    function __get($key) {
        return $this->args[$key];
    }

    function get_pagination_args() {
        global $numpages;

        $query = $this->query;

        switch ($this->type) {
            case 'multipart':
                // Multipart page
                $posts_per_page = 1;
                $paged = max(1, absint(get_query_var('page')));
                $total_pages = max(1, $numpages);
                break;
            case 'users':
                // WP_User_Query
                $posts_per_page = $query->query_vars['number'];
                $paged = max(1, floor($query->query_vars['offset'] / $posts_per_page) + 1);
                $total_pages = max(1, ceil($query->total_users / $posts_per_page));
                break;
            default:
                // WP_Query
                $posts_per_page = intval($query->get('posts_per_page'));
                $paged = max(1, absint($query->get('paged')));
                $total_pages = max(1, absint($query->max_num_pages));
                break;
        }

        return array($posts_per_page, $paged, $total_pages);
    }

    function get_single($page, $class, $raw_text, $format = '%PAGE_NUMBER%') {
        if (empty($raw_text))
            return '';

        $text = str_replace($format, number_format_i18n($page), $raw_text);

        return "<a href='" . esc_url($this->get_url($page)) . "' class='$class'>$text</a>";
    }

    function get_url($page) {
        return ( 'multipart' == $this->type ) ? get_multipage_link($page) : get_pagenum_link($page);
    }

}

/**
 * 
 * @return int
 */
function blogdesignerpaged() {
    if (strstr($_SERVER['REQUEST_URI'], 'paged') || strstr($_SERVER['REQUEST_URI'], 'page')) {
        if (isset($_REQUEST['paged'])) {
            $paged = $_REQUEST['paged'];
        } else {
            $uri = explode('/', $_SERVER['REQUEST_URI']);
            $uri = array_reverse($uri);
            $paged = $uri[1];
        }
    } else {
        $paged = 1;
    }

    return $paged;
}

/**
 * admin scripts
 */
if (!function_exists('bd_admin_scripts')) {

    function bd_admin_scripts() {
        $screen = get_current_screen();
        $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/blog-designer/blog-designer.php', $markup = true, $translate = true);
        $current_version = $plugin_data['Version'];
        $old_version = get_option('bd_version');
        if ($old_version != $current_version) {
            update_option('is_user_subscribed_cancled', '');
            update_option('bd_version', $current_version);
        }
        if (get_option('is_user_subscribed') != 'yes' && get_option('is_user_subscribed_cancled') != 'yes') {
            wp_enqueue_script('thickbox');
            wp_enqueue_style('thickbox');
        }
    }

}
add_action('admin_enqueue_scripts', 'bd_admin_scripts');

/**
 * start session if not
 */
if (!function_exists('bd_session_start')) {

    function bd_session_start() {
        if (session_id() == '') {
            session_start();
        }
    }

}
add_action('init', 'bd_session_start');

/**
 * subscribe email form
 */
if (!function_exists('bd_subscribe_mail')) {

    function bd_subscribe_mail() {
        $customer_email = get_option('admin_email');
        $current_user = wp_get_current_user();
        $f_name = $current_user->user_firstname;
        $l_name = $current_user->user_lastname;
        if (isset($_POST['sbtEmail'])) {
            $_SESSION['success_msg'] = 'Thank you for your subscription.';
            //Email To Admin
            update_option('is_user_subscribed', 'yes');
            $customer_email = trim($_POST['txtEmail']);
            $customer_name = trim($_POST['txtName']);
            $to = 'plugins@solwininfotech.com';
            $from = get_option('admin_email');

            $headers = "MIME-Version: 1.0;\r\n";
            $headers .= "From: " . strip_tags($from) . "\r\n";
            $headers .= "Content-Type: text/html; charset: utf-8;\r\n";
            $headers .= "X-Priority: 3\r\n";
            $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";
            $subject = 'New user subscribed from Plugin - Blog Designer';
            $body = '';
            ob_start();
            ?>
            <div style="background: #F5F5F5; border-width: 1px; border-style: solid; padding-bottom: 20px; margin: 0px auto; width: 750px; height: auto; border-radius: 3px 3px 3px 3px; border-color: #5C5C5C;">
                <div style="border: #FFF 1px solid; background-color: #ffffff !important; margin: 20px 20px 0;
                     height: auto; -moz-border-radius: 3px; padding-top: 15px;">
                    <div style="padding: 20px 20px 20px 20px; font-family: Arial, Helvetica, sans-serif;
                         height: auto; color: #333333; font-size: 13px;">
                        <div style="width: 100%;">
                            <strong>Dear Admin (Blog Designer plugin developer)</strong>,
                            <br />
                            <br />
                            Thank you for developing useful plugin.
                            <br />
                            <br />
                            I <?php echo $customer_name; ?> want to notify you that I have installed plugin on my <a href="<?php echo home_url(); ?>">website</a>. Also I want to subscribe to your newsletter, and I do allow you to enroll me to your free newsletter subscription to get update with new products, news, offers and updates.
                            <br />
                            <br />
                            I hope this will motivate you to develop more good plugins and expecting good support form your side.
                            <br />
                            <br />
                            Following is details for newsletter subscription.
                            <br />
                            <br />
                            <div>
                                <table border='0' cellpadding='5' cellspacing='0' style="font-family: Arial, Helvetica, sans-serif; font-size: 13px;color: #333333;width: 100%;">                                    
                                    <?php if ($customer_name != '') {
                                        ?>
                                        <tr style="border-bottom: 1px solid #eee;">
                                            <th style="padding: 8px 5px; text-align: left;width: 120px;">
                                                Name<span style="float:right">:</span>
                                            </th>
                                            <td style="padding: 8px 5px;">
                                                <?php echo $customer_name; ?>
                                            </td>
                                        </tr>
                                        <?php
                                    } else {
                                        ?>
                                        <tr style="border-bottom: 1px solid #eee;">
                                            <th style="padding: 8px 5px; text-align: left;width: 120px;">
                                                Name<span style="float:right">:</span>
                                            </th>
                                            <td style="padding: 8px 5px;">
                                                <?php echo home_url(); ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <th style="padding: 8px 5px; text-align: left;width: 120px;">
                                            Email<span style="float:right">:</span>
                                        </th>
                                        <td style="padding: 8px 5px;">
                                            <?php echo $customer_email; ?>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <th style="padding: 8px 5px; text-align: left;width: 120px;">
                                            Website<span style="float:right">:</span>
                                        </th>
                                        <td style="padding: 8px 5px;">
                                            <?php echo home_url(); ?>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <th style="padding: 8px 5px; text-align: left; width: 120px;">
                                            Date<span style="float:right">:</span>
                                        </th>
                                        <td style="padding: 8px 5px;">
                                            <?php echo date('d-M-Y  h:i  A'); ?>
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: 1px solid #eee;">
                                        <th style="padding: 8px 5px; text-align: left; width: 120px;">
                                            Plugin<span style="float:right">:</span>
                                        </th>
                                        <td style="padding: 8px 5px;">
                                            <?php echo 'Blog Designer'; ?>
                                        </td>
                                    </tr>
                                </table>
                                <br /><br />
                                Again Thanks you
                                <br />
                                <br />
                                Regards
                                <br />
                                <?php echo $customer_name; ?>
                                <br />
                                <?php echo home_url(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $body = ob_get_clean();
            wp_mail($to, $subject, $body, $headers);
        }
        if (get_option('is_user_subscribed') != 'yes' && get_option('is_user_subscribed_cancled') != 'yes') {
            ?>
            <div id="subscribe_widget_bd" style="display:none;">
                <div class="subscribe_widget">
                    <h3>Notify to plugin developer and subscribe.</h3>
                    <form class='sub_form' name="frmSubscribe" method="post" action="<?php echo admin_url() . 'admin.php?page=designer_settings'; ?>">
                        <div class="sub_row"><label>Your Name: </label><input placeholder="Your Name" name="txtName" type="text" value="<?php echo $f_name . ' ' . $l_name; ?>" /></div>
                        <div class="sub_row"><label>Email Address: </label><input placeholder="Email Address" required name="txtEmail" type="email" value="<?php echo $customer_email; ?>" /></div>
                        <input class="button button-primary" type="submit" name="sbtEmail" value="Notify & Subscribe" />                
                    </form>
                </div>
            </div>
            <?php
        }
        if (isset($_GET['page'])) {
            if (get_option('is_user_subscribed') != 'yes' && get_option('is_user_subscribed_cancled') != 'yes' && $_GET['page'] == 'designer_settings') {
                ?>
                <a style="display:none" href="#TB_inline?max-width=400&height=210&inlineId=subscribe_widget_bd" class="thickbox" id="subscribe_thickbox"></a>            
                <?php
            }
        }
    }

}
add_action('admin_head', 'bd_subscribe_mail', 10);

/**
 * user cancel subscribe
 */
if (!function_exists('wp_ajax_bd_close_tab')) {

    function wp_ajax_bd_close_tab() {
        update_option('is_user_subscribed_cancled', 'yes');
        exit();
    }

}
add_action('wp_ajax_close_tab', 'wp_ajax_bd_close_tab');
?>

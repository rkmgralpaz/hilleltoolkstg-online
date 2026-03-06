<?php

$GLOBALS['wp_post_id'] = get_the_ID();

function num_version()
{
    return '1.0.386';
}

//---------------------------------//
//--- RESTRICT CHILD PAGE LEVEL ---//
//---------------------------------//

function restrict_page_level($a)
{
    $a['depth'] = 1;
    return $a;
}
//add_action('page_attributes_dropdown_pages_args','restrict_page_level');

//-----------------------------//
//--- AD MENU COMPATIBILITY ---//
//-----------------------------//

/* register_nav_menus();

add_filter('nav_menu_item_id', 'clear_nav_menu_item_id', 10, 3);
function clear_nav_menu_item_id($id, $item, $args) {
    return "";
} */
/* add_filter('nav_menu_css_class', 'clear_nav_menu_item_class', 10, 3);
function clear_nav_menu_item_class($classes, $item, $args) {
    return array();
} */

//----------------//
//--- SETTINGS ---//
//----------------//

//--- WP-ADMIN LOGO ---//
add_action('login_enqueue_scripts', 'bs_change_login_logo');
function bs_change_login_logo()
{ ?>
    <style type="text/css">
        #login h1 a {
            width: 133px;
            height: 84px;
            margin-bottom: 30px;
            background-size: contain;
            /* background-image: url('data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI3LjUuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCAxMzMgODQiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDEzMyA4NDsiIHhtbDpzcGFjZT0icHJlc2VydmUiPgo8c3R5bGUgdHlwZT0idGV4dC9jc3MiPgoJLnN0MHtmaWxsOiM1NTVFQTg7fQoJLnN0MXtvcGFjaXR5OjAuNTt9Cgkuc3Qye2NsaXAtcGF0aDp1cmwoI1NWR0lEXzAwMDAwMDYxNDU4OTg3NDIwNTAzNDgyODQwMDAwMDEwNTc5ODcyMzAzNzI1MDI2NzEyXyk7fQoJLnN0M3tmb250LWZhbWlseTonR3JleWNsaWZmQ0YtTWVkaXVtJzt9Cgkuc3Q0e2ZvbnQtc2l6ZTozMy4wNzU3cHg7fQoJLnN0NXtsZXR0ZXItc3BhY2luZzotMTt9Cjwvc3R5bGU+CjxnIGlkPSJHcnVwb181MjciIHRyYW5zZm9ybT0idHJhbnNsYXRlKC00NiAtMjcuMTUpIj4KCTxnIGlkPSJHcnVwb18xMzIiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDQ2IDI3LjE1KSI+CgkJPHBhdGggaWQ9IlRyYXphZG9fMjIiIGNsYXNzPSJzdDAiIGQ9Ik0zNS4yLDYxLjVMMjYuNiw4NGgyMy43bDguNi0yMi41SDM1LjJ6Ii8+CgkJPGcgaWQ9IkdydXBvXzkiIHRyYW5zZm9ybT0idHJhbnNsYXRlKDIxMi4xMTEgNDEuMjQyKSIgY2xhc3M9InN0MSI+CgkJCTxnIGlkPSJHcnVwb184Ij4KCQkJCTxnPgoJCQkJCTxkZWZzPgoJCQkJCQk8cmVjdCBpZD0iU1ZHSURfMV8iIHg9Ii0xMTIuMiIgeT0iLTIxLjgiIHdpZHRoPSIzMi4yIiBoZWlnaHQ9IjIyLjUiLz4KCQkJCQk8L2RlZnM+CgkJCQkJPGNsaXBQYXRoIGlkPSJTVkdJRF8wMDAwMDEzOTk4NDc2MTM3OTE0MDI3NjE5MDAwMDAxNDExNTgxNjE1NDA1Nzk3MzEzNF8iPgoJCQkJCQk8dXNlIHhsaW5rOmhyZWY9IiNTVkdJRF8xXyIgIHN0eWxlPSJvdmVyZmxvdzp2aXNpYmxlOyIvPgoJCQkJCTwvY2xpcFBhdGg+CgkJCQkJPGcgaWQ9IkdydXBvXzciIHN0eWxlPSJjbGlwLXBhdGg6dXJsKCNTVkdJRF8wMDAwMDEzOTk4NDc2MTM3OTE0MDI3NjE5MDAwMDAxNDExNTgxNjE1NDA1Nzk3MzEzNF8pOyI+CgkJCQkJCTxwYXRoIGlkPSJUcmF6YWRvXzIzIiBjbGFzcz0ic3QwIiBkPSJNLTEwMy42LTIxLjhsLTguNiwyMi41aDIzLjdsOC42LTIyLjVILTEwMy42eiIvPgoJCQkJCTwvZz4KCQkJCTwvZz4KCQkJPC9nPgoJCTwvZz4KCQk8cGF0aCBpZD0iVHJhemFkb18yNCIgY2xhc3M9InN0MCIgZD0iTTU5LjEsMEw5MSw4NGgyMy43TDgyLjgsMEg1OS4xeiIvPgoJCTx0ZXh0IHRyYW5zZm9ybT0ibWF0cml4KDEgMCAwIDEgLTAuMzEzMyA0OS4yNzM0KSIgY2xhc3M9InN0MCBzdDMgc3Q0Ij5hPC90ZXh0PgoJCTx0ZXh0IHRyYW5zZm9ybT0ibWF0cml4KDEgMCAwIDEgMTkuNDMyMyA0OS4yNzM0KSIgY2xhc3M9InN0MCBzdDMgc3Q0Ij50PC90ZXh0PgoJCTx0ZXh0IHRyYW5zZm9ybT0ibWF0cml4KDEgMCAwIDEgMzAuMTE1OSA0OS4yNzM0KSIgY2xhc3M9InN0MCBzdDMgc3Q0IHN0NSI+cjwvdGV4dD4KCQk8dGV4dCB0cmFuc2Zvcm09Im1hdHJpeCgxIDAgMCAxIDQwLjkzMTQgNDkuMjczNCkiIGNsYXNzPSJzdDAgc3QzIHN0NCI+YTwvdGV4dD4KCTwvZz4KPC9nPgo8L3N2Zz4K'); */
        }
    </style>
<?php }
//Cambiamos la URL del logo			  
add_filter('login_headerurl', 'bs_login_logo_url');
function bs_login_logo_url($url)
{
    return get_home_url('/');
}

//--- MENUS ---//
function custom_menu_order($menu_ord)
{
    if (!$menu_ord)
        return true;

    return array(
        'index.php', // Dashboard
        'separator1', // First separator
        'edit.php?post_type=page', // Pages
        'edit.php', // Posts Default
        'edit.php?post_type=news', // News
        'edit.php?post_type=quiz_form', // Misconceptions Cards //--- ivan 28-08 ---//
        'edit.php?post_type=cards', // Misconceptions Cards //--- ivan 28-08 ---//
        'edit.php?post_type=timeline', // Timeline //--- ivan 19-09 ---//
        'edit.php?post_type=data_interactive', // Data Interactive //
        'edit.php?post_type=resources', // Resources
        'theme-options',
        'upload.php', // Media
        'users.php', // Users
        'separator2', // Second separator
        'themes.php', // Appearance
        'separator3', // Third separator
        'separator4', // Fourth separator
        'plugins.php', // Plugins
        'edit-comments.php', // Comments
        'tools.php', // Tools
        'options-general.php', // Settings
        //'separator-last', // Last separator

    );
}
add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order
add_filter('menu_order', 'custom_menu_order');

function remove_menus()
{
    remove_menu_page('index.php');                  //Dashboard
    remove_menu_page('edit.php');                   //Posts
    //remove_menu_page( 'upload.php' );                 //Media
    //remove_menu_page( 'edit.php?post_type=page' );    //Pages
    remove_menu_page('edit-comments.php');          //Comments
    //remove_menu_page( 'themes.php' );                 //Appearance
    //remove_menu_page( 'plugins.php' );                //Plugins
    //remove_menu_page( 'users.php' );                  //Users
    //remove_menu_page( 'tools.php' );                  //Tools
    //remove_menu_page( 'options-general.php' );        //Settings
}
add_action('admin_menu', 'remove_menus');


/* function wpb_custom_new_menu() {
  register_nav_menu('my-custom-menu',__( 'My Custom Menu' ));
}
add_action( 'init', 'wpb_custom_new_menu' ); */

/* Disable WordPress Admin Bar for all users but admins. */
show_admin_bar(false);


function remove_admin_bar_links()
{
    global $wp_admin_bar;
    //$wp_admin_bar->remove_menu('wp-logo');          // Remove the Wordpress logo
    //$wp_admin_bar->remove_menu('about');            // Remove the about Wordpress link
    //$wp_admin_bar->remove_menu('wporg');            // Remove the Wordpress.org link
    //$wp_admin_bar->remove_menu('documentation');    // Remove the Wordpress documentation link
    //$wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
    //$wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
    //$wp_admin_bar->remove_menu('site-name');        // Remove the site name menu
    //$wp_admin_bar->remove_menu('view-site');        // Remove the view site link
    //$wp_admin_bar->remove_menu('updates');          // Remove the updates link
    $wp_admin_bar->remove_menu('comments');           // Remove the comments link
    $wp_admin_bar->remove_menu('new-content');        // Remove the content link
    //$wp_admin_bar->remove_menu('w3tc');             // If you use w3 total cache remove the performance link
    //$wp_admin_bar->remove_menu('my-account');       // Remove the user details tab
}
add_action('wp_before_admin_bar_render', 'remove_admin_bar_links');


//--- FUTURE PERMALINK ---//

// post, page post type
add_filter('post_link', 'future_permalink', 10, 3);
// custom post types
add_filter('post_type_link', 'future_permalink', 10, 4);

function future_permalink($permalink, $post, $leavename, $sample = false)
{
    /* for filter recursion (infinite loop) */
    static $recursing = false;

    if (empty($post->ID)) {
        return $permalink;
    }

    if (!$recursing) {
        if (isset($post->post_status) && ('future' === $post->post_status)) {
            // set the post status to publish to get the 'publish' permalink
            $post->post_status = 'publish';
            $recursing = true;
            return get_permalink($post, $leavename);
        }
    }

    $recursing = false;
    return $permalink;
}

//--- CONFIG WYSIWYG EDITOR ---//

//
add_action('init', 'my_theme_add_editor_styles');
function my_theme_add_editor_styles()
{
    add_editor_style('custom-editor-style.css');
}

//
add_filter('acf/fields/wysiwyg/toolbars', 'my_toolbars');
function my_toolbars($toolbars)
{

    $toolbars['Link'] = array();
    $toolbars['Link'][1] = array('link', 'unlink', 'removeformat', 'clean_text', 'pastetext', 'fullscreen', 'add_media_custom');

    $toolbars['Bold, italic'] = array();
    $toolbars['Bold, italic'][1] = array('bold', 'italic', 'removeformat', 'clean_text', 'pastetext', 'fullscreen');

    $toolbars['Link, bold, italic'] = array();
    $toolbars['Link, bold, italic'][1] = array('bold', 'italic', 'link', 'unlink', 'removeformat', 'clean_text', 'pastetext', 'fullscreen');

    $toolbars['Format select, Bold, italic, link'] = array();
    $toolbars['Format select, Bold, italic, link'][1] = array('formatselect', 'bold', 'italic', 'link', 'unlink', 'removeformat', 'clean_text', 'pastetext', 'fullscreen');

    $toolbars['Bold, italic, bullist, numlist, link'] = array();
    $toolbars['Bold, italic, bullist, numlist, link'][1] = array('bold', 'italic', 'bullist', 'numlist', 'link', 'unlink', 'removeformat', 'clean_text', 'pastetext', 'fullscreen');

    $toolbars['Format select, Font Small, Bold, italic, bullist, numlist, link'] = array();
    $toolbars['Format select, Font Small, Bold, italic, bullist, numlist, link'][1] = array('formatselect', 'font_small', 'bold', 'italic', 'bullist', 'numlist', 'link', 'unlink', 'removeformat', 'clean_text', 'pastetext', 'fullscreen');

    $toolbars['Bullist, numlist'] = array();
    $toolbars['Bullist, numlist'][1] = array('bullist', 'numlist', 'removeformat', 'clean_text', 'pastetext', 'fullscreen');

    $toolbars['Link, hline'] = array();
    $toolbars['Link, hline'][1] = array('h_line', 'link', 'unlink', 'removeformat', 'clean_text', 'pastetext', 'fullscreen', 'add_media_custom');

    $toolbars['Full'] = array();
    $toolbars['Full'][1] = array('font_color_1', 'font_color_2', 'font_large', 'font_small', 'font_superscript', 'font_subscript', 'no_wrap_white_space', 'bold', 'italic', 'underline', 'bullist', 'numlist', 'list_no_bullets', 'link', 'unlink', 'removeformat', 'clean_text', 'pastetext', 'table', 'outdent', 'indent', 'undo', 'redo', 'fullscreen', 'add_media_custom');

    //--- ivan 28-08 ---//
    $toolbars['Basic, Font Large, List'] = array();
    $toolbars['Basic, Font Large, List'][1] = array('font_large', 'bold', 'italic', 'bullist', 'numlist', 'link', 'unlink', 'removeformat', 'clean_text', 'pastetext', 'fullscreen', 'add_media_custom');

    $toolbars['Basic, Colorize, Font Large, List'] = array();
    $toolbars['Basic, Colorize, Font Large, List'][1] = array('font_color_1', 'font_large', 'bold', 'italic', 'bullist', 'numlist', 'link', 'unlink', 'removeformat', 'clean_text', 'pastetext', 'fullscreen', 'add_media_custom');

    return $toolbars;
}

function custom_tinymce_formats($init_array)
{
    $init_array['block_formats'] = 'Heading 3=h3;Heading 4=h4';
    return $init_array;
}
add_filter('tiny_mce_before_init', 'custom_tinymce_formats');



function plugin_register_buttons($buttons)
{
    $buttons[] = 'font_color_1';
    $buttons[] = 'font_color_2';
    $buttons[] = 'font_superscript';
    $buttons[] = 'font_subscript';
    $buttons[] = 'font_large';
    $buttons[] = 'font_large_block';
    $buttons[] = 'font_small';
    $buttons[] = 'font_underline';
    $buttons[] = 'h_line';
    $buttons[] = 'no_wrap_white_space';
    $buttons[] = 'clean_text';
    $buttons[] = 'shortcode_circular_button';
    $buttons[] = 'list_no_bullets';
    $buttons[] = 'add_media_custom';
    return $buttons;
}
add_filter('mce_buttons', 'plugin_register_buttons');

function plugin_register_plugin($plugin_array)
{
    $plugin_array['customs'] = get_template_directory_uri() . '/js/tinymce-plugin.js';
    return $plugin_array;
}

add_filter('mce_external_plugins', 'plugin_register_plugin');


/*
 * Callback function to filter the MCE settings
 */
function my_mce_before_init_insert_formats($init_array)
{

    //ESTE ES EL ARRAY QUE PISA EL FORMATS ORIGINAL, QUE VENIMOS USANDO
    /* $style_formats = "[
        {
            title : 'Heading',
            inline : 'span',
            classes : 'heading',
            wrapper : true,
        },
    ]"; */

    //este objeto crea nuevos estilos para los botones nuevos
    $formats = "{
        font_superscript : {
            inline: 'span',
            classes: 'font-superscript'
        },
        font_subscript : {
            inline: 'span',
            classes: 'font-subscript'
        },
        font_color_1 : {
            inline: 'span',
            classes: 'font-color-1'
        },
        font_color_2 : {
            inline: 'span',
            classes: 'font-color-2'
        },
        font_large_block : {
            inline: 'span',
            classes: 'font-large-block'
        },
        font_large : {
            inline: 'span',
            classes: 'font-large'
        },
        font_small : {
            inline: 'span',
            classes: 'font-small'
        },
        font_underline: {
            inline: 'u',
            classes: 'font-underline'
        },
        h_line : {
            block: 'hr',
            classes: 'h-line'
        },
        add_media_custom : {
            block: 'span',
            classes: ''
        },
        no_wrap_white_space: {
            inline: 'span',
            classes: 'no-wrap-white-space'
        },
        shortcode_circular_button : {
            block: 'p',
            classes: ''
        },
        list_no_bullets : {
            block: 'ul',
            classes: 'ul-no-bulletpoints'
        },
    }";

    //$init_array['style_formats'] = $style_formats ;
    $init_array['formats'] = $formats;
    return $init_array;
}
add_filter('tiny_mce_before_init', 'my_mce_before_init_insert_formats');


//----------------------------------------------------//
//--- ACF FLEXIBLE CONTENT GET TITLE FROM SUBFIELD ---//
//http://www.advancedcustomfields.com/resources/acf-fields-flexible_content-layout_title/
//
function general_acf_flex_content_title($title, $field, $layout, $i)
{

    // backup default title
    $tmp_title = $title;
    $tmp_title_2 = $title;
    // remove layout title from text
    $title = '';

    // load sub field image
    // note you may need to add extra CSS to the page t style these elements

    /*
    if( $image = get_sub_field('image') ) {
        $title .= '<div class="thumbnail">';
        $title .= '<img src="' . $image['sizes']['thumbnail'] . '" height="36px" />';
        $title .= '</div>';
    }
    */
    //print_r(get_sub_field('rows_accordion')[0]['title']);
    $hide_original_title = $tmp_title == 'Program';
    $truncate = true;

    // load text sub field
    if ($text = get_sub_field('code')) {
        $code = explode('src=', str_replace("'", '', str_replace('"', '', $text)));
        $title = isset($code[1]) ? $code[1] : '';
    } else if (!get_sub_field('title') && get_sub_field('rows_accordion')) {
        $rows = get_sub_field('rows_accordion');
        $tmp = array();
        foreach ($rows as $row) {
            $tmp_title = strip_tags($row['title']);
            if (strlen($tmp_title) > 15) {
                $tmp_title = substr($tmp_title, 0, 12) . '...';
            }
            array_push(tmp, $tmp_title);
        }
        //if(count($tmp)){
        $title = '[' . implode('] [', $tmp) . ']';
        //}
    } else if (!get_sub_field('title') && (get_sub_field('rows') || get_sub_field('cards') || get_sub_field('items') || get_sub_field('blocks'))) {
        if (get_sub_field('rows')) {
            $rows = get_sub_field('rows');
        } else if (get_sub_field('blocks')) {
            $rows = get_sub_field('blocks');
        } else if (get_sub_field('cards')) {
            $rows = get_sub_field('cards');
        } else {
            $rows = get_sub_field('items');
        }
        $tmp = array();
        foreach ($rows as $row) {
            if (isset($row['title'])) {
                $tmp_title = strip_tags($row['title']);
                if (strlen($tmp_title) > 15) {
                    $tmp_title = substr($tmp_title, 0, 12) . '...';
                }
            } else if (isset($row['title_1x'])) {
                $tmp_title = strip_tags($row['title_1']);
                if (strlen($tmp_title) > 15) {
                    $tmp_title = substr($tmp_title, 0, 12) . '...';
                }
            } else if (isset($row['text'])) {
                $tmp_title = strip_tags($row['text']);
                if (strlen($tmp_title) > 15) {
                    $tmp_title = substr($tmp_title, 0, 12) . '...';
                }
            }
            array_push($tmp, $tmp_title);
            //array_push($tmp,$row['title']);
        }
        //if(count($tmp)){
        $title = '[' . implode('] [', $tmp) . ']';
        //}
    } else if ($text = get_sub_field('title')) {
        $title = str_replace('’', "'", strip_tags($text));
    } else if ($text = get_sub_field('name')) {
        $title = str_replace('’', "'", strip_tags($text));
    } else if ($text = get_sub_field('label')) {
        $title = str_replace('’', "'", strip_tags($text));
    } else if ($text = get_sub_field('text')) {
        $title = str_replace('’', "'", strip_tags($text));
    } else if ($text = get_sub_field('section_name')) {
        $title = ucwords(str_replace('-', ' ', str_replace('_', ' ', strip_tags($text))));
    } else if ($text = get_sub_field('text_column_1')) {
        $title = str_replace('’', "'", strip_tags($text));
    } else if ($text = get_sub_field('text_column_2')) {
        $title = str_replace('’', "'", strip_tags($text));
    } else if ($text = get_sub_field('quote')) {
        $title = strip_tags($text);
    } else if (get_sub_field('text_link') && $text = get_sub_field('text_link')['title']) {
        $title = str_replace('’', "','", strip_tags($text));
        $hide_original_title = true;
    } else if (get_sub_field('schedule_months')) {
        $tmp = array();
        $months = get_sub_field('schedule_months');
        foreach ($months as $month) {
            array_push($tmp, '[' . $month['title'] . ']');
        }
        $title = implode(' ', $tmp);
    } else if (get_sub_field('contents') && isset(get_sub_field('contents')['title']) && $text = get_sub_field('contents')['title']) {
        $title = str_replace('’', "','", strip_tags($text));
        //$hide_original_title = true;
    } else if ($text = get_sub_field('post')) {
        $title = str_replace('’', "'", strip_tags(get_the_title($text)));
    } else if ($text = get_sub_field('height')) {
        $row_visibility = get_sub_field('visibility') ?: 'always';
        $title = str_replace('’', "'", strip_tags($text)) . 'px (' . $row_visibility . ')';
    } else if ($text = get_sub_field('image') && !get_sub_field('video_url')) {
        /* $img = pathinfo(get_sub_field('image')['url']);
        $title = str_replace('’',"'",strip_tags($img['filename'].'.'.$img['extension'])); */
        $image = get_sub_field('image');
        $title = "<span class='preview-thumbs'><img src='{$image['sizes']['medium']}' height='27' width='auto' /></span>";
        $truncate = false;
    } else if ($text = get_sub_field('url')) {
        $truncate = false;
        $title = str_replace('’', "'", strip_tags($text));
    } else if ($text = get_sub_field('images')) {
        $image_list = get_sub_field('images');
        $images_arr = array();
        $title = '';
        foreach ($image_list as $image) {
            /* $img = pathinfo($image['url']);
            array_push($images_arr,str_replace('’',"'",strip_tags($img['filename'].'.'.$img['extension']))); */
            $title .= "<img src='{$image['sizes']['medium']}' height='27' width='auto' />";
        }
        if ($title != '') {
            $title = "<span class='preview-thumbs'>{$title}</span>";
        }
        $truncate = false;
    } else if ($text = get_sub_field('video_url')) {
        $image = get_sub_field('image');
        $truncate = false;
        $text = str_replace('https://', '', $text);
        $text = str_replace('http://', '', $text);
        $text = str_replace('www.', '', $text);
        if ($image && $image['url']) {
            $title = '...' . str_replace('’', "'", strip_tags($text)) . "<span class='preview-thumbs'><img src='{$image['sizes']['medium']}' height='27' width='auto' /></span>";
        } else {
            $title = '...' . str_replace('’', "'", strip_tags($text));
        }
    }

    if ($truncate && strlen($title) > 51) {
        $title = substr($title, 0, 51) . '...';
    }
    if ($truncate && strlen($tmp_title_2) > 51) {
        $tmp_title_2 = substr($tmp_title_2, 0, 51) . '...';
    }

    if ($hide_original_title) {
        $title = '<b>' . tmp_title_2 . '</b>';
    } else if (get_sub_field('items') || get_sub_field('rows') || get_sub_field('cards') || get_sub_field('blocks')) {
        $title = '<b> <span style="color:#aaaaaa">' . $tmp_title_2 . ':</span></b> ' . $title;
    } else if ($title == '') {
        $title = '<b> <span style="color:#aaaaaa">' . $tmp_title . '</span></b>';
    } else {
        //$title .= '</b> <span style="color:#aaaaaa">('.$tmp_title.')</span>';
        $title = '<b><span style="color:#aaaaaa">' . $tmp_title . ':</span></b> ' . $title;
    }


    // return
    return str_replace("\'", "'", str_replace("\h", "h", $title));
}
// name

add_filter('acf/fields/flexible_content/layout_title/name=header_modules', 'general_acf_flex_content_title', 10, 4);


//add_filter('acf/fields/flexible_content/layout_title/name=homepage_modules', 'general_acf_flex_content_title', 10, 4);
add_filter('acf/fields/flexible_content/layout_title/name=blocks', 'general_acf_flex_content_title', 10, 4);
add_filter('acf/fields/flexible_content/layout_title/name=global_modules', 'general_acf_flex_content_title', 10, 4);

function general_acf_flex_content_title_accordion($title, $field, $layout, $i)
{
    // backup default title
    $tmp_title = $title;
    // remove layout title from text
    $title = '';
    // load text sub field
    if ($text = get_sub_field('title')) {
        $title = str_replace('’', "'", strip_tags($text));
    } else if ($text = get_sub_field('text')) {
        $title = str_replace('’', "'", strip_tags($text));
    } else if (get_sub_field('rows_accordion') && $text = get_sub_field('rows_accordion')[0]['title']) {
        $title = str_replace('’', "','", strip_tags($text));
    }
    //
    if (strlen($title) > 51) {
        $title = substr($title, 0, 51) . '...';
    }
    if ($title == '') {
        $title = '<b> <span style="color:#aaaaaa">' . $tmp_title . '</span></b>';
    } else {
        //$title .= '</b> <span style="color:#aaaaaa">('.$tmp_title.')</span>';
        $title = '<b>' . $title . '</b> ';
    }

    // return
    return str_replace("\'", "'", $title);
}
add_filter('acf/fields/flexible_content/layout_title/name=accordion', 'general_acf_flex_content_title_accordion', 10, 4);
add_filter('acf/fields/flexible_content/layout_title/name=items', 'general_acf_flex_content_title_accordion', 10, 4);
add_filter('acf/fields/flexible_content/layout_title/name=rows', 'general_acf_flex_content_title_accordion', 10, 4);
add_filter('acf/fields/flexible_content/layout_title/name=rows_accordion', 'general_acf_flex_content_title_accordion', 10, 4);

function main_nav_acf_flex_content_title($title, $field, $layout, $i)
{
    // backup default title
    $tmp_title = $title;
    // remove layout title from text
    $title = '';
    // load text sub field
    $external_link = false;
    if ($text = get_sub_field('title')) {
        $title = str_replace('’', "'", strip_tags($text));
    } else if ($text = get_sub_field('link')['title']) {
        $title = str_replace('’', "'", strip_tags($text));
        if (get_sub_field('link')['target'] == '_blank') {
            $external_link = true;
        }
    }
    //
    if (strlen($title) > 51) {
        $title = substr($title, 0, 51) . '...';
    }
    if ($title == '') {
        $title = '<b> <span style="color:#aaaaaa">' . $tmp_title . '</span></b>';
    } else if ($external_link) {
        $title .= '</b> <span style="color:#aaaaaa">(External ' . $tmp_title . ')</span>';
        $title = '<b>' . $title . '</b> ';
    } else {
        $title .= '</b> <span style="color:#aaaaaa">(' . $tmp_title . ')</span>';
        $title = '<b>' . $title . '</b> ';
    }

    // return
    return str_replace("\'", "'", $title);
}
add_filter('acf/fields/flexible_content/layout_title/name=main_nav', 'main_nav_acf_flex_content_title', 10, 4);
add_filter('acf/fields/flexible_content/layout_title/name=submenu', 'main_nav_acf_flex_content_title', 10, 4);
add_filter('acf/fields/flexible_content/layout_title/name=secondary_nav', 'main_nav_acf_flex_content_title', 10, 4);
add_filter('acf/fields/flexible_content/layout_title/name=tertiary_nav', 'main_nav_acf_flex_content_title', 10, 4);

//------------------//
//--- ivan 28-08 ---//
function cards_acf_flex_content_title($title, $field, $layout, $i)
{
    // backup default title
    $tmp_title = $title;
    // remove layout title from text
    $title = '';
    // load name sub field
    $cards = get_sub_field('cards');
    $cards_list = [];
    foreach ($cards as $card) {
        array_push($cards_list, '[' . get_the_title($card) . ']');
    }
    if ($cards && count($cards)) {
        $title = implode(' ', $cards_list);
    }
    //
    if (strlen($title) > 71) {
        $title = substr($title, 0, 71) . '...';
    }
    // return
    return str_replace("\'", "'", $title);
}
add_filter('acf/fields/flexible_content/layout_title/name=card_groups', 'cards_acf_flex_content_title', 10, 4);
//--- ivan new ---//
//------------------//

//-----------------------------------------------//
//--- ADDES JS FILE WITH CUSTOM EVENTS TO ACF ---//


function my_admin_enqueue_scripts()
{
    wp_enqueue_script('my-admin-js', get_template_directory_uri() . '/js/acf-custom-events.js', array(), num_version(), true);
    wp_enqueue_script('acf-video-poster', get_template_directory_uri() . '/js/acf-video-poster.js', array('jquery'), num_version(), true);
}
add_action('acf/input/admin_enqueue_scripts', 'my_admin_enqueue_scripts');

function custom_admin_js()
{
    $url = get_bloginfo('template_directory') . '/js/wp-admin-custom-events.js?ver=' . num_version();
    echo '"<script type="text/javascript" src="' . $url . '"></script>"';
}
add_action('admin_footer', 'custom_admin_js');

add_filter('parse_query', 'events_default_view_posts_filter', 10, 1);
function events_default_view_posts_filter($query)
{
    if (isset($_GET['default_view']) && $_GET['default_view'] == 1 && isset($_GET['post_type']) && $_GET['post_type'] == 'events'):
        global $pagenow;
        $type = 'events';
        $query->set('meta_key', 'date_hour_date');
        $query->set('meta_query', array(
            'relation' => 'OR',
            array(
                'key' => 'date_hour_date',
                'value' => get_current_date('ymd'),
                'compare' => '>='
            ),
            array(
                'key' => 'on_demand',
                'value' => 1,
                'compare' => '=',
                'type' => 'NUMERIC'
            ),
            /*  array(
                'key' => 'date_hour_date',
                'value' => get_current_date('ymd'),
                'compare' => '>='
            ),
            array(
                'relation' => 'AND', 
                array(
                    'key' => 'on_demand',
                    'value' => 1,
                    'compare' => '=',
                    'type' => 'NUMERIC'
                ),
                array(
                    'key' => 'date_hour_date',
                    'value' => get_current_date('ymd'),
                    'compare' => '<'
                )
            ) */
        ));
    endif;
}


//--- ACF OPTIONS PAGE ---//

if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Website Options',
        'menu_title' => 'Website Options',
        'menu_slug' => 'theme-options',
        'capability' => 'edit_posts',
        'redirect' => true,
        'position' => '63.3'
    ));
    /*
    acf_add_options_sub_page(array(
    'page_title' => 'Footer',
    'menu_title' => 'Footer',
    'parent_slug'	=> 'theme-options',
    ));
    */
}

//-------------------------//
//--- remove body class ---//

add_filter('body_class', 'my_class_names');
function my_class_names($classes)
{
    global $wp_query;

    $arr = array();

    //if(is_page()) {
    $id = $wp_query->get_queried_object_id();
    $type = get_post_type($id);
    $slug = get_post_field('post_name', $id);
    if (is_single()) {
        $arr[] = 'type-' . $type . '-single';
    } else {
        $arr[] = 'type-' . $type;
    }
    if (is_page() || is_single()) {
        $arr[] = $type . '--' . $slug;
    }
    if (is_front_page()) {
        $arr[] = 'page-home';
    }
    //}
    /*
    if(is_single()) {
        $id = $wp_query->get_queried_object_id();
        $arr[] = 'type-post post--'.get_post_field( 'post_name', $id );
    }
    */

    return $arr;
}

//-----------------------------------------//
//--- SUBTITLE PARSERS (SRT / SBV)       ---//
//-----------------------------------------//

function subs_to_json($subsString, $format = 'auto')
{
    if ($format === 'auto') {
        if (preg_match('/\d+:\d{2}:\d{2}\.\d{3},\d+:\d{2}:\d{2}\.\d{3}/', $subsString)) {
            $format = 'sbv';
        } else {
            $format = 'srt';
        }
    }

    $subtitles = [];

    if ($format === 'sbv') {
        $subtitles = parse_sbv($subsString);
    } else {
        $subtitles = parse_srt($subsString);
    }

    return json_encode($subtitles, JSON_UNESCAPED_UNICODE);
}

function parse_srt($srtString)
{
    $blocks = preg_split('/\n\s*\n/', trim($srtString));
    $subtitles = [];

    foreach ($blocks as $block) {
        $lines = explode("\n", trim($block));

        if (count($lines) < 3)
            continue;

        if (preg_match('/(\d{2}):(\d{2}):(\d{2}),(\d{3})\s*-->\s*(\d{2}):(\d{2}):(\d{2}),(\d{3})/', $lines[1], $matches)) {
            $start = (
                intval($matches[1]) * 3600000 +
                intval($matches[2]) * 60000 +
                intval($matches[3]) * 1000 +
                intval($matches[4])
            );

            $end = (
                intval($matches[5]) * 3600000 +
                intval($matches[6]) * 60000 +
                intval($matches[7]) * 1000 +
                intval($matches[8])
            );

            $text = implode(' ', array_slice($lines, 2));

            $subtitles[] = [
                'start' => $start,
                'end' => $end,
                'text' => $text
            ];
        }
    }

    return $subtitles;
}

function parse_sbv($sbvString)
{
    $blocks = preg_split('/\n\s*\n/', trim($sbvString));
    $subtitles = [];

    foreach ($blocks as $block) {
        $lines = explode("\n", trim($block));

        if (count($lines) < 2)
            continue;

        if (preg_match('/(\d+):(\d{2}):(\d{2})\.(\d{3}),(\d+):(\d{2}):(\d{2})\.(\d{3})/', $lines[0], $matches)) {
            $start = (
                intval($matches[1]) * 3600000 +
                intval($matches[2]) * 60000 +
                intval($matches[3]) * 1000 +
                intval($matches[4])
            );

            $end = (
                intval($matches[5]) * 3600000 +
                intval($matches[6]) * 60000 +
                intval($matches[7]) * 1000 +
                intval($matches[8])
            );

            $text = implode(' ', array_slice($lines, 1));

            $subtitles[] = [
                'start' => $start,
                'end' => $end,
                'text' => $text
            ];
        }
    }

    return $subtitles;
}

// ============================================
// AUTO-POSTER: YouTube Embeds (ported from ADL Monitor)
// When editor pastes a YouTube URL, auto-generates poster thumbnail
// and detects platform + aspect ratio
// ============================================
add_action('acf/input/admin_footer', function () { ?>
<script type="text/javascript">
(function($){
    if (typeof acf === 'undefined') return;

    function detectPlatform(url){
        var u = url.toLowerCase();
        if (u.indexOf('youtube.com') !== -1 || u.indexOf('youtu.be') !== -1) return 'youtube';
        if (u.indexOf('vimeo.com') !== -1) return 'vimeo';
        return 'unknown';
    }

    function isYouTubeShort(url){
        try {
            var u = new URL(url, window.location.origin);
            var host = u.hostname.replace(/^www\./,'').toLowerCase();
            if (host.indexOf('youtube.com') !== -1 && u.pathname.indexOf('/shorts/') !== -1) return true;
            return false;
        } catch(e){
            return (url.indexOf('/shorts/') !== -1);
        }
    }

    function extractYouTubeId(url){
        try {
            var u = new URL(url, window.location.origin);
            var host = u.hostname.replace(/^www\./,'').toLowerCase();
            if (host === 'youtu.be') {
                var id = (u.pathname || '').replace('/','').trim();
                return id ? id.substring(0, 11) : '';
            }
            if (host.indexOf('youtube.com') !== -1) {
                if ((u.pathname || '').indexOf('/shorts/') !== -1) {
                    var parts = u.pathname.split('/shorts/');
                    if (parts[1]) return parts[1].split('/')[0].substring(0, 11);
                }
                var v = u.searchParams.get('v');
                if (v) return v.substring(0, 11);
            }
        } catch(e){}
        var m = String(url).match(/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|shorts\/))([^?&#\/\s]{11})/i);
        return m && m[1] ? m[1] : '';
    }

    $(document).on('blur change keyup', '[data-layout="youtube_embeds"] [data-name="video_url"] input[type="url"]', function(){
        var $this = $(this);
        var $parent = $this.closest('.acf-fields');
        var url = $this.val();
        if (!url) return;

        var platform = detectPlatform(url);
        var $poster = $parent.find('[data-name="poster_default"] input[type="text"]');
        var $aspectRatio = $parent.find('[data-name="aspect_ratio"] input[type="text"]');
        var $plattform = $parent.find('[data-name="plattform"] input[type="text"]');

        if (platform === 'unknown') {
            $poster.val('');
            $aspectRatio.val('');
            $plattform.val('');
            return;
        }

        var poster = '';
        var aspectRatio = '';

        if (platform === 'youtube') {
            var id = extractYouTubeId(url);
            if (id) {
                poster = 'https://img.youtube.com/vi/' + id + '/maxresdefault.jpg';
            }
            if (isYouTubeShort(url)) {
                aspectRatio = '9:16';
            } else {
                aspectRatio = '16:9';
                // Try oEmbed for better thumbnail + aspect ratio detection
                var watchUrl = 'https://www.youtube.com/watch?v=' + id;
                fetch('https://www.youtube.com/oembed?url=' + encodeURIComponent(watchUrl) + '&format=json')
                    .then(function(r){ return r.json(); })
                    .then(function(data){
                        if (data && data.thumbnail_url) {
                            $poster.val(data.thumbnail_url);
                        }
                        if (data && data.width && data.height) {
                            var ratio = data.width / data.height;
                            var label = '1:1';
                            if (ratio > 1.6) label = '16:9';
                            if (ratio < 0.9) label = '9:16';
                            $aspectRatio.val(label);
                        }
                    })
                    .catch(function(){});
            }
        } else if (platform === 'vimeo') {
            fetch('https://vimeo.com/api/oembed.json?url=' + encodeURIComponent(url))
                .then(function(r){ return r.json(); })
                .then(function(data){
                    if (data && data.thumbnail_url) {
                        $poster.val(data.thumbnail_url);
                    }
                    if (data && data.width && data.height) {
                        var ratio = data.width / data.height;
                        var label = '1:1';
                        if (ratio > 1.6) label = '16:9';
                        if (ratio < 0.9) label = '9:16';
                        $aspectRatio.val(label);
                    }
                })
                .catch(function(){});
        }

        $poster.val(poster);
        $aspectRatio.val(aspectRatio);
        $plattform.val(platform);
    });

})(jQuery);
</script>
<?php });

//-----------------//
//--- FUNCTIONS ---//
//-----------------//

function truncate_words($text, $count = 10, $delimiter = '...')
{
    $parsed_text = explode(' ', $text);
    if (count($parsed_text) > $count) {
        $result = implode(' ', array_slice($parsed_text, 0, $count));
        if (substr($result, -1) == ',') {
            $result = substr_replace($result, "", -1);
        }
        $result .= $delimiter;
    } else {
        $result = $text;
        if (substr($result, -1) == ',') {
            $result = substr_replace($result, "", -1);
        }
    }
    return $result;
}
function get_words($sentence, $count = 10)
{
    preg_match("/(?:\w+(?:\W+|$)){0,$count}/", $sentence, $matches);
    return $matches[0];
}
function get_snippet($str, $wordCount = 10)
{
    return implode(
        '',
        array_slice(
            preg_split(
                '/([\s,\.;\?\!]+)/',
                $str,
                $wordCount * 2 + 1,
                PREG_SPLIT_DELIM_CAPTURE
            ),
            0,
            $wordCount * 2 - 1
        )
    );
}

function remove_a($str)
{
    $regex = '/<a (.*)<\/a>/isU';
    preg_match_all($regex, $str, $result);
    foreach ($result[0] as $rs) {
        $regex = '/<a (.*)>(.*)<\/a>/isU';
        $text = preg_replace($regex, '$2', $rs);
        $str = str_replace($rs, $text, $str);
    }
    return $str;
}
function remove_p($str, $new_tag = 'div')
{
    $str = str_replace('<p', '<' . $new_tag, $str);
    $str = str_replace('</p>', '</' . $new_tag . '>', $str);
    //$str = str_replace('<p>','',$str);
    //$str = str_replace('</p>','',$str);
    return $str;
}

function slugify($string, $replace = array(), $delimiter = '-')
{
    // https://github.com/phalcon/incubator/blob/master/Library/Phalcon/Utils/Slug.php
    if (!extension_loaded('iconv')) {
        throw new Exception('iconv module not loaded');
    }
    // Save the old locale and set the new locale to UTF-8
    $oldLocale = setlocale(LC_ALL, '0');
    setlocale(LC_ALL, 'en_US.UTF-8');
    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    if (!empty($replace)) {
        $clean = str_replace((array) $replace, ' ', $clean);
    }
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower($clean);
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    $clean = trim($clean, $delimiter);
    // Revert back to the old locale
    setlocale(LC_ALL, $oldLocale);
    return $clean;
}


// Slugify a string
function slugifyStrings($text)
{
    // Strip html tags
    $text = strip_tags($text);
    // Replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    // Transliterate
    setlocale(LC_ALL, 'en_US.utf8');
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    // Remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    // Trim
    $text = trim($text, '-');
    // Remove duplicate -
    $text = preg_replace('~-+~', '-', $text);
    // Lowercase
    $text = strtolower($text);
    // Check if it is empty
    if (empty($text)) {
        return 'n-a';
    }
    // Return result
    return $text;
}

//--- NEXT PREV POST ---//


function get_next_prev_post($type, $cat, $ID)
{
    $args = array(
        'post_type' => $type,
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'caller_get_posts' => 1,
        'category_name' => $cat
    );
    $list = null;
    $list = new WP_Query($args);
    $result = array();
    $posts_ID = array();
    $n = -1;
    $i = 0;
    if ($list->have_posts()) {
        while ($list->have_posts()):
            $list->the_post();
            $post_ID = get_the_ID();
            $list_ID[] += $post_ID;
            if ($post_ID == $ID) {
                $n = $i;
            }
            $i++;
        endwhile;
    }
    wp_reset_query();
    if ($n < $i - 1) {
        if ($n == 0) {
            $j = $n + 1;
            $next = get_permalink($list_ID[$j]);
            $j = $i - 1;
            $prev = get_permalink($list_ID[$j]);
        } else {
            $j = $n + 1;
            $next = get_permalink($list_ID[$j]);
            $j = $n - 1;
            $prev = get_permalink($list_ID[$j]);
        }
        $result = array($prev, $next);
    } else {
        $j = 0;
        $next = get_permalink($list_ID[$j]);
        $j = $n - 1;
        $prev = get_permalink($list_ID[$j]);
        $result = array($prev, $next);
    }
    return $result;
}


//--- DETECT HAS CHILDREN ---//

function has_children($post_ID = null)
{
    if ($post_ID === null) {
        global $post;
        $post_ID = $post->ID;
    }
    $query = new WP_Query(array('post_parent' => $post_ID, 'post_type' => 'any'));

    return $query->have_posts();
}

//--- DETECT HAS PARENT ---//

function has_parent()
{
    global $post;     // if outside the loop
    if (is_page() && $post->post_parent) {
        return true;
    } else {
        return false;
    }
}
function get_parent()
{
    global $post;
    return $post->post_parent;
}

//--- LIMIT HIERARCHICAL PAGES DEPTH TO CHILDREN ONLY ---//

function my_hierarchical_page_depth_limit($a)
{
    $a['depth'] = 1;
    return $a;
}
//add_action('page_attributes_dropdown_pages_args','my_hierarchical_page_depth_limit');

//--- SHORT CODE ---//
/*
//example
function my_shortcode_handler( $atts, $content = null ) {
    $a = shortcode_atts( array(
        'attr_1' => 'attribute 1 default',
        'attr_2' => 'attribute 2 default',
        // ...etc
    ), $atts );
	return '<p>'.$a['attr_1'].' '.$a['attr_2'].'<p>';
}
add_shortcode( 'myshortcode', 'my_shortcode_handler' );
*/


//form shortcode
function form_shortcode($atts = [], $content = null, $tag = '')
{
    ob_start();
    $id = 'form-' . uniqid();
    $a = shortcode_atts(array(
        'src' => '',
        'height' => '300px',
        'height-tablet' => '',
        'height-phone' => '',
        'mq-tablet' => '1024px',
        'mq-phone' => '414px',
        'scrolling' => 'no'
    ), $atts);
    if ($a['height-tablet'] == '') {
        $a['height-tablet'] = $a['height'];
    }
    if ($a['height-phone'] == '') {
        $a['height-phone'] = $a['height-tablet'];
    }
    if ($a['src'] == '') {
        $a['src'] = $content;
    }
    echo '
    <style>
        #' . $id . '{
            width: 100%;
            border: none;
            height: ' . $a['height'] . '
        }
        @media only screen and (max-width: ' . $a['mq-tablet'] . ') {
            #' . $id . '{
                height: ' . $a['height-tablet'] . '
            }
        }
        @media only screen and (max-width: ' . $a['mq-phone'] . ') {
            #' . $id . '{
                height: ' . $a['height-phone'] . '
            }
        }
    </style>
    <iframe  id="' . $id . '" src="' . $a['src'] . '" height="auto" frameborder="0" scrolling="' . $a['scrolling'] . '"> <a href="' . $a['src'] . '">Loading</a> </iframe>';
    return ob_get_clean();
}
add_shortcode('form', 'form_shortcode');

//--- HEADER STYLES AND SCRIPTS ---//

function on__style()
{
    //echo '<link rel="stylesheet" href="https://use.typekit.net/lpi2qki.css">';
    wp_enqueue_style('style-theme', get_bloginfo('stylesheet_url'), false, num_version(), 'screen');
    //wp_enqueue_style( 'style-karen', get_bloginfo('template_directory') .'/style-karen.css', false, num_version() );
}
add_action('wp_print_styles', 'on__style');

function my_scripts()
{

    /*
    if (!is_admin()) {

        wp_deregister_script('jquery');
        wp_register_script('jquery', get_template_directory_uri().'/js/jquery-3.6.0.min.js', false, false, false);
         wp_enqueue_script('jquery');
    }
    */
    wp_register_script('main-script', get_template_directory_uri() . '/js/main.min.js', false, num_version(), false);
    wp_enqueue_script('main-script');

    // wp_register_script('cookieyes-script', 'https://cdn-cookieyes.com/client_data/fa68b8da34be4e431c6d3125/script.js', false, num_version(), false);
    // wp_enqueue_script('cookieyes-script');  

    wp_register_script(
        'vimeo-api',
        'https://player.vimeo.com/api/player.js',
        array(),
        null,
        true
    );

    wp_enqueue_script('vimeo-api');


    wp_register_script('lottie-script', get_template_directory_uri() . '/js/lottie.js', false, num_version(), false);

    wp_enqueue_script('lottie-script');
}
// Agregamos la función a la lista de cargas de WordPress.
add_action('wp_enqueue_scripts', 'my_scripts');


function add_type_attribute($tag, $handle, $src)
{
    // if not your script, do nothing and return original $tag
    if ('main-script' !== $handle) {
        return $tag;
    }
    // change the script tag by adding type="module" and return it.
    $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    return $tag;
}
add_filter('script_loader_tag', 'add_type_attribute', 10, 3);

function on__script()
{
    $ga_id = get_field('google_analytics_id', 'option');
    if (get_field('google_analytics_enabled', 'option') && $ga_id != ''):
        /* 
    <!-- Google tag (gtag.js) -->
    <script async src='https://www.googletagmanager.com/gtag/js?id={$ga_id}'></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{$ga_id}');
    </script> 
    */
        echo "
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','{$ga_id}');</script>
    <!-- End Google Tag Manager -->
    ";
    endif;
    echo '
    <script>
        window.siteVersion = "' . num_version() . '";
        const referrer = String(document.referrer);
        if((referrer.indexOf("/team/") !== -1 || referrer.indexOf("/our-faculty/") !== -1)){
            document.documentElement.classList.add("remove-team-submenu-transitions");
        }
        if((referrer.indexOf("/people/") !== -1 || referrer.indexOf("/course-participants/") !== -1)){
            document.documentElement.classList.add("remove-people-submenu-transitions");
        }
        if((referrer.indexOf("/insights/") !== -1)){
            document.documentElement.classList.add("remove-insights-submenu-transitions");
        }
        if((referrer.indexOf("/programs/") !== -1)){
            document.documentElement.classList.add("remove-programs-submenu-transitions");
        }
    </script>
    ';
}
add_action('wp_head', 'on__script');


//----------------------------------//
//--- ACF 'HAS PARENT' CONDITION ---//


//------------------------//
//--- ACF RELATIONSHIP ---//

add_filter('acf/fields/relationship/result/name=jump_to', 'my_acf_fields_relationship_result_timeline', 10, 4);
add_filter('acf/fields/relationship/result/name=timeline', 'my_acf_fields_relationship_result_timeline', 10, 4);
function my_acf_fields_relationship_result_timeline($text, $post, $field, $post_id)
{
    $text = '<span style="font-weight:bold">' . get_field('year_period', $post->ID) . '</span> <span>(' . $text . ')</span>';
    return $text;
}


//add_filter('acf/fields/relationship/result', 'my_acf_fields_relationship_result', 10, 4);
//add_filter('acf/fields/post_object/result', 'my_acf_fields_relationship_result', 10, 4);
function my_acf_fields_relationship_result($text, $post, $field, $post_id)
{
    if (post_password_required($post->ID)) {
        $text .= ' ' . sprintf('<span> (Password)</span>', $text);
    }
    $post_type = strtoupper(substr(get_post_type($post), 0, 1));
    $text = sprintf('<span class="post-type-custom-label">' . $post_type . '</span> ', $text) . $text;

    /* if($post_id == $post->ID){
        $text .= ' ' . sprintf( '<span class="acf-result-delete-current-post"> (Current)</span>', $text );
    } */
    return $text;
}


add_filter('acf/fields/relationship/result', 'my_acf_fields_relationship_result2', 10, 4);
//add_filter('acf/fields/post_object/result', 'my_acf_fields_relationship_result2', 10, 4);
function my_acf_fields_relationship_result2($text, $post, $field, $post_id)
{
    if (get_post_type($post) == 'events') {
        //$date = strtotime ( $input ); echo date ( 'd/M/Y' , $date )
        $date = get_field('date_hour_date', $post);
        $date_str = date('M j, Y', strtotime($date));
        $template = get_field('default_template', $post);
        $text .= ' ' . sprintf('<span data-date="' . $date . '" class="relationship-extra-label"> (' . $date_str . ' | ' . $template . ')</span>', $text);
    }
    /* $post_type = strtoupper(substr(get_post_type($post),0,1));
    $text = sprintf( '<span class="post-type-custom-label">'.$post_type.'</span> ', $text ).$text;
    */
    /* if($post_id == $post->ID){
        $text .= ' ' . sprintf( '<span class="acf-result-delete-current-post"> (Current)</span>', $text );
    } */
    return $text;
}

//acf/fields/relationship/query
add_filter('acf/fields/relationship/query/name=featured_events', 'my_acf_fields_relationship_query', 10, 3);
add_filter('acf/fields/relationship/query/name=events', 'my_acf_fields_relationship_query', 10, 3);
function my_acf_fields_relationship_query($args, $field, $post_id)
{
    $args['meta_key'] = 'date_hour_date';
    $args['orderby'] = array('date_hour_date' => 'DESC');
    return $args;
}

add_filter('acf/fields/post_object/query/name=on_demand_class', 'my_acf_fields_post_object_on_demand_class', 10, 4);
//add_filter('acf/fields/post_object/result', 'my_acf_fields_relationship_result2', 10, 4);
function my_acf_fields_post_object_on_demand_class($args, $field, $post_id)
{
    //$the_search = $args['s'];
    //unset($args['s']);
    $args['meta_query'] = array(
        'relation' => 'AND',
        /* array(
            'key' => 'default_template',
            //'value' => 'Class',
            'value' => 'Default Event',
            'compare' => 'LIKE',
        ), */
        array(
            'key' => 'on_demand',
            'value' => '1',
            'compare' => 'LIKE',
        ),
        array(
            'key' => 'date_hour_date',
            'value' => get_current_date('ymd'),
            'compare' => '<',
        )
    );
    $args['post__not_in'] = array($post_id);
    $args['meta_key'] = 'date_hour_date';
    $args['orderby'] = array('date_hour_date' => 'DESC');
    return $args;
}

function my_acf_fields_post_object_result_on_demand_class($text, $post, $field, $post_id)
{
    $date = get_field('date_hour_date', $post);
    $date_str = date('M j, Y', strtotime($date));
    $template = get_field('default_template', $post);
    //$text .= ' ' . sprintf( '<span data-date="'.$date.'" class="relationship-extra-label"> ('.$date_str.' | '.$template.')</span>', $text);
    $text .= ' (' . $date_str . ' | ' . $template . ')';
    return sprintf(html_entity_decode($text));
}
add_filter('acf/fields/post_object/result/name=on_demand_class', 'my_acf_fields_post_object_result_on_demand_class', 10, 4);

/**
 * Exclude current post/page from relationship field results
 */

add_filter('acf/fields/relationship/query', 'relationship_options_filter', 10, 3);
add_filter('acf/fields/post_object/query', 'relationship_options_filter', 10, 3);
function relationship_options_filter($options, $field, $post)
{

    $options['post_status'] = array('publish');
    $options['has_password'] = FALSE;
    $options['post__not_in'] = array($post); //current post

    return $options;
}


//-------------------------//
//--- ACF CUSTOM STYLES ---//

function my_acf_admin_head()
{
    ?>
    <style type="text/css">
        .acf-postbox.seamless>.acf-fields>.acf-tab-wrap {
            height: 46px !important;
        }

        .mce-custom-media-button {
            border-color: #2271b1 !important;
        }

        .mce-custom-media-button button {
            color: #2271b1 !important;
            padding-left: 5px !important;
            padding-right: 6px !important;
        }

        .mce-custom-media-button button .mce-txt {
            vertical-align: middle;
        }

        .mce-custom-media-button button i {
            padding-right: 5px !important;
            transform: translateY(1px) !important;
        }

        .mce-custom-media-button button i:before {
            font: normal 18px/1 dashicons !important;
            content: "\f104" !important;
            color: #2271b1 !important;
        }

        .mce-custom-media-button button:hover {
            color: white !important;
            background-color: #2271b1 !important;
        }

        .mce-custom-media-button button:hover i:before {
            color: white !important;
        }

        .acf-field-gallery.gallery-small-height .acf-gallery {
            height: 240px !important;
        }

        .afc-warning .acf-label {
            display: none !important;
        }

        .acf-warning-content {
            padding: 15px;
            background: white;
            color: black;
            border: solid 1px #ccd0d4;
            display: flex;
            align-items: center;
            justify-content: center;
            width: fit-content;
        }

        .acf-warning-content img {
            margin-right: 1em;
        }

        .wysiwyg-large-height iframe {
            min-height: 500px !important;
        }

        .mce-fullscreen .wysiwyg-large-height iframe {
            max-height: none !important;
        }

        .wysiwyg-small-height iframe {
            max-height: 203px !important;
        }

        .mce-fullscreen .wysiwyg-small-height iframe {
            max-height: none !important;
        }

        .wysiwyg-height-400 iframe {
            min-height: 347px !important;
        }

        .mce-fullscreen .wysiwyg-height-400 iframe {
            max-height: none !important;
        }

        .no-resize .mce-flow-layout-item.mce-last.mce-resizehandle {
            display: none !important;
        }

        .no-resize textarea {
            resize: none !important;
        }

        .acf-field.closed-captions textarea {
            background-color: #f1f1f1;
            color: #2c3338;
            font-family: monospace;
        }

        .text-code textarea,
        .text-code input {
            font-family: monospace;
            background: #577df5;
            color: white;
        }

        .text-code.full-width {
            width: 100% !important;
        }

        .acf-realtionship-small .acf-relationship {
            height: 309px;
        }

        .acf-realtionship-medium .acf-relationship {
            height: 435px;
        }

        .acf-realtionship-large .acf-relationship {
            height: 500px;
        }

        .acf-realtionship-custom-height.height-327 .acf-relationship {
            height: 327px;
        }

        .acf-realtionship-custom-height.height-550 .acf-relationship {
            height: 550px;
        }

        .acf-realtionship-small .acf-relationship .selection,
        .acf-realtionship-medium .acf-relationship .selection,
        .acf-realtionship-large .acf-relationship .selection,
        .acf-realtionship-custom-height .acf-relationship .selection {
            height: 100%;
            height: calc(100% - 45px);
        }

        .acf-realtionship-small .acf-relationship .selection .choices,
        .acf-realtionship-small .acf-relationship .selection .values,
        .acf-realtionship-medium .acf-relationship .selection .choices,
        .acf-realtionship-medium .acf-relationship .selection .values,
        .acf-realtionship-large .acf-relationship .selection .choices,
        .acf-realtionship-large .acf-relationship .selection .values,
        .acf-realtionship-custom-height .acf-relationship .selection .choices,
        .acf-realtionship-custom-height .acf-relationship .selection .values {
            height: 100%;
        }

        .acf-realtionship-small .acf-relationship .selection .choices ul,
        .acf-realtionship-small .acf-relationship .selection .values ul,
        .acf-realtionship-medium .acf-relationship .selection .choices ul,
        .acf-realtionship-medium .acf-relationship .selection .values ul,
        .acf-realtionship-large .acf-relationship .selection .choices ul,
        .acf-realtionship-large .acf-relationship .selection .values ul,
        .acf-realtionship-custom-height .acf-relationship .selection .choices ul,
        .acf-realtionship-custom-height .acf-relationship .selection .values ul {
            height: 100%;
            height: calc(100% - 10px);
        }

        .acf-relationship .selection .choices .post-type-custom-label {
            display: none;
        }

        .acf-field.min-height-613 {
            min-height: 613px !important;
        }

        .acf-relationship .relationship-extra-label {
            color: #a9a9a9;
            font-style: italic;
        }

        .use-labels .acf-relationship .selection .values .post-type-custom-label {
            background-color: #EC764A;
            color: white;
            padding: 3px;
            border-radius: 100%;
            width: 1em;
            height: 1em;
            display: inline-block;
            line-height: 1em;
            text-align: center;
            font-size: 0.7em;
            font-weight: bold;
            transform: translateY(-1px);
        }

        .use-labels .acf-relationship .selection .values li:hover .post-type-custom-label {
            background-color: white;
            color: black;
        }

        /* .acf-relationship .selection .values .post-type-custom-label:before{
                content: url('https://api.iconify.design/dashicons/format-gallery.svg');
            } */
        .acf-tab-wrap.-left .acf-tab-group li:first-child {
            border-top: solid 1px #cccccc;
        }

        .acf-tab-wrap.-left:before {
            content: ' ';
            border-top: solid 1px #cccccc !important;
            display: block;
            width: calc(80% - 14px);
            position: absolute;
            margin-left: -9px;
        }

        .acf-field.acf-field-group.acf-group-no-borders .acf-fields .acf-fields.-border {
            border: none;
        }

        .acf-field.acf-field-group.acf-group-no-borders .acf-fields .acf-fields>.acf-field {
            border: none;

        }

        .acf-field.no-label>.acf-label {
            display: none;
        }

        .acf-field.no-padding-top {
            padding-top: 0;
        }

        .acf-field.no-padding-top p:first-child {
            margin-top: 0;
            padding-top: 0;
        }

        .acf-flexible-content .acf-fc-layout-handle {
            user-select: none;
        }

        .acf-flexible-content .sq-color {
            display: inline-block !important;
            transform: translateY(-3px);
            line-height: 0;
            width: 100px;
            height: 2px;
            border-radius: 2px;
        }

        .acf-field.acf-break-line {
            clear: inline-start !important;
        }

        .acf-field.acf-clear-both {
            clear: both !important;
        }

        /*--- ivan 28-08 ---*/
        .acf-text-large input[type="text"],
        .acf-text-large textarea {
            font-size: 1.7em;
        }

        /*--- ivan 28-08 ---*/

        /* ------------------------- */
        /* --- events attributes --- */

        #postbox-container-2 #pageparentdiv,
        #acf_after_title-sortables #pageparentdiv {
            border: 0 none;
            background: transparent;
            box-shadow: none;
        }

        #postbox-container-2 #pageparentdiv .postbox-header,
        #acf_after_title-sortables #pageparentdiv .postbox-header {
            display: none;
        }

        #postbox-container-2 #pageparentdiv .inside,
        #acf_after_title-sortables #pageparentdiv .inside {
            padding-left: 0;
            padding-right: 0;
        }

        #postbox-container-2 #page_template,
        #acf_after_title-sortables #page_template {
            width: 33.33%;
            width: calc(33.33% - 20px);
        }

        .block {
            display: block;
        }

        /* --- events attributes --- */
        /* ------------------------- */


        .select2-container--default .select2-search--dropdown {
            display: none;
        }


        .image-gallery-small-height .acf-gallery.ui-resizable {
            height: 225px !important;
        }

        .width-100 {
            width: 100px !important;
        }

        .width-150 {
            width: 150px !important;
        }

        .max-width-100 {
            max-width: 100px;
        }

        .max-width-125 {
            max-width: 125px;
        }

        .max-width-150 {
            max-width: 150px;
        }

        .max-width-175 {
            max-width: 175px;
        }

        .max-width-200 {
            max-width: 200px;
        }

        .max-width-250 {
            max-width: 250px;
        }

        .max-width-300 {
            max-width: 300px;
        }

        .max-width-400 {
            max-width: 400px;
        }

        .max-width-100-percent-min-100px {
            max-width: calc(100% - 100px);
        }

        .max-width-100-percent-min-125px {
            max-width: calc(100% - 125px);
        }

        .max-width-100-percent-min-150px {
            max-width: calc(100% - 150px);
        }

        .max-width-100-percent-min-200px {
            max-width: calc(100% - 200px);
        }

        .max-width-100-percent-min-250px {
            max-width: calc(100% - 250px);
        }

        .max-width-100-percent-min-300px {
            max-width: calc(100% - 300px);
        }

        .max-width-100-percent-min-400px {
            max-width: calc(100% - 400px);
        }


        .max-width-50-percent-min-100px {
            max-width: calc(50% - 100px);
        }

        .max-width-50-percent-min-125px {
            max-width: calc(50% - 125px);
        }

        .max-width-50-percent-min-150px {
            max-width: calc(50% - 150px);
        }

        .max-width-50-percent-min-200px {
            max-width: calc(50% - 200px);
        }

        .max-width-50-percent-min-250px {
            max-width: calc(50% - 250px);
        }

        .max-width-50-percent-min-300px {
            max-width: calc(50% - 300px);
        }

        .max-width-50-percent-min-400px {
            max-width: calc(50% - 400px);
        }

        .max-width-50-percent {
            max-width: 50%;
        }

        .max-width-75-percent {
            max-width: 75%;
        }

        .max-width-76-percent {
            max-width: calc(75% + 1px);
        }

        .max-width-66-percent {
            max-width: 66.6%;
        }

        .max-width-67-percent {
            max-width: calc(66.6% + 1px);
        }

        .max-width-51-percent {
            max-width: calc(50% + 1px);
        }

        .max-width-37-percent {
            max-width: 37.5%;
        }

        .max-width-38-percent {
            max-width: calc(37.5% + 1px);
        }

        .max-width-33-percent {
            max-width: 33.33%;
        }

        .max-width-35-percent {
            max-width: calc(33.3% + 1px);
        }

        .max-width-34-percent {
            max-width: calc(33.3% + 1px);
        }

        .max-width-25-percent {
            max-width: 25%;
        }

        .max-width-26-percent {
            max-width: calc(25% + 1px);
        }

        .max-width-20-percent {
            max-width: 20%;
        }

        .max-width-21-percent {
            max-width: calc(20% + 1px);
        }

        .max-width-15-percent {
            max-width: 15%;
        }

        .max-width-16-percent {
            max-width: calc(15% + 1px);
        }

        .max-width-10-percent {
            max-width: 10%;
        }

        .width-max-content {
            width: 100%;
            max-width: max-content;
        }

        @media only screen and (max-width: 1250px) {

            .max-width-76-percent,
            .max-width-75-percent,
            .max-width-67-percent,
            .max-width-66-percent,
            .max-width-51-percent,
            .max-width-50-percent,
            .max-width-34-percent,
            .max-width-33-percent,
            .max-width-26-percent,
            .max-width-25-percent,
            .max-width-21-percent,
            .max-width-20-percent,
            .max-width-16-percent,
            .max-width-15-percent {
                max-width: none;
            }
        }


        .max-height-50,
        .max-height-50 img {
            max-height: 50px !important;
        }

        .max-height-60,
        .max-height-60 img {
            max-height: 60px !important;
        }

        .max-height-70,
        .max-height-70 img {
            max-height: 70px !important;
        }

        .max-height-80,
        .max-height-80 img {
            max-height: 80px !important;
        }

        .max-height-90,
        .max-height-90 img {
            max-height: 90px !important;
        }

        .max-height-100,
        .max-height-100 img {
            max-height: 100px !important;
        }

        .max-height-150,
        .max-height-150 img {
            max-height: 150px !important;
        }

        .max-height-160,
        .max-height-160 img {
            max-height: 160px !important;
        }

        .edit-timestamp {
            /* display: none; */
            /* disable edition of WP Post default date */
        }

        .admin-columns-hide-element {
            display: none !important;
        }

        .admin-columns-element-gray-color {
            color: gray;
        }


        .acf-input-prepend,
        .acf-input-append {
            user-select: none;
        }

        .unhiddenable[hidden] {
            display: block !important;
        }

        .unhiddenable[hidden] .acf-input-wrap,
        .unhiddenable[hidden] .acf-input-prepend,
        .unhiddenable[hidden] .acf-input-append,
        .unhiddenable[hidden].acf-field-image.acf-hidden {
            opacity: 0.5 !important;
            user-select: none;
            color: #333;
            border-color: darkgray;
            background: #eee;
            user-select: none;
        }

        .unhiddenable[hidden] .acf-input-wrap input {
            color: #333;
            border-color: darkgray;
            background: #eee;
            user-select: none;
        }

        .unhiddenable[hidden].acf-field-image.acf-hidden {
            border: none;
            pointer-events: none;
        }

        .unhiddenable[hidden].acf-field-image.acf-hidden .button {
            visibility: hidden;
        }

        .acf-field.hide-field {
            display: none;
        }

        .acf-field-group.remove-group-layout {
            padding: 0;
        }

        .acf-field-group.remove-group-layout>.acf-label {
            display: none;
        }

        .acf-field-group.remove-group-layout .acf-fields.-top.-border {
            border: none;
            background: none;
        }

        .acf-field-group.remove-group-layout .acf-fields .acf-field-date-picker {}

        .acf-field.input-width-25 input {
            width: calc(25% - 22px) !important;
        }

        .acf-field.input-width-33 input {
            width: calc(33.33% - 22px) !important;
        }

        .acf-field.input-width-50 input {
            width: calc(50% - 22px) !important;
        }

        .acf-field.input-width-66 input {
            width: calc(66.66% - 22px) !important;
        }

        .acf-field.input-width-75 input {
            width: calc(75% - 22px) !important;
        }

        .acf-field.instructions-to-side label,
        .acf-field.instructions-to-side p.description,
        .acf-field.description-to-side label,
        .acf-field.description-to-side p.description {
            width: fit-content;
            display: inline-block;
            margin-right: 5px;
        }

        .acf-flexible-content .layout[data-layout='image'] .preview-thumbs,
        .acf-flexible-content .layout[data-layout='full_size_video'] .preview-thumbs,
        .acf-flexible-content .layout[data-layout='full_width_image'] .preview-thumbs,
        .acf-flexible-content .layout[data-layout='image_full_width'] .preview-thumbs,
        .acf-flexible-content .layout[data-layout='image_gallery'] .preview-thumbs,
        .acf-flexible-content .layout[data-layout='image_slider'] .preview-thumbs {
            position: absolute;
            top: 5px;
            left: auto;
            height: 0;
            width: fit-content;
            filter: grayscale(1);
            opacity: 0.7;
            visibility: hidden;
            transition: opacity 0.3s, filter 0.3s;
            max-width: calc(100% - 250px);
            height: 27px;
            overflow: hidden;
        }

        .acf-flexible-content .layout.-collapsed[data-layout='image']:hover .preview-thumbs,
        .acf-flexible-content .layout.-collapsed[data-layout='full_size_video']:hover .preview-thumbs,
        .acf-flexible-content .layout.-collapsed[data-layout='full_width_image']:hover .preview-thumbs,
        .acf-flexible-content .layout.-collapsed[data-layout='image_full_width']:hover .preview-thumbs,
        .acf-flexible-content .layout.-collapsed[data-layout='image_gallery']:hover .preview-thumbs,
        .acf-flexible-content .layout.-collapsed[data-layout='image_slider']:hover .preview-thumbs {
            filter: none;
            opacity: 1;
        }

        .acf-flexible-content .layout.-collapsed[data-layout='image'] .preview-thumbs,
        .acf-flexible-content .layout.-collapsed[data-layout='full_size_video'] .preview-thumbs,
        .acf-flexible-content .layout.-collapsed[data-layout='full_width_image'] .preview-thumbs,
        .acf-flexible-content .layout.-collapsed[data-layout='image_full_width'] .preview-thumbs,
        .acf-flexible-content .layout.-collapsed[data-layout='image_gallery'] .preview-thumbs,
        .acf-flexible-content .layout.-collapsed[data-layout='image_slider'] .preview-thumbs {

            visibility: visible;
        }

        .acf-flexible-content .layout.-collapsed[data-layout='image'] .preview-thumbs img,
        .acf-flexible-content .layout.-collapsed[data-layout='full_size_video'] .preview-thumbs img,
        .acf-flexible-content .layout.-collapsed[data-layout='full_width_image'] .preview-thumbs img,
        .acf-flexible-content .layout.-collapsed[data-layout='image_full_width'] .preview-thumbs img,
        .acf-flexible-content .layout.-collapsed[data-layout='image_gallery'] .preview-thumbs img,
        .acf-flexible-content .layout.-collapsed[data-layout='image_slider'] .preview-thumbs img {
            height: 27px;
            width: auto;
            border-radius: 3px;
            margin-left: 5px
        }

        .acf-field.acf-field-flexible-content.disable-native-controls .button-primary,
        .acf-field.acf-field-flexible-content.disable-native-controls .acf-fc-layout-controls>*:not(.-collapse),
        .acf-field.acf-field-flexible-content.hide-add-button .button-primary,
        .acf-field.acf-field-flexible-content.hide-controls .acf-fc-layout-controls>*:not(.-collapse) {
            display: none !important;
        }

        .acf-field-group .acf-field-flexible-content .acf-fc-layout-handle,
        .acf-field.acf-field-flexible-content .acf-field-flexible-content .acf-fc-layout-handle {
            background-color: #f6f7f7 !important;
        }

        .acf-field-group .acf-field-flexible-content .layout .acf-fc-layout-controls .acf-icon,
        .acf-field.acf-field-flexible-content .acf-field-flexible-content .layout .acf-fc-layout-controls .acf-icon {
            background-color: white;
        }

        .acf-field.disabled input {
            pointer-events: none;
            user-select: none;
            border: solid 1px darkgray;
            background: #eee;
            color: #333;
            opacity: 0.5;
        }

        .acf-field.acf-field-true-false.disabled * {
            pointer-events: none;
        }

        .acf-field.acf-field-true-false.disabled .acf-switch {
            filter: grayscale(1);
            opacity: 0.5;
        }

        .acf-field.acf-field-true-false.disabled input {
            display: none;
        }

        .acf-field.img-tiny .acf-image-uploader .image-wrap img {
            max-height: 50px !important;
            width: auto !important;
        }

        .acf-field.hide-table-header thead,
        .acf-field.hide-table-header thead * {
            height: 0;
            visibility: hidden;
            padding: 0;
            line-height: 0;
            min-height: 0;
            max-height: 0;
            border: none;
            margin: 0;
        }

        .acf-field.hide-table thead {
            display: none;
        }

        .acf-field.hide-table .acf-table {
            border: none;
            background: none;
        }

        .acf-field.hide-table td.acf-field {
            border: none;
            background: none;
            padding: 0;
        }

        .gforms_edit_form #field_id-7 {
            width: 50% !important;
        }


        .table-view-list th.sortable a,
        .table-view-list th.sorted a {
            display: flex;
            align-items: center;
            gap: 0;
        }

        .table-view-list th.sortable a span,
        .table-view-list th.sorted a span {
            width: fit-content;
        }

        .acf-field-taxonomy.full-height .acf-taxonomy-field .categorychecklist-holder {
            max-height: none;
        }

        #timeline_filtersdiv {
            display: none;
            /* disable edition of WP Timeline filters */
        }

        .incidents_data_table .acf-repeater-add-row {
            display: none;
        }

        .incidents_data_table th,
        .incidents_data_table td {
            min-width: 100px;
        }

        .incidents_data_table th.acf-row-handle,
        .incidents_data_table td.acf-row-handle {
            display: none;
        }

        .year_post_incidents_data input {
            background: #FAFAFA;
            border-color: lightgray;
            color: gray;
        }

        .acf-out-of-tab {
            display: block !important;
        }
    </style>

    <script type="text/javascript">
        /*

    (function($){
 
        //
 
    })(jQuery); 
 
    */
    </script>

    <?php
}

//add_action('acf/input/admin_head', 'my_acf_admin_head');
add_action('admin_head', 'my_acf_admin_head');

//elimina parametros de versión en los css y js del wp_head()
//add_filter( 'style_loader_src', 't5_remove_version' );
//add_filter( 'script_loader_src', 't5_remove_version' );

function t5_remove_version($url)
{
    return remove_query_arg('ver', $url);
}

// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

//remove_action( 'wp_head', 'wlwmanifest_link);

//HIDE JSON API REST
/*
add_filter( 'rest_authentication_errors', function( $result ) {
  if ( ! empty( $result ) ) {
    return $result;
  }
  if ( ! is_user_logged_in() ) {
    return new WP_Error( 'rest_not_logged_in', 'You are not currently logged in.', array( 'status' => 401 ) );
  }
  if ( ! current_user_can( 'administrator' ) ) {
    return new WP_Error( 'rest_not_admin', 'You are not an administrator.', array( 'status' => 401 ) );
  }
  return $result;
});
*/
// Disable some endpoints for unauthenticated users
add_filter('rest_endpoints', 'disable_default_endpoints');
function disable_default_endpoints($endpoints)
{
    $endpoints_to_remove = array(
        '/oembed/1.0',
        '/wp/v2',
        '/wp/v2/media',
        '/wp/v2/types',
        '/wp/v2/statuses',
        '/wp/v2/taxonomies',
        '/wp/v2/tags',
        '/wp/v2/users',
        '/wp/v2/comments',
        '/wp/v2/settings',
        '/wp/v2/themes',
        '/wp/v2/blocks',
        '/wp/v2/oembed',
        '/wp/v2/posts',
        '/wp/v2/pages',
        '/wp/v2/block-renderer',
        '/wp/v2/search',
        '/wp/v2/categories'
    );

    if (!is_user_logged_in()) {
        foreach ($endpoints_to_remove as $rem_endpoint) {
            // $base_endpoint = "/wp/v2/{$rem_endpoint}";
            foreach ($endpoints as $maybe_endpoint => $object) {
                if (stripos($maybe_endpoint, $rem_endpoint) !== false) {
                    unset($endpoints[$maybe_endpoint]);
                }
            }
        }
    }
    return $endpoints;
}
/*
   Debug preview with custom fields
*/

add_filter('_wp_post_revision_fields', 'add_field_debug_preview');
function add_field_debug_preview($fields)
{
    $fields["debug_preview"] = "debug_preview";
    return $fields;
}

add_action('edit_form_after_title', 'add_input_debug_preview');
function add_input_debug_preview()
{
    echo '<input type="hidden" name="debug_preview" value="debug_preview">';
}



//-------------------------------//
//--- DISABLE TRASH POST/PAGE ---//

//add_action('wp_trash_post', 'prevent_post_deletion');
function prevent_post_deletion($postid)
{
    //https://wordpress.stackexchange.com/questions/29357/how-to-disable-page-delete
    /*
    home: 2;
    */
    $restricted_pages = array(2);
    if (in_array($postid, $restricted_pages)) {
        exit('<div style="text-align:center;padding:30px;font-family:sans-serif;">The page you were trying to delete is protected.<br><br><div style="cursor:pointer;" onclick="window.history.back()">BACK</div></div>');
    }
}


//--------------//
//--- SHARER ---//
function get_twitter_share_url()
{
    return 'https://twitter.com/intent/tweet?url=' . rtrim(BASE_URL, "/") . PATH . '/';
}
function get_facebook_share_url()
{
    return 'https://www.facebook.com/sharer/sharer.php?u=' . rtrim(BASE_URL, "/") . PATH . '/';
}



//-------------------//
// --- VIDEO URL --- //

function get_video_embed($url = '')
{
    $result = array(
        'code' => '',
        'player_name' => ''
    );
    if (strrpos($url, "streamspot") === false && $url != '' && strrpos($url, "vimeo") !== false):
        //https://vimeo.com/event/1195310/embed)
        if (strrpos($url, "event/") !== false):
            $video_id = explode('event/', $url);
            $video_id = explode('/embed', $video_id[1]);
            $video_id = explode('/', $video_id[0]);
            $video_id = $video_id[0];
            $result = array(
                'code' => '<iframe src="https://vimeo.com/event/' . $video_id . '/embed?muted=1&autoplay=1" width="100%" height="100%" frameborder="0" allowfullscreen allow="autoplay; encrypted-media"></iframe>',
                'player_name' => 'vimeo'
            );
        else:
            $video_id = get_vimeo_id_from_url($url);
            $result = array(
                'code' => '<iframe src="https://player.vimeo.com/video/' . $video_id . '?muted=1&autoplay=1" width="100%" height="100%" frameborder="0" allowfullscreen allow="autoplay; encrypted-media"></iframe>',
                'player_name' => 'vimeo'
            );
        endif;
    elseif (strrpos($url, "streamspot") === false && $url != ''):
        $video_id = get_youtube_id_from_url($url);
        $result = array(
            'code' => '<iframe src="https://www.youtube.com/embed/' . $video_id . '?mute=1&autoplay=1" width="100%" height="100%" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>',
            'player_name' => 'youtube'
        );
    elseif ($url != ''):
        $video_id = get_streamspot_id_from_url($url);
        //$result = '<iframe width="100%" height="100%" src="https://player2.streamspot.com/?playerId=830ec95e" frameborder="0" allowfullscreen></iframe>';
        $result = array(
            'code' => '<iframe src="https://player2.streamspot.com/?playerId=' . $video_id . '&muted=1&autoplay=1" width="100%" height="100%" frameborder="0" allowfullscreen=""></iframe>',
            'player_name' => 'streamspot'
        );
    endif;
    return $result;
}
function get_youtube_id_from_url($url)
{
    //return preg_match('/(http(s|):|)\/\/(www\.|)yout(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $results);    return $results[6];
    $parts = parse_url($url);
    $result = '';
    if (isset($parts['query'])) {
        parse_str($parts['query'], $qs);
        if (isset($qs['v'])) {
            $result = $qs['v'];
        } else if (isset($qs['vi'])) {
            $result = $qs['vi'];
        }
    }
    if (isset($parts['path'])) {
        $path = explode('/', trim($parts['path'], '/'));
        $result = $path[count($path) - 1];
    }
    return $result;
}
function get_streamspot_id_from_url($url = '')
{
    $id = '';
    //https://player2.streamspot.com/?playerId=830ec95e
    if ($url != ''):
        $tmp = explode('playerId=', $url);
        $tmp = explode('"', $tmp[1]);
        $id = $tmp[0];
    endif;
    return $id;
}
function get_vimeo_id_from_url($url = '')
{
    //https://gist.github.com/anjan011/1fcecdc236594e6d700f
    $regs = array();
    $id = '';
    if (preg_match('%^https?:\/\/(?:www\.|player\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)(?:$|\/|\?)(?:[?]?.*)$%im', $url, $regs)) {
        $id = $regs[3];
    }
    return $id;
}


//--------------//
//--- SEARCH ---//

/**
 * Generate custom search form
 *
 * @param string $form Form HTML.
 * @return string Modified form HTML.
 */
function wpdocs_my_search_form($form)
{
    $form = '
    <form role="search" method="get" id="searchform" class="searchform max-width" action="' . home_url('/') . '" >
        <label class="unselectable txt-h2" for="s">' . __('Search Form') . '</label>
        <div class="fields-wrapper">
            <input class="txt-h2" type="search" autocomplete="off" value="' . get_search_query() . '" name="s" id="s" placeholder="We are all searching for something. What\'s your thing?" data-placeholdermobile="Search..." />
            <button class="txt-h2 unselectable" type="submit" aria-label="Search">
                <span>Search</span>
                <svg class="icon" width="38" height="38" viewBox="0 0 38 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="0.75" y="0.75" width="36.5" height="36.5" rx="18.25" stroke="#1C393A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></rect>
                    <path d="M13.5 19H24.5" stroke="#1C393A" stroke-width="1.5" stroke-linecap="round"></path>
                    <path d="M20.5 14.5L24.5 19L20.5 23.5" stroke="#1C393A" stroke-width="1.5" stroke-linecap="round"></path>
                </svg>
            </button>
        </div>
    </form>
    ';
    return $form;
}
add_filter('get_search_form', 'wpdocs_my_search_form');

//----------------------------------------------//
//--- ACF FILTER META QUERY BY FLEX CONTENTS ---//

function my_posts_where($where)
{

    $where = str_replace("meta_key = 'global_modules_$", "meta_key LIKE 'global_modules_%", $where);

    return $where;
}
add_filter('posts_where', 'my_posts_where');

//--- ACF FILTER META QUERY BY FLEX CONTENTS ---//
//----------------------------------------------//


//--------------------------------//
//--- ADD META FIELD WHEN SAVE ---//

function add_meta_field_when_save($post_id = 0)
{

    /* if ( get_post_type($post_id) == 'cpt_name_here' ) {

         // If this is just a revision, don't send the email.
         if ( wp_is_post_revision( $post_id ) )
         return;

         $value = 'something'; // The value depends in fact on the value of another field
         update_post_meta($post_id, 'some_custom_field', $value);

     } */
    update_post_meta($post_id, 'default_title', get_the_title($post_id));
    if ($post_id && get_post_type($post_id) == 'events'): //restrict post_type to events
        update_post_meta($post_id, 'default_template', ucwords(str_replace('-', ' ', str_replace('template-events-', '', str_replace('.php', '', get_field('_wp_page_template', $post_id))))));
        class_and_recurring_events_date_control($post_id);
    endif;
}
//add_action( 'save_post', 'add_meta_field_when_save', 10, 2 );


function set_date_event_when_save($post_id = 0)
{

    if ($post_id && get_post_type($post_id) == 'events'): //restrict post_type to events

        $template = get_field('_wp_page_template', $post_id);
        $on_demand = get_field('on_demand', $post_id);
        $date_result_future = array();
        $start_hour_result_future = array();
        $end_hour_result_future = array();
        $date_result_past = array();
        $start_hour_result_past = array();
        $end_hour_result_past = array();
        if ($template == 'template-events-class.php') {
            $class_dates = get_field('class_dates', $post_id);
            if ($class_dates['classes']) {
                foreach ($class_dates['classes'] as $class) {
                    if ($class['date'] && get_current_date('ymd') <= date('Ymd', strtotime($class['date']))) {
                        array_push($date_result_future, $class['date']);
                        array_push($start_hour_result_future, $class['start_hour']);
                        array_push($end_hour_result_future, $class['end_hour']);
                    } elseif ($class['date'] && get_current_date('ymd') > date('Ymd', strtotime($class['date']))) {
                        array_push($date_result_past, $class['date']);
                        array_push($start_hour_result_past, $class['start_hour']);
                        array_push($end_hour_result_past, $class['end_hour']);
                    }
                }
            }
            if (count($date_result_future) > 0) {
                sort($date_result_future);
                update_post_meta($post_id, 'date_hour_date', $date_result_future[0]);
                update_post_meta($post_id, 'date_hour_start_hour', $start_hour_result_future[0]);
                update_post_meta($post_id, 'date_hour_end_hour', $end_hour_result_future[0]);
            } elseif (count($date_result_past) > 0) {
                sort($date_result_past);
                $reversed = array_reverse($date_result_past);
                $reversed_start_hour = array_reverse($start_hour_result_past);
                $reversed_end_hour = array_reverse($end_hour_result_past);
                update_post_meta($post_id, 'date_hour_date', $reversed[0]);
                update_post_meta($post_id, 'date_hour_start_hour', $reversed_start_hour[0]);
                update_post_meta($post_id, 'date_hour_end_hour', $reversed_end_hour[0]);
            } elseif (!$on_demand) {
                update_post_meta($post_id, 'date_hour_date', get_the_date('Ymd'));
            }
        }/* elseif($template == 'template-events-class.php' && $on_demand && !get_field('date_hour_date',$post_id)){
           update_post_meta($post_id, 'date_hour_date', get_the_date('Ymd'));
       } */
        if ($template == 'template-events-default-event.php' && get_field('date_hour_recurring_event') && get_field('date_hour_date') == '') {
            update_post_meta($post_id, 'date_hour_date', get_the_date('Ymd'));
        }
        if ($template != 'template-events-default-event.php') {
            //update_post_meta($post_id, 'date_hour_start_hour', '00:00:00');
            //update_post_meta($post_id, 'date_hour_end_hour', '00:59:00');
            update_post_meta($post_id, 'date_hour_recurring_event', 0);
        } elseif (get_field('date_hour_recurring_event', $post_id)) {
            $new_date = get_date_recurring_event($post_id);
            update_field('date_hour_date', $new_date, $post_id);
        }
        //if($template != 'template-events-writing.php' && date(strtotime(get_field('date_hour_date'))) >= get_current_date('Ymd')){
        if ($template == 'template-events-writing.php') {
            //$new_date = date('Ymd', strtotime("-1 day"));
            $new_date = new DateTime();
            $new_date->setTimeZone(new DateTimeZone('America/Los_Angeles'));
            $new_date->modify('-1 day');
            if (date('Ymd', strtotime(get_field('date_hour_date', 2113))) > date('Ymd', strtotime($new_date->format('Ymd')))) {
                update_post_meta($post_id, 'date_hour_date', $new_date->format('Ymd'));
            }
            //update_post_meta($post_id, 'blurb', 'Hello World!');
        }
        //lo aplico aca para se guarde la fecha correcta
        update_post_meta($post_id, 'default_to_search', get_event_default_to_search($post_id));
    endif;
}
//add_action( 'save_post', 'set_date_event_when_save', 10, 2 );

//--- ADD META FIELD WHEN SAVE ---//
//--------------------------------//


function get_current_date($format = 'Ymd')
{
    //date_default_timezone_set('America/Los_Angeles');
    //return date($format);
    $current_date = new DateTime(date('Ymd g:i a'), new DateTimeZone('UTC'));
    $current_date->setTimeZone(new DateTimeZone('America/Los_Angeles'));
    return $current_date->format($format);
}

//----------------//
//--- ON LOGIN ---//

/* function when_any_user_login( $user_login, $user ) {

}
add_action('wp_login', 'when_any_user_login', 10, 2); */

//--- ON LOGIN ---//
//----------------//

//---------------------//
//--- PASSWORD FORM ---//

function my_password_form()
{
    global $post;
    $label = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);
    $o = '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" method="post">
    <label for="' . $label . '"><b>' . __("Enter your password:") . '</b></label>
    <input name="post_password" autocomplete="off" id="' . $label . '" type="password" size="20" maxlength="20" placeholder="•••••" value="" />
    <button type="submit" name="Submit">
        Next
    </button>

    </form>
    ';
    return $o;
}
add_filter('the_password_form', 'my_password_form');


//

function str_url_to_link($string)
{
    // The Regular Expression filter
    $reg_pattern = "/(((http|https|ftp|ftps)\:\/\/)|(www\.))[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\:[0-9]+)?(\/\S*)?/";

    // make the urls to hyperlinks
    return preg_replace($reg_pattern, '<a href="$0" target="_blank" rel="noopener noreferrer">$0</a>', $string);
}

function html_to_plain_text($str = '')
{
    return str_replace('•', '', str_replace('&nbsp;', '', strip_tags($str)));
}
function html_to_plain_lowercase_text($str = '')
{
    return strtolower(str_replace('•', '', str_replace('&nbsp;', '', strip_tags($str))));
}

//--- custom wp player style ----//

function custom_player()
{
    wp_enqueue_style(
        'custom-player',
        get_stylesheet_directory_uri() . '/wp-mediaelement.css'
    );
    $custom_css = " ";
    wp_add_inline_style('custom-player', $custom_css);
}

add_action('wp_enqueue_scripts', 'custom_player');


//


function natural_language_join(array $list, $conjunction = 'and')
{
    $last = array_pop($list);
    if ($list) {
        return implode(', ', $list) . ' ' . $conjunction . ' ' . $last;
    }
    return $last;
}

// BUTTON SECONDARY
// function get_button($_params = [])
// {
//     $params = array_merge(['html_text' => '', 'href' => '', 'target' => '', 'class' => '', 'id' => '', 'icon' => '', 'tag' => 'button'], $_params);

//     $is_link = $params['href'] != '';
//     $id_attribute = $params['id'] != '' ? "id='{$params['id']}'" : '';

//     $classes = 'btn ' . $params['class']; // Asegúrate de incluir la clase btn--secondary aquí

//     if ($is_link) :
//         $tag_open = "<a {$id_attribute} class='{$classes}' href='{$params['href']}' target='{$params['target']}'>";
//         $tag_close = "</a>";
//     else :
//         $tag_open = "<{$params['tag']} {$id_attribute} class='{$classes}'>";//--- ivan 28-08 ---//added $params['tag']
//         $tag_close = "</{$params['tag']}>";
//     endif;

//     if ($params['icon'] != '') {
//         ob_start();
//         include 'icons/' . $params['icon'] . '.php';
//         $icon = ob_get_clean();
//     } else {
//         $icon = '';
//     }

//     $has_icon_only = strpos($params['class'], 'btn--icon-only') !== false;
//     $has_icon_before = strpos($params['class'], 'btn--icon-before') !== false;

//     if ($has_icon_only) {
//         $html = "
//             {$tag_open}
//                 <div class='btn__icon'>{$icon}</div>
//             {$tag_close}
//         ";
//     } elseif ($has_icon_before) {
//         $html = "
//             {$tag_open}
//                 <div class='btn__icon'>{$icon}</div>
//                 <span class='btn__text'>{$params['html_text']}</span>
//             {$tag_close}
//         ";
//     } else {
//         $html = "
//             {$tag_open}
//                 <span class='btn__text'>{$params['html_text']}</span>
//                 <div class='btn__icon'>{$icon}</div>
//             {$tag_close}
//         ";
//     }

//     return $html;
// }

// BUTTON SECONDARY
function get_button($_params = [])
{
    $params = array_merge(['html_text' => '', 'href' => '', 'target' => '', 'class' => '', 'id' => '', 'icon' => '', 'tag' => 'button'], $_params);

    $is_link = $params['href'] != '';
    $id_attribute = $params['id'] != '' ? "id='{$params['id']}'" : '';

    $classes = 'btn ' . $params['class']; // Asegúrate de incluir la clase btn--secondary aquí

    // Filtrar los atributos adicionales que no son parte de los parámetros principales
    $standard_keys = ['html_text', 'href', 'target', 'class', 'id', 'icon', 'tag'];
    $additional_attributes = '';
    foreach ($params as $key => $value) {
        if (!in_array($key, $standard_keys) && $value !== '') {
            $additional_attributes .= " {$key}='{$value}'";
        }
    }

    if ($is_link) {
        $tag_open = "<a {$id_attribute} class='{$classes}' href='{$params['href']}' target='{$params['target']}'{$additional_attributes}>";
        $tag_close = "</a>";
    } else {
        $tag_open = "<{$params['tag']} {$id_attribute} class='{$classes}'{$additional_attributes}>"; //--- ivan 28-08 ---//added $params['tag']
        $tag_close = "</{$params['tag']}>";
    }

    if ($params['icon'] != '') {
        ob_start();
        include 'icons/' . $params['icon'] . '.php';
        $icon = ob_get_clean();
    } else {
        $icon = '';
    }

    $has_icon_only = strpos($params['class'], 'btn--icon-only') !== false;
    $has_icon_before = strpos($params['class'], 'btn--icon-before') !== false;

    if ($has_icon_only) {
        $html = "
            {$tag_open}
                <div class='btn__icon'>{$icon}</div>
            {$tag_close}
        ";
    } elseif ($has_icon_before) {
        $html = "
            {$tag_open}
                <div class='btn__icon'>{$icon}</div>
                <span class='btn__text'>{$params['html_text']}</span>
            {$tag_close}
        ";
    } else {
        $html = "
            {$tag_open}
                <span class='btn__text'>{$params['html_text']}</span>
                <div class='btn__icon'>{$icon}</div>
            {$tag_close}
        ";
    }

    return $html;
}




//---------------//
//--- GET NAV ---//

function get_nav($p = array())
{
    $params = array_merge(array(
        'first_level_ul_tag' => true,
        'first_level_only' => false
    ), $p);
    $nav_items = get_field('main_nav', 'options');
    $secondary_items = get_field('secondary_nav', 'options');
    $html = '';
    $first_level_ul_tag = $params['first_level_ul_tag'] ? array("<ul class='site-nav__first-level-ul'>", "</ul>") : array("", "");
    $html .= $first_level_ul_tag[0];
    foreach ($nav_items as $item):
        if ($item['acf_fc_layout'] == 'link'):
            $html .= "
            <li class='site-nav__first-level-li'>
                <a class='site-nav__first-level-a font-body-md' href='{$item['link']['url']}' target='{$item['link']['target']}'>
                    {$item['link']['title']}
                </a>
            </li>
            ";
        elseif ($item['acf_fc_layout'] == 'submenu' && $params['first_level_only']):
            $html .= "
            <li class='site-nav__first-li'>
                <a class='site-nav__first-level-a font-body-md' href='{$item['submenu'][0]['link']['url']}' target='{$item['submenu'][0]['link']['target']}'>
                    {$item['title']} 
                </a>
            </li>
            ";
        elseif ($item['acf_fc_layout'] == 'submenu'):
            $tmp_id = 'l2w-' . uniqid();
            $html .= "
            <li class='site-nav__first-level-li first-level-li--has-submenu'>
                <button class='site-nav__first-level-btn font-body-md' data-target='{$tmp_id}'>
                    {$item['title']}
                    <div class='site-nav__icon-for-mobile'>
                        <svg width='16' height='16' viewBox='0 0 16 16' fill='none' xmlns='http://www.w3.org/2000/svg'>
                            <path fill-rule='evenodd' clip-rule='evenodd' d='M8 9.93934L13.4697 4.46967L14.5303 5.53033L8.53033 11.5303L8 12.0607L7.46967 11.5303L1.46967 5.53034L2.53033 4.46967L8 9.93934Z' fill='#33312E'/>
                        </svg>
                    </div>
                </button>
                <div id='{$tmp_id}' class='site-nav__second-level-wrapper'>
                    
                    <div class='site-nav__submenu-blurb'>
                        <div class='submenu__blurb font-display-sm'>
                            {$item['blurb']}
                        </div>
                    </div>
                ";
            $items_per_column = ceil(count($item['submenu']) / 2);
            if (count($item['submenu']) < 5) {
                $items_per_column = 4;
            }
            $n = 1;
            $html .= "
                    <div class='site-nav__second-level-list'>    
                        <ul class='site-nav__second-level-ul'>
                ";
            foreach ($item['submenu'] as $subitem):
                $html .= "
                            <li class='site-nav__second-level-li'>
                                <a class='site-nav__second-level-a font-body-md' href='{$subitem['link']['url']}' target='{$subitem['link']['target']}'>
                                    <span class='txt-h2'>{$subitem['link']['title']}</span>
                                </a>
                            </li>
                        ";
                if ($n >= $items_per_column && $n < count($item['submenu'])):
                    $n = 1;
                    $html .= "</ul><ul class='site-nav__second-level-ul'>";
                else:
                    $n++;
                endif;
            endforeach;
            $html .= "</ul>
                    </div>
                    <button class='site-nav__close-btn' aria-label='Close Submenu'>
                        <svg width='24' height='24' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'>
                            <path class='stroke' d='M18 6L6 18M6 6L18 18' fill='none'  stroke='#0E6049' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'></path>
                        </svg>
                    </button>
                    <div class='site-secondary-nav-desktop'>
                    
                        
                    </div>
                </div>
            </li>
            ";
        endif;
    endforeach;
    $html .= $first_level_ul_tag[1];
    $html = str_replace('<ul class="site-nav__second-level-ul"></ul>', '', $html);
    $html = str_replace("<ul class='site-nav__second-level-ul'></ul>", '', $html);

    if ($secondary_items && count($secondary_items)):

        $html .= "
        <div class='site-secondary-nav-mobile'>
            <ul class='site-secondary-nav-mobile__ul'>
        ";
        foreach ($secondary_items as $s_item):
            if (isset($s_item['link'])):
                $html .= "<li class='site-secondary-nav-mobile__li'><a class='site-secondary-nav-mobile__a font-body-md' href='{$s_item['link']['url']}' target='{$s_item['link']['target']}'>{$s_item['link']['title']}</a></li>";
            endif;
        endforeach;
        $html .= "
            </ul>
        </div>
        ";
    endif;
    //
    return $html;
}

//--- GET NAV ---//
//---------------//




add_action('admin_head', 'hide_posts_pages');
function hide_posts_pages()
{
    global $current_user;
    get_currentuserinfo();
    if ($current_user->user_login != 'admin') {
        ?>
        <script>
            document.addEventListener('DOMContentLoaded', e => {
                document.querySelectorAll('.row-title').forEach(el => {
                    if (el.textContent == 'spot-it-data') {
                        el.parentNode.parentNode.parentNode.remove();
                    }
                });
            });
        </script>
        <?php
    }
}

function linkify($value, $protocols = array('http', 'mail'), array $attributes = array())
{
    // Link attributes
    $attr = '';
    foreach ($attributes as $key => $val) {
        $attr = ' ' . $key . '="' . htmlentities($val) . '"';
    }

    $links = array();

    // Extract existing links and tags
    $value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) {
        return '<' . array_push($links, $match[1]) . '>';
    }, $value);

    // Extract text links for each protocol
    foreach ((array) $protocols as $protocol) {
        switch ($protocol) {
            case 'http':
            case 'https':
                $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) {
                    if ($match[1])
                        $protocol = $match[1];
                    $link = $match[2] ?: $match[3];
                    return '<' . array_push($links, "<a $attr href=\"$protocol://$link\">$link</a>") . '>';
                }, $value);
                break;
            case 'mail':
                $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) {
                    return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>';
                }, $value);
                break;
            case 'twitter':
                $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) {
                    return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1] . "\">{$match[0]}</a>") . '>';
                }, $value);
                break;
            default:
                $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) {
                    return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\">{$match[1]}</a>") . '>';
                }, $value);
                break;
        }
    }

    // Insert all link
    return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) {
        return $links[$match[1] - 1];
    }, $value);
}


function clean_instagram_url($url)
{
    // Parseamos la URL
    $parsed_url = parse_url($url);
    // Si no tiene path, devolvemos la original
    if (!isset($parsed_url['path'])) {
        return $url;
    }
    // Dividimos el path
    $segments = explode('/', trim($parsed_url['path'], '/'));
    // Buscamos si el segundo segmento es 'p' o 'reel'
    if (isset($segments[1]) && in_array($segments[0], ['p', 'reel'])) {
        // Ya no hay usuario, devolvemos como está
        $new_path = $segments[0] . '/' . $segments[1];
    } elseif (isset($segments[2]) && in_array($segments[1], ['p', 'reel'])) {
        // El usuario es el primer segmento, lo eliminamos
        $new_path = $segments[1] . '/' . $segments[2];
    } else {
        // Formato inesperado, devolvemos la original
        return $url;
    }
    // Armamos la URL limpia sin parámetros
    $new_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . '/' . $new_path . '/';
    //
    return $new_url;
}


// ------------------------------
// get_dynamic_heading
// ------------------------------
function get_dynamic_heading($title, $heading_tag, $classes = '', $attributes = [])
{
    if (!$title) {
        return '';
    }

    if ($heading_tag && $heading_tag !== 'none') {
        $heading_tag = str_replace('header-', '', $heading_tag);
    } else {
        $heading_tag = null;
    }

    $attr_string = '';
    foreach ($attributes as $key => $value) {
        $attr_string .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
    }

    ob_start();
    ?>
    <?php if ($heading_tag): ?>
        <<?php echo esc_html($heading_tag); ?> class="<?php echo esc_attr($classes); ?>" <?php echo $attr_string; ?>>
            <?php echo esc_html($title); ?>
        </<?php echo esc_html($heading_tag); ?>>
    <?php else: ?>
        <div class="<?php echo esc_attr($classes); ?>" <?php echo $attr_string; ?>>
            <?php echo esc_html($title); ?>
        </div>
    <?php endif; ?>
    <?php
    return ob_get_clean();
}


//-----------------------------------------------//
//--- FRONT-PAGE SIEMPRE PRIMERA EN WP-ADMIN --- //
//
/* add_action('pre_get_posts', function($query) {
    if (!is_admin() || !$query->is_main_query()) return;

    // Solo afecta al listado de páginas
    if ($query->get('post_type') === 'page') {
        $front_page_id = get_option('page_on_front');

        // Cambiamos el orden para que el front page esté primero
        $query->set('orderby', 'post__in');
        $query->set('post__in', array_merge([$front_page_id], get_all_page_ids_except($front_page_id)));
        $query->set('posts_per_page', -1); // opcional, para que no haya paginación
    }
});
//
function get_all_page_ids_except($exclude_id) {
    $pages = get_pages([
        'exclude' => $exclude_id,
        'sort_column' => 'post_title', // o el orden que prefieras
        'post_status' => ['publish', 'draft', 'pending', 'private'] // Incluir todos los estados
    ]);
    return wp_list_pluck($pages, 'ID');
} */
add_action('pre_get_posts', function ($query) {
    if (!is_admin() || !$query->is_main_query())
        return;

    if ($query->get('post_type') === 'page') {
        $front_page_id = get_option('page_on_front');

        // Traemos todas las páginas respetando menu_order
        $pages = get_pages([
            'exclude' => $front_page_id,
            'sort_column' => 'menu_order, post_title',
            'post_status' => ['publish', 'draft', 'pending', 'private']
        ]);

        // Creamos el array de IDs: front-page primero, luego todas las demás
        $ids = array_merge([$front_page_id], wp_list_pluck($pages, 'ID'));

        // Forzamos ese orden
        $query->set('post__in', $ids);
        $query->set('orderby', 'post__in');
        $query->set('posts_per_page', -1); // opcional, sin paginación
    }
});
//
//--- FRONT-PAGE SIEMPRE PRIMERA EN WP-ADMIN --- //
//-----------------------------------------------//



//-----------------------//
//--- CARD FUNCTIONS --- //
//
require_once get_template_directory() . '/includes/cards-functions.php';
//
//--- CARD FUNCTIONS --- //
//-----------------------//

/**
 * @brief Process Data Interactive CSV file and create Data Interactive year posts
 * when Data Interactive page is saved.
 */
add_action('acf/save_post', function ($post_id) {
    if ($post_id !== 'data_interactive') {
        return;
    }

    include 'partials/data-interactive-data-processor.php';

    $csv_filepath = get_field('csv_file', 'data_interactive');

    import_csv_data($csv_filepath, 'data_table', 'data_interactive');
}, 20);


/**
 * @brief Process Data Interactive CSV file and create Data Interactive year posts
 * when Data Interactive page is saved.
 */
add_action('acf/save_post', function ($post_id) {
    if ($post_id !== 'data_interactive') {
        return;
    }

    include_once 'partials/data-interactive-data-processor.php';

    $csv_filepath = get_field('csv_file', 'data_interactive');

    import_csv_data($csv_filepath, 'data_table', 'data_interactive');
}, 20);


//----------------------------------------------------------------------//
//---- hide years-comparison slug from wp-admin data_interactive CPT ---//
add_action('pre_get_posts', function ($query) {
    if (is_admin() && $query->is_main_query() && $query->get('post_type') === 'data_interactive') {

        // Slugs a ocultar
        $hide_slugs = ['years-comparison', 'sources'];

        // Buscar IDs
        $hide_ids = get_posts([
            'post_type' => 'data_interactive',
            'post_name__in' => $hide_slugs,
            'fields' => 'ids',
            'post_status' => 'any',
            'posts_per_page' => -1
        ]);

        if (!empty($hide_ids)) {
            $query->set('post__not_in', $hide_ids);
        }
    }
});
//---- hide years-comparison slug from wp-admin data_interactive CPT ---//
//----------------------------------------------------------------------//


//---------------------------------//
//--- News order by date (DESC) ---//
add_filter('acf/fields/relationship/query/name=featured_news_archive', function ($args, $field, $post_id) {
    // ACF Relationship Query Modification
    $args['orderby'] = 'date';
    $args['order'] = 'DESC';
    return $args;
}, 10, 3);
//--- News order by date (DESC) ---//
//---------------------------------//


// Hook para actualizar el campo meta oculto al guardar un post
add_action('save_post', function ($post_id) {
    // Verificar que no sea un autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Verificar que sea el tipo de post correcto
    if (get_post_type($post_id) !== 'resources') {
        return;
    }

    // Obtener el título del post
    $title = get_the_title($post_id);

    // Decodificar entidades HTML y procesar el título eliminando caracteres especiales
    $processed_title = preg_replace('/^[^a-zA-Z0-9]+/', '', html_entity_decode($title));

    // Guardar el título procesado en un campo meta
    update_post_meta($post_id, 'processed_title', $processed_title);
});

// Script para actualizar el campo meta `processed_title` para todos los posts existentes
add_action('init', function () {
    if (isset($_GET['update_processed_titles']) && $_GET['update_processed_titles'] === '1') {
        $posts = get_posts([
            'post_type' => 'resources',
            'posts_per_page' => -1,
        ]);

        foreach ($posts as $post) {
            $title = get_the_title($post->ID);
            $processed_title = preg_replace('/^[^a-zA-Z0-9]+/', '', $title); // Eliminar caracteres especiales
            update_post_meta($post->ID, 'processed_title', $processed_title);
        }

        echo 'Processed titles updated successfully.';
        exit;
    }
});


// Register and maintain a hidden meta field `search_title` for Resources
add_action('init', function () {
    // Register post meta (hidden from editor UI; not using ACF)
    register_post_meta('resources', 'search_title', [
        'type' => 'string',
        'single' => true,
        'show_in_rest' => false, // keep it internal
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => function () {
            return current_user_can('read'); },
    ]);
});

// Keep `search_title` synchronized with the post title whenever a resource is saved
add_action('save_post_resources', function ($post_id, $post, $update) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if (wp_is_post_revision($post_id))
        return;
    if ($post->post_type !== 'resources')
        return;

    $title = get_the_title($post_id);
    if ($title === '')
        $title = '';

    $current = get_post_meta($post_id, 'search_title', true);
    if ($current !== $title) {
        update_post_meta($post_id, 'search_title', sanitize_text_field($title));
    }
}, 10, 3);


if (!function_exists('hillel_get_subtype_list')) {
    function hillel_get_subtype_list()
    {
        return [
            ['name' => 'all', 'title' => 'All'],
            ['name' => 'social_media_email', 'title' => 'Social Media/Email'],
            ['name' => 'article_publication', 'title' => 'Article/Publication'],
            ['name' => 'hate_speech', 'title' => 'Hate Speech'],
            ['name' => 'vandalism_graffiti', 'title' => 'Vandalism/Graffiti'],
            ['name' => 'physical_harassment', 'title' => 'Harassment'],
            ['name' => 'assault', 'title' => 'Assault'],
            ['name' => 'others', 'title' => 'Other'],
        ];
    }
}

if (!function_exists('get_subtype_title')) {
    function get_subtype_title($name = '')
    {
        foreach (hillel_get_subtype_list() as $subtype) {
            if ($subtype['name'] === $name) {
                return $subtype['title'];
            }
        }
        return null;
    }
}


/* add_filter('wpseo_opengraph_title', function($og_title) {
    if (is_post_type_archive('data_interactive')) {
        return 'Calendario de Clases - Mi Sitio';
    }
    return $og_title;
}); */
add_filter('wpseo_opengraph_title', function ($title) {
    if (is_singular('data_interactive')) {
        $slug = get_post_field('post_name', get_queried_object_id());

        if ($slug === 'years-comparison') {
            return 'Antisemitic Incidents on Campus: Compare up to Three Years';
        } elseif ($slug === 'sources') {
            return 'Antisemitic Incidents on Campus: Sources and Tracking';
        } else {
            return 'Antisemitic Incidents on Campus by Year: ' . get_the_title();
        }
    }

    if (is_post_type_archive('data_interactive')) {
        return 'Antisemitic Incidents on Campus: Interactive Data';
    }

    return $title;
}, 99); // prioridad alta para pisar Yoast


function prevent_orphans($text, $allow_long_word = false, $long_word_min_length = 12)
{
    // Extraer solo el texto plano (sin etiquetas) para análisis
    $plain_text = trim(preg_replace('/\s+/', ' ', strip_tags($text)));
    $words = explode(' ', $plain_text);

    if (count($words) <= 2) {
        return $text; // 1 o 2 palabras no hace nada
    }

    $last_word = end($words);

    // Permitir huérfana larga
    if ($allow_long_word && mb_strlen($last_word) >= $long_word_min_length) {
        return $text;
    }

    /** 
    - \s+   → el último espacio
    - ([^\s<>]+) → la última palabra (sin espacios ni etiquetas)
    - (\s*<\/[^>]+>\s*)* → opcional: etiquetas de cierre después de esa palabra
    */
    return preg_replace('/\s+([^\s<>]+)(\s*<\/[^>]+>\s*)*$/u', '&nbsp;$1$2', $text, 1);
}


//-------------------------------//
//--- NEWS FEATURED (ARCHIVE) ---//
//
require 'partials/news/functions_news.php';
//
//--- NEWS FEATURED (ARCHIVE) ---//
//-------------------------------//

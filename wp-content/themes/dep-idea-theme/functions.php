<?php
add_action( 'after_setup_theme', 'blankslate_setup' );
function blankslate_setup() {
load_theme_textdomain( 'blankslate', get_template_directory() . '/languages' );
add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'responsive-embeds' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'html5', array( 'search-form', 'navigation-widgets' ) );
add_theme_support( 'appearance-tools' );
add_theme_support( 'woocommerce' );
global $content_width;
if ( !isset( $content_width ) ) { $content_width = 1920; }
register_nav_menus( array( 'main-menu' => esc_html__( 'Main Menu', 'blankslate' ) ) );
}
add_action( 'admin_notices', 'blankslate_notice' );
function blankslate_notice() {
$user_id = get_current_user_id();
$admin_url = ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http' ) . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$param = ( count( $_GET ) ) ? '&' : '?';
if ( !get_user_meta( $user_id, 'blankslate_notice_dismissed_11' ) && current_user_can( 'manage_options' ) )
echo '<div class="notice notice-info"><p><a href="' . esc_url( $admin_url ), esc_html( $param ) . 'dismiss" class="alignright" style="text-decoration:none"><big>' . esc_html__( 'Ⓧ', 'blankslate' ) . '</big></a>' . wp_kses_post( __( '<big><strong>🏆 Thank you for using BlankSlate!</strong></big>', 'blankslate' ) ) . '<p>' . esc_html__( 'Powering over 10k websites! Buy me a sandwich! 🥪', 'blankslate' ) . '</p><a href="https://github.com/bhadaway/blankslate/issues/57" class="button-primary" target="_blank"><strong>' . esc_html__( 'How do you use BlankSlate?', 'blankslate' ) . '</strong></a> <a href="https://opencollective.com/blankslate" class="button-primary" style="background-color:green;border-color:green" target="_blank"><strong>' . esc_html__( 'Donate', 'blankslate' ) . '</strong></a> <a href="https://wordpress.org/support/theme/blankslate/reviews/#new-post" class="button-primary" style="background-color:purple;border-color:purple" target="_blank"><strong>' . esc_html__( 'Review', 'blankslate' ) . '</strong></a> <a href="https://github.com/bhadaway/blankslate/issues" class="button-primary" style="background-color:orange;border-color:orange" target="_blank"><strong>' . esc_html__( 'Support', 'blankslate' ) . '</strong></a></p></div>';
}
add_action( 'admin_init', 'blankslate_notice_dismissed' );
function blankslate_notice_dismissed() {
$user_id = get_current_user_id();
if ( isset( $_GET['dismiss'] ) )
add_user_meta( $user_id, 'blankslate_notice_dismissed_11', 'true', true );
}
add_action( 'wp_enqueue_scripts', 'blankslate_enqueue' );
function blankslate_enqueue() {
wp_enqueue_style( 'blankslate-style', get_stylesheet_uri() );
wp_enqueue_script( 'jquery' );
}
add_action( 'wp_footer', 'blankslate_footer' );
function blankslate_footer() {
?>
<script>
jQuery(document).ready(function($) {
var deviceAgent = navigator.userAgent.toLowerCase();
if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
$("html").addClass("ios");
$("html").addClass("mobile");
}
if (deviceAgent.match(/(Android)/)) {
$("html").addClass("android");
$("html").addClass("mobile");
}
if (navigator.userAgent.search("MSIE") >= 0) {
$("html").addClass("ie");
}
else if (navigator.userAgent.search("Chrome") >= 0) {
$("html").addClass("chrome");
}
else if (navigator.userAgent.search("Firefox") >= 0) {
$("html").addClass("firefox");
}
else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
$("html").addClass("safari");
}
else if (navigator.userAgent.search("Opera") >= 0) {
$("html").addClass("opera");
}
});
</script>
<?php
}
add_filter( 'document_title_separator', 'blankslate_document_title_separator' );
function blankslate_document_title_separator( $sep ) {
$sep = esc_html( '|' );
return $sep;
}
add_filter( 'the_title', 'blankslate_title' );
function blankslate_title( $title ) {
if ( $title == '' ) {
return esc_html( '...' );
} else {
return wp_kses_post( $title );
}
}
function blankslate_schema_type() {
$schema = 'https://schema.org/';
if ( is_single() ) {
$type = "Article";
} elseif ( is_author() ) {
$type = 'ProfilePage';
} elseif ( is_search() ) {
$type = 'SearchResultsPage';
} else {
$type = 'WebPage';
}
echo 'itemscope itemtype="' . esc_url( $schema ) . esc_attr( $type ) . '"';
}
add_filter( 'nav_menu_link_attributes', 'blankslate_schema_url', 10 );
function blankslate_schema_url( $atts ) {
$atts['itemprop'] = 'url';
return $atts;
}
if ( !function_exists( 'blankslate_wp_body_open' ) ) {
function blankslate_wp_body_open() {
do_action( 'wp_body_open' );
}
}
add_action( 'wp_body_open', 'blankslate_skip_link', 5 );
function blankslate_skip_link() {
echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__( 'Skip to the content', 'blankslate' ) . '</a>';
}
add_filter( 'the_content_more_link', 'blankslate_read_more_link' );
function blankslate_read_more_link() {
if ( !is_admin() ) {
return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . sprintf( __( '...%s', 'blankslate' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
}
}
add_filter( 'excerpt_more', 'blankslate_excerpt_read_more_link' );
function blankslate_excerpt_read_more_link( $more ) {
if ( !is_admin() ) {
global $post;
return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">' . sprintf( __( '...%s', 'blankslate' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
}
}
add_filter( 'big_image_size_threshold', '__return_false' );
add_filter( 'intermediate_image_sizes_advanced', 'blankslate_image_insert_override' );
function blankslate_image_insert_override( $sizes ) {
unset( $sizes['medium_large'] );
unset( $sizes['1536x1536'] );
unset( $sizes['2048x2048'] );
return $sizes;
}
add_action( 'widgets_init', 'blankslate_widgets_init' );
function blankslate_widgets_init() {
register_sidebar( array(
'name' => esc_html__( 'Sidebar Widget Area', 'blankslate' ),
'id' => 'primary-widget-area',
'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
'after_widget' => '</li>',
'before_title' => '<h3 class="widget-title">',
'after_title' => '</h3>',
) );
}
add_action( 'wp_head', 'blankslate_pingback_header' );
function blankslate_pingback_header() {
if ( is_singular() && pings_open() ) {
printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
}
}
add_action( 'comment_form_before', 'blankslate_enqueue_comment_reply_script' );
function blankslate_enqueue_comment_reply_script() {
if ( get_option( 'thread_comments' ) ) {
wp_enqueue_script( 'comment-reply' );
}
}
function blankslate_custom_pings( $comment ) {
?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url( comment_author_link() ); ?></li>
<?php
}
add_filter( 'get_comments_number', 'blankslate_comment_count', 0 );
function blankslate_comment_count( $count ) {
    if ( !is_admin() ) {
        global $id;
        $get_comments = get_comments( 'status=approve&post_id=' . $id );
        $comments_by_type = separate_comments( $get_comments );
        return count( $comments_by_type['comment'] );
    } else {
        return $count;
    }
}
function sw_add_bootstrap5() {

    wp_register_style( 'sw-bootstrap-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    wp_register_script( 'sw-bootstrap-script', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), '5.3.3', true);

    wp_enqueue_style('sw-bootstrap-style');
    wp_enqueue_script('sw-bootstrap-script'); 
}
add_action( 'wp_enqueue_scripts', 'sw_add_bootstrap5');

function sw_add_custom_styles(){
    wp_enqueue_style( 'dashboard-style', get_template_directory_uri() . '/css/dashboard-style.css', array(), filemtime(get_template_directory() . '/css/dashboard-style.css'), false);
}
add_action( 'wp_enqueue_scripts', 'sw_add_custom_styles');


function register_menus() { 
    register_nav_menu('sidebar-menu',__('Sidebar Menu')); 
} 
add_action('init', 'register_menus');

function add_menu_title( $item_output, $item, $depth, $args ) {
    global $menuTitle;
    $menuTitle = $item->title;
    $menuTitle = strtok($menuTitle, " ");
    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'add_menu_title', 10, 4);

if ( !class_exists('Sidebar_Walker') ) {
    class Sidebar_Walker extends Walker {
        var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
        var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

        function start_lvl(&$output, $depth=0, $args = []) {
            global $menuTitle;
            global $page_is_active;
            if ($depth == 0) {
                $indent = str_repeat("\t", $depth);
                $output .= "<div class=\"collapse\" id=\"".$menuTitle."-collapse\">\n";
                $output .= "<ul class=\"btn-toggle-nav list-unstyled fw-normal pb-1 small\">\n";
            }
        }

        function end_lvl(&$output, $depth=0, $args = []) {
            if ($depth == 0) {
                $indent = str_repeat("\t", $depth);
                $output .= "$indent</ul>\n";
                $output .= "$indent</div>\n";
                $output .= "$indent</li>\n";
            }
        }

        function start_el(&$output, $data_object, $depth = 0, $args = [], $current_object_id = 0) {
            $is_active = in_array("current_page_item",$data_object->classes);
            $active_attr = $is_active ? ' active_sidebar_menu' : '';
            $value = '';
            $classes = empty( $data_object->classes ) ? array() : (array) $data_object->classes;
            $classes = in_array( 'current-menu-item', $classes ) ? array( 'current-menu-item' ) : array();
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $data_object, $args ) );
            $class_names = strlen( trim( $class_names ) ) > 0 ? ' class="' . esc_attr( $class_names ) . '"' : '';
            $id = apply_filters( 'nav_menu_item_id', '', $data_object, $args );
            $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
            if ($depth != 0) {

                if($is_active){
                    $attributes = ! empty( $data_object->url )        ? ' href="#"' : '';
                } else {
                    $attributes = ! empty( $data_object->url )        ? ' href="'   . esc_attr( $data_object->url        ) .'"' : '';
                }
                $attributes .= ' class="d-inline-flex text-decoration-none rounded text-white pe-auto item-button"';
                $data_object_output = $args->before;
                $data_object_output .= '<li class="'.$active_attr.'">';
                $data_object_output .= '<a'. $attributes . $id . $value . $class_names . '>';
                $data_object_output .= $args->link_before . apply_filters( 'the_title', $data_object->title, $data_object->ID ) . $args->link_after;
                $data_object_output .= "</a>\n";
                $data_object_output .= "</li>\n";
                $data_object_output .= $args->after;
            } else {
                
                $tokTitle = strtok($data_object->title, " ");
                $attributes = ' class="btn btn-toggle d-inline-flex align-items-center rounded rounded-0 border-0 collapsed text-white category-button"';
                $attributes .= ' data-bs-toggle="collapse"';
                $attributes .= ' data-bs-target="#'.$tokTitle.'-collapse"';
                $attributes .= ' aria-expanded="false"';
                $data_object_output = $args->before;
                $data_object_output .= '<li class="mb-1"><button'. $attributes . $id . $value . $class_names . '>';
                $data_object_output .= $args->link_before . apply_filters( 'the_title', $data_object->title, $data_object->ID ) . $args->link_after;
                $data_object_output .= "</button>\n";
                $data_object_output .= $args->after;
            }
            $output .= apply_filters( 'walker_nav_menu_start_el', $data_object_output, $data_object, $depth, $args );
        }
    }
}

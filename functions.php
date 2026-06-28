<?php
/**
 * HealthFlowRCM Theme Functions
 */

if (!defined('ABSPATH')) exit;

define('HFRCM_VERSION', '1.0.0');
define('HFRCM_DIR', get_template_directory());
define('HFRCM_URI', get_template_directory_uri());

/* ── Theme Setup ─────────────────────────────────── */
function hfrcm_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 48,
        'width'       => 160,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array('search-form','comment-form','comment-list','gallery','caption','style','script'));
    add_theme_support('automatic-feed-links');
    add_theme_support('wp-block-styles');
    add_theme_support('responsive-embeds');

    register_nav_menus(array(
        'primary' => __('Primary Navigation', 'healthflowrcm'),
    ));
}
add_action('after_setup_theme', 'hfrcm_setup');

/* ── Enqueue Assets ──────────────────────────────── */
function hfrcm_scripts() {
    wp_enqueue_style('hfrcm-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap', array(), null);
    wp_enqueue_style('hfrcm-theme', HFRCM_URI . '/assets/css/theme.css', array(), HFRCM_VERSION);
    wp_enqueue_style('hfrcm-style', get_stylesheet_uri(), array(), HFRCM_VERSION);
    wp_enqueue_script('hfrcm-main', HFRCM_URI . '/assets/js/main.js', array(), HFRCM_VERSION, true);

    // Enqueue services JS on services page (both template and Elementor built)
    $page = get_page_by_path('services');
    $is_services = is_page_template('page-templates/template-services.php') ||
                   ( $page && is_page($page->ID) );
    if ($is_services) {
        wp_enqueue_script('hfrcm-services', HFRCM_URI . '/assets/js/services.js', array(), HFRCM_VERSION, true);
    }
}
add_action('wp_enqueue_scripts', 'hfrcm_scripts');

/* ── Helper: get page URL by slug ────────────────── */
function hfrcm_url($slug) {
    $page = get_page_by_path($slug);
    return $page ? get_permalink($page) : home_url('/' . $slug . '/');
}

/* ── Custom Nav Walker (adds nav-cta class to last item) */
class HFRCM_Nav_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $is_cta = in_array('menu-item-cta', $classes) || in_array('nav-cta', $classes);

        $atts = array(
            'href'  => !empty($item->url) ? $item->url : '',
            'class' => $is_cta ? 'nav-cta' : '',
        );
        if (in_array('current-menu-item', $classes) || in_array('current_page_item', $classes)) {
            $atts['class'] .= ($atts['class'] ? ' ' : '') . 'active';
        }
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $attributes .= ' ' . $attr . '="' . esc_attr(trim($value)) . '"';
            }
        }
        $output .= '<a' . $attributes . '>' . esc_html($item->title) . '</a>';
    }
    function end_el(&$output, $item, $depth = 0, $args = null) {}
    function start_lvl(&$output, $depth = 0, $args = null) {}
    function end_lvl(&$output, $depth = 0, $args = null) {}
}

/* ── Fallback menu ───────────────────────────────── */
function hfrcm_fallback_menu() {
    echo '<a href="' . esc_url(home_url('/')) . '" class="active">Home</a>';
    echo '<a href="' . esc_url(hfrcm_url('about-us')) . '">About</a>';
    echo '<a href="' . esc_url(hfrcm_url('services')) . '">Services</a>';
    echo '<a href="' . esc_url(hfrcm_url('book-a-consultation')) . '" class="nav-cta">Book a Consultation</a>';
}

/* ── Elementor Support ───────────────────────────── */
// add_theme_support('elementor') must run regardless of plugin load order
function hfrcm_elementor_support() {
    add_theme_support( 'elementor' );
}
add_action( 'after_setup_theme',           'hfrcm_elementor_support', 20 );
add_action( 'elementor/loaded',            'hfrcm_elementor_support' );

/* ── Register Custom Elementor Category ─────────── */
function hfrcm_register_elementor_category( $manager ) {
    $manager->add_category( 'healthflowrcm', [
        'title' => 'HealthFlowRCM',
        'icon'  => 'fa fa-heartbeat',
    ] );
}
add_action( 'elementor/elements/categories_registered', 'hfrcm_register_elementor_category' );

/* ── Register Elementor Locations ────────────────── */
function hfrcm_register_elementor_locations( $manager ) {
    $manager->register_all_core_locations();
}
add_action( 'elementor/theme/register_locations', 'hfrcm_register_elementor_locations' );

/*
 * ── Register Custom Elementor Widgets ────────────
 *
 * ROOT CAUSE FIX:
 * 'elementor/loaded' fires during plugins_loaded — BEFORE the theme's
 * functions.php is even included. So any add_action() for that hook
 * registered inside functions.php never runs.
 *
 * 'elementor/widgets/register' fires during WordPress 'init' (priority 0)
 * which is AFTER the theme has loaded. This is the correct hook.
 */
add_action( 'elementor/widgets/register', 'hfrcm_register_all_widgets' );

function hfrcm_register_all_widgets( $widgets_manager ) {
    if ( ! class_exists( '\Elementor\Widget_Base' ) ) return;

    $dir   = HFRCM_DIR . '/inc/widgets/';
    $files = [
        'widget-hero', 'widget-stats-bar', 'widget-why-us',
        'widget-services-grid', 'widget-free-audit-cta', 'widget-specialties',
        'widget-process', 'widget-cta-banner', 'widget-page-hero',
        'widget-about-story', 'widget-mission-vision', 'widget-guarantee',
        'widget-team', 'widget-testimonials', 'widget-services-panel',
        'widget-contact-form',
    ];
    foreach ( $files as $f ) {
        $path = $dir . $f . '.php';
        if ( file_exists( $path ) ) require_once $path;
    }

    $classes = [
        'HFRCM_Widget_Hero',         'HFRCM_Widget_Stats_Bar',    'HFRCM_Widget_Why_Us',
        'HFRCM_Widget_Services_Grid','HFRCM_Widget_Free_Audit_CTA','HFRCM_Widget_Specialties',
        'HFRCM_Widget_Process',      'HFRCM_Widget_CTA_Banner',   'HFRCM_Widget_Page_Hero',
        'HFRCM_Widget_About_Story',  'HFRCM_Widget_Mission_Vision','HFRCM_Widget_Guarantee',
        'HFRCM_Widget_Team',         'HFRCM_Widget_Testimonials', 'HFRCM_Widget_Services_Panel',
        'HFRCM_Widget_Contact_Form',
    ];
    foreach ( $classes as $class ) {
        if ( class_exists( $class ) ) {
            $widgets_manager->register( new $class() );
        }
    }
}

/* ── Admin: Recommend Elementor Plugin ───────────── */
function hfrcm_admin_notice_elementor() {
    if (!current_user_can('install_plugins')) return;
    if (defined('ELEMENTOR_VERSION')) return;
    $install_url = wp_nonce_url(
        add_query_arg(array('action' => 'install-plugin', 'plugin' => 'elementor'), admin_url('update.php')),
        'install-plugin_elementor'
    );
    echo '<div class="notice notice-info is-dismissible">';
    echo '<p><strong>HealthFlowRCM Theme:</strong> Install <a href="' . esc_url($install_url) . '">Elementor Page Builder</a> to visually edit all pages with drag and drop.</p>';
    echo '</div>';
}
add_action('admin_notices', 'hfrcm_admin_notice_elementor');

/* ── Demo Import on Theme Activation ─────────────── */
require_once HFRCM_DIR . '/inc/demo-import.php';

/* ── Widget Areas (optional) ─────────────────────── */
function hfrcm_widgets_init() {
    register_sidebar(array(
        'name'          => 'Footer Sidebar',
        'id'            => 'footer-sidebar',
        'before_widget' => '<div class="footer-widget">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="footer-heading">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'hfrcm_widgets_init');

/* ── Remove Emoji Scripts (performance) ──────────── */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/* ── Add body classes ────────────────────────────── */
function hfrcm_body_class($classes) {
    if (is_page_template('page-templates/template-home.php') || is_front_page()) {
        $classes[] = 'page-home';
    }
    return $classes;
}
add_filter('body_class', 'hfrcm_body_class');

/* ── Contact Form Handler ────────────────────────── */
function hfrcm_handle_contact_form() {
    if (!isset($_POST['hfrcm_nonce']) || !wp_verify_nonce($_POST['hfrcm_nonce'], 'hfrcm_contact_nonce')) {
        wp_die('Invalid request.');
    }

    $first   = sanitize_text_field($_POST['first_name'] ?? '');
    $last    = sanitize_text_field($_POST['last_name'] ?? '');
    $email   = sanitize_email($_POST['email'] ?? '');
    $phone   = sanitize_text_field($_POST['phone'] ?? '');
    $practice= sanitize_text_field($_POST['practice'] ?? '');
    $specialty=sanitize_text_field($_POST['specialty'] ?? '');
    $service = sanitize_text_field($_POST['service'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    $to      = get_option('admin_email');
    $subject = 'New Consultation Request from ' . $first . ' ' . $last;
    $body    = "Name: $first $last\nEmail: $email\nPhone: $phone\nPractice: $practice\nSpecialty: $specialty\nService: $service\n\nMessage:\n$message";
    $headers = array('Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $email);

    wp_mail($to, $subject, $body, $headers);

    $redirect = hfrcm_url('book-a-consultation') . '?submitted=1';
    wp_safe_redirect($redirect);
    exit;
}
add_action('admin_post_hfrcm_contact', 'hfrcm_handle_contact_form');
add_action('admin_post_nopriv_hfrcm_contact', 'hfrcm_handle_contact_form');

/* ── Customizer: Header & Footer Controls ────────── */
function hfrcm_customizer_register( $wp_customize ) {

    /* === Header Settings === */
    $wp_customize->add_section( 'hfrcm_header_section', array(
        'title'    => __( 'Header Settings', 'healthflowrcm' ),
        'priority' => 30,
    ) );

    // Announcement bar toggle
    $wp_customize->add_setting( 'hfrcm_show_announcement', array( 'default' => true, 'sanitize_callback' => 'wp_validate_boolean' ) );
    $wp_customize->add_control( 'hfrcm_show_announcement', array(
        'label'   => 'Show Announcement Bar',
        'section' => 'hfrcm_header_section',
        'type'    => 'checkbox',
    ) );

    // Announcement text
    $wp_customize->add_setting( 'hfrcm_announcement_text', array( 'default' => 'Limited Offer: Get a FREE 90-Day RCM Audit for Your Practice', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'hfrcm_announcement_text', array(
        'label'   => 'Announcement Bar Text',
        'section' => 'hfrcm_header_section',
        'type'    => 'text',
    ) );

    // Announcement button text
    $wp_customize->add_setting( 'hfrcm_announcement_btn', array( 'default' => 'Claim Now', 'sanitize_callback' => 'sanitize_text_field' ) );
    $wp_customize->add_control( 'hfrcm_announcement_btn', array(
        'label'   => 'Announcement Button Text',
        'section' => 'hfrcm_header_section',
        'type'    => 'text',
    ) );

    // Announcement link
    $wp_customize->add_setting( 'hfrcm_announcement_link', array( 'default' => '', 'sanitize_callback' => 'esc_url_raw' ) );
    $wp_customize->add_control( 'hfrcm_announcement_link', array(
        'label'       => 'Announcement Button Link (leave blank for Book a Consultation)',
        'section'     => 'hfrcm_header_section',
        'type'        => 'url',
    ) );

    /* === Footer Settings === */
    $wp_customize->add_section( 'hfrcm_footer_section', array(
        'title'    => __( 'Footer Settings', 'healthflowrcm' ),
        'priority' => 31,
    ) );

    $footer_fields = array(
        'hfrcm_footer_tagline'    => array( 'label' => 'Footer Tagline Text',   'default' => 'HealthFlowRCM is a premier healthcare financial services company specializing in revenue cycle management solutions for providers of all sizes across the United States.' ),
        'hfrcm_footer_phone'      => array( 'label' => 'Phone Number',          'default' => '+1 (406) 235-6348' ),
        'hfrcm_footer_phone_link' => array( 'label' => 'Phone Link (tel:…)',    'default' => 'tel:+14062356348' ),
        'hfrcm_footer_email'      => array( 'label' => 'Email Address',         'default' => 'Healthflowrcmllc@gmail.com' ),
        'hfrcm_footer_address'    => array( 'label' => 'Physical Address',      'default' => '1001 S Main St, STE 500, Kalispell, MT 59901, USA' ),
        'hfrcm_footer_copyright'  => array( 'label' => 'Copyright Text',        'default' => '&copy; ' . date('Y') . ' HealthFlowRCM. All Rights Reserved.' ),
    );

    foreach ( $footer_fields as $key => $args ) {
        $wp_customize->add_setting( $key, array( 'default' => $args['default'], 'sanitize_callback' => 'wp_kses_post' ) );
        $wp_customize->add_control( $key, array(
            'label'   => $args['label'],
            'section' => 'hfrcm_footer_section',
            'type'    => 'text',
        ) );
    }

    /* === Social Media === */
    $wp_customize->add_section( 'hfrcm_social_section', array(
        'title'    => __( 'Social Media Links', 'healthflowrcm' ),
        'priority' => 32,
    ) );

    $social_fields = array(
        'hfrcm_social_facebook' => 'Facebook URL',
        'hfrcm_social_linkedin' => 'LinkedIn URL',
        'hfrcm_social_twitter'  => 'Twitter / X URL',
    );

    foreach ( $social_fields as $key => $label ) {
        $wp_customize->add_setting( $key, array( 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ) );
        $wp_customize->add_control( $key, array(
            'label'   => $label,
            'section' => 'hfrcm_social_section',
            'type'    => 'url',
        ) );
    }
}
add_action( 'customize_register', 'hfrcm_customizer_register' );

/* ── Set Elementor canvas template for all pages ─── */
function hfrcm_set_elementor_page_settings() {
    // Make sure Elementor is active
    if ( ! defined( 'ELEMENTOR_VERSION' ) ) return;

    // Enable Elementor for pages
    $cpt_support = get_option( 'elementor_cpt_support', array( 'page', 'post' ) );
    if ( ! in_array( 'page', $cpt_support ) ) {
        $cpt_support[] = 'page';
        update_option( 'elementor_cpt_support', $cpt_support );
    }
}
add_action( 'init', 'hfrcm_set_elementor_page_settings' );


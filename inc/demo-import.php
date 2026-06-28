<?php
/**
 * HealthFlowRCM Demo Import
 *
 * Creates / repairs 4 pages pre-loaded with HFRCM Elementor widgets.
 * Auto-detects missing or empty Elementor data on every admin_init and re-injects.
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ────────────────────────────────────────────────────────────
 *  Build one Elementor section wrapping a single custom widget
 * ──────────────────────────────────────────────────────────── */
function hfrcm_el_section( $widget_type, $widget_settings = array() ) {
    static $counter = 0;
    $counter++;
    return array(
        'id'       => 'hfrcm_s' . $counter,
        'elType'   => 'section',
        'settings' => array(
            'layout'  => 'full_width',
            'gap'     => 'no',
            'padding' => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ),
        ),
        'elements' => array( array(
            'id'       => 'hfrcm_c' . $counter,
            'elType'   => 'column',
            'settings' => array(
                '_column_size' => 100,
                '_inline_size' => null,
                'padding'      => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ),
            ),
            'elements' => array( array(
                'id'         => 'hfrcm_w' . $counter,
                'elType'     => 'widget',
                'widgetType' => $widget_type,
                'settings'   => empty( $widget_settings ) ? new stdClass() : $widget_settings,
                'elements'   => array(),
            ) ),
        ) ),
        'isInner' => false,
    );
}

/* ────────────────────────────────────────────────────────────
 *  Page definitions
 * ──────────────────────────────────────────────────────────── */
function hfrcm_page_definitions() {
    return array(

        'home' => array(
            'title'   => 'Home',
            'widgets' => array(
                array( 'hfrcm_hero',           array() ),
                array( 'hfrcm_stats_bar',      array() ),
                array( 'hfrcm_why_us',         array() ),
                array( 'hfrcm_services_grid',  array() ),
                array( 'hfrcm_free_audit_cta', array() ),
                array( 'hfrcm_specialties',    array() ),
                array( 'hfrcm_process',        array() ),
                array( 'hfrcm_cta_banner',     array() ),
            ),
        ),

        'about-us' => array(
            'title'   => 'About Us',
            'widgets' => array(
                array( 'hfrcm_page_hero', array(
                    'label_text'  => 'About Us',
                    'title'       => 'The Team Behind Your Revenue Growth',
                    'description' => 'HealthFlowRCM is a premier healthcare financial services company specializing in revenue cycle management solutions for providers of all sizes.',
                ) ),
                array( 'hfrcm_about_story',    array() ),
                array( 'hfrcm_mission_vision', array() ),
                array( 'hfrcm_guarantee',      array() ),
                array( 'hfrcm_team',           array() ),
                array( 'hfrcm_testimonials',   array() ),
                array( 'hfrcm_cta_banner', array(
                    'title'       => 'Partner with a Team That Cares About Your Growth',
                    'description' => 'Get your free 90-day RCM audit and see the difference.',
                    'btn1_text'   => 'Book a Free Consultation',
                ) ),
            ),
        ),

        'services' => array(
            'title'   => 'Services',
            'widgets' => array(
                array( 'hfrcm_page_hero', array(
                    'label_text'  => 'Our Services',
                    'title'       => 'End-to-End Revenue Cycle Management Solutions',
                    'description' => 'We handle every aspect of the revenue cycle so your team can focus on patient care.',
                ) ),
                array( 'hfrcm_services_panel', array() ),
                array( 'hfrcm_cta_banner', array(
                    'title'       => 'Need a Custom RCM Solution?',
                    'description' => 'Let us build a tailored revenue cycle strategy for your practice.',
                    'btn1_text'   => 'Book a Free Consultation',
                ) ),
            ),
        ),

        'book-a-consultation' => array(
            'title'   => 'Book a Consultation',
            'widgets' => array(
                array( 'hfrcm_page_hero', array(
                    'label_text'  => 'Get Started',
                    'title'       => 'Book Your Free RCM Consultation',
                    'description' => 'Fill out the form and our RCM experts will reach out within 24 hours.',
                ) ),
                array( 'hfrcm_contact_form', array() ),
                array( 'hfrcm_stats_bar', array() ),
            ),
        ),
    );
}

/* ────────────────────────────────────────────────────────────
 *  Inject Elementor widget data into a page
 * ──────────────────────────────────────────────────────────── */
function hfrcm_inject_elementor( $post_id, $widget_list ) {
    $sections = array();
    foreach ( $widget_list as $entry ) {
        $sections[] = hfrcm_el_section( $entry[0], $entry[1] );
    }

    $json = wp_json_encode( $sections );

    // WordPress requires slashes on meta values that contain special chars
    update_post_meta( $post_id, '_elementor_data',          wp_slash( $json ) );
    update_post_meta( $post_id, '_elementor_edit_mode',     'builder' );
    update_post_meta( $post_id, '_elementor_template_type', 'wp-page' );
    update_post_meta( $post_id, '_elementor_version',       defined( 'ELEMENTOR_VERSION' ) ? ELEMENTOR_VERSION : '3.0.0' );

    // Clear Elementor's CSS cache for this post
    if ( function_exists( 'Elementor\Plugin' ) && isset( Elementor\Plugin::$instance->files_manager ) ) {
        Elementor\Plugin::$instance->files_manager->clear_cache();
    }
    delete_post_meta( $post_id, '_elementor_css' );
}

/* ────────────────────────────────────────────────────────────
 *  Check if a page has real Elementor widget data
 * ──────────────────────────────────────────────────────────── */
function hfrcm_page_has_data( $post_id ) {
    $data = get_post_meta( $post_id, '_elementor_data', true );
    return ! empty( $data ) && strlen( trim( $data ) ) > 100;
}

/* ────────────────────────────────────────────────────────────
 *  Main import / repair function
 * ──────────────────────────────────────────────────────────── */
function hfrcm_demo_import( $force = false ) {
    $defs     = hfrcm_page_definitions();
    $page_ids = array();

    foreach ( $defs as $slug => $def ) {
        $existing = get_page_by_path( $slug );

        /* —— Create page if missing —— */
        if ( ! $existing || $existing->post_status !== 'publish' ) {
            if ( $existing ) wp_delete_post( $existing->ID, true );

            // Also clear trash / drafts
            foreach ( get_posts( array(
                'post_type'   => 'page',
                'name'        => $slug,
                'post_status' => array( 'trash', 'draft', 'private' ),
                'numberposts' => 5,
            ) ) as $t ) {
                wp_delete_post( $t->ID, true );
            }

            $id = wp_insert_post( array(
                'post_title'   => $def['title'],
                'post_name'    => $slug,
                'post_content' => '',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_author'  => get_current_user_id() ?: 1,
            ) );

            if ( is_wp_error( $id ) ) continue;
            update_post_meta( $id, '_wp_page_template', 'default' );
            $page_ids[ $slug ] = $id;
            hfrcm_inject_elementor( $id, $def['widgets'] );

        } else {
            $page_ids[ $slug ] = $existing->ID;

            /* —— Re-inject if page has no / empty Elementor data —— */
            if ( $force || ! hfrcm_page_has_data( $existing->ID ) ) {
                hfrcm_inject_elementor( $existing->ID, $def['widgets'] );
            }
        }
    }

    /* —— Front page —— */
    if ( isset( $page_ids['home'] ) ) {
        update_option( 'show_on_front', 'page' );
        update_option( 'page_on_front', $page_ids['home'] );
    }

    /* —— Navigation menu —— */
    $menu_name = 'Primary Navigation';
    $old_menu  = wp_get_nav_menu_object( $menu_name );
    if ( $old_menu ) wp_delete_nav_menu( $old_menu->term_id );

    $menu_id = wp_create_nav_menu( $menu_name );
    if ( ! is_wp_error( $menu_id ) ) {
        $order = 1;
        foreach ( array(
            'home'               => 'Home',
            'about-us'           => 'About Us',
            'services'           => 'Services',
            'book-a-consultation' => 'Book a Consultation',
        ) as $s => $t ) {
            if ( ! isset( $page_ids[ $s ] ) ) continue;
            $item_args = array(
                'menu-item-title'     => $t,
                'menu-item-object'    => 'page',
                'menu-item-object-id' => $page_ids[ $s ],
                'menu-item-type'      => 'post_type',
                'menu-item-status'    => 'publish',
                'menu-item-position'  => $order++,
            );
            if ( $s === 'book-a-consultation' ) $item_args['menu-item-classes'] = 'nav-cta';
            wp_update_nav_menu_item( $menu_id, 0, $item_args );
        }
        $locs           = get_theme_mod( 'nav_menu_locations', array() );
        $locs['primary'] = $menu_id;
        set_theme_mod( 'nav_menu_locations', $locs );
    }

    hfrcm_import_logo();

    if ( get_option( 'permalink_structure' ) === '' ) {
        update_option( 'permalink_structure', '/%postname%/' );
        flush_rewrite_rules();
    }

    update_option( 'hfrcm_demo_imported', time() );
}

/* Run on theme activation */
add_action( 'after_switch_theme', 'hfrcm_demo_import' );

/* ────────────────────────────────────────────────────────────
 *  Auto-repair on admin_init:
 *  If any page is missing Elementor data, re-inject everything.
 * ──────────────────────────────────────────────────────────── */
add_action( 'admin_init', 'hfrcm_maybe_repair_pages' );

function hfrcm_maybe_repair_pages() {
    if ( ! current_user_can( 'manage_options' ) ) return;
    if ( get_transient( 'hfrcm_repair_check' ) ) return; // throttle to once per 60 s

    set_transient( 'hfrcm_repair_check', 1, 60 );

    $defs       = hfrcm_page_definitions();
    $needs_work = false;

    foreach ( $defs as $slug => $def ) {
        $page = get_page_by_path( $slug );
        if ( ! $page || $page->post_status !== 'publish' ) {
            $needs_work = true; break;
        }
        if ( ! hfrcm_page_has_data( $page->ID ) ) {
            $needs_work = true; break;
        }
    }

    if ( $needs_work ) {
        hfrcm_demo_import(); // repair silently
    }
}

/* ────────────────────────────────────────────────────────────
 *  Manual "Rebuild Pages" admin action
 *  Visit: /wp-admin/admin-post.php?action=hfrcm_rebuild
 * ──────────────────────────────────────────────────────────── */
add_action( 'admin_post_hfrcm_rebuild', 'hfrcm_handle_rebuild' );

function hfrcm_handle_rebuild() {
    if ( ! current_user_can( 'manage_options' ) ) wp_die( 'Forbidden' );
    check_admin_referer( 'hfrcm_rebuild' );
    delete_transient( 'hfrcm_repair_check' );
    hfrcm_demo_import( true ); // force re-inject even if pages have data
    wp_redirect( admin_url( 'themes.php?hfrcm_rebuilt=1' ) );
    exit;
}

/* ────────────────────────────────────────────────────────────
 *  Admin notices
 * ──────────────────────────────────────────────────────────── */
add_action( 'admin_notices', 'hfrcm_admin_notices' );

function hfrcm_admin_notices() {
    if ( ! current_user_can( 'manage_options' ) ) return;

    /* Success rebuild notice */
    if ( isset( $_GET['hfrcm_rebuilt'] ) ) {
        echo '<div class="notice notice-success is-dismissible"><p>';
        echo '<strong>HealthFlowRCM:</strong> Pages rebuilt successfully with Elementor widgets! ';
        echo '<a href="' . esc_url( home_url( '/' ) ) . '" target="_blank">View site &rarr;</a>';
        echo '</p></div>';
        return;
    }

    /* Elementor not installed */
    if ( ! defined( 'ELEMENTOR_VERSION' ) ) {
        $url = wp_nonce_url( add_query_arg( array( 'action' => 'install-plugin', 'plugin' => 'elementor' ), admin_url( 'update.php' ) ), 'install-plugin_elementor' );
        echo '<div class="notice notice-warning is-dismissible"><p>';
        echo '<strong>HealthFlowRCM:</strong> <a href="' . esc_url( $url ) . '">Install Elementor</a> to edit your pages visually.';
        echo '</p></div>';
        return;
    }

    /* Rebuild button — always visible so the user can re-inject at any time */
    $rebuild_url = wp_nonce_url( admin_url( 'admin-post.php?action=hfrcm_rebuild' ), 'hfrcm_rebuild' );
    echo '<div class="notice notice-info is-dismissible"><p>';
    echo '<strong>HealthFlowRCM Theme Active</strong> &mdash; ';
    echo '<a href="' . esc_url( $rebuild_url ) . '" style="font-weight:600;">&#x21BA; Rebuild all pages with Elementor widgets</a>';
    echo ' (use this if pages appear empty).';
    echo '</p></div>';
}

/* ────────────────────────────────────────────────────────────
 *  Logo import
 * ──────────────────────────────────────────────────────────── */
function hfrcm_import_logo() {
    if ( get_theme_mod( 'custom_logo' ) ) return;
    $path = HFRCM_DIR . '/assets/images/logo.jpg';
    if ( ! file_exists( $path ) ) return;

    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';
    require_once ABSPATH . 'wp-admin/includes/image.php';

    $upload = wp_upload_bits( 'healthflowrcm-logo.jpg', null, file_get_contents( $path ) );
    if ( ! empty( $upload['error'] ) ) return;

    $id = wp_insert_attachment( array(
        'post_title'     => 'HealthFlowRCM Logo',
        'post_mime_type' => 'image/jpeg',
        'post_status'    => 'inherit',
    ), $upload['file'] );

    if ( ! is_wp_error( $id ) ) {
        wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );
        set_theme_mod( 'custom_logo', $id );
    }
}

/* Reset flag on theme switch so next activation re-runs clean */
add_action( 'switch_theme', function() {
    delete_option( 'hfrcm_demo_imported' );
    delete_transient( 'hfrcm_repair_check' );
} );

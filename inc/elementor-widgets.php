<?php
/**
 * HealthFlowRCM – Elementor Widgets Registration
 * All widgets are loaded via the elementor/loaded action (called from functions.php).
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/* ── Load all widget classes ─────────────────────── */
require_once HFRCM_DIR . '/inc/widgets/widget-hero.php';
require_once HFRCM_DIR . '/inc/widgets/widget-stats-bar.php';
require_once HFRCM_DIR . '/inc/widgets/widget-why-us.php';
require_once HFRCM_DIR . '/inc/widgets/widget-services-grid.php';
require_once HFRCM_DIR . '/inc/widgets/widget-free-audit-cta.php';
require_once HFRCM_DIR . '/inc/widgets/widget-specialties.php';
require_once HFRCM_DIR . '/inc/widgets/widget-process.php';
require_once HFRCM_DIR . '/inc/widgets/widget-cta-banner.php';
require_once HFRCM_DIR . '/inc/widgets/widget-page-hero.php';
require_once HFRCM_DIR . '/inc/widgets/widget-about-story.php';
require_once HFRCM_DIR . '/inc/widgets/widget-mission-vision.php';
require_once HFRCM_DIR . '/inc/widgets/widget-guarantee.php';
require_once HFRCM_DIR . '/inc/widgets/widget-team.php';
require_once HFRCM_DIR . '/inc/widgets/widget-testimonials.php';
require_once HFRCM_DIR . '/inc/widgets/widget-services-panel.php';
require_once HFRCM_DIR . '/inc/widgets/widget-contact-form.php';

/* ── Registration class ──────────────────────────── */
class HFRCM_Elementor_Widgets {
    public function __construct() {
        add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
    }

    public function register_widgets( $widgets_manager ) {
        $widgets_manager->register( new HFRCM_Widget_Hero() );
        $widgets_manager->register( new HFRCM_Widget_Stats_Bar() );
        $widgets_manager->register( new HFRCM_Widget_Why_Us() );
        $widgets_manager->register( new HFRCM_Widget_Services_Grid() );
        $widgets_manager->register( new HFRCM_Widget_Free_Audit_CTA() );
        $widgets_manager->register( new HFRCM_Widget_Specialties() );
        $widgets_manager->register( new HFRCM_Widget_Process() );
        $widgets_manager->register( new HFRCM_Widget_CTA_Banner() );
        $widgets_manager->register( new HFRCM_Widget_Page_Hero() );
        $widgets_manager->register( new HFRCM_Widget_About_Story() );
        $widgets_manager->register( new HFRCM_Widget_Mission_Vision() );
        $widgets_manager->register( new HFRCM_Widget_Guarantee() );
        $widgets_manager->register( new HFRCM_Widget_Team() );
        $widgets_manager->register( new HFRCM_Widget_Testimonials() );
        $widgets_manager->register( new HFRCM_Widget_Services_Panel() );
        $widgets_manager->register( new HFRCM_Widget_Contact_Form() );
    }
}
new HFRCM_Elementor_Widgets();

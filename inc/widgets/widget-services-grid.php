<?php
/**
 * Widget: Services Grid (Home page overview)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class HFRCM_Widget_Services_Grid extends \Elementor\Widget_Base {

    public function get_name()       { return 'hfrcm_services_grid'; }
    public function get_title()      { return 'HFRCM – Services Grid'; }
    public function get_icon()       { return 'eicon-gallery-grid'; }
    public function get_categories() { return [ 'healthflowrcm' ]; }
    public function get_keywords()   { return [ 'services', 'grid', 'home', 'healthflow' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'label_text', [ 'label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Our Core Services' ] );
        $this->add_control( 'title',      [ 'label' => 'Title', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Comprehensive Revenue Cycle Solutions' ] );
        $this->add_control( 'subtitle',   [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => 'We provide a full suite of RCM services designed to maximize your reimbursements, minimize denials, and keep your cash flow healthy.' ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_services', [
            'label' => 'Service Cards',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'number', [ 'label' => 'Number', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '01' ] );
        $repeater->add_control( 'title',  [ 'label' => 'Title',  'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Service Name' ] );
        $repeater->add_control( 'text',   [ 'label' => 'Text',   'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => 'Service description.' ] );
        $repeater->add_control( 'link',   [ 'label' => 'Link',   'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => '/services/' ] ] );
        $repeater->add_control( 'link_text', [ 'label' => 'Link Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Learn More' ] );

        $this->add_control( 'services', [
            'label'       => 'Services',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'number' => '01', 'title' => 'Medical Billing & Claims',      'text' => 'Complete charge entry, claims submission, correction, payment posting, and patient billing handled by expert billing professionals.' ],
                [ 'number' => '02', 'title' => 'Medical Coding',                'text' => 'Certified outpatient and inpatient coding, specialty specific coding support, and risk adjustment coding to ensure accuracy.' ],
                [ 'number' => '03', 'title' => 'Denial Management',             'text' => 'Proactive denial prevention, thorough root cause analysis, and aggressive appeals management to recover lost revenue.' ],
                [ 'number' => '04', 'title' => 'Credentialing & Enrollment',    'text' => 'Provider credentialing, payer enrollment, ERA and EFT setups, and facility and group enrollment managed end to end.' ],
                [ 'number' => '05', 'title' => 'A/R Management',                'text' => 'Dedicated accounts receivable follow up, aging analysis, and collections optimization to reduce A/R days significantly.' ],
                [ 'number' => '06', 'title' => 'Eligibility Verification',      'text' => 'Fast and thorough patient insurance eligibility verification so you can provide better care while guaranteeing payment for services.' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_cta', [
            'label' => 'Bottom CTA Button',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'cta_text', [ 'label' => 'Button Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'View All Services' ] );
        $this->add_control( 'cta_link', [ 'label' => 'Button Link', 'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '/services/' ] ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="section" id="services-overview">
            <div class="container">
                <div class="text-center fade-in">
                    <?php if ( $s['label_text'] ) : ?>
                        <span class="section-label"><span class="dot"></span> <?php echo esc_html( $s['label_text'] ); ?></span>
                    <?php endif; ?>
                    <h2 class="section-title"><?php echo wp_kses_post( $s['title'] ); ?></h2>
                    <div class="section-subtitle mx-auto"><?php echo wp_kses_post( $s['subtitle'] ); ?></div>
                </div>
                <div class="services-home-grid">
                    <?php foreach ( $s['services'] as $svc ) :
                        $svc_url = ! empty( $svc['link']['url'] ) ? $svc['link']['url'] : '/services/';
                        $svc_link_text = ! empty( $svc['link_text'] ) ? $svc['link_text'] : 'Learn More';
                    ?>
                        <div class="service-home-card fade-in">
                            <div class="shc-number"><?php echo esc_html( $svc['number'] ); ?></div>
                            <h3><?php echo esc_html( $svc['title'] ); ?></h3>
                            <div><?php echo wp_kses_post( $svc['text'] ); ?></div>
                            <a href="<?php echo esc_url( $svc_url ); ?>"><?php echo esc_html( $svc_link_text ); ?> <span class="arrow">&rarr;</span></a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if ( $s['cta_text'] ) :
                    $cta_url = ! empty( $s['cta_link']['url'] ) ? $s['cta_link']['url'] : '/services/';
                ?>
                    <div class="text-center" style="margin-top:48px;">
                        <a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn-primary btn-lg fade-in"><?php echo esc_html( $s['cta_text'] ); ?> <span class="arrow">&rarr;</span></a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}

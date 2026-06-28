<?php
/**
 * Widget: Why Choose Us (Feature Cards Grid)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class HFRCM_Widget_Why_Us extends \Elementor\Widget_Base {

    public function get_name()       { return 'hfrcm_why_us'; }
    public function get_title()      { return 'HFRCM – Why Choose Us'; }
    public function get_icon()       { return 'eicon-posts-grid'; }
    public function get_categories() { return [ 'healthflowrcm' ]; }
    public function get_keywords()   { return [ 'why', 'features', 'cards', 'grid', 'healthflow' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'label_text', [
            'label'   => 'Label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Why HealthFlowRCM',
        ] );

        $this->add_control( 'title', [
            'label'   => 'Title',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'The RCM Partner Your Practice Deserves',
        ] );

        $this->add_control( 'subtitle', [
            'label'   => 'Subtitle',
            'type'    => \Elementor\Controls_Manager::WYSIWYG,
            'default' => 'In today\'s complex healthcare environment, providers need a reliable partner to enhance workflow efficiency, boost revenue, and reduce operational costs.',
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_cards', [
            'label' => 'Feature Cards',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'icon',  [ 'label' => 'Icon (emoji)',  'type' => \Elementor\Controls_Manager::TEXT, 'default' => '⚙️' ] );
        $repeater->add_control( 'title', [ 'label' => 'Card Title',   'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Feature Title' ] );
        $repeater->add_control( 'text',  [ 'label' => 'Card Text',    'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => 'Feature description goes here.' ] );

        $this->add_control( 'cards', [
            'label'       => 'Cards',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'icon' => '⚙️',  'title' => 'Technology Driven Solutions',  'text' => 'We leverage cutting edge technology and industry expertise tailored to your specific practice needs.' ],
                [ 'icon' => '📋',  'title' => 'End to End RCM Services',       'text' => 'From patient registration to A/R follow up, we handle every step of the revenue cycle.' ],
                [ 'icon' => '📊',  'title' => 'Dedicated Expert Team',         'text' => 'Certified professionals with five plus years of experience ensure accuracy and optimal revenue capture.' ],
                [ 'icon' => '📈',  'title' => 'Transparent Reporting',         'text' => 'Full visibility into your financial health with real time reporting and data driven insights.' ],
                [ 'icon' => '🔒',  'title' => 'HIPAA Compliant & Secure',      'text' => 'Advanced cybersecurity measures protect your data and exceed the most stringent industry standards.' ],
                [ 'icon' => '💲',  'title' => 'Cost Effective Pricing',        'text' => 'Reduce operational costs by up to 50% while increasing revenue by 20 to 30%.' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="section section-bg" id="why-us">
            <div class="container">
                <div class="text-center fade-in">
                    <?php if ( $s['label_text'] ) : ?>
                        <span class="section-label"><span class="dot"></span> <?php echo esc_html( $s['label_text'] ); ?></span>
                    <?php endif; ?>
                    <h2 class="section-title"><?php echo wp_kses_post( $s['title'] ); ?></h2>
                    <div class="section-subtitle mx-auto"><?php echo wp_kses_post( $s['subtitle'] ); ?></div>
                </div>
                <div class="why-grid">
                    <?php foreach ( $s['cards'] as $card ) : ?>
                        <div class="card fade-in">
                            <div class="card-icon"><?php echo esc_html( $card['icon'] ); ?></div>
                            <h3 class="card-title"><?php echo esc_html( $card['title'] ); ?></h3>
                            <div class="card-text"><?php echo wp_kses_post( $card['text'] ); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}

<?php
/**
 * Widget: Mission & Vision
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class HFRCM_Widget_Mission_Vision extends \Elementor\Widget_Base {

    public function get_name()       { return 'hfrcm_mission_vision'; }
    public function get_title()      { return 'HFRCM – Mission & Vision'; }
    public function get_icon()       { return 'eicon-target'; }
    public function get_categories() { return [ 'healthflowrcm' ]; }
    public function get_keywords()   { return [ 'mission', 'vision', 'about', 'healthflow' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_mission', [
            'label' => 'Mission Card',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'mission_icon',  [ 'label' => 'Icon (emoji)', 'type' => \Elementor\Controls_Manager::TEXT,     'default' => '🎯' ] );
        $this->add_control( 'mission_title', [ 'label' => 'Title',        'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Our Mission' ] );
        $this->add_control( 'mission_text',  [ 'label' => 'Text',         'type' => \Elementor\Controls_Manager::WYSIWYG,  'default' => 'To empower healthcare providers with innovative RCM solutions that enhance operational efficiency, improve revenue streams, and streamline administrative workflows.' ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_vision', [
            'label' => 'Vision Card',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'vision_icon',  [ 'label' => 'Icon (emoji)', 'type' => \Elementor\Controls_Manager::TEXT,     'default' => '👁' ] );
        $this->add_control( 'vision_title', [ 'label' => 'Title',        'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Our Vision' ] );
        $this->add_control( 'vision_text',  [ 'label' => 'Text',         'type' => \Elementor\Controls_Manager::WYSIWYG,  'default' => 'To be the trusted partner of choice for medical billing and revenue cycle management services, ensuring financial stability and growth for healthcare providers nationwide.' ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="section section-bg" id="mission-vision">
            <div class="container">
                <div class="mv-grid">
                    <div class="mv-card fade-in">
                        <div class="mv-icon"><?php echo esc_html( $s['mission_icon'] ); ?></div>
                        <h3><?php echo esc_html( $s['mission_title'] ); ?></h3>
                        <div><?php echo wp_kses_post( $s['mission_text'] ); ?></div>
                    </div>
                    <div class="mv-card fade-in">
                        <div class="mv-icon"><?php echo esc_html( $s['vision_icon'] ); ?></div>
                        <h3><?php echo esc_html( $s['vision_title'] ); ?></h3>
                        <div><?php echo wp_kses_post( $s['vision_text'] ); ?></div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

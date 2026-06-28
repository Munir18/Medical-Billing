<?php
/**
 * Widget: Process Steps (How It Works)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class HFRCM_Widget_Process extends \Elementor\Widget_Base {

    public function get_name()       { return 'hfrcm_process'; }
    public function get_title()      { return 'HFRCM – Process Steps'; }
    public function get_icon()       { return 'eicon-flow'; }
    public function get_categories() { return [ 'healthflowrcm' ]; }
    public function get_keywords()   { return [ 'process', 'steps', 'how it works', 'healthflow' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'label_text', [ 'label' => 'Label',    'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'How It Works' ] );
        $this->add_control( 'title',      [ 'label' => 'Title',    'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Getting Started Is Simple' ] );
        $this->add_control( 'subtitle',   [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::WYSIWYG,  'default' => 'We make the transition seamless so you can start seeing results from day one.' ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_steps', [
            'label' => 'Process Steps',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'step_num',   [ 'label' => 'Step Number', 'type' => \Elementor\Controls_Manager::TEXT,   'default' => '1' ] );
        $repeater->add_control( 'step_title', [ 'label' => 'Title',       'type' => \Elementor\Controls_Manager::TEXT,   'default' => 'Step Title' ] );
        $repeater->add_control( 'step_text',  [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => 'Step description goes here.' ] );

        $this->add_control( 'steps', [
            'label'       => 'Steps',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'step_num' => '1', 'step_title' => 'Free Consultation',  'step_text' => 'Schedule a call with our RCM experts. We will assess your current billing process and identify areas for improvement.' ],
                [ 'step_num' => '2', 'step_title' => 'Custom Strategy',    'step_text' => 'We build a tailored RCM plan based on your specialty, volume, and specific pain points to maximize your revenue potential.' ],
                [ 'step_num' => '3', 'step_title' => 'Seamless Onboarding','step_text' => 'Our team handles the entire transition. We integrate with your existing EHR/PM systems with zero disruption to your workflow.' ],
                [ 'step_num' => '4', 'step_title' => 'Ongoing Optimization','step_text' => 'We continuously monitor, report, and refine your billing processes to ensure sustained revenue growth and compliance.' ],
            ],
            'title_field' => '{{{ step_title }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $steps = $s['steps'];
        $total = count( $steps );
        ?>
        <section class="section" id="process">
            <div class="container">
                <div class="text-center fade-in">
                    <?php if ( $s['label_text'] ) : ?>
                        <span class="section-label"><span class="dot"></span> <?php echo esc_html( $s['label_text'] ); ?></span>
                    <?php endif; ?>
                    <h2 class="section-title"><?php echo wp_kses_post( $s['title'] ); ?></h2>
                    <div class="section-subtitle mx-auto"><?php echo wp_kses_post( $s['subtitle'] ); ?></div>
                </div>
                <div class="process-grid">
                    <?php $i = 0; foreach ( $steps as $step ) : $i++; ?>
                        <div class="process-step fade-in">
                            <div class="process-num"><?php echo esc_html( $step['step_num'] ); ?></div>
                            <h3><?php echo esc_html( $step['step_title'] ); ?></h3>
                            <div><?php echo wp_kses_post( $step['step_text'] ); ?></div>
                        </div>
                        <?php if ( $i < $total ) : ?>
                            <div class="process-connector fade-in"></div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}

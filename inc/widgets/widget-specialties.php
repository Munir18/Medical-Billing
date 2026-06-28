<?php
/**
 * Widget: Specialties Tag Cloud
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class HFRCM_Widget_Specialties extends \Elementor\Widget_Base {

    public function get_name()       { return 'hfrcm_specialties'; }
    public function get_title()      { return 'HFRCM – Specialties'; }
    public function get_icon()       { return 'eicon-tags'; }
    public function get_categories() { return [ 'healthflowrcm' ]; }
    public function get_keywords()   { return [ 'specialties', 'tags', 'healthflow' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'label_text', [ 'label' => 'Label',    'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Industry Specialties' ] );
        $this->add_control( 'title',      [ 'label' => 'Title',    'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Serving Healthcare Providers Across All Specialties' ] );
        $this->add_control( 'subtitle',   [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::WYSIWYG,  'default' => 'Our team has deep expertise across a wide range of medical specialties, ensuring accurate coding and maximum reimbursement for your specific field.' ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_tags', [
            'label' => 'Specialty Tags',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'tag', [ 'label' => 'Specialty', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Cardiology' ] );

        $this->add_control( 'tags', [
            'label'       => 'Specialties',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'tag' => '❤️ Cardiology' ],
                [ 'tag' => '🦴 Orthopedics' ],
                [ 'tag' => '🩺 Internal Medicine' ],
                [ 'tag' => '🩹 Dermatology' ],
                [ 'tag' => '👨‍👩‍👧 Family Practice' ],
                [ 'tag' => '🧠 Neurology' ],
                [ 'tag' => '🏥 Oncology' ],
                [ 'tag' => '🔪 Surgery' ],
                [ 'tag' => '🔬 Radiology' ],
                [ 'tag' => '🧠 Psychiatry' ],
                [ 'tag' => '🏥 Urgent Care' ],
                [ 'tag' => '🩹 Ambulatory Clinics' ],
            ],
            'title_field' => '{{{ tag }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="section section-bg" id="specialties">
            <div class="container">
                <div class="text-center fade-in">
                    <?php if ( $s['label_text'] ) : ?>
                        <span class="section-label"><span class="dot"></span> <?php echo esc_html( $s['label_text'] ); ?></span>
                    <?php endif; ?>
                    <h2 class="section-title"><?php echo wp_kses_post( $s['title'] ); ?></h2>
                    <div class="section-subtitle mx-auto"><?php echo wp_kses_post( $s['subtitle'] ); ?></div>
                </div>
                <div class="specialties-grid fade-in">
                    <?php foreach ( $s['tags'] as $t ) : ?>
                        <div class="specialty-tag"><?php echo esc_html( $t['tag'] ); ?></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}

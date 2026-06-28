<?php
/**
 * Widget: Testimonials Slider (About page)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class HFRCM_Widget_Testimonials extends \Elementor\Widget_Base {

    public function get_name()       { return 'hfrcm_testimonials'; }
    public function get_title()      { return 'HFRCM – Testimonials Slider'; }
    public function get_icon()       { return 'eicon-testimonial-carousel'; }
    public function get_categories() { return [ 'healthflowrcm' ]; }
    public function get_keywords()   { return [ 'testimonials', 'slider', 'reviews', 'healthflow' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'label_text', [ 'label' => 'Label',    'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Testimonials' ] );
        $this->add_control( 'title',      [ 'label' => 'Title',    'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'What Our Clients Say' ] );
        $this->add_control( 'subtitle',   [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::WYSIWYG,  'default' => 'Healthcare providers across the United States trust HealthFlowRCM to manage their revenue cycle.' ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_testimonials', [
            'label' => 'Testimonials',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'quote',       [ 'label' => 'Quote',       'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => 'Client testimonial goes here.' ] );
        $repeater->add_control( 'name',        [ 'label' => 'Name',        'type' => \Elementor\Controls_Manager::TEXT,    'default' => 'Client Name' ] );
        $repeater->add_control( 'role',        [ 'label' => 'Role',        'type' => \Elementor\Controls_Manager::TEXT,    'default' => 'Position, Location' ] );
        $repeater->add_control( 'initials',    [ 'label' => 'Initials',    'type' => \Elementor\Controls_Manager::TEXT,    'default' => 'CN' ] );
        $repeater->add_control( 'stars',       [ 'label' => 'Stars (1-5)', 'type' => \Elementor\Controls_Manager::NUMBER,  'default' => 5, 'min' => 1, 'max' => 5 ] );

        $this->add_control( 'testimonials', [
            'label'       => 'Testimonials',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'quote' => '"Since switching to HealthFlowRCM, our collections have increased by over 22% and our denial rate dropped dramatically."', 'name' => 'Dr. Robert Mitchell', 'role' => 'Cardiologist, Texas',                           'initials' => 'DR', 'stars' => 5 ],
                [ 'quote' => '"HealthFlowRCM completely transformed our billing operation. Within 90 days, our A/R days dropped by 35%."',              'name' => 'Sarah Johnson',      'role' => 'Practice Manager, Family Care Clinic, Montana', 'initials' => 'SJ', 'stars' => 5 ],
                [ 'quote' => '"Their credentialing team got our new providers enrolled with major payers in record time."',                              'name' => 'Dr. Michael Kim',    'role' => 'Orthopedic Surgeon, California',                 'initials' => 'MK', 'stars' => 5 ],
                [ 'quote' => '"Our clean claim rate is now at 97% and we have reduced our operational billing costs by nearly 40%."',                   'name' => 'Lisa Patel',         'role' => 'Director of Operations, Urgent Care Network, FL', 'initials' => 'LP', 'stars' => 5 ],
            ],
            'title_field' => '{{{ name }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        $testimonials = $s['testimonials'];
        ?>
        <section class="section" id="testimonials">
            <div class="container">
                <div class="text-center fade-in">
                    <?php if ( $s['label_text'] ) : ?>
                        <span class="section-label"><span class="dot"></span> <?php echo esc_html( $s['label_text'] ); ?></span>
                    <?php endif; ?>
                    <h2 class="section-title"><?php echo wp_kses_post( $s['title'] ); ?></h2>
                    <div class="section-subtitle mx-auto"><?php echo wp_kses_post( $s['subtitle'] ); ?></div>
                </div>
                <div class="testimonials-wrapper">
                    <div class="testimonial-track testimonial-slider" id="testimonialSlider">
                        <?php foreach ( $testimonials as $t ) :
                            $stars_html = str_repeat( '&#9733;', intval( $t['stars'] ) );
                        ?>
                            <div class="testimonial-card">
                                <div class="testimonial-stars"><?php echo $stars_html; ?></div>
                                <div class="testimonial-text"><?php echo wp_kses_post( $t['quote'] ); ?></div>
                                <div class="testimonial-author">
                                    <div class="testimonial-avatar"><?php echo esc_html( $t['initials'] ); ?></div>
                                    <div>
                                        <div class="testimonial-name"><?php echo esc_html( $t['name'] ); ?></div>
                                        <div class="testimonial-role"><?php echo esc_html( $t['role'] ); ?></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="slider-dots">
                        <?php foreach ( $testimonials as $i => $t ) : ?>
                            <button class="slider-dot <?php echo $i === 0 ? 'active' : ''; ?>" aria-label="Slide <?php echo $i + 1; ?>"></button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

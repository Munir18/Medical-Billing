<?php
/**
 * Widget: CTA Banner (final CTA sections used on all pages)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class HFRCM_Widget_CTA_Banner extends \Elementor\Widget_Base {

    public function get_name()       { return 'hfrcm_cta_banner'; }
    public function get_title()      { return 'HFRCM – CTA Banner'; }
    public function get_icon()       { return 'eicon-call-to-action'; }
    public function get_categories() { return [ 'healthflowrcm' ]; }
    public function get_keywords()   { return [ 'cta', 'banner', 'button', 'healthflow' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => 'CTA Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'title',       [ 'label' => 'Title',       'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Ready to Optimize Your Revenue Cycle?' ] );
        $this->add_control( 'description', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::WYSIWYG,  'default' => 'Join healthcare providers nationwide who trust HealthFlowRCM to handle their billing operations and increase their bottom line.' ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_buttons', [
            'label' => 'Buttons',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'btn1_text', [ 'label' => 'Button 1 Text', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Book a Free Consultation' ] );
        $this->add_control( 'btn1_link', [ 'label' => 'Button 1 Link', 'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => '/book-a-consultation/' ] ] );

        $this->add_control( 'btn2_text', [ 'label' => 'Button 2 Text (optional)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Call +1 (406) 235-6348' ] );
        $this->add_control( 'btn2_link', [ 'label' => 'Button 2 Link',            'type' => \Elementor\Controls_Manager::URL,  'default' => [ 'url' => 'tel:+14062356348' ] ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s    = $this->get_settings_for_display();
        $url1 = ! empty( $s['btn1_link']['url'] ) ? $s['btn1_link']['url'] : '/book-a-consultation/';
        $url2 = ! empty( $s['btn2_link']['url'] ) ? $s['btn2_link']['url'] : '#';
        ?>
        <section class="section section-primary" id="final-cta">
            <div class="container text-center">
                <div class="fade-in">
                    <h2 style="font-size:clamp(1.8rem,3.5vw,2.6rem);color:#fff;margin-bottom:18px;"><?php echo wp_kses_post( $s['title'] ); ?></h2>
                    <div style="color:rgba(255,255,255,0.85);font-size:1.1rem;max-width:600px;margin:0 auto 36px;"><?php echo wp_kses_post( $s['description'] ); ?></div>
                    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
                        <?php if ( $s['btn1_text'] ) : ?>
                            <a href="<?php echo esc_url( $url1 ); ?>" class="btn btn-white btn-lg"><?php echo esc_html( $s['btn1_text'] ); ?> <span class="arrow">&rarr;</span></a>
                        <?php endif; ?>
                        <?php if ( $s['btn2_text'] ) : ?>
                            <a href="<?php echo esc_url( $url2 ); ?>" class="btn btn-outline btn-lg" style="border-color:rgba(255,255,255,0.4);color:#fff;"><?php echo esc_html( $s['btn2_text'] ); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

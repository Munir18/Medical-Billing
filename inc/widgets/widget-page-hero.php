<?php
/**
 * Widget: Page Hero (inner pages banner – About, Services, Consultation)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class HFRCM_Widget_Page_Hero extends \Elementor\Widget_Base {

    public function get_name()       { return 'hfrcm_page_hero'; }
    public function get_title()      { return 'HFRCM – Page Hero'; }
    public function get_icon()       { return 'eicon-image-rollover'; }
    public function get_categories() { return [ 'healthflowrcm' ]; }
    public function get_keywords()   { return [ 'page hero', 'banner', 'inner page', 'healthflow' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => 'Page Hero Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'label_text',  [ 'label' => 'Label',       'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'About Us' ] );
        $this->add_control( 'title',       [ 'label' => 'Title',       'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'The Team Behind Your Revenue Growth' ] );
        $this->add_control( 'description', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::WYSIWYG,  'default' => 'HealthFlowRCM is a premier healthcare financial services company specializing in revenue cycle management solutions for healthcare providers of all sizes across the United States.' ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="page-hero">
            <div class="container">
                <div class="page-hero-content fade-in">
                    <?php if ( $s['label_text'] ) : ?>
                        <span class="section-label"><span class="dot"></span> <?php echo esc_html( $s['label_text'] ); ?></span>
                    <?php endif; ?>
                    <h1><?php echo wp_kses_post( $s['title'] ); ?></h1>
                    <div><?php echo wp_kses_post( $s['description'] ); ?></div>
                </div>
            </div>
        </section>
        <?php
    }
}

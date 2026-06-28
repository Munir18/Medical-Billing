<?php
/**
 * Widget: Guarantee Grid (About page)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class HFRCM_Widget_Guarantee extends \Elementor\Widget_Base {

    public function get_name()       { return 'hfrcm_guarantee'; }
    public function get_title()      { return 'HFRCM – Guarantee Grid'; }
    public function get_icon()       { return 'eicon-check-circle'; }
    public function get_categories() { return [ 'healthflowrcm' ]; }
    public function get_keywords()   { return [ 'guarantee', 'grid', 'about', 'healthflow' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'label_text', [ 'label' => 'Label',    'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Our Guarantee' ] );
        $this->add_control( 'title',      [ 'label' => 'Title',    'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'What You Can Count On' ] );
        $this->add_control( 'subtitle',   [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::WYSIWYG,  'default' => 'When you partner with HealthFlowRCM, these are the commitments we make to your practice from day one.' ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_items', [
            'label' => 'Guarantee Items',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'icon',  [ 'label' => 'Icon (emoji)', 'type' => \Elementor\Controls_Manager::TEXT,    'default' => '📈' ] );
        $repeater->add_control( 'title', [ 'label' => 'Title',        'type' => \Elementor\Controls_Manager::TEXT,    'default' => 'Guarantee title' ] );
        $repeater->add_control( 'text',  [ 'label' => 'Text',         'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => 'Guarantee description.' ] );

        $this->add_control( 'items', [
            'label'       => 'Items',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'icon' => '📈', 'title' => 'Up to 20% Increase in Collections',  'text' => 'See a measurable boost in your revenue within the first few months of partnership.' ],
                [ 'icon' => '✔',  'title' => '97% First-Pass Acceptance',           'text' => 'Our expert coding and scrubbing process ensures claims are accepted on the very first submission.' ],
                [ 'icon' => '📉', 'title' => 'Reduced Denials & A/R Days',          'text' => 'Significant reduction in claim denials and accounts receivable aging for healthier cash flow.' ],
                [ 'icon' => '💲', 'title' => 'Competitive Pricing',                 'text' => 'Cost effective service pricing that delivers premium results without stretching your budget.' ],
                [ 'icon' => '🔒', 'title' => 'Advanced Cybersecurity',              'text' => 'Enterprise grade data protection measures to safeguard all patient and financial information.' ],
                [ 'icon' => '📊', 'title' => 'Transparent Reporting',               'text' => 'Full visibility of your earnings with detailed financial reporting and real time analytics.' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="section" id="guarantee">
            <div class="container">
                <div class="text-center fade-in">
                    <?php if ( $s['label_text'] ) : ?>
                        <span class="section-label"><span class="dot"></span> <?php echo esc_html( $s['label_text'] ); ?></span>
                    <?php endif; ?>
                    <h2 class="section-title"><?php echo wp_kses_post( $s['title'] ); ?></h2>
                    <div class="section-subtitle mx-auto"><?php echo wp_kses_post( $s['subtitle'] ); ?></div>
                </div>
                <div class="guarantee-grid">
                    <?php foreach ( $s['items'] as $item ) : ?>
                        <div class="guarantee-item fade-in">
                            <div class="gi-icon"><?php echo esc_html( $item['icon'] ); ?></div>
                            <h4><?php echo esc_html( $item['title'] ); ?></h4>
                            <div><?php echo wp_kses_post( $item['text'] ); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}

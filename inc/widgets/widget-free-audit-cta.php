<?php
/**
 * Widget: Free Audit CTA (dark section with badge)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class HFRCM_Widget_Free_Audit_CTA extends \Elementor\Widget_Base {

    public function get_name()       { return 'hfrcm_free_audit_cta'; }
    public function get_title()      { return 'HFRCM – Free Audit CTA'; }
    public function get_icon()       { return 'eicon-call-to-action'; }
    public function get_categories() { return [ 'healthflowrcm' ]; }
    public function get_keywords()   { return [ 'audit', 'cta', 'free', 'healthflow' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => 'Audit CTA Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'label_text',  [ 'label' => 'Label',       'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Limited Time Offer' ] );
        $this->add_control( 'title',       [ 'label' => 'Title',       'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Get Your FREE 90-Day RCM Audit' ] );
        $this->add_control( 'description', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::WYSIWYG,  'default' => 'Discover exactly where your practice is leaving money on the table. Our expert team will audit your entire revenue cycle and deliver a detailed roadmap to maximize collections and minimize denials.' ] );
        $this->add_control( 'btn_text',    [ 'label' => 'Button Text', 'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Claim Your Free Audit' ] );
        $this->add_control( 'btn_link',    [ 'label' => 'Button Link', 'type' => \Elementor\Controls_Manager::URL,      'default' => [ 'url' => '/book-a-consultation/' ] ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_list', [
            'label' => 'Checklist Items',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'item', [ 'label' => 'Item', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Checklist item' ] );

        $this->add_control( 'list_items', [
            'label'       => 'Items',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'item' => 'Complete claims analysis and error identification' ],
                [ 'item' => 'Denial pattern assessment with recovery strategies' ],
                [ 'item' => 'A/R aging review and optimization recommendations' ],
                [ 'item' => 'Coding accuracy evaluation across all specialties' ],
                [ 'item' => 'Custom action plan delivered within 30 days' ],
            ],
            'title_field' => '{{{ item }}}',
        ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_badge', [
            'label' => 'Audit Badge',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'badge_days', [ 'label' => 'Days Number', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '90' ] );
        $this->add_control( 'badge_text', [ 'label' => 'Badge Label', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'FREE AUDIT' ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s       = $this->get_settings_for_display();
        $btn_url = ! empty( $s['btn_link']['url'] ) ? $s['btn_link']['url'] : '/book-a-consultation/';
        ?>
        <section class="section section-dark" id="free-audit">
            <div class="container">
                <div class="audit-cta fade-in">
                    <div class="audit-content">
                        <?php if ( $s['label_text'] ) : ?>
                            <span class="section-label light"><span class="dot"></span> <?php echo esc_html( $s['label_text'] ); ?></span>
                        <?php endif; ?>
                        <h2 class="section-title" style="color:#fff;"><?php echo wp_kses_post( $s['title'] ); ?></h2>
                        <div class="section-subtitle" style="color:rgba(255,255,255,0.75);"><?php echo wp_kses_post( $s['description'] ); ?></div>
                        <?php if ( ! empty( $s['list_items'] ) ) : ?>
                            <ul class="audit-list">
                                <?php foreach ( $s['list_items'] as $li ) : ?>
                                    <li>&#10003; <?php echo esc_html( $li['item'] ); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                        <?php if ( $s['btn_text'] ) : ?>
                            <a href="<?php echo esc_url( $btn_url ); ?>" class="btn btn-accent btn-lg"><?php echo esc_html( $s['btn_text'] ); ?> <span class="arrow">&rarr;</span></a>
                        <?php endif; ?>
                    </div>
                    <div class="audit-visual">
                        <div class="audit-badge">
                            <div class="audit-badge-inner">
                                <span class="ab-days"><?php echo esc_html( $s['badge_days'] ); ?></span>
                                <span class="ab-text">DAYS</span>
                                <span class="ab-sub"><?php echo esc_html( $s['badge_text'] ); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

<?php
/**
 * Widget: Hero Section (Home Page)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class HFRCM_Widget_Hero extends \Elementor\Widget_Base {

    public function get_name()       { return 'hfrcm_hero'; }
    public function get_title()      { return 'HFRCM – Hero Section'; }
    public function get_icon()       { return 'eicon-header'; }
    public function get_categories() { return [ 'healthflowrcm' ]; }
    public function get_keywords()   { return [ 'hero', 'banner', 'home', 'healthflow' ]; }

    protected function register_controls() {

        /* ── Content Tab ── */
        $this->start_controls_section( 'section_content', [
            'label' => 'Hero Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'label_text', [
            'label'   => 'Section Label',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Trusted RCM Partner',
        ] );

        $this->add_control( 'title', [
            'label'   => 'Heading',
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => 'We Manage Your <span class="text-gradient">Revenue Cycle</span> So You Can Focus on Patient Care',
        ] );

        $this->add_control( 'description', [
            'label'   => 'Description',
            'type'    => \Elementor\Controls_Manager::WYSIWYG,
            'default' => 'HealthFlowRCM delivers comprehensive medical billing, coding, and revenue cycle management solutions that increase collections, reduce denials, and streamline your entire billing operation.',
        ] );

        $this->add_control( 'btn_primary_text', [
            'label'   => 'Primary Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Get Free RCM Audit',
        ] );

        $this->add_control( 'btn_primary_link', [
            'label'   => 'Primary Button Link',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/book-a-consultation/' ],
        ] );

        $this->add_control( 'btn_secondary_text', [
            'label'   => 'Secondary Button Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Explore Services',
        ] );

        $this->add_control( 'btn_secondary_link', [
            'label'   => 'Secondary Button Link',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/services/' ],
        ] );

        $this->end_controls_section();

        /* ── Trust Items ── */
        $this->start_controls_section( 'section_trust', [
            'label' => 'Trust Badges',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'trust_text', [
            'label'   => 'Badge Text',
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'HIPAA Compliant',
        ] );

        $this->add_control( 'trust_items', [
            'label'       => 'Trust Badges',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'trust_text' => 'HIPAA Compliant' ],
                [ 'trust_text' => 'Certified Coders' ],
                [ 'trust_text' => 'Nationwide Service' ],
            ],
            'title_field' => '{{{ trust_text }}}',
        ] );

        $this->end_controls_section();

        /* ── Stat Cards ── */
        $this->start_controls_section( 'section_stats', [
            'label' => 'Hero Stat Cards',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $sr = new \Elementor\Repeater();
        $sr->add_control( 'icon',  [ 'label' => 'Icon (emoji)', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '📈' ] );
        $sr->add_control( 'value', [ 'label' => 'Value',        'type' => \Elementor\Controls_Manager::TEXT, 'default' => '97%' ] );
        $sr->add_control( 'label', [ 'label' => 'Label',        'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Clean Claim Rate' ] );

        $this->add_control( 'stat_cards', [
            'label'       => 'Stat Cards',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $sr->get_controls(),
            'default'     => [
                [ 'icon' => '📈', 'value' => '97%',  'label' => 'Clean Claim Rate' ],
                [ 'icon' => '💰', 'value' => '20%+', 'label' => 'Revenue Increase' ],
                [ 'icon' => '⏱',  'value' => '48hr', 'label' => 'Turnaround Time' ],
            ],
            'title_field' => '{{{ label }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s            = $this->get_settings_for_display();
        $primary_url  = ! empty( $s['btn_primary_link']['url'] )   ? $s['btn_primary_link']['url']   : '/book-a-consultation/';
        $secondary_url = ! empty( $s['btn_secondary_link']['url'] ) ? $s['btn_secondary_link']['url'] : '/services/';
        ?>
        <section class="hero" id="hero">
            <div class="hero-bg-shapes"><div class="shape shape-1"></div><div class="shape shape-2"></div><div class="shape shape-3"></div></div>
            <div class="container">
                <div class="hero-grid">
                    <div class="hero-content fade-in">
                        <?php if ( $s['label_text'] ) : ?>
                            <span class="section-label"><span class="dot"></span> <?php echo esc_html( $s['label_text'] ); ?></span>
                        <?php endif; ?>
                        <h1><?php echo wp_kses_post( $s['title'] ); ?></h1>
                        <div class="hero-desc"><?php echo wp_kses_post( $s['description'] ); ?></div>
                        <div class="hero-btns">
                            <?php if ( $s['btn_primary_text'] ) : ?>
                                <a href="<?php echo esc_url( $primary_url ); ?>" class="btn btn-primary btn-lg"><?php echo esc_html( $s['btn_primary_text'] ); ?> <span class="arrow">&rarr;</span></a>
                            <?php endif; ?>
                            <?php if ( $s['btn_secondary_text'] ) : ?>
                                <a href="<?php echo esc_url( $secondary_url ); ?>" class="btn btn-outline btn-lg"><?php echo esc_html( $s['btn_secondary_text'] ); ?></a>
                            <?php endif; ?>
                        </div>
                        <?php if ( ! empty( $s['trust_items'] ) ) : ?>
                            <div class="hero-trust">
                                <?php foreach ( $s['trust_items'] as $item ) : ?>
                                    <div class="trust-item">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none"><circle cx="10" cy="10" r="10" fill="#6FC7D5" opacity="0.15"/><path d="M6 10l3 3 5-6" stroke="#6FC7D5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        <?php echo esc_html( $item['trust_text'] ); ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if ( ! empty( $s['stat_cards'] ) ) : ?>
                        <div class="hero-visual fade-in-right">
                            <div class="hero-card-stack">
                                <?php $i = 1; foreach ( $s['stat_cards'] as $card ) : ?>
                                    <div class="hero-stat-card card-<?php echo $i; ?>">
                                        <div class="hsc-icon"><?php echo esc_html( $card['icon'] ); ?></div>
                                        <div class="hsc-value"><?php echo esc_html( $card['value'] ); ?></div>
                                        <div class="hsc-label"><?php echo esc_html( $card['label'] ); ?></div>
                                    </div>
                                <?php $i++; endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php
    }
}

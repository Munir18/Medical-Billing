<?php
/**
 * Widget: Team Features (About page)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class HFRCM_Widget_Team extends \Elementor\Widget_Base {

    public function get_name()       { return 'hfrcm_team'; }
    public function get_title()      { return 'HFRCM – Team Features'; }
    public function get_icon()       { return 'eicon-team-members'; }
    public function get_categories() { return [ 'healthflowrcm' ]; }
    public function get_keywords()   { return [ 'team', 'about', 'healthflow' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_header', [
            'label' => 'Section Header',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'label_text', [ 'label' => 'Label',    'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Our Team' ] );
        $this->add_control( 'title',      [ 'label' => 'Title',    'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Experienced Professionals at Your Service' ] );
        $this->add_control( 'subtitle',   [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::WYSIWYG,  'default' => 'Our team consists of experienced medical billing professionals, certified coders, AR specialists, compliance managers, and credentialing experts with a minimum of five years of industry experience.' ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_features', [
            'label' => 'Team Features',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'icon',  [ 'label' => 'Icon (emoji)', 'type' => \Elementor\Controls_Manager::TEXT,    'default' => '👤' ] );
        $repeater->add_control( 'title', [ 'label' => 'Title',        'type' => \Elementor\Controls_Manager::TEXT,    'default' => 'Role Title' ] );
        $repeater->add_control( 'text',  [ 'label' => 'Description',  'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => 'Role description.' ] );

        $this->add_control( 'features', [
            'label'       => 'Team Roles',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'icon' => '👤', 'title' => 'Certified Coders',       'text' => 'AAPC and AHIMA certified professionals who stay current with every coding update and regulation change.' ],
                [ 'icon' => '💼', 'title' => 'AR Specialists',          'text' => 'Dedicated accounts receivable experts who aggressively pursue every dollar your practice is owed.' ],
                [ 'icon' => '📝', 'title' => 'Compliance Managers',     'text' => 'Regulatory compliance specialists ensuring every process meets federal and state healthcare standards.' ],
                [ 'icon' => '📋', 'title' => 'Credentialing Experts',   'text' => 'Streamlined provider enrollment and credentialing handled efficiently from start to finish.' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="section section-bg" id="team">
            <div class="container">
                <div class="text-center fade-in">
                    <?php if ( $s['label_text'] ) : ?>
                        <span class="section-label"><span class="dot"></span> <?php echo esc_html( $s['label_text'] ); ?></span>
                    <?php endif; ?>
                    <h2 class="section-title"><?php echo wp_kses_post( $s['title'] ); ?></h2>
                    <div class="section-subtitle mx-auto"><?php echo wp_kses_post( $s['subtitle'] ); ?></div>
                </div>
                <div class="team-features">
                    <?php foreach ( $s['features'] as $feat ) : ?>
                        <div class="team-feature fade-in">
                            <div class="tf-icon"><?php echo esc_html( $feat['icon'] ); ?></div>
                            <h4><?php echo esc_html( $feat['title'] ); ?></h4>
                            <div><?php echo wp_kses_post( $feat['text'] ); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}

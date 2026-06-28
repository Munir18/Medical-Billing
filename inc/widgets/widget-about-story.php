<?php
/**
 * Widget: About Story Section
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class HFRCM_Widget_About_Story extends \Elementor\Widget_Base {

    public function get_name()       { return 'hfrcm_about_story'; }
    public function get_title()      { return 'HFRCM – About Story'; }
    public function get_icon()       { return 'eicon-person'; }
    public function get_categories() { return [ 'healthflowrcm' ]; }
    public function get_keywords()   { return [ 'about', 'story', 'stats', 'healthflow' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_text', [
            'label' => 'Story Text',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'label_text',   [ 'label' => 'Label',       'type' => \Elementor\Controls_Manager::TEXT,   'default' => 'Our Story' ] );
        $this->add_control( 'title',        [ 'label' => 'Title',       'type' => \Elementor\Controls_Manager::TEXTAREA,'default' => 'Built by Billing Experts, For Healthcare Providers' ] );
        $this->add_control( 'paragraph_1',  [ 'label' => 'Paragraph 1', 'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => 'From small practices to large healthcare organizations, HealthFlowRCM provides end to end RCM services including credentialing, coding, claims processing, denial management, and patient communication.' ] );
        $this->add_control( 'paragraph_2',  [ 'label' => 'Paragraph 2', 'type' => \Elementor\Controls_Manager::WYSIWYG, 'default' => 'We offer comprehensive medical billing and coding services, leveraging cutting edge technology and industry expertise to enhance financial performance.' ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_stats', [
            'label' => 'Stat Cards',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'count',  [ 'label' => 'Count',  'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 97 ] );
        $repeater->add_control( 'suffix', [ 'label' => 'Suffix', 'type' => \Elementor\Controls_Manager::TEXT,   'default' => '%' ] );
        $repeater->add_control( 'prefix', [ 'label' => 'Prefix', 'type' => \Elementor\Controls_Manager::TEXT,   'default' => '' ] );
        $repeater->add_control( 'label',  [ 'label' => 'Label',  'type' => \Elementor\Controls_Manager::TEXT,   'default' => 'Stat description' ] );

        $this->add_control( 'stat_cards', [
            'label'       => 'Stats',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'count' => 97,  'suffix' => '%',  'prefix' => '',  'label' => 'Claim Acceptance Rate on First Submission' ],
                [ 'count' => 20,  'suffix' => '%',  'prefix' => '+', 'label' => 'Increase in Collections Within First Few Months' ],
                [ 'count' => 50,  'suffix' => '+',  'prefix' => '',  'label' => 'Healthcare Specialties Supported Nationwide' ],
            ],
            'title_field' => '{{{ label }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="section" id="our-story">
            <div class="container">
                <div class="about-split">
                    <div class="about-text fade-in-left">
                        <?php if ( $s['label_text'] ) : ?>
                            <span class="section-label"><span class="dot"></span> <?php echo esc_html( $s['label_text'] ); ?></span>
                        <?php endif; ?>
                        <h2 class="section-title"><?php echo wp_kses_post( $s['title'] ); ?></h2>
                        <div><?php echo wp_kses_post( $s['paragraph_1'] ); ?></div>
                        <div><?php echo wp_kses_post( $s['paragraph_2'] ); ?></div>
                    </div>
                    <div class="about-stats fade-in-right">
                        <?php foreach ( $s['stat_cards'] as $stat ) :
                            $initial = $stat['prefix'] . '0' . $stat['suffix'];
                        ?>
                            <div class="about-stat-card">
                                <div class="asc-num"
                                     data-count="<?php echo intval( $stat['count'] ); ?>"
                                     data-suffix="<?php echo esc_attr( $stat['suffix'] ); ?>"
                                     data-prefix="<?php echo esc_attr( $stat['prefix'] ); ?>">
                                    <?php echo esc_html( $initial ); ?>
                                </div>
                                <div class="asc-text"><?php echo esc_html( $stat['label'] ); ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

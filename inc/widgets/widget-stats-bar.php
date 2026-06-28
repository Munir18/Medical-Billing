<?php
/**
 * Widget: Stats Bar
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class HFRCM_Widget_Stats_Bar extends \Elementor\Widget_Base {

    public function get_name()       { return 'hfrcm_stats_bar'; }
    public function get_title()      { return 'HFRCM – Stats Bar'; }
    public function get_icon()       { return 'eicon-counter'; }
    public function get_categories() { return [ 'healthflowrcm' ]; }
    public function get_keywords()   { return [ 'stats', 'numbers', 'counter', 'healthflow' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_stats', [
            'label' => 'Statistics',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'count',  [ 'label' => 'Count (number only)', 'type' => \Elementor\Controls_Manager::NUMBER, 'default' => 97 ] );
        $repeater->add_control( 'suffix', [ 'label' => 'Suffix (%, +, hr…)',  'type' => \Elementor\Controls_Manager::TEXT,   'default' => '%' ] );
        $repeater->add_control( 'prefix', [ 'label' => 'Prefix (optional)',   'type' => \Elementor\Controls_Manager::TEXT,   'default' => '' ] );
        $repeater->add_control( 'label',  [ 'label' => 'Label',               'type' => \Elementor\Controls_Manager::TEXT,   'default' => 'First-Pass Acceptance' ] );

        $this->add_control( 'stats', [
            'label'       => 'Stats',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'count' => 97,  'suffix' => '%',  'prefix' => '',  'label' => 'First-Pass Acceptance' ],
                [ 'count' => 20,  'suffix' => '%',  'prefix' => '+', 'label' => 'Collection Increase' ],
                [ 'count' => 48,  'suffix' => 'hr', 'prefix' => '',  'label' => 'Avg Turnaround' ],
                [ 'count' => 50,  'suffix' => '+',  'prefix' => '',  'label' => 'Specialties Covered' ],
            ],
            'title_field' => '{{{ label }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="stats-bar section-primary section-sm">
            <div class="container">
                <div class="stats-grid">
                    <?php foreach ( $s['stats'] as $stat ) :
                        $initial = $stat['prefix'] . '0' . $stat['suffix'];
                    ?>
                        <div class="stat-item fade-in">
                            <div class="stat-number"
                                 data-count="<?php echo intval( $stat['count'] ); ?>"
                                 data-suffix="<?php echo esc_attr( $stat['suffix'] ); ?>"
                                 data-prefix="<?php echo esc_attr( $stat['prefix'] ); ?>">
                                <?php echo esc_html( $initial ); ?>
                            </div>
                            <div class="stat-label"><?php echo esc_html( $stat['label'] ); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}

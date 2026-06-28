<?php
/**
 * Widget: Services Panel (accordion-style list + preview pane – Services page)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class HFRCM_Widget_Services_Panel extends \Elementor\Widget_Base {

    public function get_name()       { return 'hfrcm_services_panel'; }
    public function get_title()      { return 'HFRCM – Services Panel'; }
    public function get_icon()       { return 'eicon-accordion'; }
    public function get_categories() { return [ 'healthflowrcm' ]; }
    public function get_keywords()   { return [ 'services', 'panel', 'accordion', 'healthflow' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_services', [
            'label' => 'Services',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'cta_link', [
            'label'   => 'CTA Link (all preview cards)',
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '/book-a-consultation/' ],
        ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'id',          [ 'label' => 'Unique ID (no spaces)',     'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'billing' ] );
        $repeater->add_control( 'icon',         [ 'label' => 'Icon (emoji)',             'type' => \Elementor\Controls_Manager::TEXT,     'default' => '📋' ] );
        $repeater->add_control( 'title',        [ 'label' => 'Service Title',            'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Service Name' ] );
        $repeater->add_control( 'short',        [ 'label' => 'Short Description',        'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'One-line summary.' ] );
        $repeater->add_control( 'badge',        [ 'label' => 'Preview Badge',            'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Full Service' ] );
        $repeater->add_control( 'description',  [ 'label' => 'Preview Description',      'type' => \Elementor\Controls_Manager::WYSIWYG,  'default' => 'Detailed description.' ] );
        $repeater->add_control( 'features',     [ 'label' => 'Features (one per line)',  'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => "Feature 1\nFeature 2\nFeature 3" ] );
        $repeater->add_control( 'stat_value',   [ 'label' => 'Stat Value',              'type' => \Elementor\Controls_Manager::TEXT,     'default' => '97%' ] );
        $repeater->add_control( 'stat_label',   [ 'label' => 'Stat Label',              'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Stat description' ] );
        $repeater->add_control( 'cta_text',     [ 'label' => 'CTA Button Text',         'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Get Started' ] );

        $this->add_control( 'services', [
            'label'       => 'Services',
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'id' => 'billing',      'icon' => '📋', 'title' => 'Medical Billing & Revenue Cycle Management', 'short' => 'Complete billing lifecycle from charge entry to patient collections.',         'badge' => 'Full Service', 'description' => 'Our comprehensive medical billing service covers the entire revenue cycle from start to finish.',    'features' => "Charge Entry & Verification\nClaims Submission & Correction\nPayment Posting & Reconciliation\nDenial Management & Appeals\nPatient Billing & Collections\nFinancial Reporting & Analytics",    'stat_value' => '97%',      'stat_label' => 'First-pass claim acceptance rate', 'cta_text' => 'Get Started' ],
                [ 'id' => 'coding',       'icon' => '📝', 'title' => 'Medical Coding Services',                   'short' => 'Certified coding for all specialties with risk adjustment support.',           'badge' => 'Certified',    'description' => 'Our certified coders ensure accurate code assignment for all specialties.',                        'features' => "Certified Outpatient & Inpatient Coding\nSpecialty Specific Coding Support\nRisk Adjustment Coding (HCC)\nCoding Audits & Compliance Reviews\nICD-10, CPT, and HCPCS Expertise",              'stat_value' => '99.2%',    'stat_label' => 'Coding accuracy rate',            'cta_text' => 'Get Started' ],
                [ 'id' => 'credentialing','icon' => '🔔', 'title' => 'Credentialing & Enrollment',                'short' => 'Fast and reliable provider credentialing with all major payers.',               'badge' => 'End to End',   'description' => 'We handle the entire credentialing process so your providers can start billing as quickly as possible.','features' => "Provider Credentialing with All Major Payers\nPayer Enrollment & Re-enrollment\nERA & EFT Setup\nFacility & Group Enrollment\nCAQH Profile Management",                                      'stat_value' => '30 Days',  'stat_label' => 'Average credentialing turnaround', 'cta_text' => 'Get Started' ],
                [ 'id' => 'denial',       'icon' => '💥', 'title' => 'Denial Management & Appeals',               'short' => 'Proactive denial prevention and aggressive appeals recovery.',                 'badge' => 'Recovery',     'description' => 'Over 90% of claim denials are preventable.',                                                       'features' => "Root Cause Analysis\nDenial Categorization & Tracking\nAppeals Filing & Follow Up\nPrevention Strategy Implementation\nPayer Trend Analysis",                                                'stat_value' => '85%+',     'stat_label' => 'Appeal success rate',             'cta_text' => 'Get Started' ],
                [ 'id' => 'ar',           'icon' => '💰', 'title' => 'Accounts Receivable Management',            'short' => 'Dedicated A/R follow up to reduce aging and accelerate payments.',            'badge' => 'Optimization', 'description' => 'Our dedicated A/R team pursues every dollar owed to your practice.',                              'features' => "Aging Analysis & Prioritization\nInsurance Follow Up & Resubmission\nUnderpayment Identification & Recovery\nPatient Balance Collections\nWeekly A/R Performance Reporting",                'stat_value' => '35%',      'stat_label' => 'Average reduction in A/R days',   'cta_text' => 'Get Started' ],
                [ 'id' => 'eligibility',  'icon' => '🔍', 'title' => 'Eligibility Verification',                  'short' => 'Real time insurance verification before every patient visit.',                'badge' => 'Verification', 'description' => 'Verify patient insurance coverage before every visit.',                                           'features' => "Real Time Insurance Verification\nBenefit & Coverage Confirmation\nPrior Authorization Support\nCo-pay & Deductible Estimation\nCoverage Gap Identification",                               'stat_value' => '100%',     'stat_label' => 'Pre-visit verification coverage', 'cta_text' => 'Get Started' ],
                [ 'id' => 'helpdesk',     'icon' => '📞', 'title' => 'Patient Help Desk',                         'short' => 'Dedicated support for patient billing inquiries and payment assistance.',     'badge' => 'Support',      'description' => 'Give your patients a dedicated support line for all billing related inquiries.',                   'features' => "Patient Billing Inquiry Handling\nPayment Plan Setup & Management\nPayment Assistance & Processing\nStatement Clarification\nProfessional & Empathetic Communication",                     'stat_value' => '24/7',     'stat_label' => 'Available support coverage',       'cta_text' => 'Get Started' ],
                [ 'id' => 'software',     'icon' => '💻', 'title' => 'Software & Technology Support',             'short' => 'EHR/PM system expertise with training and transition support.',               'badge' => 'Technology',   'description' => 'We work with all leading EHR and practice management systems.',                                   'features' => "EHR/PM System Expertise\nSoftware Training & Onboarding\nSystem Transition Support\nWorkflow Optimization\nIntegration & Configuration",                                                   'stat_value' => '50+',      'stat_label' => 'EHR/PM systems supported',        'cta_text' => 'Get Started' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s        = $this->get_settings_for_display();
        $cta_url  = ! empty( $s['cta_link']['url'] ) ? $s['cta_link']['url'] : '/book-a-consultation/';
        $services = $s['services'];
        ?>
        <section class="section" id="services-main">
            <div class="container">
                <div class="services-layout">
                    <div class="service-list">
                        <?php foreach ( $services as $svc ) : ?>
                            <div class="service-item fade-in" data-service="<?php echo esc_attr( $svc['id'] ); ?>">
                                <div class="si-header">
                                    <div class="si-icon"><?php echo esc_html( $svc['icon'] ); ?></div>
                                    <div>
                                        <h3><?php echo esc_html( $svc['title'] ); ?></h3>
                                        <p class="si-short"><?php echo esc_html( $svc['short'] ); ?></p>
                                    </div>
                                    <div class="si-arrow">&#8250;</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="service-preview" id="servicePreview">
                        <div class="sp-default">
                            <div class="sp-default-icon">&#128073;</div>
                            <h3>Hover Over a Service</h3>
                            <p>Move your mouse over any service on the left to see a detailed preview with all included features right here.</p>
                        </div>

                        <?php foreach ( $services as $svc ) :
                            $features = array_filter( array_map( 'trim', explode( "\n", $svc['features'] ) ) );
                        ?>
                            <div class="sp-content" data-preview="<?php echo esc_attr( $svc['id'] ); ?>">
                                <?php if ( $svc['badge'] ) : ?>
                                    <div class="sp-badge"><?php echo esc_html( $svc['badge'] ); ?></div>
                                <?php endif; ?>
                                <h3><?php echo esc_html( $svc['title'] ); ?></h3>
                                <div><?php echo wp_kses_post( $svc['description'] ); ?></div>
                                <?php if ( ! empty( $features ) ) : ?>
                                    <h4>What's Included:</h4>
                                    <ul>
                                        <?php foreach ( $features as $feat ) : ?>
                                            <li>&#10003; <?php echo esc_html( $feat ); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                <?php if ( $svc['stat_value'] ) : ?>
                                    <div class="sp-stat">
                                        <span class="sp-stat-num"><?php echo esc_html( $svc['stat_value'] ); ?></span>
                                        <span class="sp-stat-text"><?php echo esc_html( $svc['stat_label'] ); ?></span>
                                    </div>
                                <?php endif; ?>
                                <a href="<?php echo esc_url( $cta_url ); ?>" class="btn btn-primary btn-sm"><?php echo esc_html( $svc['cta_text'] ); ?> <span class="arrow">&rarr;</span></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

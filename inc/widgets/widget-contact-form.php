<?php
/**
 * Widget: Contact Form (Book a Consultation page)
 */
if ( ! defined( 'ABSPATH' ) ) exit;

class HFRCM_Widget_Contact_Form extends \Elementor\Widget_Base {

    public function get_name()       { return 'hfrcm_contact_form'; }
    public function get_title()      { return 'HFRCM – Contact Form'; }
    public function get_icon()       { return 'eicon-form-horizontal'; }
    public function get_categories() { return [ 'healthflowrcm' ]; }
    public function get_keywords()   { return [ 'contact', 'form', 'consultation', 'healthflow' ]; }

    protected function register_controls() {

        $this->start_controls_section( 'section_content', [
            'label' => 'Form Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'title',         [ 'label' => 'Title',           'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Request a Free Consultation' ] );
        $this->add_control( 'description',   [ 'label' => 'Description',     'type' => \Elementor\Controls_Manager::WYSIWYG,  'default' => 'Fill out the details below and our team will contact you within one business day.' ] );
        $this->add_control( 'btn_text',      [ 'label' => 'Submit Button',   'type' => \Elementor\Controls_Manager::TEXT,     'default' => 'Submit Consultation Request' ] );

        $this->end_controls_section();

        $this->start_controls_section( 'section_sidebar', [
            'label' => 'Sidebar Content',
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        // Audit Card
        $this->add_control( 'audit_title',   [ 'label' => 'Audit Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '90-Day RCM Audit', 'separator' => 'before' ] );
        $this->add_control( 'audit_desc',    [ 'label' => 'Audit Desc',  'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Get a comprehensive analysis of your entire revenue cycle at absolutely no cost. Our audit includes:' ] );
        $this->add_control( 'audit_value',   [ 'label' => 'Audit Value', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => '$2,500' ] );

        // Contact Card
        $this->add_control( 'contact_title', [ 'label' => 'Contact Title', 'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Prefer to Talk?', 'separator' => 'before' ] );
        $this->add_control( 'contact_desc',  [ 'label' => 'Contact Desc',  'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Reach out to us directly. We are available Monday through Friday, 8 AM to 6 PM MT.' ] );
        $this->add_control( 'phone',         [ 'label' => 'Phone',         'type' => \Elementor\Controls_Manager::TEXT, 'default' => '+1 (406) 235-6348' ] );
        $this->add_control( 'email',         [ 'label' => 'Email',         'type' => \Elementor\Controls_Manager::TEXT, 'default' => 'Healthflowrcmllc@gmail.com' ] );
        $this->add_control( 'address',       [ 'label' => 'Address',       'type' => \Elementor\Controls_Manager::TEXT, 'default' => '1001 S Main St, STE 500, Kalispell, MT 59901, USA' ] );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>
        <section class="section" id="book-section">
            <div class="container">
                <div class="consult-layout">
                    
                    <!-- Left: Form Card -->
                    <div class="consult-form-wrap fade-in-left">
                        <div class="form-card">
                            <div class="fc-header">
                                <h2><?php echo wp_kses_post( $s['title'] ); ?></h2>
                                <p><?php echo wp_kses_post( $s['description'] ); ?></p>
                            </div>
                            
                            <form class="consultation-form" id="consultationForm" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                                <?php wp_nonce_field( 'hfrcm_contact_nonce', 'hfrcm_nonce' ); ?>
                                <input type="hidden" name="action" value="hfrcm_contact">

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="cf_first_name" class="form-label">First Name <span class="required">*</span></label>
                                        <input type="text" id="cf_first_name" class="form-input" name="first_name" placeholder="John" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cf_last_name" class="form-label">Last Name <span class="required">*</span></label>
                                        <input type="text" id="cf_last_name" class="form-input" name="last_name" placeholder="Smith" required>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="cf_email" class="form-label">Email Address <span class="required">*</span></label>
                                        <input type="email" id="cf_email" class="form-input" name="email" placeholder="john@practice.com" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cf_phone" class="form-label">Phone Number <span class="required">*</span></label>
                                        <input type="tel" id="cf_phone" class="form-input" name="phone" placeholder="+1 (555) 123-4567" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="cf_practice" class="form-label">Practice / Organization Name</label>
                                    <input type="text" id="cf_practice" class="form-input" name="practice" placeholder="Your Practice Name">
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="cf_specialty" class="form-label">Specialty</label>
                                        <select id="cf_specialty" class="form-select" name="specialty">
                                            <option value="">Select Specialty</option>
                                            <option>Cardiology</option>
                                            <option>Orthopedics</option>
                                            <option>Internal Medicine</option>
                                            <option>Dermatology</option>
                                            <option>Family Practice</option>
                                            <option>Neurology</option>
                                            <option>Oncology</option>
                                            <option>Surgery</option>
                                            <option>Radiology</option>
                                            <option>Psychiatry</option>
                                            <option>Urgent Care</option>
                                            <option>Multi-Specialty</option>
                                            <option>Other</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cf_providers" class="form-label">Number of Providers</label>
                                        <select id="cf_providers" class="form-select" name="providers">
                                            <option value="">Select Range</option>
                                            <option>1 to 5</option>
                                            <option>6 to 15</option>
                                            <option>16 to 30</option>
                                            <option>31 to 50</option>
                                            <option>50+</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="cf_service" class="form-label">Service Interested In</label>
                                    <select id="cf_service" class="form-select" name="service">
                                        <option value="">Select Service</option>
                                        <option>Medical Billing &amp; RCM</option>
                                        <option>Medical Coding</option>
                                        <option>Credentialing &amp; Enrollment</option>
                                        <option>Denial Management</option>
                                        <option>A/R Management</option>
                                        <option>Eligibility Verification</option>
                                        <option>Complete RCM Solution</option>
                                        <option>Free 90-Day RCM Audit</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="cf_message" class="form-label">Tell Us About Your Current Challenges</label>
                                    <textarea id="cf_message" class="form-textarea" name="message" placeholder="Describe your current billing challenges, pain points, or what you are looking for in an RCM partner..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary btn-lg btn-submit" style="width:100%;justify-content:center;">
                                    <?php echo esc_html( $s['btn_text'] ); ?> <span class="arrow">&rarr;</span>
                                </button>
                                <p class="form-note">&#128274; Your information is 100% secure and will never be shared. HIPAA compliant.</p>
                            </form>
                        </div>
                    </div>

                    <!-- Right: Sidebar -->
                    <div class="consult-sidebar fade-in-right">
                        
                        <!-- Free Audit Card -->
                        <div class="sidebar-card audit-card">
                            <div class="sc-badge">FREE OFFER</div>
                            <h3><?php echo esc_html( $s['audit_title'] ); ?></h3>
                            <p><?php echo esc_html( $s['audit_desc'] ); ?></p>
                            <ul>
                                <li>&#10003; Claims accuracy &amp; error analysis</li>
                                <li>&#10003; Denial rate assessment</li>
                                <li>&#10003; A/R aging review</li>
                                <li>&#10003; Coding compliance check</li>
                                <li>&#10003; Revenue leakage identification</li>
                                <li>&#10003; Custom improvement roadmap</li>
                            </ul>
                            <div class="audit-value">
                                <span class="av-label">Audit Value</span>
                                <span class="av-price"><s><?php echo esc_html( $s['audit_value'] ); ?></s> FREE</span>
                            </div>
                        </div>

                        <!-- Contact Card -->
                        <div class="sidebar-card contact-card">
                            <h3><?php echo esc_html( $s['contact_title'] ); ?></h3>
                            <p><?php echo esc_html( $s['contact_desc'] ); ?></p>
                            <div class="cc-item">
                                <span>&#128222;</span>
                                <a href="tel:<?php echo esc_attr( preg_replace('/[^0-9+]/', '', $s['phone']) ); ?>"><?php echo esc_html( $s['phone'] ); ?></a>
                            </div>
                            <div class="cc-item">
                                <span>&#9993;</span>
                                <a href="mailto:<?php echo esc_attr( $s['email'] ); ?>"><?php echo esc_html( $s['email'] ); ?></a>
                            </div>
                            <div class="cc-item">
                                <span>&#128205;</span>
                                <span><?php echo esc_html( $s['address'] ); ?></span>
                            </div>
                        </div>

                        <!-- Quick Stats Card (Static as per original HTML) -->
                        <div class="sidebar-card stats-card">
                            <h3>Why Providers Choose Us</h3>
                            <div class="qs-item">
                                <div class="qs-num">97%</div>
                                <div class="qs-text">First-pass claim acceptance</div>
                            </div>
                            <div class="qs-item">
                                <div class="qs-num">+20%</div>
                                <div class="qs-text">Average revenue increase</div>
                            </div>
                            <div class="qs-item">
                                <div class="qs-num">48hr</div>
                                <div class="qs-text">Average turnaround time</div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>
        <?php
    }
}

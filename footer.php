<?php
/**
 * HealthFlowRCM – Footer Template
 * All settings editable via Appearance → Customize → Footer Settings
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$tagline      = get_theme_mod( 'hfrcm_footer_tagline',    'HealthFlowRCM is a premier healthcare financial services company specializing in revenue cycle management solutions for providers of all sizes across the United States.' );
$phone        = get_theme_mod( 'hfrcm_footer_phone',      '+1 (406) 235-6348' );
$phone_link   = get_theme_mod( 'hfrcm_footer_phone_link', 'tel:+14062356348' );
$email        = get_theme_mod( 'hfrcm_footer_email',      'Healthflowrcmllc@gmail.com' );
$address      = get_theme_mod( 'hfrcm_footer_address',    '1001 S Main St, STE 500, Kalispell, MT 59901, USA' );
$copyright    = get_theme_mod( 'hfrcm_footer_copyright',  '&copy; ' . date( 'Y' ) . ' HealthFlowRCM. All Rights Reserved.' );
$fb_url       = get_theme_mod( 'hfrcm_social_facebook',   '#' );
$li_url       = get_theme_mod( 'hfrcm_social_linkedin',   '#' );
$tw_url       = get_theme_mod( 'hfrcm_social_twitter',    '#' );
?>
  <!-- Footer (edit via Customizer → Footer Settings) -->
  <footer class="footer" id="footer">
    <div class="container">
      <div class="footer-grid">

        <div class="footer-brand">
          <?php if ( has_custom_logo() ) :
            $logo_id  = get_theme_mod( 'custom_logo' );
            $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
          ?>
            <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="150" height="44">
          <?php else : ?>
            <img src="<?php echo esc_url( HFRCM_URI . '/assets/images/logo-white.png' ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="150" height="44">
          <?php endif; ?>
          <p><?php echo esc_html( $tagline ); ?></p>
        </div>

        <div>
          <h4 class="footer-heading">Quick Links</h4>
          <div class="footer-links">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
            <a href="<?php echo esc_url( hfrcm_url( 'about-us' ) ); ?>">About Us</a>
            <a href="<?php echo esc_url( hfrcm_url( 'services' ) ); ?>">Services</a>
            <a href="<?php echo esc_url( hfrcm_url( 'book-a-consultation' ) ); ?>">Book a Consultation</a>
          </div>
        </div>

        <div>
          <h4 class="footer-heading">Services</h4>
          <div class="footer-links">
            <a href="<?php echo esc_url( hfrcm_url( 'services' ) ); ?>">Medical Billing</a>
            <a href="<?php echo esc_url( hfrcm_url( 'services' ) ); ?>">Medical Coding</a>
            <a href="<?php echo esc_url( hfrcm_url( 'services' ) ); ?>">Credentialing</a>
            <a href="<?php echo esc_url( hfrcm_url( 'services' ) ); ?>">Denial Management</a>
            <a href="<?php echo esc_url( hfrcm_url( 'services' ) ); ?>">A/R Management</a>
          </div>
        </div>

        <div>
          <h4 class="footer-heading">Contact</h4>
          <div class="footer-contact">
            <?php if ( $phone ) : ?>
              <a href="<?php echo esc_attr( $phone_link ); ?>">&#128222; <?php echo esc_html( $phone ); ?></a>
            <?php endif; ?>
            <?php if ( $email ) : ?>
              <a href="mailto:<?php echo esc_attr( $email ); ?>">&#9993; <?php echo esc_html( $email ); ?></a>
            <?php endif; ?>
            <?php if ( $address ) : ?>
              <p>&#128205; <?php echo esc_html( $address ); ?></p>
            <?php endif; ?>
          </div>
        </div>

      </div><!-- .footer-grid -->

      <div class="footer-bottom">
        <p><?php echo wp_kses_post( $copyright ); ?></p>
        <div class="footer-social">
          <?php if ( $fb_url && $fb_url !== '#' ) : ?>
            <a href="<?php echo esc_url( $fb_url ); ?>" aria-label="Facebook" target="_blank" rel="noopener">f</a>
          <?php else : ?>
            <a href="#" aria-label="Facebook">f</a>
          <?php endif; ?>
          <?php if ( $li_url && $li_url !== '#' ) : ?>
            <a href="<?php echo esc_url( $li_url ); ?>" aria-label="LinkedIn" target="_blank" rel="noopener">in</a>
          <?php else : ?>
            <a href="#" aria-label="LinkedIn">in</a>
          <?php endif; ?>
          <?php if ( $tw_url && $tw_url !== '#' ) : ?>
            <a href="<?php echo esc_url( $tw_url ); ?>" aria-label="Twitter" target="_blank" rel="noopener">X</a>
          <?php else : ?>
            <a href="#" aria-label="Twitter">X</a>
          <?php endif; ?>
        </div>
      </div>

    </div>
  </footer>

<?php wp_footer(); ?>
</body>
</html>

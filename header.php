<?php
/**
 * HealthFlowRCM – Header Template
 * All settings editable via Appearance → Customize → Header Settings
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$show_bar     = get_theme_mod( 'hfrcm_show_announcement', true );
$bar_text     = get_theme_mod( 'hfrcm_announcement_text',  'Limited Offer: Get a FREE 90-Day RCM Audit for Your Practice' );
$bar_btn      = get_theme_mod( 'hfrcm_announcement_btn',   'Claim Now' );
$bar_link     = get_theme_mod( 'hfrcm_announcement_link',  '' );
if ( ! $bar_link ) $bar_link = hfrcm_url( 'book-a-consultation' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php if ( $show_bar ) : ?>
  <!-- Announcement Bar (edit via Customizer → Header Settings) -->
  <div class="announcement-bar">
    <span class="pulse-dot"></span>
    <?php echo esc_html( $bar_text ); ?>
    <a href="<?php echo esc_url( $bar_link ); ?>"><?php echo esc_html( $bar_btn ); ?> &rarr;</a>
  </div>
<?php endif; ?>

<!-- Site Header -->
<header class="header" id="header">
  <nav class="nav">

    <!-- Logo (edit via Customizer → Site Identity) -->
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-logo">
      <?php if ( has_custom_logo() ) :
        $logo_id  = get_theme_mod( 'custom_logo' );
        $logo_url = wp_get_attachment_image_url( $logo_id, 'full' );
      ?>
        <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="160" height="48">
      <?php else : ?>
        <img src="<?php echo esc_url( HFRCM_URI . '/assets/images/logo.jpg' ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="160" height="48">
      <?php endif; ?>
    </a>

    <!-- Navigation (edit via Appearance → Menus) -->
    <div class="nav-links" id="navLinks">
      <?php
      wp_nav_menu( array(
          'theme_location' => 'primary',
          'container'      => false,
          'items_wrap'     => '%3$s',
          'walker'         => new HFRCM_Nav_Walker(),
          'fallback_cb'    => 'hfrcm_fallback_menu',
          'depth'          => 1,
      ) );
      ?>
    </div>

    <div class="menu-toggle" id="menuToggle" aria-label="Toggle navigation menu">
      <span></span><span></span><span></span>
    </div>
  </nav>
</header>
<div class="mobile-overlay" id="mobileOverlay"></div>

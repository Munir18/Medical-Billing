# Health Flow RCM - WordPress Custom Theme

A professionally designed WordPress custom theme specifically built for healthcare and revenue cycle management services.

## Overview

Health Flow RCM is a custom-built WordPress theme designed to showcase healthcare services, consultancy offerings, and RCM (Revenue Cycle Management) expertise. The theme features a modern, clean design with comprehensive Elementor widget integration for flexible page building.

## Features

- **Custom Elementor Widgets** - Specialized widgets for:
  - Hero sections and page headers
  - Service grids and panels
  - Team member showcases
  - Testimonials and client reviews
  - Statistics and metrics display
  - Call-to-action banners
  - About and mission/vision sections
  - Process workflows
  - Contact forms and consultancy booking

- **Pre-built Page Templates**:
  - Home page
  - About page
  - Services page
  - Consultation booking page

- **Responsive Design** - Mobile-first approach ensuring perfect display across all devices

- **Demo Content** - Includes HTML templates and demo import functionality for quick setup

## Installation

1. Download or clone this repository
2. Upload to your WordPress themes directory: `/wp-content/themes/healthflowrcm/`
3. Activate the theme in WordPress Dashboard → Appearance → Themes
4. Customize using Elementor page builder

## File Structure

```
healthflowrcm/
├── index.php              # Main template file
├── header.php             # Header template
├── footer.php             # Footer template
├── page.php               # Page template
├── functions.php          # Theme functions and setup
├── style.css              # Main stylesheet
├── assets/                # Static assets
│   ├── css/               # Stylesheets
│   ├── images/            # Images
│   └── js/                # JavaScript files
├── inc/                   # Include files
│   ├── elementor-widgets.php    # Widget registration
│   ├── widget-hfrcm-block.php   # Block components
│   ├── demo-import.php          # Demo import functionality
│   └── widgets/                 # Individual widget files
└── page-templates/        # Custom page templates
```

## Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- Elementor (free or pro)

## Usage

### Adding Custom Widgets

Custom widgets are located in `inc/widgets/`. Each widget file handles specific functionality:
- Widget Hero - Hero banner sections
- Widget Services - Service showcase and grids
- Widget Testimonials - Client testimonials
- Widget Team - Team member listings
- And more specialized healthcare/RCM widgets

### Using Page Templates

Select page templates from the WordPress page editor:
1. Create/Edit a page
2. Look for "Template" option in the right sidebar
3. Select from available custom templates

### Demo Content

Import demo content using the demo import functionality in `inc/demo-import.php` to see the theme in action.

## Customization

### Style Modifications

Main theme styles can be modified in:
- `style.css` - Primary theme stylesheet
- `assets/css/theme.css` - Additional theme styles
- Individual widget styling within each widget file

### JavaScript

Extend functionality using:
- `assets/js/main.js` - Main JavaScript file
- `assets/js/services.js` - Service-related scripts

## Development

This theme is built with:
- PHP for backend functionality
- HTML5 for markup
- CSS3 for styling
- JavaScript for interactivity
- Elementor for page building integration

## Support

For issues, feature requests, or questions, please refer to the project documentation or contact the development team.

## License

This theme is licensed under the MIT License. See LICENSE.md for details.

## Author

Developed as a custom WordPress theme solution.

---

**Note**: This is a custom-developed theme. Ensure proper backups and testing before deploying to production environments.

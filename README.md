# Hello Motion

**A lightweight, minimalist WordPress theme built specifically to work seamlessly with the Elementor site builder, and fully compatible with the MotionUI Addons for Elementor plugin.**

[![License: GPL v3 or later](https://img.shields.io/badge/License-GPL%20v3%20or%20later- blue.svg)](https://www.gnu.org/licenses/gpl-3.0.html)
[![WordPress compatible](https://img.shields.io/badge/WordPress-6.0%2B-6633AA.svg)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4.svg)](https://www.php.net/)
[![Tested up to 7.0](https://img.shields.io/badge/Tested%20up%20to-7.0-8E0F6B.svg)](https://wordpress.org/)

[![MotionUI Addons](https://img.shields.io/badge/MotionUI%20Addons-Compatible-green.svg)](https://wordpress.org/plugins/motionui-addons-for-elementor/
[![motionuiaddons.com](https://img.shields.io/badge/motionuiaddons.com-Visit%20Site-blue.svg)](https://motionuiaddons.com/)

---

## Theme Overview

Hello Motion is a clean, bloat-free WordPress theme designed for users who want a flexible, easy-to-use website built with the **Elementor drag-and-drop site builder**. It's optimized for performance and works perfectly with the **MotionUI Addons for Elementor** plugin, giving you access to MotionUI's widget library, motion effects, and design controls on top of a minimal foundation.

The theme handles all the structural needs (headers, footers, navigation) through the Customizer, leaving every other pixel of your layout to Elementor — or MotionUI Addons widgets.

---

## ✅ MotionUI Addons for Elementor Compatibility

[motionuiaddons.com](https://motionuiaddons.com/) · [WordPress.org](https://wordpress.org/plugins/motionui-addons-for-elementor/)

| Feature | Status |
|---------|--------|
| MotionUI widgets | ✅ Fully compatible |
| Motion effects | ✅ Fully compatible |
| Design controls | ✅ Fully compatible |
| Theme integration | ✅ No conflicts |
| Page building | ✅ Recommended setup |

**Plugin details:**
- **Website:** [motionuiaddons.com](https://motionuiaddons.com/) — Full plugin documentation, demos, and support.
- **WordPress.org:** [MotionUI Addons for Elementor](https://wordpress.org/plugins/motionui-addons-for-elementor/) — Plugin repository page with installation, ratings, and support forums.

> **How to use:** After installing both the theme and MotionUI Addons for Elementor, any MotionUI widget can be added to Elementor canvas pages. The theme provides the header/footer structure, while Elementor (with MotionUI) handles the content area.

---

## 📦 Installation

### From WordPress.org

1. Navigate to **Appearance → Themes** in your WordPress dashboard.
2. Click **Add New** → **Upload Theme**.
3. Upload the `hello-motion.zip` file.
4. Activate the theme.

### Manual FTP

1. Upload the `hello-motion` directory to `wp-content/themes/`.
2. Activate the theme from **Appearance → Themes**.

### Via WP-CLI

```bash
wp theme install hello-motion --activate
```

---

## 🛠️ Requirements

- **WordPress:** 6.0 or later
- **PHP:** 7.4 or later
- **Elementor:** Latest version (free or Pro)
- **MotionUI Addons for Elementor:** Latest version (optional but recommended)

---

## ⚙️ Customizer Settings

All theme settings are available under **Appearance → Customizer → Header & Footer**.

### Header

| Setting | Type | Description |
|---------|------|-------------|
| **Header menu** | Select | Choose which menu appears in the site header. "Default" uses the menu assigned to the Header location. |
| **Header logo** | Media | Upload an image to use as the header logo. Replaces the site title. |

### Footer

| Setting | Type | Description |
|---------|------|-------------|
| **Footer menu** | Select | Choose which menu appears in the site footer. "Default" uses the menu assigned to the Footer location. |
| **Footer logo** | Media | Upload an image to use as the footer logo. Replaces the site title. |
| **Footer copyright text** | Textarea | Text shown at the bottom of the footer. Leave empty to use the value from Elementor Site Settings. |

---

## 📁 Template Structure

```
template-parts/
├── header.php          # Site header (logo, nav, mobile menu)
├── footer.php          # Site footer (copyright, social, etc.)
├── dynamic-header.php  # Dynamic header via Customizer
├── dynamic-footer.php  # Dynamic footer via Customizer
├── page-header.php     # Shared page header with title logic
├── single.php          # Single post/page template
├── archive.php         # Archive/tag/category template
├── search.php          # Search results template
└── 404.php             # 404 error template
```

### Key Template Parts

- **`header.php`** — Renders the site header only when Elementor is not handling the header location. Uses Customizer settings for logo and menu.
- **`footer.php`** — Renders the site footer only when Elementor is not handling the footer location. Includes `wp_footer()` call.
- **`page-header.php`** — Shared `<div class="page-header">` with title logic for all page types:
  - **404:** "The page can't be found."
  - **Search:** "Search results for: `{query}`"
  - **Archive/Blog home:** `the_archive_title()` + `the_archive_description()`
  - **Singular posts/pages:** `the_title()` wrapped in `<h1 class="entry-title">`
- **`dynamic-header.php`** / **`dynamic-footer.php`** — Elementor-integrated headers/footers when the Elementor experiment is active.

### Page Hierarchy

All requests flow through `index.php`, which dispatches to the appropriate template part based on conditional tags (`is_singular()`, `is_archive()`, `is_home()`, `is_search()`).

---

## 🔌 Hooks & Actions

The theme provides two action hooks for plugin developers to inject markup at specific points:

| Hook | Fires After |
|------|-------------|
| `hello_motion_before_content_start` | After the site header (`<header>`), before the main content |
| `hello_motion_after_content_end` | After the main content, before the site footer (`<footer>`) |

### Usage Example

```php
// In a plugin or theme
add_action( 'hello_motion_before_content_start', 'my_custom_header_text' );
function my_custom_header_text() {
    echo '<p class="welcome-text">Welcome to our site!</p>';
}
```

> **Note:** Hook names use the `hello_motion_` prefix to avoid collisions. For theme-wide consistency, consider using the `themeic_hello_motion_` prefix for new hooks.

---

## 🌐 Additional Features

- **Custom logo support** — Upload via Customizer or WordPress Site Icon.
- **Custom menus** — Assign locations "Header" and "Footer" in **Appearance → Menus**.
- **Responsive layout** — Mobile-first, works across all devices.
- **SEO friendly** — Clean HTML structure, proper heading hierarchy.
- **Translation ready** — `.pot` file included, `hello-motion` text domain.
- **Gutenberg compatible** — Full support for block editor.

---

## 🛡️ License

Hello Motion is released under the [GNU General Public License v3 or later](https://www.gnu.org/licenses/gpl-3.0.html).

This means you're free to use, modify, and distribute the theme — even commercially — provided you include the original copyright and license notice.

---

## 🙏 Credits

- **Theme:** Themeic (https://themeic.com/)
- **Framework:** WordPress, Elementor
- **Compatible with:** MotionUI Addons for Elementor
- **Icons:** Dashicons (WordPress core)

---

## 📬 Contact

- **Website:** https://themeic.com/
- **Support:** WordPress.org support forum
- **Email:** support@themeic.com

---

## 🛠️ Development

### Project Setup

```bash
# Install dependencies
composer install   # if using Composer
npm install        # for asset build (if applicable)

# Lint / format
phpcs --standard=wpcs *.php

# Run tests (if any)
vendor/bin/phpunit
```

### Adding a New Customizer Field

```php
function themeic_hello_motion_customize_register( $wp_customize ) {
    $customizer = new Hello_Motion_Customaizer( 'themeic-hello-motion-' );

    $customizer->add_field( 'themeic-hello-motion-options', 'my_new_field', [
        'type'        => 'text',
        'label'       => esc_html__( 'My Field', 'hello-motion' ),
        'description' => esc_html__( 'Description', 'hello-motion' ),
        'priority'    => 40,
    ] );

    return $customizer;
}
add_action( 'customize_register', 'themeic_hello_motion_customize_register' );
```

### Adding a New Hook

```php
// In header.php, after the opening <header> tag:
do_action( 'hello_motion_before_content_start' );

// In footer.php, at the very top (before <footer>):
do_action( 'hello_motion_after_content_end' );
```
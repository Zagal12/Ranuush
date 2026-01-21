=== Contact Form Gmail ===
Contributors: ranuush
Donate link: https://github.com/Zagal12/Ranuush
Tags: contact form, gmail, smtp, ajax, email
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A simple, secure contact form that sends messages directly to Gmail using SMTP. Features AJAX submission, validation, and customizable button colors.

== Description ==

Contact Form Gmail is a lightweight WordPress plugin that allows you to add a professional contact form to your website with direct Gmail integration via SMTP.

= Key Features =

* **Simple Contact Form** - Name, Email, and Message fields
* **AJAX Submission** - No page reload for better user experience
* **Gmail SMTP Compatible** - Works with WP Mail SMTP and other SMTP plugins
* **Security First** - Full input sanitization and validation
* **Customizable** - Change button colors from admin panel
* **Success/Error Messages** - Clear feedback for users
* **Responsive Design** - Works perfectly on mobile devices
* **Easy to Use** - Simple shortcode implementation

= How It Works =

1. Install and activate the plugin
2. Install an SMTP plugin (WP Mail SMTP recommended)
3. Configure Gmail SMTP settings
4. Add the shortcode `[contact_form_gmail]` to any page or post
5. Start receiving contact form submissions!

= SMTP Configuration =

This plugin uses WordPress's built-in `wp_mail()` function, making it compatible with any SMTP plugin. We recommend **WP Mail SMTP** for Gmail configuration.

**Gmail SMTP Settings:**
* SMTP Host: smtp.gmail.com
* SMTP Port: 587 (TLS) or 465 (SSL)
* Encryption: TLS or SSL
* Authentication: ON

**Important:** You must create a Gmail App Password (not your regular password) for secure authentication.

= Security Features =

* WordPress nonce verification (CSRF protection)
* Input sanitization using WordPress core functions
* Email validation
* XSS prevention
* SQL injection prevention

== Installation ==

= Automatic Installation =

1. Log in to your WordPress admin panel
2. Go to Plugins → Add New
3. Search for "Contact Form Gmail"
4. Click "Install Now" and then "Activate"

= Manual Installation =

1. Download the plugin ZIP file
2. Log in to your WordPress admin panel
3. Go to Plugins → Add New → Upload Plugin
4. Choose the ZIP file and click "Install Now"
5. Click "Activate Plugin"

= After Installation =

1. Go to Settings → Contact Form Gmail
2. Enter your Gmail address as the recipient
3. Install and configure an SMTP plugin (WP Mail SMTP recommended)
4. Create a Gmail App Password in your Google Account
5. Configure SMTP settings with your App Password
6. Add `[contact_form_gmail]` shortcode to any page

== Frequently Asked Questions ==

= How do I add the contact form to my page? =

Simply add the shortcode `[contact_form_gmail]` to any page, post, or widget area.

= Do I need an SMTP plugin? =

Yes, for reliable email delivery via Gmail, you need to install an SMTP plugin like WP Mail SMTP and configure it with your Gmail credentials.

= What is a Gmail App Password? =

A Gmail App Password is a 16-character code that lets apps access your Gmail account securely. You can create one in your Google Account Security settings. Regular Gmail passwords won't work with SMTP.

= How do I create a Gmail App Password? =

1. Go to https://myaccount.google.com/
2. Click Security
3. Enable 2-Step Verification (if not already enabled)
4. Search for "App passwords"
5. Select "Mail" and "Other (Custom name)"
6. Click "Generate" and copy the password

= Can I change the button colors? =

Yes! Go to Settings → Contact Form Gmail and you'll find options to customize the button background color and text color.

= Where do the form submissions go? =

Submissions are sent to the email address you configure in Settings → Contact Form Gmail. If not configured, they go to your WordPress admin email.

= Is the form secure? =

Yes! The plugin implements WordPress security best practices including nonce verification, input sanitization, validation, and XSS prevention.

= Does it work on mobile devices? =

Absolutely! The form is fully responsive and works perfectly on all devices.

= Can I customize the form fields? =

The current version includes Name, Email, and Message fields. Future versions will include more customization options.

== Screenshots ==

1. Contact form on the frontend
2. Admin settings page
3. Button color customization
4. Success message after submission
5. SMTP configuration guide

== Changelog ==

= 1.0.0 =
* Initial release
* AJAX form submission
* Gmail SMTP compatibility
* Input sanitization and validation
* Customizable button colors
* Admin settings page
* Responsive design
* Success/error messages

== Upgrade Notice ==

= 1.0.0 =
Initial release of Contact Form Gmail plugin.

== Additional Info ==

= Support =

For support and feature requests, please visit our GitHub repository:
https://github.com/Zagal12/Ranuush

= Privacy Policy =

This plugin does not collect, store, or transmit any user data. Form submissions are sent via email using your configured SMTP settings.

= Credits =

Developed by Ranuush following WordPress coding standards and best practices.

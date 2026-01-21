# Contact Form Gmail - WordPress Plugin

A simple, secure contact form plugin that sends messages directly to Gmail using WordPress's wp_mail() function with SMTP compatibility.

## Features

- ✅ Simple contact form with Name, Email, and Message fields
- ✅ AJAX form submission (no page reload)
- ✅ Full input sanitization and validation
- ✅ Compatible with Gmail SMTP
- ✅ Success and error message notifications
- ✅ Responsive design
- ✅ WordPress coding standards compliant
- ✅ Easy shortcode implementation
- ✅ Admin settings page

## Installation

### Method 1: Manual Installation

1. Download the plugin folder `a contact form`
2. Rename it to `contact-form-gmail` (remove spaces)
3. Upload the entire `contact-form-gmail` folder to `/wp-content/plugins/` directory
4. Go to WordPress Admin → Plugins
5. Activate the "Contact Form Gmail" plugin

### Method 2: ZIP Installation

1. Compress the plugin folder into a ZIP file
2. Go to WordPress Admin → Plugins → Add New → Upload Plugin
3. Upload the ZIP file and click "Install Now"
4. Activate the plugin

## Gmail SMTP Configuration

For the plugin to send emails via Gmail, you need to configure an SMTP plugin:

### Recommended: WP Mail SMTP Plugin

1. Install "WP Mail SMTP" plugin from WordPress repository
2. Go to WP Mail SMTP → Settings
3. Configure the following:

**Gmail SMTP Settings:**
- **From Email:** your-email@gmail.com
- **From Name:** Your Name/Website Name
- **Mailer:** Select "Gmail" or "Other SMTP"
- **SMTP Host:** smtp.gmail.com
- **SMTP Port:** 587 (for TLS) or 465 (for SSL)
- **Encryption:** TLS or SSL
- **Authentication:** ON
- **SMTP Username:** your-email@gmail.com
- **SMTP Password:** Your App Password (see below)

### Creating a Gmail App Password

**Important:** You cannot use your regular Gmail password. You must create an App Password:

1. Go to your Google Account: https://myaccount.google.com/
2. Navigate to Security
3. Enable 2-Step Verification (if not already enabled)
4. Go to "App passwords"
5. Select "Mail" and "Other (Custom name)"
6. Name it "WordPress Contact Form"
7. Click "Generate"
8. Copy the 16-character password
9. Use this password in your SMTP plugin settings

### Alternative SMTP Plugins

- **Easy WP SMTP**
- **Post SMTP**
- **Gmail SMTP**

Any of these plugins will work with the Contact Form Gmail plugin.

## Usage

### Adding the Contact Form

Use the shortcode in any page, post, or widget:

```
[contact_form_gmail]
```

### Setting Recipient Email

1. Go to WordPress Admin → Settings → Contact Form Gmail
2. Enter your Gmail address in "Recipient Email Address"
3. Click "Save Changes"

**Note:** If no email is set, forms will be sent to the WordPress admin email.

## Plugin Structure

```
contact-form-gmail/
├── contact-form-gmail.php    # Main plugin file
├── js/
│   └── contact-form.js        # AJAX handler
├── css/
│   └── contact-form.css       # Styling
└── README.md                  # Documentation
```

## How It Works

### PHP Backend (contact-form-gmail.php)
- Registers the shortcode `[contact_form_gmail]`
- Renders HTML form with Name, Email, Message fields
- Handles AJAX form submissions
- Sanitizes inputs using `sanitize_text_field()`, `sanitize_email()`, `sanitize_textarea_field()`
- Validates all fields (checks for empty values and valid email format)
- Uses `wp_mail()` to send emails (compatible with SMTP plugins)
- Implements WordPress nonce for security
- Provides admin settings page for configuration

### JavaScript (contact-form.js)
- Intercepts form submission
- Prevents page reload
- Sends form data via AJAX to WordPress backend
- Displays success/error messages dynamically
- Resets form after successful submission
- Provides real-time email validation
- Shows loading spinner during submission

### CSS (contact-form.css)
- Clean, modern form styling
- Responsive design for mobile devices
- Success/error message styling with animations
- Focus states and validation indicators

## Security Features

- **Nonce Verification:** Prevents CSRF attacks
- **Input Sanitization:** All inputs are sanitized before processing
- **Email Validation:** Uses WordPress `is_email()` function
- **XSS Prevention:** All output is escaped
- **Direct Access Prevention:** Plugin files cannot be accessed directly

## Customization

### Changing Form Styles

Edit `css/contact-form.css` to customize:
- Colors
- Fonts
- Spacing
- Button styles

### Modifying Form Fields

Edit the `render_contact_form()` method in `contact-form-gmail.php` to add or modify fields.

### Custom Email Template

Modify the email message format in the `handle_form_submission()` method.

## Troubleshooting

### Emails Not Sending

1. Verify SMTP plugin is installed and configured
2. Test SMTP connection in SMTP plugin settings
3. Check Gmail App Password is correct
4. Ensure 2-Step Verification is enabled in Google Account
5. Check WordPress debug.log for errors

### Form Not Submitting

1. Check browser console for JavaScript errors
2. Verify jQuery is loaded
3. Ensure AJAX URL is correct
4. Check WordPress debug mode

### "Security Check Failed" Error

1. Clear browser cache
2. Reload the page
3. Ensure nonce is being generated correctly

## Support

For issues or questions:
- Check the WordPress admin settings page
- Review this README
- Check WordPress error logs
- Verify SMTP configuration

## License

GPL v2 or later

## Credits

Developed following WordPress coding standards and best practices.

---

**Version:** 1.0.0  
**Last Updated:** January 11, 2026

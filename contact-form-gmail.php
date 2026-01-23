<?php
/**
 * Plugin Name: Contact-Form-Gmail
 * Plugin URI: https://github.com/Zagal12/contact-form-gmail
 * Description: A simple contact form that sends messages directly to Gmail using SMTP
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Author: Ranuush
 * Author URI: https://github.com/Zagal12
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: contact-form-gmail
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Main Contact Form Gmail Class
 */
class Contact_Form_Gmail {

    /**
     * Constructor
     */
    public function __construct() {
        // Register shortcode
        add_shortcode( 'contact_form_gmail', array( $this, 'render_contact_form' ) );
        
        // Enqueue scripts and styles
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        
        // AJAX handlers
        add_action( 'wp_ajax_submit_contact_form', array( $this, 'handle_form_submission' ) );
        add_action( 'wp_ajax_nopriv_submit_contact_form', array( $this, 'handle_form_submission' ) );
    }

    /**
     * Enqueue scripts and styles
     */
    public function enqueue_scripts() {
        wp_enqueue_style( 'contact-form-gmail-css', plugin_dir_url( __FILE__ ) . 'css/contact-form.css', array(), '1.0.0' );
        
        // Add custom button colors
        $bg_color = get_option( 'contact_form_gmail_button_bg_color', '#3498db' );
        $text_color = get_option( 'contact_form_gmail_button_text_color', '#ffffff' );
        
        $custom_css = "
            .contact-form .submit-btn {
                background-color: {$bg_color} !important;
                color: {$text_color} !important;
            }
            .contact-form .submit-btn:hover {
                background-color: {$bg_color} !important;
                opacity: 0.9;
            }
        ";
        wp_add_inline_style( 'contact-form-gmail-css', $custom_css );
        
        wp_enqueue_script( 'contact-form-gmail-js', plugin_dir_url( __FILE__ ) . 'js/contact-form.js', array( 'jquery' ), '1.0.0', true );
        
        // Localize script to pass AJAX URL
        wp_localize_script( 'contact-form-gmail-js', 'contactFormAjax', array(
            'ajax_url' => admin_url( 'admin-ajax.php' ),
            'nonce'    => wp_create_nonce( 'contact_form_nonce' )
        ) );
    }

    /**
     * Render contact form
     */
    public function render_contact_form( $atts ) {
        ob_start();
        ?>
        <div class="contact-form-wrapper">
            <form id="contact-form-gmail" class="contact-form" method="post">
                <div class="form-messages"></div>
                
                <div class="form-group">
                    <label for="contact-name">Name <span class="required">*</span></label>
                    <input type="text" id="contact-name" name="contact_name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="contact-email">Email <span class="required">*</span></label>
                    <input type="email" id="contact-email" name="contact_email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="contact-message">Message <span class="required">*</span></label>
                    <textarea id="contact-message" name="contact_message" class="form-control" rows="5" required></textarea>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="submit-btn">Send Message</button>
                    <span class="loading-spinner" style="display:none;">Sending...</span>
                </div>
                
                <?php wp_nonce_field( 'contact_form_nonce', 'contact_form_nonce_field' ); ?>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }

    /**
     * Handle form submission via AJAX
     */
    public function handle_form_submission() {
        // Verify nonce
        if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'contact_form_nonce' ) ) {
            wp_send_json_error( array( 'message' => 'Security check failed. Please refresh the page and try again.' ) );
        }

        // Sanitize and validate inputs
        $name = isset( $_POST['contact_name'] ) ? sanitize_text_field( $_POST['contact_name'] ) : '';
        $email = isset( $_POST['contact_email'] ) ? sanitize_email( $_POST['contact_email'] ) : '';
        $message = isset( $_POST['contact_message'] ) ? sanitize_textarea_field( $_POST['contact_message'] ) : '';

        // Validation
        $errors = array();

        if ( empty( $name ) ) {
            $errors[] = 'Name is required.';
        }

        if ( empty( $email ) ) {
            $errors[] = 'Email is required.';
        } elseif ( ! is_email( $email ) ) {
            $errors[] = 'Please enter a valid email address.';
        }

        if ( empty( $message ) ) {
            $errors[] = 'Message is required.';
        }

        // If there are errors, return them
        if ( ! empty( $errors ) ) {
            wp_send_json_error( array( 'message' => implode( '<br>', $errors ) ) );
        }

        // Prepare email
        $to = get_option( 'contact_form_gmail_recipient', get_option( 'admin_email' ) );
        $subject = 'New Contact Form Submission from ' . $name;
        
        $email_message = "You have received a new message from the contact form:\n\n";
        $email_message .= "Name: " . $name . "\n";
        $email_message .= "Email: " . $email . "\n\n";
        $email_message .= "Message:\n" . $message . "\n";

        // Email headers
        $headers = array(
            'Content-Type: text/plain; charset=UTF-8',
            'From: ' . $name . ' <' . $email . '>',
            'Reply-To: ' . $email
        );

        // Send email using wp_mail (compatible with SMTP plugins)
        $sent = wp_mail( $to, $subject, $email_message, $headers );

        if ( $sent ) {
            wp_send_json_success( array( 'message' => 'Thank you! Your message has been sent successfully.' ) );
        } else {
            wp_send_json_error( array( 'message' => 'Sorry, there was an error sending your message. Please try again later.' ) );
        }
    }
}

// Initialize the plugin
new Contact_Form_Gmail();

/**
 * Add settings page for plugin configuration
 */
add_action( 'admin_menu', 'contact_form_gmail_add_admin_menu' );
add_action( 'admin_init', 'contact_form_gmail_settings_init' );
add_action( 'admin_enqueue_scripts', 'contact_form_gmail_admin_scripts' );

function contact_form_gmail_admin_scripts( $hook ) {
    if ( 'settings_page_contact_form_gmail' !== $hook ) {
        return;
    }
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );
}

function contact_form_gmail_add_admin_menu() {
    add_options_page(
        'Contact Form Gmail Settings',
        'Contact Form Gmail',
        'manage_options',
        'contact_form_gmail',
        'contact_form_gmail_options_page'
    );
}

function contact_form_gmail_settings_init() {
    register_setting( 'contact_form_gmail_settings', 'contact_form_gmail_recipient' );
    register_setting( 'contact_form_gmail_settings', 'contact_form_gmail_button_bg_color' );
    register_setting( 'contact_form_gmail_settings', 'contact_form_gmail_button_text_color' );

    add_settings_section(
        'contact_form_gmail_settings_section',
        __( 'Email Settings', 'contact-form-gmail' ),
        'contact_form_gmail_settings_section_callback',
        'contact_form_gmail_settings'
    );

    add_settings_field(
        'contact_form_gmail_recipient',
        __( 'Recipient Email Address', 'contact-form-gmail' ),
        'contact_form_gmail_recipient_render',
        'contact_form_gmail_settings',
        'contact_form_gmail_settings_section'
    );

    add_settings_section(
        'contact_form_gmail_button_section',
        __( 'Button Customization', 'contact-form-gmail' ),
        'contact_form_gmail_button_section_callback',
        'contact_form_gmail_settings'
    );

    add_settings_field(
        'contact_form_gmail_button_bg_color',
        __( 'Button Background Color', 'contact-form-gmail' ),
        'contact_form_gmail_button_bg_color_render',
        'contact_form_gmail_settings',
        'contact_form_gmail_button_section'
    );

    add_settings_field(
        'contact_form_gmail_button_text_color',
        __( 'Button Text Color', 'contact-form-gmail' ),
        'contact_form_gmail_button_text_color_render',
        'contact_form_gmail_settings',
        'contact_form_gmail_button_section'
    );
}

function contact_form_gmail_recipient_render() {
    $recipient = get_option( 'contact_form_gmail_recipient', get_option( 'admin_email' ) );
    ?>
    <input type="email" name="contact_form_gmail_recipient" value="<?php echo esc_attr( $recipient ); ?>" class="regular-text">
    <p class="description">Enter the Gmail address where you want to receive contact form messages.</p>
    <?php
}

function contact_form_gmail_settings_section_callback() {
    echo __( 'Configure where contact form submissions should be sent.', 'contact-form-gmail' );
}

function contact_form_gmail_button_section_callback() {
    echo __( 'Customize the appearance of the submit button.', 'contact-form-gmail' );
}

function contact_form_gmail_button_bg_color_render() {
    $bg_color = get_option( 'contact_form_gmail_button_bg_color', '#3498db' );
    ?>
    <input type="text" name="contact_form_gmail_button_bg_color" value="<?php echo esc_attr( $bg_color ); ?>" class="color-picker" />
    <p class="description">Choose the background color for the send button (default: #3498db).</p>
    <script>
        jQuery(document).ready(function($){
            $('.color-picker').wpColorPicker();
        });
    </script>
    <?php
}

function contact_form_gmail_button_text_color_render() {
    $text_color = get_option( 'contact_form_gmail_button_text_color', '#ffffff' );
    ?>
    <input type="text" name="contact_form_gmail_button_text_color" value="<?php echo esc_attr( $text_color ); ?>" class="color-picker" />
    <p class="description">Choose the text color for the send button (default: #ffffff).</p>
    <?php
}

function contact_form_gmail_options_page() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
        <form action="options.php" method="post">
            <?php
            settings_fields( 'contact_form_gmail_settings' );
            do_settings_sections( 'contact_form_gmail_settings' );
            submit_button();
            ?>
        </form>
        
        <hr>
        
        <h2>How to Use</h2>
        <ol>
            <li>Add this shortcode to any page or post: <code>[contact_form_gmail]</code></li>
            <li>Configure an SMTP plugin (like "WP Mail SMTP" or "Easy WP SMTP") to send emails via Gmail</li>
            <li>Test the form to ensure emails are being delivered</li>
        </ol>
        
        <h2>Gmail SMTP Configuration</h2>
        <p>To send emails via Gmail, you need to install an SMTP plugin. Recommended: <strong>WP Mail SMTP</strong></p>
        <p>Gmail SMTP Settings:</p>
        <ul>
            <li>SMTP Host: smtp.gmail.com</li>
            <li>SMTP Port: 587 (TLS) or 465 (SSL)</li>
            <li>Encryption: TLS or SSL</li>
            <li>Username: Your Gmail address</li>
            <li>Password: App Password (not your regular Gmail password)</li>
        </ul>
        <p><strong>Note:</strong> You must create an App Password in your Google account settings for this to work securely.</p>
    </div>
    <?php
}

<?php
/*
Plugin Name: Mouzh Message
Plugin URI: https://github.com/mouzhhs/mouzh-message
Description: A WordPress plugin to send messages easily.
Version: 1.1
Author: Mouzh Hossain Shad
Author URI: https://github.com/mouzhhs
Requires at least: 6.0
Tested up to: 6.8
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: mouzh-message
Domain Path: /languages
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Register setting with sanitization callback
function mouzh_message_register_settings() {
    register_setting(
        'mouzh_message_options_group', // option group
        'mouzh_message_text',           // option name
        array(
            'sanitize_callback' => 'sanitize_text_field',
            'default' => 'Hello from Mouzh Message plugin!',
        )
    );
}
add_action( 'admin_init', 'mouzh_message_register_settings' );

// Add settings page under Settings menu
function mouzh_message_add_settings_page() {
    add_options_page(
        'Mouzh Message Settings',
        'Mouzh Message',
        'manage_options',
        'mouzh-message',
        'mouzh_message_settings_page_html'
    );
}
add_action( 'admin_menu', 'mouzh_message_add_settings_page' );

// Settings page HTML
function mouzh_message_settings_page_html() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }
    ?>
    <div class="wrap">
        <h1>Mouzh Message Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'mouzh_message_options_group' );
            do_settings_sections( 'mouzh_message_options_group' );
            $message = get_option( 'mouzh_message_text', 'Hello from Mouzh Message plugin!' );
            ?>
            <table class="form-table" role="presentation">
                <tr>
                    <th scope="row"><label for="mouzh_message_text">Footer Message</label></th>
                    <td>
                        <input name="mouzh_message_text" type="text" id="mouzh_message_text" value="<?php echo esc_attr( $message ); ?>" class="regular-text" />
                        <p class="description">Enter the message to display in the footer.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Print message in the footer
function mouzh_message_print_footer_message() {
    $message = get_option( 'mouzh_message_text', '' );
    if ( ! empty( $message ) ) {
        echo '<p style="text-align:center; padding:10px 0; font-style:italic;">' . esc_html( $message ) . '</p>';
    }
}
add_action( 'wp_footer', 'mouzh_message_print_footer_message' );

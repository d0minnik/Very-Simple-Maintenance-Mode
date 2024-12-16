<?php
/*
Plugin Name: Very Simple Maintenance Mode
Description: A simple plugin to enable a maintenance mode with custom title, message, and styles.
Version: 1.1
Author: Dominik
*/

// 1. Add options to the WordPress database to store the settings
function maintenance_mode_settings() {
    add_option( 'maintenance_mode_enabled', 'off' ); // Default is off
    add_option( 'maintenance_mode_title', 'Site Under Construction' ); // Default title
    add_option( 'maintenance_mode_message', 'The site is currently under maintenance. Please check back later.' ); // Default message
    add_option( 'maintenance_mode_styles', 'body { background-color: #f0f0f0; text-align: center; padding: 50px; } h1 { color: red; }' ); // Default styles
}
add_action( 'admin_init', 'maintenance_mode_settings' );

// 2. Create a settings page in the admin panel where the user can modify settings
function maintenance_mode_settings_page() {
    ?>
    <div class="wrap">
        <h2>Maintenance Mode Settings</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'maintenance_mode_group' );
            wp_nonce_field( 'maintenance_mode_nonce_action', 'maintenance_mode_nonce' ); // Add nonce for security
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Enable Maintenance Mode</th>
                    <td><input type="checkbox" name="maintenance_mode_enabled" value="on" <?php echo get_option( 'maintenance_mode_enabled' ) == 'on' ? 'checked' : ''; ?> /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Message Title</th>
                    <td><input type="text" name="maintenance_mode_title" value="<?php echo esc_attr( get_option( 'maintenance_mode_title' ) ); ?>" /></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Message Content</th>
                    <td><textarea name="maintenance_mode_message"><?php echo esc_textarea( get_option( 'maintenance_mode_message' ) ); ?></textarea></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Custom Styles</th>
                    <td><textarea style="width: 400px; height: 400px; " name="maintenance_mode_styles"><?php echo esc_textarea( get_option( 'maintenance_mode_styles' ) ); ?></textarea></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// 3. Add the settings page to the WordPress admin menu
function maintenance_mode_menu() {
    add_options_page( 'Maintenance Mode Settings', 'Maintenance Mode', 'manage_options', 'maintenance_mode', 'maintenance_mode_settings_page' );
}
add_action( 'admin_menu', 'maintenance_mode_menu' );

// 4. Register the settings so they can be saved and retrieved
function maintenance_mode_register_settings() {
    register_setting( 'maintenance_mode_group', 'maintenance_mode_enabled' );
    register_setting( 'maintenance_mode_group', 'maintenance_mode_title' );
    register_setting( 'maintenance_mode_group', 'maintenance_mode_message' );
    register_setting( 'maintenance_mode_group', 'maintenance_mode_styles' );
}
add_action( 'admin_init', 'maintenance_mode_register_settings' );

// 5. Check if maintenance mode is enabled, and display the custom message
function check_maintenance_mode() {
    // If maintenance mode is enabled
    if ( get_option( 'maintenance_mode_enabled' ) == 'on' ) {
        // Only display the message for non-administrators
        if ( ! current_user_can( 'administrator' ) ) {
            // Get the custom title, content, and styles for the message
            $title = get_option( 'maintenance_mode_title', 'Site Under Construction' );
            $message = get_option( 'maintenance_mode_message', 'The site is currently under maintenance.' );
            $styles = get_option( 'maintenance_mode_styles', 'body { background-color: #000; text-align: center; padding: 50px; } h1 { color: #fff; }' );
            
            // Output the custom styles
            echo '<style>' . esc_html( $styles ) . '</style>';
            
            // Display the custom title and content
            echo '<h1>' . esc_html( $title ) . '</h1>';
            echo '<p>' . esc_html( $message ) . '</p>';
            exit; // Stop further page load
        }
    }
}

// 6. Trigger the check for maintenance mode when loading the page
add_action( 'wp', 'check_maintenance_mode' );

?>

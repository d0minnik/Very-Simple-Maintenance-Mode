<?php
/**
 * Plugin Name: Custom DB Error Message
 * Description: Changes the database connection error message to a custom one with editable title, content, and style.
 * Version: 1.0
 * Author: Dominik
 * License: GPL2
 */

// Add a settings page to the admin menu
function custom_db_error_message_menu() {
    add_options_page(
        'Custom DB Error Message Settings', // Page title
        'Custom DB Error Message', // Menu title
        'manage_options', // Capability required to access the page
        'custom-db-error-message', // Menu slug
        'custom_db_error_message_settings_page' // Callback function to display the settings page
    );
}
add_action('admin_menu', 'custom_db_error_message_menu');

// Display the settings page
function custom_db_error_message_settings_page() {
    ?>
    <div class="wrap">
        <h1>Database Error Message Settings</h1>
        <form method="post" action="options.php">
            <?php
            // Security measure
            settings_fields('custom_db_error_message_options_group');
            // Load settings sections
            do_settings_sections('custom-db-error-message');
            ?>
            <p class="submit">
                <input type="submit" class="button-primary" value="Save Changes" />
            </p>
        </form>
    </div>
    <?php
}

// Register plugin settings
function custom_db_error_message_settings_init() {
    // Register our options group and option name
    register_setting('custom_db_error_message_options_group', 'custom_db_error_message_options');
    
    // Add a settings section
    add_settings_section(
        'custom_db_error_message_section', 
        'Customize Database Error Message', 
        null, 
        'custom-db-error-message'
    );

    // Add fields to the section
    add_settings_field(
        'custom_db_error_message_title', 
        'Error Message Title', 
        'custom_db_error_message_title_field', 
        'custom-db-error-message', 
        'custom_db_error_message_section'
    );
    
    add_settings_field(
        'custom_db_error_message_content', 
        'Error Message Content', 
        'custom_db_error_message_content_field', 
        'custom-db-error-message', 
        'custom_db_error_message_section'
    );
    
    add_settings_field(
        'custom_db_error_message_style', 
        'Custom CSS Styles', 
        'custom_db_error_message_style_field', 
        'custom-db-error-message', 
        'custom_db_error_message_section'
    );
}
add_action('admin_init', 'custom_db_error_message_settings_init');

// Display the title field
function custom_db_error_message_title_field() {
    $options = get_option('custom_db_error_message_options');
    ?>
    <input type="text" name="custom_db_error_message_options[title]" value="<?php echo esc_attr($options['title'] ?? 'Site Under Construction'); ?>" class="regular-text" />
    <?php
}

// Display the content field
function custom_db_error_message_content_field() {
    $options = get_option('custom_db_error_message_options');
    ?>
    <textarea name="custom_db_error_message_options[content]" rows="5" class="large-text"><?php echo esc_textarea($options['content'] ?? 'Sorry, our site is temporarily unavailable due to technical issues. Please try again later.'); ?></textarea>
    <?php
}

// Display the CSS styles field
function custom_db_error_message_style_field() {
    $options = get_option('custom_db_error_message_options');
    ?>
    <textarea name="custom_db_error_message_options[style]" rows="5" class="large-text"><?php echo esc_textarea($options['style'] ?? ''); ?></textarea>
    <?php
}

// Add custom error message if database connection fails
function custom_db_error_message() {
    // Skip if the WordPress installation process is running
    if ( defined('WP_INSTALLING') && WP_INSTALLING ) {
        return;
    }

    // Only show the custom message if the user is not logged in and not in admin
    if ( !is_user_logged_in() && !is_admin() ) {
        // Get the stored options
        $options = get_option('custom_db_error_message_options');
        $title = esc_html($options['title'] ?? 'Site Under Construction');
        $content = esc_html($options['content'] ?? 'Sorry, our site is temporarily unavailable due to technical issues. Please try again later.');
        $style = esc_html($options['style'] ?? '');

        // Display the custom error message with the title, content, and styles
        echo '<html><head><title>' . $title . '</title></head><body>';
        echo '<h1 style="text-align: center; color: red;">' . $content . '</h1>';
        if ($style) {
            echo '<style>' . $style . '</style>';
        }
        echo '</body></html>';
        exit;
    }
}

// Hook into the shutdown process to display the custom error message
add_action('shutdown', 'custom_db_error_message', 0);

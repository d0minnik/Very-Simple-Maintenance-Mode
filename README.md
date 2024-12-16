# Custom DB Error Message Plugin

This WordPress plugin allows you to customize the default database connection error message displayed on your site. You can modify the title, content, and style of the error message directly from the WordPress admin panel. This is especially useful for displaying a user-friendly message when the site is temporarily unavailable due to a database connection issue.

## Features

- Customize the error message title, content, and style.
- Change the default database connection error message displayed by WordPress.
- Easily editable settings via the WordPress admin panel.
- Add custom CSS to style the error page.
- Supports multi-line content for the error message.

## Installation

1. Download the plugin files.
2. Upload the `custom-db-error-message` folder to your WordPress `wp-content/plugins/` directory.
3. Go to the WordPress admin panel and navigate to **Plugins** → **Installed Plugins**.
4. Activate the "Custom DB Error Message" plugin.
5. Once activated, go to **Settings** → **Custom DB Error Message** to configure the title, content, and style of your error message.

## Configuration

After installing and activating the plugin, you can configure the following settings:

- **Error Message Title**: Customize the title of the error page.
- **Error Message Content**: Add a message that will be displayed when there is a database connection issue.
- **Custom CSS Styles**: Add any custom CSS to style the error page to your preference.

## Example Usage

Here’s how the error page might look after customization:

- **Title**: Site Under Construction
- **Content**: Sorry, our site is temporarily unavailable due to technical issues. Please try again later.
- **Custom CSS**: You can add your custom styles to control the appearance of the error message.

### Sample Error Page

When a database connection issue occurs, the plugin will display the following message:

```html
<html>
<head>
    <title>Site Under Construction</title>
</head>
<body>
    <h1 style="text-align: center; color: red;">Sorry, our site is temporarily unavailable due to technical issues. Please try again later.</h1>
    <style>
        /* Custom CSS goes here */
    </style>
</body>
</html>

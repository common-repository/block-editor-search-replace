### Block Editor Search & Replace

Contributors: krasenslavov, developry
Donate Link: https://krasenslavov.com/hire-krasen/
Tags: block editor, blocks, classic editor, search, replace
Requires at least: 5.0
Tested up to: 6.6
Requires PHP: 7.2
Stable tag: 1.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Effortlessly search and replace text within the Block Editor's content area, with full support for the Classic Editor.

## DESCRIPTION

Effortlessly search and replace text within the Block Editor's content area, with full support for the Classic Editor.

Elevate your editing experience with our [**Block Editor Search & Replace**](https://krasenslavov.com/plugins/block-editor-search-replace) plugin! 

https://www.youtube.com/embed/5jKHHvnF7iI

Designed to seamlessly integrate into the WordPress environment, this plugin allows you to swiftly locate and replace text within the Block Editor. 

[**Block Editor Search & Replace**](https://krasenslavov.com/plugins/block-editor-search-replace) is engineered to cater to both modern and traditional workflows, offering full compatibility with the Classic Editor.

## USAGE

After installing and activating [**Block Editor Search & Replace**](https://krasenslavov.com/plugins/block-editor-search-replace), a new meta box labeled Search & Replace will be accessible in your page or post editing screen. Here's how it works:

1. Enter your search phrase to instantly highlight matching keywords within the content.
2. Input your desired replacement text and click the **Replace** button to execute the change.
3. Adjust settings on-the-fly, toggling the highlighter and case sensitivity options as needed.
4. Use the **Reset** button to remove any custom HTML tags created by the highlighter, restoring the text to its original state.

## FEATURES & LIMITATIONS

[**Block Editor Search & Replace**](https://krasenslavov.com/plugins/block-editor-search-replace) enhance your productivity with these streamlined features:

1. **Search & Replace:** A familiar, intuitive search and replace functionality.
2. **Highlighter:** Visual cues highlight all search hits, making editing more efficient.
3. **Case Sensitivity:** Flexibility to conduct case-sensitive or insensitive searches and replacements.
4. **Classic Editor Support:** Full backward compatibility ensures seamless integration with the Classic Editor.
5. **Full-text Management:** (To Be Added)

**Convenient User Settings**

While [**Block Editor Search & Replace**](https://krasenslavov.com/plugins/block-editor-search-replace) doesn't have a separate settings page, all configurations are conveniently located under `Settings > Search & Replace`. This includes:

* Toggle support between Block (Gutenberg) and Classic editors.
* Extend functionality to WooCommerce Products and all registered Custom Post Types.
* Manage these settings and more directly from the `Settings > Search & Replace` page for streamlined control.

## DETAILED DOCUMENTATION

The step-by-step setup, usage, demos, video, and insights can be found on [**Block Editor Search & Replace**](https://krasenslavov.com/plugins/block-editor-search-replace).

## BLOCK EDITOR SEARCH & REPLACE PRO

As of yet, this plugin doesn't have a commercial version available.

## FREQUENTLY ASKED QUESTIONS

Visit the [**Support**](https://wordpress.org/support/plugin/block-editor-search-replace/) tab on this page to post your requests and questions.

We typically address all tickets within a few days.

If you have a feature request, we'll add it to the plugin wish list and consider implementing it in the next major version.

### Is This Plugin Compatible with the Classic Editor?

**Absolutely!** [**Block Editor Search & Replace**](https://krasenslavov.com/plugins/block-editor-search-replace) ensures support and backward compatibility with the Classic Editor.

### Can This Plugin Be Used with Custom Post Types (CPT) or WooCommerce?

**Certainly!** For WooCommerce users, ensure that WooCommerce is active. Then, navigate to Settings > Search & Replace to activate the search and replace feature. This functionality is also available for all existing Custom Post Types.

### Is This Plugin Multisite Compatible?
**Yes**, our plugin has been rigorously tested and is fully functional on WordPress multisite environments.

### Are Revisions Saved by This Plugin?

**No**, to avoid cluttering your database with unnecessary revisions, the revision feature is disabled. However, you can utilize the Update button at the conclusion of your post or page editing process to save a standard WordPress revision.

### What If I Need Additional Support?

**Absolutely!** For any issues or queries, feel free to reach out through the contact form available on the [**Block Editor Search & Replace**](https://krasenslavov.com/plugins/block-editor-search-replace) website. We're here to help!

## SCREENSHOTS

The screenshots below highlight the primary way to use and access the plugin inside WordPress.

1. screenshot-1.(png)
2. screenshot-2.(png)
3. screenshot-3.(png)
4. screenshot-4.(png)
5. screenshot-5.(png)

## INSTALLATION

The installation process for the plugin is standard and user-friendly. Please inform us if you face any challenges throughout the installation.

= Installation from WordPress =

1. Visit **Plugins > Add New**.
2. Search for **Block Editor Search & Replace**.
3. Install and activate the **Block Editor Search & Replace** plugin.
4. Click on **Settings** link or go to **Settings > Search & Replace** from the main menu.

= Manual Installation =

1. Upload the contents of the entire `block-editor-search-replace` folder to the `/wp-content/plugins/` directory.
2. Visit **Plugins**.
3. Activate the **Block Editor Search & Replace** plugin.
4. Click on **Settings** link or go to **Settings > Block Editor Search & Replace** from the main menu.

= After Activation =

1. You can set some settings from **Settings > Search & Replace**.
2. Edit any individual Post or Page, with the Block or Classic Editor and you will see the additional meta box with search & replace form.

## CHANGELOG

= 1.2.0 =

- Fix - Missing `$domain` parameter in function call.
- Fix - Not unslashed before sanitization. Use `wp_unslash()` or similar.
- Fix - Detected usage of a non-sanitized input variable.
- Update - Replace all php files end of line sequence from `CRLF` to `LF`.
- Update - Don't show up the rating notice when toggle plugin activate/deactivate. 
- Update - Replace `BESNR_PLUGIN_DOMAIN` with krasenslavov.com in Settings main page.
- Update - Make `_wpnonce` standard throughout the plugin php and js files.
- Update - Update the correct support ticket link with `BESNR_PLUGIN_WPORG_SUPPORT`.
- Update - Regenerate the .pot file.
- New - Convert to HTML entities for non-ASCII characters.

= 1.1.9 =

- Update - PHP 8.3 compatibility check

= 1.1.8 =

- Update - WordPress 6.6 compatibility check

= 1.1.7 =

- New - Add WP admin main menu link as default and compact mode option for sub menu link
- Update - Remove promo code which was disabled temporary

= 1.1.6 =

- Fix - Fix upgrade notice to show every 30 days.

= 1.1.5 =

- Update - WordPress 6.5 compatibility check

= 1.1.4 =

- Fix - Replace all `json_encode` with `wp_json_encode`, and be sure the `json_decode` returns an array with 2nd arg `true`
- Fix - Add `wp_nonce` for rating and upgrade notices links
- Fix - Used `esc_html`, `esc_url`, `wp_kses` etc. to escape all missed strings
- Fix - Use `wp_strip_all_tags` for `strip_tags`

= 1.1.3 =

- New - Add upgrade notice with transient and dissmis nd success button
- Update - Add UTM for plugin website links
- Update - Update the rating notice block
- Update - Update dev files to the latest version

= 1.1.2 =

- Update - Remove admin user cap from `settings-menu.php`
- Update - Move all ajax actions to `settings-actions.php`
- Update - Move all search & replace ajax action to `/search-replace` files
- Update - Update development and workflow files to match the Pro
- Fix - Update the highlighter to search & replace to only the text without the HTML
- Fix - Update the highlighter to preserve letter case when doing insensitive search and replace

= 1.1.1 =

- Update - Break the requirements and settings into components
- Update - Break the SASS into componenets and fixed some small CSS issues
- Update - Refactor and optmize JS code, for the admin functions

= 1.1.0 =

- New - Brand new plugin file structure for improved maintenance and easy addons with
- New - Improved search and replace form UI
- New - Update and add new Settings page with options
- New - Used proper ReactJS for the block editor integration
- New - Fixed and update the highlight and case-sensitive checkboxes and funcitonlity

= 1.0.0 =

- Realease for the first stable version.

= 0.1.0 =

- Initial release (beta) and first commit into the WordPress.org SVN.

## UPGRADE NOTICE

_None_

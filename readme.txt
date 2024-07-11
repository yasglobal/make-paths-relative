=== Make Paths Relative ===
Contributors: sasiddiqui
Tags: Portable URLs, Relative Links, SEO-Friendly URLs, Multisite Compatibility, Subdomain Migration, URL Migration, Domain Move
Requires at least: 2.6
Tested up to: 6.5
Stable tag: 2.1.0
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Convert Absolute URLs to be relative in your fingertip.

## Description

This powerful plugin simplifies website maintenance by automatically converting absolute paths (URLs) for resources like links, scripts, stylesheets, and images to relative paths. This ensures your website functions flawlessly regardless of its location on a server or domain.

### Enhanced Efficiency and Flexibility

- **Seamless Relocation:** Move your website with confidence, knowing all paths will adjust accordingly, preventing broken links and preserving a seamless user - experience.
- **Centralized Control:** Update paths once in a central location, eliminating the need for tedious, site-wide modifications.
- **Potential Performance Boost:** Relative paths can, in some cases, improve website loading times.

### Whitelist Your Domains (Optional)

For extra control, you can specify a list of domains that will always be converted to relative paths. This ensures internal links are always optimized while allowing external resources to function properly.

### Embrace a Streamlined Approach

This plugin empowers you to focus on creating exceptional content while eliminating the burden of managing absolute paths. Take control, optimize your workflow, and ensure your website's continued success!

### Filters

If you want to make plugin works and all the paths relative without going to check/visit Settings Page so, just add this line in your theme's `functions.php`.

```
add_filter( 'make_paths_relative_activate_all', '__return_true' );
```

**Note**: Make sure to check the settings Page.

### Bug reports

Bug reports for **Make Paths Relative** are [welcomed on GitHub](https://github.com/yasglobal/make-paths-relative/issues/). Please note GitHub is not a support forum, and issues that aren't properly qualified as bugs will be closed.

## Installation

This process defines you the steps to follow either you are installing through WordPress or Manually from FTP.

### From within WordPress

1. Visit 'Plugins > Add New'
2. Search for Make Paths Relative
3. Activate Make Paths Relative from your Plugins page.
4. Go to **"after activation"** below.

### Manually

1. Upload the `make-paths-relative` folder to the `/wp-content/plugins/` directory
2. Activate Make Paths Relative through the 'Plugins' menu in WordPress
3. Go to **"after activation"** below.

### After activation

1. Go to the plugin settings page and set up the plugin for your site.
2. You're done!

## Changelog

= 2.1.0 - July 11, 2024 =

* Bugs:
  * Fixed an issue where replacements using \n or $n weren't working correctly.
* Feature Additions:
  * You can now include slashes in hostnames, giving you more flexibility.
  * For improved security, plugin can no longer be used on the admin dashboard.
  * We've enhanced how relative escaped URLs are handled within the body content.
  * Add functionality to relative WordPress stylesheet directory URIs.

= 2.0.0 - June 28, 2024 =

* Security Enhancement:
	* Implemented a nonce mechanism to safeguard page updates, preventing unauthorized modifications.
* Feature Additions:
	* Define multiple domains to be act as relative.
	* Enhanced content control by allowing removal of specific domains from the entire HTML body tag.

= Earlier versions =

  * For the changelog of earlier versions, please refer to the separate changelog.txt file.

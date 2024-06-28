# Make Paths Relative

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

```php
add_filter( 'make_paths_relative_activate_all', '__return_true' );
```

**Note**: Make sure to check the settings Page.

### Thanks for the Support

The support from the users that love Make Paths Relative is huge. You can support Make Paths Relative future development and help to make it even better by giving a 5-star rating with a nice message to me :)

## Installation

This process defines you the steps to follow either you are installing through WordPress or Manually from FTP.

### From within WordPress

1. Visit 'Plugins > Add New'
2. Search for Make Paths Relative
3. Activate Make Paths Relative from your Plugins page.
4. Go to "after activation" below.

### Manually

1. Upload the `make-paths-relative` folder to the `/wp-content/plugins/` directory
2. Activate Make Paths Relative through the 'Plugins' menu in WordPress
3. Go to "after activation" below.

### After activation

1. Go to the plugin settings page and set up the plugin for your site.
2. You're done!

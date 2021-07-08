# Make Paths Relative

## Description

This plugin can make(convert) the paths(URLs) to a relative instead of the absolute.
This plugin is useful for using relative URLs. The given below list of permalinks and src can
be easily converted to a relative:

* Post Permalinks
* Archive Permalinks
* Author Permalinks
* Term Permalinks
* Scripts Paths(src)
* Styles Paths(src)
* Image Paths(src)

All the above permalinks and src can be converted to a relative instead of absolute by using
this plugin. You can select the options from the plugin settings page.

### Filters

If you want to exclude some Permalink or src to be a relative then you can use
`paths_relative` filter in your theme's `functions.php` or in your custom plugin.

Your filter may look like this (Below filter would make the jquery.js Path to absolute):

```php
function yasglobal_change_path( $link ) {
  if( $link == '/wp-includes/js/jquery/jquery.js?ver=1.12.4' ) {
    $link = site_url().'/wp-includes/js/jquery/jquery.js?ver=1.12.4';
  }
  return $link;
}
add_filter( 'paths_relative', 'yasglobal_change_path' );
```

If you don't want to Make the Paths relative for srcset(Responsive Images) then add the
below-mentioned line in your theme's `functions.php`.

```php
add_filter( 'srcset_paths_relative', '__return_false' );
```

If you want to make plugin works and all the paths relative without going to
check/visit Settings Page so, just add this line in your theme's `functions.php`.

```php
add_filter( 'make_paths_relative_activate_all', '__return_true' );
```

**Note**: Make sure to check the settings Page.

### Thanks for the Support

The support from the users that love Make Paths Relative is huge. You can support
Make Paths Relative future development and help to make it even better by giving
a 5-star rating with a nice message to me :)

## Installation

This process defines you the steps to follow either you are installing through WordPress
or Manually from FTP.

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

## Frequently Asked Questions

**Q. Why should I install this plugin?**

A. Installing this plugin is the easiest way to make the paths(Permalinks + src) relative.

**Q. May I select the paths which I want to be shown as relative items?**

A. Yes, You can select the items you want to be relative.

**Q. May I exclude some items to be shown as absolute?**

A. Yes, You can exclude the items by using the add_filter
(You can find the filters in the [Description Area](https://github.com/yasglobal/make-paths-relative#filters)).

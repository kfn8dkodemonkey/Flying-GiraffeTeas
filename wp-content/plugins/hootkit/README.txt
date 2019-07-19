=== HootKit ===
Contributors: wphoot
Tags: widgets, wphoot, demo content, slider
Requires at least: 4.0
Tested up to: 5.2
Stable tag: 1.0.10
Requires PHP: 5.6
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-3.0.html

HootKit is a great companion plugin for WordPress themes by wpHoot.

== Description ==

HootKit is a great companion plugin for WordPress themes by wpHoot.
This plugin adds extra widgets and features to your theme. Though it will work with any theme, HootKit is primarily developed to work in sync with WordPress themes by wpHoot.

Get free support at <a href="https://wphoot.com/support" target="_blank">wpHoot Support</a>

== Installation ==

1. In your wp-admin (WordPress dashboard), go to Plugins Menu > Add New
2. Search for 'Hootkit' in search field on top right.
3. In the search results, click on 'Install Now' button next to Hootkit result.
4. Once the installation is complete, click Activate button.

You can also install the plugin manually by following these steps:
1. Download the plugin zip file from https://wordpress.org/plugins/hootkit/
2. In your wp-admin (WordPress dashboard), go to Plugins Menu > Add New
3. Click the 'Upload Plugin' button at the top.
4. Upload the zip file you downloaded in Step 1.
5. Once the upload is finish, click on Activate.

== Frequently Asked Questions ==

= What is the plugin license? =

This plugin is released under a GPL license.

= Which themes does HootKit work with? =

The plugin supports all themes, but works best with wpHoot Themes. A few options are available only in compatible wpHoot Themes.

== Changelog ==

= 1.0.10 =
* Run script on content-block-style5 on $(window).load instead of $(document).ready to properly calculate image heights
* Added singleSlideView class to slider template (corresponds to multiSlideView for carousels in themes)
* Fixed args for 'hootkit_content_blocks_start' action in Content Block widget
* Added multiselect option (select2 script) for various posts widgets
* SiteOrigin Page Builder compatibility (live preview) (new widget instance doesnt have all option values when post is saved without editing widget even once (in Gutenberg only))

= 1.0.9 =
* Widget Post List - Added No thumbnail option
* Added 'View All' option to Posts Blocks widget, Posts Image slider and Posts Carousel Slider
* Fixed content-block-style5 javascript for certain edge case scenarios (height not set properly when js loads before image or mouse hover out)
* Improved one click description to make sure user understands (added manual input Accept)
* Increased hoot_admin_list_item_count to 999 to remove limitation on terms lists
* Added missing argument for 'the_title' filter to prevent error with certain plugins
* Added data-type argument to slider template

= 1.0.8 =
* Improved slider/carousel template to use custom classes (for different slider styles)
* Link titles for post slider and carousel

= 1.0.6 =
* Added style 5 and 6 support for Content Block and Content Posts Block widgets
* Added variables for scrollspeed and scrollpadding for developers to override it using child themes
* Fixed limit for Content Block widget

= 1.0.5 =
* Added compatibility with latest Hoot Framework functions in v3.0.1
* Added style option for Call To Action widget for themes which support it
* Added profile widget
* Fixed array_search sanitization for vcard urls

= 1.0.4 =
* Bug Fix: Removed Composer autoloader for OCDI whcih did not work on certain installation environments

= 1.0.3 =
* Added support for content installation (ocdi) functionality
* Added nav option and pause time option for sliders and carousels
* Exclude carousel images from Jetpack lazyload
* Update register and load action priority
* Added wphoot themelist to register
* Set theme details data if not present
* Menu order function for wphoot themes

= 1.0.2 =
* Added preset combo (preset colors with bright option)
* Slider and Icon template - Minor updates
* Slider template - Remove counter break (for more slides option)
* Added new widgets

= 1.0.1 =
* Added Icon color option for announce widget
* Added several action and filter hooks for developer modifications
* Compatibility fix for for Jetpack lazy load with sliders
* Reworked widget options array syntax for easy modification using filters
* Cleaned up code at several locations and removed redundant functions
* Updated CSS

= 1.0.0 =
* Initial Public Release
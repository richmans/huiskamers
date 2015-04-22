=== Huiskamers ===
Tags: matching, huiskamers
Requires at least: 3.8.1
Tested up to: 3.8.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Local group administration plugin for thuisverder.nl

== Description ==
Provides a plugin for thuisverder.nl to administer a list of local groups. It allows visitors to connect to the groups by sending an email.


== Installation ==
1. Upload the `huiskamers` directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. place [huiskamers] somewhere in a post
4. Add the style of theme_style.css.example in your active theme and adjust it to your needs.

== Changelog ==

= 1.0 =
* First release

= 1.1 =
* Fix for age selection bug in the frontend

= 1.2 =
* Gave the email button a minimal size so it doesn't get squished

= 1.3 =
* Configured cron to support the reminder email

= 1.4 =
Added column sorting

= 1.5 = 
Small bugfix

= 1.6 = 
Makes it possible to change the order of huiskamers

= 1.7 = 
Added default value functionality to the framework
Added a switch to temporarily disable emails to huiskamers

= 1.8 =
Added not-found message.
The age search field is now executed directly (search button removed).
The age search field can now only contain numbers.
The rows are now tagged with even/odd style for zebra striping. (This is updated after filtering)
Now the huiskamers shortcode returns the widget instead of echo. This makes it able to insert it inside a post instead of only at the top.
Added theme_style.css.example
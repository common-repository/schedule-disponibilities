=== Plugin Name ===
Contributors: devnco
Donate link: http://www.hellomoon.be/
Tags: schedule, availability, horaire
Requires at least: 3.0.1
Tested up to: 4.3
Stable tag: 4.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin allows you to display some beautiful schedules on your wordpress by using simple shortcode.

== Description ==

This plugin allows you to display some beautiful schedules on your wordpress by using simple shortcode.

To begin, let's display an empty schedule by typing `[schedule show-all-days="true"]` on your page or post.

To fill the availabilities, you should use the following attributes :`"mo","tu","we","th,"fr',sa","su"`

`Exemple : [schedule mo="10h00-14h00" su="09h30-13h00|15h00-19h00"]`

As you've seen in the first example there are some addtional attributes to display empty days. 

There are two of them :

1. `show-all-days` which displays the entire week (monday to sunday)
2. `show-week-days` which displays only the business days (monday to friday)

Both of them take a boolean value (true or false). If you leave them empty or with another value it will be considered false.

`Exemple : [schedule show-week-days="true" mo="10h00-13h00"]`

You can choose the color used to fill your schedule by providing a `color` tag. This one accept hexadecimal format such as `color="#003300"` or html color  `color="pink"`. *Don't forget the # before your code !*

`Exemple : [schedule show-week-days="true" mo="10h00-13h00" color="orange"]`

== Installation ==

Simply install and enable the plugin, you should be able to use it on your posts and articles right after that :-)


== Frequently Asked Questions ==


== Screenshots ==

1. A view of a shortcode used in a post article
2. Here is a render of the schedule 

== Changelog ==

= 1.0.8 =
* Enable plugin on new post page.
* Add plugin icon.

= 1.0.7 =
* Fix some bugs.

= 1.0.6 =
* New name for this plugin !
* Code improvement.

= 1.0.5 =
* Implementation of default style and responsive version.

= 1.0.4 =
* Add translation system for admin panel (fr).

= 1.0.3 =
* Fix a bug with js tinymce.

= 1.0.2 =
* Add french translation for the name of the days in frontend.
* Code improvements

= 1.0.1 =
* Add a button to content editor to set up and insert the shortcode with a configuration window.

= 1.0.0 =
* First release, you can use shortags :-D
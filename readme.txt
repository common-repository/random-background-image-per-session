=== Random Background Image Per Session ===
Contributors: waffleguy4
Tags: background, backgrounds, bg, image, images, random, fixed, full, screen, fade, theme plugin
Requires at least: 2.0.2
Tested up to: 3.1.1
Stable tag: 1.2.2

Chooses a random background image for each site visitor, but remembers the chosen background on each sub-page for the entire visit session. Allows full screen backgrounds that are fixed or scroll. Has optional fade effect.

== Description ==

Keep your site looking fresh!

= Features! =
* Randomly choose background image - every page refresh OR every user visit/session
* Upload background images using NextGen Gallery plugin (must install first) OR manual FTP uploads
* Position your background image centered and full width and height of screen.
* Fix the background image so that it doesn't scroll with the rest of the page OR have it scroll like default behavior
* Optionally fade in background dynamically using jQuery
* For scrolling backgrounds, optionally you can set height of background
* Internationalized - French & Spanish translations in progress

= Details! =
This plugin makes it easy to have a random background image displayed from a folder of available images, such that every time a user visits your site they see a "fresh" new look to your site. Optionally, the image is saved in a temporary cookie so that the chosen background image remains the same for the entire visit of the user on your site. The next time they visit your site, and once the browser cookie has expired, a new image will be randomly chosen. This is usually every 6 hours, but may vary due to various reasons. 

The plugin automatically adds the background image code to the top and bottom of your page, and will be displayed full screen behind all the other content. It does not slow your page load time because it requires no extra style sheets or javascript files. The only exception is that it will load jQuery if you choose to have a fading background and jQuery isn't already loaded.

= More Info =
[Plugin Article](http://davetcoleman.com/blog/random-background-image-per-session)

= Contributors = 
[Dave Coleman](http://davetcoleman.com/),
[Benjamin Dubois](http://www.imagerienumerique.com/)


== Installation ==

1. Install and activate through your Wordpress' Admin plugins page.
2. Within Admin, on the left "Appearance" sub-menu, select the "Random Background" menu item.
3. Follow the setup instruction on the page.

== Screenshots ==

1. Background is full height and width and is fixed - does not scroll with rest of page.
2. Background scrolls with page. Best to use a fading gradient at the bottom.
3. Plugin admin options page

== Changelog ==

= 1.0.0 =
* Started project

= 1.0.1 =
* Tweaked documentation

= 1.1.0 =
* Added the BG height and disable session persistance options on the settings page. Improved instructions and durability

= 1.1.1 =
* Tweaked documentation

= 1.2.1 =
* Added fixed background support
* Re-vamped settings page and step by step instructions
* Added optional jQuery fade-in (thanks Dubois)
* Added multi-lingual support (thanks Dubois)
* Added integration with NextGen Gallery (thanks Dubois)
* Translated to French (thanks Dubois)
* Removed custom class option - you can just use ".bg-rand" or "#bg-rand" in your style sheet


= To-Do =
update POedit 
Spanish translation


== Feedback ==
http://davetcoleman.com/blog/random-background-image-per-session
dave@davetcoleman.com




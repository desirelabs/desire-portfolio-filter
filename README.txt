=== Desire Portfolio Filter ===

Contributors: franck
Tags: portfolio, isotope, masonry, jetpack, pinterest like, cards
Requires at least: 3.5
Tested up to: 4.7.1
dev tag: 0.2.5
License: MIT
Desire Portfolio Filter is a responsive plugin which allows visitors to filter Jetpack portfolio by type.

== Description ==

Desire Portfolio Filter is designed to allow visitors to filter Jetpack portfolio by type. It's responsive, so can be used on tablets and smartphone, as well as desktop of course.

== Installation ==

**This plugin requires Jetpack plugin to be activated to get running !**

Upload the Desire Portfolio Filter plugin to your wp-content/plugins/ blog folder, then activate it.

1. Go to your portfolio page
2. Remove Jetpack shortcode
3. Select the newly added Portfolio Template
4. Publish

done!

== Development Notes ==

This plugin is not designed to replace Jetpack Portfolio Shortcode. By now, it doesn't offer the same level of customization in queries.
I'm working on the admin page to make it able to give the same options as Jetpack shortcode.

Concerning the template, especially the gutters and column sizes, there's no option in the administration pages to set it.
But you have the possibility to override the default CSS with your own values in order to get something that fits your needs :

* use .grid-sizer and .portfolio-item width to define the column width
* use .gutter-sizer width to set your gutter's size
* apply a margin-bottom to .portfolio-item, equal to .gutter-sizer width to get the job done

I'm willing to bring those features directly accessible via a dedicated administration menu page or via shortcode very soon. Probabably in a next release. So be patient :)

== Translation ==

The plugin comes with english and french translations. Feel free to [fork me on Github](https://github.com/neovea/desire-portfolio-filter "fork me on Github") if you want me to add yours :)

== Support ==

I'll offer support as much as I can through :
[WordPress official page](http://wordpress.org/plugins/desire-portfolio-filter/ "WordPress Official repository")
[My Github official page](https://github.com/neovea/desire-portfolio-filter "My Github Official repository")

*Notice that this plugin is made on my free time, so please, be patient if I don't answer your requests right away ;)*

== Changelog ==

= 1.0 =
* Update licence

= 0.2.4 =
* Fix language

= 0.2.3.2 =
* Added license file description

= 0.2.3.1 =
* Licence update to conform with Isotope library included in this package

= 0.2 =
* Fix image loading delay
* Add responsive design support

= 0.1.1 =
* Fix issue when deactivating custom post types but not jetpack
=== Wonderm00n's Simple Facebook Open Graph Meta Tags ===
Contributors: wonderm00n
Donate link: http://blog.wonderm00n.com/2011/10/14/wordpress-plugin-simple-facebook-open-graph-tags/
Tags: facebook, open graph, seo, share, social, meta
Requires at least: 3
Tested up to: 3.2.1
Stable tag: 0.1.5

This plugin inserts Facebook Open Graph Tags into your WordPress Blog/Website for more effective Facebook sharing results.

== Description ==

This plugin inserts Facebook Open Graph Tags into your WordPress Blog/Website for more effective Facebook sharing results.

It allows the user to choose which tags are, or not, included and also the default image if the post/page doesn't have one.

The tags that this plugin inserts are:

* **og:app_id** : From settings on the options screen
* **og:admins** : From settings on the options screen
* **og:site_name** : From blog title
* **og:title** : From post/page/archive/tag/... title
* **og:url** : From the post/page permalink
* **og:type** : "article" for posts and pages and "website" for all the others
* **og:description** : From post/page excerpt if it exists, or from post/page content
* **og:image** : From post/page featured/thumbnail image, or if it doesn't exists from the first image in the post content, or if it doesn't exists from the first image on the post media gallery, or if it doesn't exists from the default image defined on the options menu 

== Installation ==

1. Upload the `wonderm00n-open-graph` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Got to `Options`, `Wonderm00n's Open Graph` to set it up

== Changelog ==

= 0.1.5 =

* Fixed the way Categories and Tags pages links were being retrieved that would cause an error on WP 3.0
* Added the option to use a Custom text as homepage og:description instead of the Website Tagline
* Fixed a bug that wouldn't allow to uncheck the og:image tag

= 0.1.4 =

* Shortcodes are now stripped from og:description
* Changed og:app_id and og:admins not to be included by default

= 0.1.3 =

* Just fixing some typos

= 0.1.2 =

* Fixing a bug for themes that do not support post thumbnail

= 0.1.1 =

* Adding Open Graph Namespace to the HTML tag

= 0.1 =

* First release
=== Wonderm00n's Simple Facebook Open Graph Meta Tags ===
Contributors: wonderm00n
Donate link: http://blog.wonderm00n.com/2011/10/14/wordpress-plugin-simple-facebook-open-graph-tags/
Tags: facebook, open graph, seo, share, social, meta
Requires at least: 3
Tested up to: 3.4.2
Stable tag: 0.3.1

This plugin inserts Facebook Open Graph Tags into your WordPress Blog/Website for more effective Facebook sharing results.

== Description ==

This plugin inserts Facebook Open Graph Tags into your WordPress Blog/Website for more effective Facebook sharing results.
It also allows to insert the "enclosure" and "media:content" tags to the RSS feeds, so that apps like RSS Graffiti and twitterfeed post the image to Facebook correctly.

It allows the user to choose which tags are, or not, included and also the default image if the post/page doesn't have one.

The tags that this plugin inserts are:

* **fb:app_id** : From settings on the options screen.
* **fb:admins** : From settings on the options screen.
* **og:locale** : From Wordpress locale or chosen by the user.
* **og:site_name** : From blog title.
* **og:title** : From post/page/archive/tag/... title.
* **og:url** : From the post/page permalink.
* **og:type** : "website" or "blog" for the homepage and "article" for all the others.
* **og:description** : From post/page excerpt if it exist, or from post/page content. From category/tag description on it's pages, if it exist. From tagline, or custom text, on all the others.
* **og:image** : From post/page featured/thumbnail image, or if it doesn't exist from the first image in the post content, or if it doesn't exist from the first image on the post media gallery, or if it doesn't exist from the default image defined on the options menu. The same image chosen here will be used and enclosure/media:content on the RSS feed.

== Installation ==

1. Upload the `wonderm00n-open-graph` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Got to `Options`, `Wonderm00n's Open Graph` to set it up

== Changelog ==

= 0.3.1 =

* When saving settings the $_POST array was showned for debug/development reasons. This output has been removed.

= 0.3 =

* "SubHeading" plugin integration. It's now possible add this field to the "og:title" tag.
* Changed the way defaults and user settings are loaded and saved, to "try" to eliminate the problem some users experienced where the user settings would disappear.
* Bugfix: "Also add image to RSS/RSS2 feeds?" option was not being correctly loaded
* The plugin version is now showed both as a comment before the open graph tags and on the settings page

= 0.2.3 =

* No changes. Had a problem updating to 0.2.2 on the Wordpress website.

= 0.2.2 =

* Bugfix: small change to avoid using the "has_cap" function (deprecated). Thanks to @flynsarmy.

= 0.2.1 =

* Bugfix: when the og:image is not hosted on the same domain as the website/blog.

= 0.2 =

* If the option is set to true, the same image obtained to the og:image will be added to the RSS feed on the "enclosure" and "media:content" tags so that apps like RSS Graffiti and twitterfeed post them correctly.

= 0.1.9.5 =

* It's now possible to choose how the post/page og:image tag is set. It means that if the user doesn't want to use the featured/thumbnail image, or the first image in the post content, or the first image on the media gallery, or even the default image, he can choose not to.

= 0.1.9 =

* Added the og:locale tag. This will be the Wordpress locale by default, but can be chosen by the user also.
* The og:type tag can now be set as 'website' or 'blog' for the homepage.
* A final trailing slash can now be added to the homepage url, if the user wants to. Avoids 'circular reference error' on the Facebook debugger.


= 0.1.8.1 =

* Fixed the namespace declarations

= 0.1.8 =

* Type 'website' was being used as default for all the urls beside posts. This is wrong. According to Facebook Open Graph specification only the homepage should be 'website' and all the other contents must bu 'article'. This was fixed.
* On Category and Tags pages, their descriptions, if not blank, are used for the og:description tag.
* If the description comes out empty, the title is used on this tag.

= 0.1.7 =

* Changed the plugin priority, so that it shows up as late as possible on the <head> tag, and it won't be override by another plugin's Open Graph implementation, because other plugins usually don't allow to disable the tags. If you want to keep a specific tag from another plugin, you can just disable that tag on this plugin options.

= 0.1.6 =

* Settings link now shows up on the plugins list.
* Small fix to ensure admin functions only are running when on the admin interface.
* Some admin options now only show up when the tag is set to be included.


= 0.1.5 =

* Fixed the way Categories and Tags pages links were being retrieved that would cause an error on WP 3.0
* Added the option to use a Custom text as homepage og:description instead of the Website Tagline.
* Fixed a bug that wouldn't allow to uncheck the og:image tag.

= 0.1.4 =

* Shortcodes are now stripped from og:description.
* Changed og:app_id and og:admins not to be included by default.

= 0.1.3 =

* Just fixing some typos.

= 0.1.2 =

* Fixing a bug for themes that do not support post thumbnail.

= 0.1.1 =

* Adding Open Graph Namespace to the HTML tag.

= 0.1 =

* First release.
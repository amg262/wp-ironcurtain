/*
 * Copyright (c) 2018. | WP Bill of Materials
 * andrewmgunn26@gmail.com | https://github.com/amg262/wp-bom
 */

/*
 * Plugins that insert posts via Ajax, such as infinite scroll plugins, should trigger the
 * post-load evendort on document.body after posts are inserted. Other scripts that depend on
 * a JavaScript interaction after posts are loaded
 *
 * JavaScript triggering the post-load evendort after posts have been inserted via Ajax:
 */
jQuery(document).ready(function ($) {

});

/*
 * Plugins that insert posts via Ajax, such as infinite scroll plugins, should trigger the
 * post-load evendort on document.body after posts are inserted. Other scripts that depend on
 * a JavaScript interaction after posts are loaded
 *
 * JavaScript triggering the post-load evendort after posts have been inserted via Ajax:
 */
//jQuery(document.body).trigger('post-load');

/*
 *JavaScript listening to the post-load evendort:
 */
jQuery(document.body).trigger('post-load');
jQuery(document.body).on('post-load', function () {
	// New posts have been added to the page.
	console.log('posts');
});
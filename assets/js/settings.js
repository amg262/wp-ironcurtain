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
	//$('form select').select2();
	$(".chosen-select").chosen({
		//disable_search_threshold: 10,
		//no_results_text: "Oops, nothing found!",
		width: "95%"
	});
	$('#bom_settings form input').on('change', function () {
		var data = {
			'url': ajax_object.ajax_url,
			'action': 'wco_ajax',
			'security': ajax_object.nonce,
			'ajaxid': ajax_object.ajaxid,
			'select2': ajax_object.select2,
			'options': ajax_object.options,
			'options2': ajax_object.options2,
		};

		console.log(this);
		console.log(data);

		var name = $(this).attr('name');
		var iddd = $(this).attr('type');
		var key = $(this).attr('data-key');
		var va = $(this).attr('value');

		console.log(name);
		console.log(key);

		data.options[key] = va;

		var json = data.options.toString();
		console.log(data);

	});

	$('#bom_ajax').on('click', function (event, params) {
		var data = {
			'url': ajax_object.ajax_url,
			'action': 'wco_ajax',
			'security': ajax_object.nonce,
			'ajaxid': ajax_object.ajaxid,
			'select2': ajax_object.select2,
			'options': ajax_object.options,
			'options2': ajax_object.options2,
		};

		var json = JSON.stringify(data.options);

		sweetAlert({
			title: 'Export Product\'s BOM? ',
			text: 'Submit to run ajax request',
			type: 'info',
			showCancelButton: true,
			closeOnConfirm: false,
			showLoaderOnConfirm: true,
		}, function () {

			// We can also pass the url value separately from ajaxurl for front end AJAX implementations
			jQuery.post(ajax_object.ajax_url, data, function (response) {

				$('#bom_ajax_text').html(json);
				$('#bom_ajax_text').attr('value', json);

				setTimeout(function () {
					swal(response);
				});
				//alert('seRespon ' + response);
			});
		});
	});

//
//	var data = {
//		'url': ajax_object.ajax_url,
//		'action': 'wco_ajax',
//		'security': ajax_object.nonce,
//		'product': rel_text,
//	};
//	// We can also pass the url value separately from ajaxurl for front end AJAX implementations
//
//	$('#wpb_admin_ajax').click(function (e) {
//		//swal();
//
//
//		var data = {
//			'url': ajax_object.ajax_url,
//			'action': 'wco_ajax',
//			'security': ajax_object.nonce,
//			'product': rel_text,
//		};
//		console.log(data);
//		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
//		jQuery.post(ajax_object.ajax_url, data, function (response) {
//
//			$('#wpb_ajax_io').html(response);
//			setTimeout(function () {
//				swal('Finished');
//			});
//			alert('seRespon ' + response);
//		});

//	});
//
//	alert("bitch");
//	$('select').on('change', function (event, params) {
//
//		$('select > span.selection').innerHTML;
//		//console.log(params['selected']);
//		console.log(this);
//	});
////$('#wpb_item_list')
//	$('#wpb_item_type').click('click', function (event, params) {
//
//		console.log(this);
//
//	});
//
//	$('#wpb_item_type > select').on('change', function () {
//
//		swal('hey');
//
//	});
//	$('#wpb_admin_ajax').click(function (e) {
//		swal('hey');
//
//		console.log(e);
//		// We can also pass the url value separately from ajaxurl for front end AJAX implementations
//		jQuery.post(ajax_object.ajax_url, data, function (response) {
//
//			$('#wpb_ajax_io').html(response);
//			setTimeout(function () {
//				swal('Finished');
//			});
//			alert('seRespon ' + response);
//		});
//
//	});
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
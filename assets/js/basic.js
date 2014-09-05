/*
 * SimpleModal Basic Modal Dialog
 * http://simplemodal.com
 *
 * Copyright (c) 2013 Eric Martin - http://ericmmartin.com
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 */

jQuery(function ($) {
	// Load dialog on page load
	//$('#basic-modal-content').modal();

	// Load dialog on click
	$('#basic-modal .basic').click(function (e) {
		$('#basic-modal-content').modal();

		return false;
	});
	$('#basic-modal .basic2').click(function (e) {
		$('#basic-modal-content.term').modal();
		/* _gaq.push(['_trackPageview', '/vp/SyaratKetentuan']); */
		ga('send', 'pageview', '/vp/SyaratKetentuan');
		

		return false;
	});
	$('#basic-modal .basic3').click(function (e) {
		$('#basic-modal-content.privacy').modal();
		/* _gaq.push(['_trackPageview', '/vp/KebijakanPrivacy']); */
		ga('send', 'pageview', '/vp/KebijakanPrivacy');

		return false;
	});
	$('#basic-modal .global-popup').click(function (e) {
		$('#basic-modal-content.global').modal();
		/* _gaq.push(['_trackPageview', '/vp/Tentang']); */
		ga('send', 'pageview', '/vp/Tentang');

		return false;
	});
});
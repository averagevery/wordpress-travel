<?php

function blocksy_social_icons($socials_descriptor = null, $args = []) {
	$args = wp_parse_args(
		$args,
		[
			'icons-color' => 'custom',
			'type' => 'simple',
			'size' => 'custom',
			'fill' => false,
			'hide_labels' => true
		]
	);

	$attr = [
		'data-type' => $args['type'],
		'data-size' => $args['size'],
		'data-color' => $args['icons-color']
	];

	if ($args['fill']) {
		if ($args['type'] !== 'simple') {
			$attr['data-fill'] = $args['fill'];
		}
	}

	return blocksy_get_social_box([
		'attr' => $attr,
		'socials' => $socials_descriptor,
		'hide_labels' => $args['hide_labels']
	]);
}

/**
 * Get social share box.
 */
function blocksy_get_social_share_box($check_for_preview = false, $args = []) {
	$args = wp_parse_args(
		$args,
		[
			'html_atts' => [],
			'type' => 'type-1'
		]
	);

	$old_args = $args['html_atts'];

	$args['html_atts'] = wp_parse_args($old_args, $args['html_atts']);

	$args['html_atts']['data-type'] = $args['type'];

	$after_content = '';

	if ($args['type'] === 'type-2' || $check_for_preview) {
		$after_content = '<span>
			<svg width="16" height="16" viewBox="0 0 20 20">
				<path d="M10 7.1c1.2 0 2.4-.8 2.9-1.8 1.8.8 3 2.4 3.5 4.2.1.3.4.7.8.7h.2c.4-.1.8-.6.6-1-.7-2.5-2.4-4.5-4.8-5.5 0-1.8-1.4-3.2-3.2-3.2S6.7 1.9 6.7 3.8 8.2 7.1 10 7.1zm0-5c.9 0 1.7.8 1.7 1.7s-.8 1.6-1.7 1.6-1.7-.7-1.7-1.6.8-1.7 1.7-1.7zm-6.7 9.1c0-1.9.8-3.8 2.2-5 .2-.2.3-.3.3-.6.1-.3 0-.4-.2-.6-.3-.2-.8-.2-1.1 0-1.8 1.6-2.8 3.8-2.8 6.2v.4c-1 .6-1.7 1.7-1.7 2.9 0 1.8 1.5 3.3 3.3 3.3s3.3-1.5 3.3-3.3-1.4-3.3-3.3-3.3zm-1.6 3.4c0-.9.8-1.7 1.7-1.7s1.6.8 1.6 1.7-.8 1.7-1.7 1.7-1.6-.8-1.6-1.7zm15-3.4c-1.8 0-3.3 1.5-3.3 3.3 0 .8.2 1.4.7 2-1.8 1.4-4.3 1.8-6.5.9-.4-.2-.9 0-1.1.4-.1.2-.1.4 0 .7.1.2.3.3.4.4 1 .4 2.1.6 3.2.6 1.9 0 3.8-.7 5.3-1.9.4.2.8.2 1.3.2 1.8 0 3.3-1.5 3.3-3.3s-1.5-3.3-3.3-3.3zm0 5c-.9 0-1.7-.8-1.7-1.7s.8-1.7 1.7-1.7c.9 0 1.7.7 1.7 1.7s-.8 1.7-1.7 1.7z"/>
			</svg>
		</span>';
	}

	return blocksy_get_social_box([
		'type' => 'share',
		'root_class' => 'ct-share-box',
		'class' => blocksy_visibility_classes(
			get_theme_mod('share_box_visibility', [
				'desktop' => true,
				'tablet' => true,
				'mobile' => false,
			])
		),
		'has_count' => $args['type'] === 'type-2' || $check_for_preview,
		'attr' => $args['html_atts'],
		'after_links_content' => $after_content,
		'force_output' => $check_for_preview
	]);
}

function blocksy_get_social_metadata($args = []) {
	$args = wp_parse_args(
		$args,
		[
			// url | share
			'type' => 'url',
			'social' => null,
		]
	);

	$metadata = [
		'facebook' => [
			'name' => __( 'Facebook', 'blocksy' ),
			'icon' => '
				<svg
				width="20px"
				height="20px"
				viewBox="0 0 20 20">
					<path d="M20,10.1c0-5.5-4.5-10-10-10S0,4.5,0,10.1c0,5,3.7,9.1,8.4,9.9v-7H5.9v-2.9h2.5V7.9C8.4,5.4,9.9,4,12.2,4c1.1,0,2.2,0.2,2.2,0.2v2.5h-1.3c-1.2,0-1.6,0.8-1.6,1.6v1.9h2.8L13.9,13h-2.3v7C16.3,19.2,20,15.1,20,10.1z"/>
				</svg>
			',
		],

		'twitter' => [
			'name' => __( 'Twitter', 'blocksy' ),
			'icon' => '
				<svg
				width="20px"
				height="20px"
				viewBox="0 0 20 20">
					<path d="M20,3.8c-0.7,0.3-1.5,0.5-2.4,0.6c0.8-0.5,1.5-1.3,1.8-2.3c-0.8,0.5-1.7,0.8-2.6,1c-0.7-0.8-1.8-1.3-3-1.3c-2.3,0-4.1,1.8-4.1,4.1c0,0.3,0,0.6,0.1,0.9C6.4,6.7,3.4,5.1,1.4,2.6C1,3.2,0.8,3.9,0.8,4.7c0,1.4,0.7,2.7,1.8,3.4C2,8.1,1.4,7.9,0.8,7.6c0,0,0,0,0,0.1c0,2,1.4,3.6,3.3,4c-0.3,0.1-0.7,0.1-1.1,0.1c-0.3,0-0.5,0-0.8-0.1c0.5,1.6,2,2.8,3.8,2.8c-1.4,1.1-3.2,1.8-5.1,1.8c-0.3,0-0.7,0-1-0.1c1.8,1.2,4,1.8,6.3,1.8c7.5,0,11.7-6.3,11.7-11.7c0-0.2,0-0.4,0-0.5C18.8,5.3,19.4,4.6,20,3.8z"/>
				</svg>
			',
		],

		'pinterest' => [
			'name' => __( 'Pinterest', 'blocksy' ),
			'icon' => '
				<svg
				width="20px"
				height="20px"
				viewBox="0 0 20 20">
					<path d="M10,0C4.5,0,0,4.5,0,10c0,4.1,2.5,7.6,6,9.2c0-0.7,0-1.5,0.2-2.3c0.2-0.8,1.3-5.4,1.3-5.4s-0.3-0.6-0.3-1.6c0-1.5,0.9-2.6,1.9-2.6c0.9,0,1.3,0.7,1.3,1.5c0,0.9-0.6,2.3-0.9,3.5c-0.3,1.1,0.5,1.9,1.6,1.9c1.9,0,3.2-2.4,3.2-5.3c0-2.2-1.5-3.8-4.2-3.8c-3,0-4.9,2.3-4.9,4.8c0,0.9,0.3,1.5,0.7,2C6,12,6.1,12.1,6,12.4c0,0.2-0.2,0.6-0.2,0.8c-0.1,0.3-0.3,0.3-0.5,0.3c-1.4-0.6-2-2.1-2-3.8c0-2.8,2.4-6.2,7.1-6.2c3.8,0,6.3,2.8,6.3,5.7c0,3.9-2.2,6.9-5.4,6.9c-1.1,0-2.1-0.6-2.4-1.2c0,0-0.6,2.3-0.7,2.7c-0.2,0.8-0.6,1.5-1,2.1C8.1,19.9,9,20,10,20c5.5,0,10-4.5,10-10C20,4.5,15.5,0,10,0z"/>
				</svg>
			',
		],

		'linkedin' => [
			'name' => __( 'LinkedIn', 'blocksy' ),
			'icon' => '
				<svg
				width="20px"
				height="20px"
				viewBox="0 0 20 20">
					<path d="M18.6,0H1.4C0.6,0,0,0.6,0,1.4v17.1C0,19.4,0.6,20,1.4,20h17.1c0.8,0,1.4-0.6,1.4-1.4V1.4C20,0.6,19.4,0,18.6,0z M6,17.1h-3V7.6h3L6,17.1L6,17.1zM4.6,6.3c-1,0-1.7-0.8-1.7-1.7s0.8-1.7,1.7-1.7c0.9,0,1.7,0.8,1.7,1.7C6.3,5.5,5.5,6.3,4.6,6.3z M17.2,17.1h-3v-4.6c0-1.1,0-2.5-1.5-2.5c-1.5,0-1.8,1.2-1.8,2.5v4.7h-3V7.6h2.8v1.3h0c0.4-0.8,1.4-1.5,2.8-1.5c3,0,3.6,2,3.6,4.5V17.1z"/>
				</svg>
			',
		],

		'reddit' => [
			'name' => __( 'Reddit', 'blocksy' ),
			'icon' => '
				<svg
				width="20px"
				height="20px"
				viewBox="0 0 20 20">
					<path d="M7.8,12c-0.6,0-1-0.4-1-1c0-0.6,0.4-1,1-1c0.5,0,1,0.4,1,1C8.8,11.6,8.3,12,7.8,12z M20,10c0,5.5-4.5,10-10,10S0,15.5,0,10S4.5,0,10,0S20,4.5,20,10z M14.7,8.3c-0.4,0-0.7,0.2-1,0.4c-0.9-0.6-2.1-1-3.5-1.1l0.7-3.2L13.2,5c0,0.5,0.4,1,1,1c0.6,0,1-0.5,1-1s-0.4-1-1-1c-0.4,0-0.7,0.2-0.9,0.6L10.8,4c-0.1,0-0.2,0.1-0.3,0.2L9.8,7.7C8.4,7.7,7.2,8.1,6.3,8.8c-0.2-0.3-0.6-0.4-1-0.4c-1.4,0-1.9,1.9-0.6,2.5c0,0.2-0.1,0.4-0.1,0.6c0,2.1,2.4,3.8,5.3,3.8c2.9,0,5.3-1.7,5.3-3.8c0-0.2,0-0.4-0.1-0.6C16.5,10.2,16.1,8.3,14.7,8.3L14.7,8.3z M11.9,13c-0.7,0.7-3.1,0.7-3.8,0c-0.1-0.1-0.2-0.1-0.3,0c-0.1,0.1-0.1,0.3,0,0.3c0.9,0.9,3.5,0.9,4.4,0c0.1-0.1,0.1-0.2,0-0.3C12.1,12.9,12,12.9,11.9,13z M12.2,10c-0.5,0-1,0.4-1,1c0,0.5,0.4,1,1,1c0.6,0,1-0.4,1-1C13.2,10.4,12.8,10,12.2,10z"/>
				</svg>
			',
		],

		'hacker_news' => [
			'name' => __( 'Hacker News', 'blocksy' ),
			'icon' => '
				<svg
				width="20px"
				height="20px"
				viewBox="0 0 20 20">

					<path d="M0,0v20h20V0H0z M11.2,11.8v4.7H8.8v-4.7L4.7,4.1h1.9l3.4,6l3.4-6h1.9L11.2,11.8z"/>
				</svg>
			',
		],

		'vk' => [
			'name' => __( 'VK', 'blocksy' ),
			'icon' => '
				<svg
				width="20px"
				height="20px"
				viewBox="0 0 20 20">
					<path d="M19.2,4.8H16c-0.3,0-0.5,0.1-0.6,0.4c0,0-1.3,2.4-1.7,3.2c-1.1,2.2-1.8,1.5-1.8,0.5V5.4c0-0.6-0.5-1.1-1.1-1.1H8.2C7.6,4.3,6.9,4.6,6.5,5.1c0,0,1.2-0.2,1.2,1.5c0,0.4,0,1.6,0,2.6c0,0.4-0.3,0.7-0.7,0.7c-0.2,0-0.4-0.1-0.6-0.2c-1-1.4-1.8-2.9-2.5-4.5C4,5,3.7,4.8,3.5,4.8c-0.7,0-2.1,0-2.9,0C0.2,4.8,0,5,0,5.3c0,0.1,0,0.1,0,0.2C0.9,8,4.8,15.7,9.2,15.7H11c0.4,0,0.7-0.3,0.7-0.7v-1.1c0-0.4,0.3-0.7,0.7-0.7c0.2,0,0.4,0.1,0.5,0.2l2.2,2.1c0.2,0.2,0.5,0.3,0.7,0.3h2.9c1.4,0,1.4-1,0.6-1.7c-0.5-0.5-2.5-2.6-2.5-2.6c-0.3-0.4-0.4-0.9-0.1-1.3c0.6-0.8,1.7-2.2,2.1-2.8C19.6,6.5,20.7,4.8,19.2,4.8z"/>
				</svg>
			',
		],

		'ok' => [
			'name' => __( 'Odnoklassniki', 'blocksy' ),
			'icon' => '
				<svg
				width="20px"
				height="20px"
				viewBox="0 0 20 20">
					<path d="M8.2,6.5c0-1,0.8-1.8,1.8-1.8s1.8,0.8,1.8,1.8c0,1-0.8,1.8-1.8,1.8S8.2,7.5,8.2,6.5L8.2,6.5z M20,2.1v15.7c0,1.2-1,2.1-2.1,2.1H2.1C1,20,0,19,0,17.9V2.1C0,1,1,0,2.1,0h15.7C19,0,20,1,20,2.1z M6.4,6.5c0,2,1.6,3.6,3.6,3.6s3.6-1.6,3.6-3.6c0-2-1.6-3.6-3.6-3.6S6.4,4.5,6.4,6.5z M14.2,10.5c-0.2-0.4-0.8-0.8-1.5-0.2c0,0-1,0.8-2.6,0.8s-2.6-0.8-2.6-0.8C6.6,9.8,6,10.1,5.8,10.5c-0.4,0.7,0,1.1,1,1.7c0.8,0.5,1.8,0.7,2.5,0.8l-0.6,0.6c-0.8,0.8-1.6,1.6-2.1,2.1c-0.8,0.8,0.5,2,1.3,1.3l2.1-2.1c0.8,0.8,1.6,1.6,2.1,2.1c0.8,0.8,2.1-0.5,1.3-1.3l-2.1-2.1l-0.6-0.6c0.7-0.1,1.7-0.3,2.5-0.8C14.1,11.6,14.5,11.2,14.2,10.5z"/>
				</svg>
			',
		],

		'telegram' => [
			'name' => __( 'Telegram', 'blocksy' ),
			'icon' => '
				<svg
				width="20px"
				height="20px"
				viewBox="0 0 20 20">
					<path d="M19.9,3.1l-3,14.2c-0.2,1-0.8,1.3-1.7,0.8l-4.6-3.4l-2.2,2.1c-0.2,0.2-0.5,0.5-0.9,0.5l0.3-4.7L16.4,5c0.4-0.3-0.1-0.5-0.6-0.2L5.3,11.4L0.7,10c-1-0.3-1-1,0.2-1.5l17.7-6.8C19.5,1.4,20.2,1.9,19.9,3.1z"/>
				</svg>
			',
		],

		'viber' => [
			'name' => __( 'Viber', 'blocksy' ),
			'icon' => '
				<svg
				width="20px"
				height="20px"
				viewBox="0 0 20 20">
					<path d="M18.6,4.4c-0.3-1.2-1-2.2-2-2.9c-1.2-0.9-2.7-1.2-3.9-1.4C11,0,9.4-0.1,8,0.1C6.6,0.3,5.5,0.6,4.6,1c-1.9,0.9-3,2.2-3.3,4.1C1.1,6,1,6.9,0.9,7.6c-0.2,1.8,0,3.4,0.4,4.9c0.4,1.5,1.2,2.5,2.2,3.2c0.3,0.2,0.6,0.3,1,0.4c0.2,0.1,0.3,0.1,0.5,0.2v2.9C5,19.7,5.3,20,5.7,20l0,0c0.2,0,0.4-0.1,0.5-0.2l2.7-2.6C9,17,9,17,9.1,17c0.9,0,1.9-0.1,2.8-0.1c1.1-0.1,2.5-0.2,3.7-0.7c1.1-0.5,2-1.2,2.5-2.2c0.5-1.1,0.8-2.2,0.9-3.5C19.3,8.2,19.1,6.2,18.6,4.4z M13.9,13.1c-0.3,0.4-0.7,0.8-1.2,1c-0.4,0.1-0.7,0.1-1.1,0C8.8,12.8,6.5,10.9,5,8.1C4.7,7.5,4.5,6.9,4.2,6.3C4.2,6.2,4.2,6,4.2,5.9c0-1,0.8-1.5,1.5-1.7c0.3-0.1,0.5,0,0.8,0.2c0.6,0.6,1.1,1.2,1.4,2C8,6.7,8,7,7.7,7.2C7.6,7.3,7.6,7.3,7.5,7.4C6.9,7.8,6.8,8.2,7.2,8.9c0.5,1.2,1.5,1.9,2.6,2.4c0.3,0.1,0.6,0.1,0.8-0.2c0,0,0.1-0.1,0.1-0.1c0.5-0.8,1.1-0.7,1.8-0.3c0.4,0.3,0.8,0.6,1.2,0.9C14.3,12.1,14.3,12.5,13.9,13.1z M10.4,5.1c-0.2,0-0.3,0-0.5,0C9.7,5.2,9.5,5,9.4,4.8c0-0.3,0.1-0.5,0.4-0.5c0.2,0,0.4-0.1,0.6-0.1c2.1,0,3.7,1.7,3.7,3.7c0,0.2,0,0.4-0.1,0.6c0,0.2-0.2,0.4-0.5,0.4c0,0-0.1,0-0.1,0c-0.3,0-0.4-0.3-0.4-0.5c0-0.2,0-0.3,0-0.5C13.2,6.4,12,5.1,10.4,5.1z M12.5,8.2c0,0.3-0.2,0.5-0.5,0.5s-0.5-0.2-0.5-0.5c0-0.8-0.6-1.4-1.4-1.4c-0.3,0-0.5-0.2-0.5-0.5c0-0.3,0.2-0.5,0.5-0.5C11.4,5.8,12.5,6.9,12.5,8.2zM15.7,8.8c-0.1,0.2-0.2,0.4-0.5,0.4c0,0-0.1,0-0.1,0c-0.3-0.1-0.4-0.3-0.4-0.6c0.1-0.3,0.1-0.6,0.1-0.9c0-2.3-1.9-4.2-4.2-4.2c-0.3,0-0.6,0-0.9,0.1C9.5,3.6,9.2,3.5,9.2,3.2C9.1,2.9,9.3,2.7,9.5,2.6c0.4-0.1,0.8-0.1,1.1-0.1c2.8,0,5.2,2.3,5.2,5.2C15.8,8,15.8,8.4,15.7,8.8z"/>
				</svg>
			',
		],

		'whatsapp' => [
			'name' => __( 'WhatsApp', 'blocksy' ),
			'icon' => '
				<svg
				width="20px"
				height="20px"
				viewBox="0 0 20 20">
					<path d="M10,0C4.5,0,0,4.5,0,10c0,1.9,0.5,3.6,1.4,5.1L0.1,20l5-1.3C6.5,19.5,8.2,20,10,20c5.5,0,10-4.5,10-10S15.5,0,10,0zM6.6,5.3c0.2,0,0.3,0,0.5,0c0.2,0,0.4,0,0.6,0.4c0.2,0.5,0.7,1.7,0.8,1.8c0.1,0.1,0.1,0.3,0,0.4C8.3,8.2,8.3,8.3,8.1,8.5C8,8.6,7.9,8.8,7.8,8.9C7.7,9,7.5,9.1,7.7,9.4c0.1,0.2,0.6,1.1,1.4,1.7c0.9,0.8,1.7,1.1,2,1.2c0.2,0.1,0.4,0.1,0.5-0.1c0.1-0.2,0.6-0.7,0.8-1c0.2-0.2,0.3-0.2,0.6-0.1c0.2,0.1,1.4,0.7,1.7,0.8s0.4,0.2,0.5,0.3c0.1,0.1,0.1,0.6-0.1,1.2c-0.2,0.6-1.2,1.1-1.7,1.2c-0.5,0-0.9,0.2-3-0.6c-2.5-1-4.1-3.6-4.2-3.7c-0.1-0.2-1-1.3-1-2.6c0-1.2,0.6-1.8,0.9-2.1C6.1,5.4,6.4,5.3,6.6,5.3z"/>
				</svg>
			',
		],

		'wechat' => [
			'name' => 'WeChat',
			'icon' => '
				<svg
				width="20"
				height="20"
				viewBox="0 0 20 20">
					<path d="M13.5,6.8c0.2,0,0.5,0,0.7,0c-0.6-2.9-3.7-5-7.1-5C3.2,1.9,0,4.5,0,7.9c0,1.9,1.1,3.5,2.8,4.8l-0.7,2.1l2.5-1.2c0.9,0.2,1.6,0.4,2.5,0.4c0.2,0,0.4,0,0.7,0c-0.1-0.5-0.2-1-0.2-1.5C7.5,9.3,10.2,6.8,13.5,6.8L13.5,6.8zM9.7,4.9c0.5,0,0.9,0.4,0.9,0.9c0,0.5-0.4,0.9-0.9,0.9c-0.5,0-1.1-0.4-1.1-0.9C8.7,5.2,9.2,4.9,9.7,4.9zM4.8,6.6c-0.5,0-1.1-0.4-1.1-0.9c0-0.5,0.5-0.9,1.1-0.9c0.5,0,0.9,0.4,0.9,0.9C5.7,6.3,5.3,6.6,4.8,6.6z M20,12.3c0-2.8-2.8-5.1-6-5.1c-3.4,0-6,2.3-6,5.1s2.6,5.1,6,5.1c0.7,0,1.4-0.2,2.1-0.4l1.9,1.1l-0.5-1.8C18.9,15.3,20,13.9,20,12.3zM12,11.4c-0.4,0-0.7-0.4-0.7-0.7c0-0.4,0.4-0.7,0.7-0.7c0.5,0,0.9,0.4,0.9,0.7C12.9,11.1,12.6,11.4,12,11.4zM15.9,11.4c-0.4,0-0.7-0.4-0.7-0.7c0-0.4,0.4-0.7,0.7-0.7c0.5,0,0.9,0.4,0.9,0.7C16.8,11.1,16.5,11.4,15.9,11.4z"/>
				</svg>
			'
		],

		'qq' => [
			'name' => 'QQ',
			'icon' => '
				<svg
				width="20"
				height="20"
				viewBox="0 0 20 20">
					<path d="M18.2,16.4c-0.5,0.1-1.8-2.1-1.8-2.1c0,1.2-0.6,2.8-2,4c0.7,0.2,2.1,0.7,1.8,1.3C16,20.2,11.3,20,10,19.8c-1.3,0.2-5.9,0.3-6.2-0.2c-0.4-0.6,1.1-1.1,1.8-1.3c-1.4-1.2-2-2.8-2-4c0,0-1.3,2.1-1.8,2.1c-0.2,0-0.5-1.2,0.4-3.9c0.4-1.3,0.9-2.4,1.6-4.1C3.6,3.8,5.5,0,10,0c4.4,0,6.4,3.8,6.3,8.4c0.7,1.8,1.2,2.8,1.6,4.1C18.7,15.3,18.4,16.4,18.2,16.4L18.2,16.4z"/>
				</svg>
			'
		],

		'weibo' => [
			'name' => 'Weibo',
			'icon' => '
				<svg
				width="20"
				height="20"
				viewBox="0 0 20 20">
					<path d="M15.9,7.6c0.3-0.9-0.5-1.8-1.5-1.6c-0.9,0.2-1.1-1.1-0.3-1.3c2-0.4,3.6,1.4,3,3.3C16.9,8.8,15.6,8.4,15.9,7.6z M8.4,18.1c-4.2,0-8.4-2-8.4-5.3C0,11,1.1,9,3,7.2c3.9-3.9,7.9-3.9,6.8-0.2c-0.2,0.5,0.5,0.2,0.5,0.2c3.1-1.3,5.5-0.7,4.5,2c-0.1,0.4,0,0.4,0.3,0.5C20.3,11.3,16.4,18.1,8.4,18.1L8.4,18.1zM14,12.4c-0.2-2.2-3.1-3.7-6.4-3.3C4.3,9.4,1.8,11.4,2,13.6s3.1,3.7,6.4,3.3C11.7,16.6,14.2,14.6,14,12.4zM13.6,2c-1,0.2-0.7,1.7,0.3,1.5c2.8-0.6,5.3,2.1,4.4,4.8c-0.3,0.9,1.1,1.4,1.5,0.5C21,4.9,17.6,1.2,13.6,2L13.6,2z M10.5,14.2c-0.7,1.5-2.6,2.3-4.3,1.8c-1.6-0.5-2.3-2.1-1.6-3.5c0.7-1.4,2.5-2.2,4-1.8C10.4,11.1,11.2,12.7,10.5,14.2zM7.2,13c-0.5-0.2-1.2,0-1.5,0.5C5.3,14,5.5,14.6,6,14.8c0.5,0.2,1.2,0,1.5-0.5C7.8,13.8,7.7,13.2,7.2,13zM8.4,12.5c-0.2-0.1-0.4,0-0.6,0.2c-0.1,0.2-0.1,0.4,0.1,0.5c0.2,0.1,0.5,0,0.6-0.2C8.7,12.8,8.6,12.6,8.4,12.5z"/>
				</svg>
			'
		],

		'xing' => [
			'name' => 'Xing',
			'icon' => '
				<svg
				width="20"
				height="20"
				viewBox="0 0 20 20">
					<path d="M16.8,0H3.2C1.4,0,0,1.4,0,3.2v13.6C0,18.6,1.4,20,3.2,20h13.6c1.8,0,3.2-1.4,3.2-3.2V3.2C20,1.4,18.6,0,16.8,0z M6.2,13.3H3.8c-0.2,0-0.3-0.3-0.3-0.4L6,8.4c0.1-0.1,0.1-0.2,0-0.3L4.5,5.4C4.4,5.3,4.5,5,4.7,5H7c0.1,0,0.2,0.1,0.3,0.2L9,8.2c0.1,0.1,0.1,0.2,0,0.3l-2.6,4.7C6.4,13.2,6.2,13.3,6.2,13.3z M16.3,2.9l-4.7,8.6c-0.1,0.1-0.1,0.2,0,0.3l3,5.3c0.1,0.2,0,0.4-0.3,0.4h-2.3c-0.1,0-0.2-0.1-0.3-0.2l-3.2-5.6c-0.1-0.1-0.1-0.2,0-0.3l4.8-8.9c0.1,0,0.3-0.1,0.3-0.1h2.3C16.3,2.5,16.4,2.8,16.3,2.9z"/>
				</svg>
			'
		],

		'rss' => [
			'name' => 'RSS',
			'icon' => '
				<svg
				width="20"
				height="20"
				viewBox="0 0 20 20">
					<path d="M17.9,0H2.1C1,0,0,1,0,2.1v15.7C0,19,1,20,2.1,20h15.7c1.2,0,2.1-1,2.1-2.1V2.1C20,1,19,0,17.9,0z M5,17.1c-1.2,0-2.1-1-2.1-2.1s1-2.1,2.1-2.1s2.1,1,2.1,2.1S6.2,17.1,5,17.1z M12,17.1h-1.5c-0.3,0-0.5-0.2-0.5-0.5c-0.2-3.6-3.1-6.4-6.7-6.7c-0.3,0-0.5-0.2-0.5-0.5V8c0-0.3,0.2-0.5,0.5-0.5c4.9,0.3,8.9,4.2,9.2,9.2C12.6,16.9,12.3,17.1,12,17.1L12,17.1z M16.6,17.1h-1.5c-0.3,0-0.5-0.2-0.5-0.5c-0.2-6.1-5.1-11-11.2-11.2c-0.3,0-0.5-0.2-0.5-0.5V3.4c0-0.3,0.2-0.5,0.5-0.5c7.5,0.3,13.5,6.3,13.8,13.8C17.2,16.9,16.9,17.1,16.6,17.1L16.6,17.1z"/>
				</svg>
			'
		],

		'vimeo' => [
			'name' => 'Vimeo',
			'icon' => '
				<svg
				width="20"
				height="20"
				viewBox="0 0 20 20">
					<path d="M20,5.3c-0.1,1.9-1.4,4.6-4.1,8c-2.7,3.5-5,5.3-6.9,5.3c-1.2,0-2.2-1.1-3-3.2C4.5,9.7,3.8,6.3,2.5,6.3c-0.2,0-0.7,0.3-1.6,0.9L0,6c2.3-2,4.5-4.3,5.9-4.4c1.6-0.2,2.5,0.9,2.9,3.2c1.3,8.1,1.8,9.3,4.2,5.7c0.8-1.3,1.3-2.3,1.3-3c0.2-2-1.6-1.9-2.8-1.4c1-3.2,2.9-4.8,5.6-4.7C19.1,1.4,20.1,2.7,20,5.3L20,5.3z"/>
				</svg>
			'
		],

		'youtube' => [
			'name' => 'YouTube',
			'icon' => '
				<svg
				width="20"
				height="20"
				viewbox="0 0 20 20">
					<path d="M15,0H5C2.2,0,0,2.2,0,5v10c0,2.8,2.2,5,5,5h10c2.8,0,5-2.2,5-5V5C20,2.2,17.8,0,15,0z M14.5,10.9l-6.8,3.8c-0.1,0.1-0.3,0.1-0.5,0.1c-0.5,0-1-0.4-1-1l0,0V6.2c0-0.5,0.4-1,1-1c0.2,0,0.3,0,0.5,0.1l6.8,3.8c0.5,0.3,0.7,0.8,0.4,1.3C14.8,10.6,14.6,10.8,14.5,10.9z"/>
				</svg>
			'
		],

		'patreon' => [
			'name' => 'Patreon',
			'icon' => '
				<svg
				width="20"
				height="20"
				viewBox="0 0 20 20">
					<path d="M20,7.6c0,4-3.2,7.2-7.2,7.2c-4,0-7.2-3.2-7.2-7.2c0-4,3.2-7.2,7.2-7.2C16.8,0.4,20,3.6,20,7.6z M0,19.6h3.5V0.4H0V19.6z"/>
				</svg>
			'
		],

		'medium' => [
			'name' => 'Medium',
			'icon' => '
				<svg
				width="20"
				height="20"
				viewBox="0 0 20 20">
					<path d="M2.4,5.3c0-0.2-0.1-0.5-0.3-0.7L0.3,2.4V2.1H6l4.5,9.8l3.9-9.8H20v0.3l-1.6,1.5c-0.1,0.1-0.2,0.3-0.2,0.4v11.2c0,0.2,0,0.3,0.2,0.4l1.6,1.5v0.3h-7.8v-0.3l1.6-1.6c0.2-0.2,0.2-0.2,0.2-0.4V6.5L9.4,17.9H8.8L3.6,6.5v7.6c0,0.3,0.1,0.6,0.3,0.9L6,17.6v0.3H0v-0.3L2.1,15c0.2-0.2,0.3-0.6,0.3-0.9V5.3z"/>
				</svg>
			'
		],

		'dribbble' => [
			'name' => 'Dribbble',
			'icon' => '
				<svg
				width="20"
				height="20"
				viewBox="0 0 20 20">
					<path d="M10,0C4.5,0,0,4.5,0,10c0,5.5,4.5,10,10,10c5.5,0,10-4.5,10-10C20,4.5,15.5,0,10,0 M16.1,5.2c1,1.2,1.6,2.8,1.7,4.4c-1.1-0.2-2.2-0.4-3.2-0.4v0h0c-0.8,0-1.6,0.1-2.3,0.2c-0.2-0.4-0.3-0.8-0.5-1.2C13.4,7.6,14.9,6.6,16.1,5.2 M10,2.2c1.8,0,3.5,0.6,4.9,1.7c-1,1.2-2.4,2.1-3.8,2.7c-1-2-2-3.4-2.7-4.3C8.9,2.3,9.4,2.2,10,2.2 M6.6,3c0.5,0.6,1.6,2,2.8,4.2C7,8,4.6,8.1,3.2,8.1c0,0-0.1,0-0.1,0h0c-0.2,0-0.4,0-0.6,0C3,5.9,4.5,4,6.6,3 M2.2,10c0,0,0-0.1,0-0.1c0.2,0,0.5,0,0.9,0h0c1.6,0,4.3-0.1,7.1-1c0.2,0.3,0.3,0.7,0.4,1c-1.9,0.6-3.3,1.6-4.4,2.6c-1,0.9-1.7,1.9-2.2,2.5C2.9,13.7,2.2,11.9,2.2,10 M10,17.8c-1.7,0-3.3-0.6-4.6-1.5c0.3-0.5,0.9-1.3,1.8-2.2c1-0.9,2.3-1.9,4.1-2.5c0.6,1.7,1.1,3.6,1.5,5.7C11.9,17.6,11,17.8,10,17.8M14.4,16.4c-0.4-1.9-0.9-3.7-1.4-5.2c0.5-0.1,1-0.1,1.6-0.1h0h0h0c0.9,0,2,0.1,3.1,0.4C17.3,13.5,16.1,15.3,14.4,16.4"/>
				</svg>
			'
		],

		'instagram' => [
			'name' => 'Instagram',
			'icon' => '
				<svg
				width="20"
				height="20"
				viewBox="0 0 20 20">
					<circle cx="10" cy="10" r="3.3"/>
					<path d="M14.2,0H5.8C2.6,0,0,2.6,0,5.8v8.3C0,17.4,2.6,20,5.8,20h8.3c3.2,0,5.8-2.6,5.8-5.8V5.8C20,2.6,17.4,0,14.2,0zM10,15c-2.8,0-5-2.2-5-5s2.2-5,5-5s5,2.2,5,5S12.8,15,10,15z M15.8,5C15.4,5,15,4.6,15,4.2s0.4-0.8,0.8-0.8s0.8,0.4,0.8,0.8S16.3,5,15.8,5z"/>
				</svg>
			'
		]
	];

	if (! $args['social']) {
		return null;
	}

	if (! isset($metadata[$args['social']])) {
		return null;
	}

	$single_metadata = $metadata[$args['social']];
	$single_metadata['url'] = '';

	if ($args['type'] === 'url') {
		$single_metadata['url'] = get_theme_mod($args['social'], '#');

		if (empty(trim($single_metadata['url']))) {
			$single_metadata['url'] = '#';
		}
	}

	if ($args['type'] === 'share') {
		$home_url = blocksy_encode_uri_component(
			get_the_permalink()
		);

		$social_urls = [
			'facebook' => str_replace(
				'{url}',
				$home_url,
				'https://www.facebook.com/sharer/sharer.php?u={url}'
			),
			'twitter' => str_replace(
				'{url}',
				$home_url,
				'https://twitter.com/share?url={url}'
			),
			'pinterest' => str_replace(
				'{url}',
				$home_url,
				'#'
			),
			'linkedin' => str_replace(
				'{url}',
				$home_url,
				'https://www.linkedin.com/shareArticle?url={url}'
			),
			'reddit' => str_replace(
				'{url}',
				$home_url,
				'https://reddit.com/submit?url={url}'
			),
			'hacker_news' => str_replace(
				'{url}',
				$home_url,
				'https://news.ycombinator.com/submitlink?u={url}'
			),
			'reddit' => str_replace(
				'{url}',
				$home_url,
				'http://www.reddit.com/submit?url={url}'
			),
			'vk' => str_replace(
				'{url}',
				$home_url,
				'http://vk.com/share.php?url={url}'
			),
			'ok' => str_replace(
				'{url}',
				$home_url,
				'https://connect.ok.ru/dk?st.cmd=WidgetSharePreview&st.shareUrl={url}'
			),
			'telegram' => str_replace(
				'{url}',
				$home_url,
				'https://t.me/share/url?url={url}'
			),
			'viber' => str_replace(
				'{url}',
				$home_url,
				'viber://forward?{url}=This+is+the+content'
			),
			'whatsapp' => str_replace(
				'{url}',
				$home_url,
				'whatsapp://send?text={url}'
			),
		];

		if (isset($social_urls[$args['social']])) {
			$single_metadata['url'] = $social_urls[$args['social']];
		} else {
			$single_metadata['url'] = '#';
		}
	}

	return $single_metadata;
}

function blocksy_get_social_share_items() {
	return [
		[
			'id' => 'facebook',
			'enabled' => get_theme_mod('share_facebook', 'yes') === 'yes',
		],

		[
			'id' => 'twitter',
			'enabled' => get_theme_mod('share_twitter', 'yes') === 'yes',
		],

		[
			'enabled' => get_theme_mod('share_pinterest', 'yes') === 'yes',
			'id' => 'pinterest',
		],

		[
			'enabled' => get_theme_mod('share_linkedin', 'yes') === 'yes',
			'id' => 'linkedin',
		],

		[
			'enabled' => get_theme_mod('share_reddit', 'no') === 'yes',
			'id' => 'reddit',
		],

		[
			'enabled' => get_theme_mod('share_hacker_news', 'no') === 'yes',
			'id' => 'hacker_news',
		],

		[
			'enabled' => get_theme_mod('share_vk', 'no') === 'yes',
			'id' => 'vk',
		],

		[
			'enabled' => get_theme_mod('share_ok', 'no') === 'yes',
			'id' => 'ok',
		],

		[
			'enabled' => get_theme_mod('share_telegram', 'no') === 'yes',
			'id' => 'telegram',
		],

		[
			'enabled' => get_theme_mod('share_viber', 'no') === 'yes',
			'id' => 'viber',
		],

		[
			'enabled' => get_theme_mod('share_whatsapp', 'no') === 'yes',
			'id' => 'whatsapp',
		],
	];
}

function blockst_get_social_url_items() {
	return [
		[
			'id' => 'facebook',
			'enabled' => true,
		],

		[
			'id' => 'twitter',
			'enabled' => true,
		],

		[
			'id' => 'instagram',
			'enabled' => true,
		],

		[
			'id' => 'pinterest',
			'enabled' => true,
		],

		[
			'id' => 'dribbble',
			'enabled' => true,
		],

		[
			'id' => 'linkedin',
			'enabled' => true,
		],

		[
			'id' => 'medium',
			'enabled' => true,
		],

		[
			'id' => 'patreon',
			'enabled' => true,
		],

		[
			'id' => 'vk',
			'enabled' => true,
		],

		[
			'id' => 'youtube',
			'enabled' => true,
		],

		[
			'id' => 'vimeo',
			'enabled' => true,
		],

		[
			'id' => 'rss',
			'enabled' => true,
		],

		[
			'id' => 'xing',
			'enabled' => true,
		],

		[
			'id' => 'whatsapp',
			'enabled' => true,
		],

		[
			'id' => 'viber',
			'enabled' => true,
		],

		[
			'id' => 'telegram',
			'enabled' => true,
		],

		[
			'id' => 'weibo',
			'enabled' => true,
		],

		[
			'id' => 'qq',
			'enabled' => true,
		],

		[
			'id' => 'wechat',
			'enabled' => true,
		],
	];
}

function blocksy_get_social_box($args = []) {
	$args = wp_parse_args(
		$args,
		[
			// url | share
			'type' => 'url',
			'socials' => null,
			'attr' => [],
			'class' => '',
			'before_links_content' => '',
			'after_links_content' => '',
			'has_count' => false,
			'hide_labels' => false,
			'root_class' => 'ct-social-box',
			'force_output' => false
		]
	);

	if ($args['type'] === 'share') {
		$args['socials'] = blocksy_get_social_share_items();
	}

	if (! $args['socials']) {
		$args['socials'] = blockst_get_social_url_items();
	}

	$has_any_social = 0;

	foreach ($args['socials'] as $single_social) {
		if (
			! isset($single_social['enabled'])
			|| (
				isset($single_social['enabled'])
				&&
				$single_social['enabled']
			) || $args['force_output']
		) {
			$has_any_social++;
		}
	}

	if (! $has_any_social) {
		return '';
	}

	$old_attr = [];

	$old_attr['class'] = $args['root_class'];

	if (! empty($args['class'])) {
		$old_attr['class'] .= ' ' . $args['class'];
	}

	if ($args['type'] === 'share') {
		// $old_attr['data-behavior'] = 'share';
	}

	if ($args['has_count']) {
		$old_attr['data-count'] = $has_any_social;
	}

	$old_attr = array_merge($old_attr, $args['attr']);

	ob_start();

	?>

		<div <?php echo blocksy_attr_to_html($old_attr) ?>>
			<?php echo $args['before_links_content'] ?>

			<?php foreach ($args['socials'] as $single_social) { ?>
				<?php
					if (! $single_social['enabled'] && !$args['force_output']) {
						continue;
					}

					$metadata = blocksy_get_social_metadata([
						'type' => $args['type'],
						'social' => $single_social['id']
					]);

					$label_attr = ['class' => 'ct-label'];

					if ($args['hide_labels']) {
						$label_attr['hidden'] = '';
					}
				?>

				<a
					href="<?php echo $metadata['url'] ?>"
					target="_blank"
					data-network="<?php echo $single_social['id'] ?>">
					<?php echo $metadata['icon'] ?>

					<span <?php echo blocksy_attr_to_html($label_attr)?>>
						<?php echo $metadata['name'] ?>
					</span>
				</a>
			<?php } ?>

			<?php echo $args['after_links_content'] ?>
		</div>

	<?php

	return ob_get_clean();
}

/**
 * Encore a string to be safely included in the URL.
 *
 * @param string $str String to encode for URL.
 */
function blocksy_encode_uri_component( $str ) {
	$revert = [
		'%21' => '!',
		'%2A' => '*',
		'%27' => "'",
		'%28' => '(',
		'%29' => ')',
	];

	return strtr( rawurlencode( $str ), $revert );
}

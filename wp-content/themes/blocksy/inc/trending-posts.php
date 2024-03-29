<?php

add_action('wp_ajax_blocksy_get_trending_posts', 'blocksy_get_trending_posts');
add_action('wp_ajax_nopriv_blocksy_get_trending_posts', 'blocksy_get_trending_posts');

function blocksy_get_trending_posts() {
	if (! isset($_REQUEST['page'])) {
		wp_send_json_error();
	}

	$page = intval(sanitize_text_field($_REQUEST['page']));

	if (! $page) {
		wp_send_json_error();
	}

	wp_send_json_success([
		'posts' => blocksy_get_trending_posts_value([
			'paged' => $page
		])
	]);
}

function blocksy_get_trending_posts_value($args = []) {
	$args = wp_parse_args(
		$args,
		[
			'paged' => 1
		]
	);

	$date_query = [];

	$date_filter = get_theme_mod('trending_block_filter', 'all_time');

	if ($date_filter && 'all_time' !== $date_filter) {
		$days = [
			'last_24_hours' => 1,
			'last_7_days' => 7,
			'last_month' => 30
		][$date_filter] || 1;

		$time = time() - (intval($days) * 24 * 60 * 60);

		$date_query = array(
			'after' => date('F jS, Y', $time),
			'before' => date('F jS, Y'),
			'inclusive' => true,
		);
	}

	$query = new WP_Query(
		[
			'post_type' => 'post',
			'order' => 'DESC',
			'date_query' => $date_query,
			'posts_per_page' => 4,
			'orderby' => 'comment_count',
			'paged' => $args['paged']
		]
	);

	if (! $query->have_posts()) {
		return [
			'posts' => [],
			'is_last_page' => false
		];
	}

	$result = [];

	while ($query->have_posts()) {
		$query->the_post();

		$result[] = [
			'id' => get_the_ID(),
			'attachment_id' => get_post_thumbnail_id(),
			'title' => get_the_title(),
			'url' => get_permalink(),
			'image' => blocksy_image([
				'attachment_id' => get_post_thumbnail_id(),
				'size' => 'thumbnail',
				'ratio' => '1/1',
				'tag_name' => 'div',
			])
		];
	}

	$is_last = intval($query->max_num_pages) === intval($args['paged']);

	wp_reset_postdata();

	return [
		'posts' => $result,
		'is_last_page' => $is_last
	];
}

function blocksy_get_trending_block_cache() {
	if (! is_customize_preview()) return;

	blocksy_add_customizer_preview_cache(
		blocksy_html_tag(
			'div',
			['data-id' => 'blocksy-trending-block'],
			blocksy_get_trending_block(true)
		)
	);
}

function blocksy_get_trending_block($forced = false) {
	if (! $forced) {
		blocksy_get_trending_block_cache();
	}

	if (get_theme_mod('has_trending_block', 'no') !== 'yes') {
		if (! $forced) {
			return '';
		}
	}

	$result = blocksy_get_trending_posts_value();

	if (empty($result)) {
		return '';
	}

	ob_start();

	$data_page = 'data-page="1"';

	if ($result['is_last_page']) {
		$data_page = '';
	}

    $class = 'ct-trending-block';

    $class .= ' ' . blocksy_visibility_classes(
        get_theme_mod('trending_block_visibility', [
            'desktop' => true,
            'tablet' => true,
            'mobile' => false,
        ])
    );

	?>

    <section class="<?php echo $class ?>">
		<div class="ct-container" <?php echo $data_page ?>>
			<h5 class="ct-block-title">
				<?php echo __('Trending now', 'blocksy') ?>

				<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>

				<?php if (! $result['is_last_page']) { ?>
					<span class="ct-arrow-left">
					</span>

					<span class="ct-arrow-right">
					</span>
				<?php } ?>
			</h5>

			<?php

				foreach ($result['posts'] as $post) {
					echo blocksy_html_tag(
						'a',
						[
							'href' => $post['url']
						],

						$post['image'] . blocksy_html_tag(
							'h3',
							[
								'class' => 'ct-item-title',
							],
							$post['title']
						)
					);
				}

			?>

		</div>
	</section>

	<?php

	return ob_get_clean();
}

<?php
/**
 * Implement meta boxes
 *
 * @copyright 2019-present Creative Themes
 * @license   http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @package   Blocksy
 */

function blocksy_get_post_options($post_id = null) {
	static $post_opts = [];

	if (! $post_id) {
		global $post;

		if ($post) {
			$post_id = $post->ID;
		}

		if (is_home() && !is_front_page()) {
			$post_id = get_option('page_for_posts');
		}

		if (function_exists('is_shop') && is_shop()) {
			$post_id = get_option( 'woocommerce_shop_page_id' );
		}
	}

	if (isset($post_opts[$post_id])) {
		return $post_opts[$post_id];
	}

	$values = get_post_meta($post_id, 'blocksy_post_meta_options');

	if (empty($values)) {
		$values = [[]];
	}

	$post_opts[$post_id] = $values[0];

	return $values[0];
}

function blocksy_get_taxonomy_options($term_id = null) {
	static $taxonomy_opts = [];

	if (! $term_id) {
		$term_id = get_queried_object_id();
	}

	if (isset($taxonomy_opts[$term_id])) {
		return $taxonomy_opts[$term_id];
	}

	$values = get_term_meta(
		$term_id,
		'blocksy_taxonomy_meta_options'
	);

	if ( empty( $values ) ) {
		$values = [ [] ];
	}

	$taxonomy_opts[$term_id] = $values[0];

	return $values[0];
}

class Blocksy_Meta_Boxes {
	public function __construct() {
		add_action('init', [$this, 'init_taxonomies']);
	}

	public function init_metabox() {
		add_action('add_meta_boxes', [$this, 'setup_meta_box']);
		add_action('save_post', [$this, 'save_meta_box']);
	}

	public function init_taxonomies() {
		register_rest_field(
			['post', 'page'],
			'blocksy_meta',
			array(
				'get_callback' => function ($object) {
					$post_id = $object['id'];
					return get_post_meta($post_id, 'blocksy_post_meta_options', true);
				},
				'update_callback' => function ($value, $object) {
					$post_id = $object->ID;
					update_post_meta($post_id, 'blocksy_post_meta_options', $value);
				}
			)
		);

		$current_edit_taxonomy = $this->get_current_edit_taxonomy();

		if (! empty($_POST)) {
			add_action( 'edited_term', function ($term_id, $tt_id, $taxonomy) {
				if (
					!(
						isset( $_POST['action'] )
						&&
						'editedtag' === $_POST['action']
						&&
						isset( $_POST['taxonomy'] )
						&&
						($taxonomy = get_taxonomy( sanitize_text_field(wp_unslash($_POST['taxonomy'])) ))
						&&
						current_user_can($taxonomy->cap->edit_terms)
					)
				) {
					return;
				}

				if (isset( $_POST['tag_ID'] ) && intval(sanitize_text_field(wp_unslash($_POST['tag_ID']))) !== $term_id) {
					// the $_POST values belongs to another term, do not save them into this one
					return;
				}

				$options = $this->get_options_for_taxonomy($taxonomy->name);

				if ( empty( $options ) ) {
					return;
				}

				$values = [];

				if (isset($_POST['blocksy_taxonomy_meta_options']['ct_options'])) {
					$values = json_decode(
						sanitize_text_field(wp_unslash( $_POST['blocksy_taxonomy_meta_options']['ct_options'] )),
						true
					);
				}

				update_term_meta(
					$term_id,
					'blocksy_taxonomy_meta_options',
					$values
				);
			}, 10, 3 );
		}

		if ($current_edit_taxonomy['taxonomy']) {
			add_action(
				$current_edit_taxonomy['taxonomy'] . '_edit_form',

				function ($term) {
					$values = get_term_meta(
						$term->term_id,
						'blocksy_taxonomy_meta_options'
					);

					if ( empty( $values ) ) {
						$values = [ [] ];
					}

					$options = $this->get_options_for_taxonomy($term->taxonomy);

					if (empty($options)) {
						return;
					}

					$theme = blocksy_get_wp_theme();

					echo '<div class="ct-meta-box-container">';

					echo blocksy_html_tag(
						'h2',
						[],
						sprintf(
							// Translators: %s is the theme name.
							__('%s Settings', 'blocksy'),
							$theme->get('Name')
						)
					);

					/**
					 * Note to code reviewers: This line doesn't need to be escaped.
					 * Function blocksy_output_options_panel() used here escapes the value properly.
					 */
					echo blocksy_output_options_panel(
						[
							'options' => $options,
							'values' => $values[0],
							'id_prefix' => 'ct-post-meta-options',
							'name_prefix' => 'blocksy_taxonomy_meta_options',
						]
					);

					echo '</div>';
				}
			);
		}
	}

	private function get_current_edit_taxonomy() {
		static $cache_current_taxonomy_data = null;

		if ($cache_current_taxonomy_data !== null) {
			return $cache_current_taxonomy_data;
		}

		$result = array(
			'taxonomy' => null,
			'term_id'  => 0,
		);

		do {
			if (! is_admin()) {
				break;
			}

			// code from /wp-admin/admin.php line 110
			{
				if (
					isset($_REQUEST['taxonomy'])
					&&
					taxonomy_exists(
						sanitize_text_field(wp_unslash($_REQUEST['taxonomy']))
					)
				) {
					$taxnow = sanitize_text_field(wp_unslash($_REQUEST['taxonomy']));
				} else {
					$taxnow = '';
				}
			}

			if (empty($taxnow)) {
				break;
			}

			$result['taxonomy'] = $taxnow;

			if (empty($_REQUEST['tag_ID'])) {
				return $result;
			}

			// code from /wp-admin/edit-tags.php
			{
				$tag_ID = (int) $_REQUEST['tag_ID'];
			}

			$result['term_id'] = $tag_ID;
		} while ( false );

		$cache_current_taxonomy_data = $result;
		return $cache_current_taxonomy_data;
	}

	private function get_options_for_taxonomy($taxonomy) {
		$options = [];

		$taxonomy_slug = str_replace('_', '-', $taxonomy);

		global $wp_taxonomies;

		$post_type = $wp_taxonomies[$taxonomy]->object_type;

		if (is_array($post_type) && strpos(implode('', $post_type), 'post') !== false) {
			$taxonomy_slug = 'category';
		}

		$path = get_template_directory() . '/inc/options/taxonomies/' . $taxonomy_slug . '.php';

		if (file_exists($path)) {
			$options = blocksy_akg(
				'options',
				blocksy_get_variables_from_file($path, [ 'options' => [] ])
			);
		}

		return $options;
	}
}

new Blocksy_Meta_Boxes();

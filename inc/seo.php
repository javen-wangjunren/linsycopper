<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function gpb2b_schema_output_json_ld( $data ) {
	$json = wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
	if ( ! $json ) {
		return;
	}

	echo '<script type="application/ld+json">' . $json . '</script>';
}

function gpb2b_schema_trim_text( $text, $max_chars = 500 ) {
	$text = wp_strip_all_tags( (string) $text );
	$text = preg_replace( '/\s+/u', ' ', trim( $text ) );

	if ( '' === $text ) {
		return '';
	}

	$len = function_exists( 'mb_strlen' ) ? mb_strlen( $text ) : strlen( $text );

	if ( $len <= $max_chars ) {
		return $text;
	}

	$truncated = function_exists( 'mb_substr' ) ? mb_substr( $text, 0, $max_chars ) : substr( $text, 0, $max_chars );
	$truncated = rtrim( $truncated );

	$last_space = function_exists( 'mb_strrpos' ) ? mb_strrpos( $truncated, ' ' ) : strrpos( $truncated, ' ' );
	if ( false !== $last_space && $last_space > (int) floor( $max_chars * 0.8 ) ) {
		$truncated = function_exists( 'mb_substr' ) ? mb_substr( $truncated, 0, $last_space ) : substr( $truncated, 0, $last_space );
		$truncated = rtrim( $truncated );
	}

	return $truncated;
}

function gpb2b_get_product_schema_description( $post_id ) {
	$post_id = (int) $post_id;
	if ( ! $post_id ) {
		return '';
	}

	$short = get_flat_field( 'product_hero_desc', $post_id );
	if ( '' !== trim( (string) $short ) ) {
		return gpb2b_schema_trim_text( $short, 500 );
	}

	$overview = get_flat_field( 'product_desc_content', $post_id );
	if ( '' !== trim( (string) $overview ) ) {
		return gpb2b_schema_trim_text( $overview, 500 );
	}

	$excerpt = get_the_excerpt( $post_id );
	if ( '' !== trim( (string) $excerpt ) ) {
		return gpb2b_schema_trim_text( $excerpt, 500 );
	}

	return '';
}

function gpb2b_get_product_schema_images( $post_id ) {
	$post_id = (int) $post_id;
	if ( ! $post_id ) {
		return array();
	}

	$images = array();
	$gallery_ids = get_flat_field( 'product_hero_gallery', $post_id );

	if ( is_array( $gallery_ids ) ) {
		foreach ( $gallery_ids as $img_id ) {
			$img_id = (int) $img_id;
			if ( $img_id ) {
				$images[] = $img_id;
			}
		}
	} elseif ( is_numeric( $gallery_ids ) ) {
		$images[] = (int) $gallery_ids;
	}

	$primary_id = function_exists( 'linsy_get_product_primary_image_id' ) ? (int) linsy_get_product_primary_image_id( $post_id ) : (int) get_post_thumbnail_id( $post_id );
	if ( $primary_id ) {
		array_unshift( $images, $primary_id );
	}

	$images = array_values( array_unique( array_filter( $images ) ) );

	$urls = array();
	foreach ( $images as $img_id ) {
		$url = wp_get_attachment_image_url( $img_id, 'full' );
		if ( $url ) {
			$urls[] = $url;
		}
		if ( count( $urls ) >= 3 ) {
			break;
		}
	}

	return $urls;
}

function gpb2b_get_product_schema_additional_properties( $post_id ) {
	$post_id = (int) $post_id;
	if ( ! $post_id ) {
		return array();
	}

	$specs = get_flat_field( 'product_hero_specs', $post_id );
	if ( ! is_array( $specs ) ) {
		return array();
	}

	$props = array();
	foreach ( $specs as $spec ) {
		if ( ! is_array( $spec ) ) {
			continue;
		}

		$label = isset( $spec['label'] ) ? trim( (string) $spec['label'] ) : '';
		$value = isset( $spec['value'] ) ? trim( (string) $spec['value'] ) : '';

		if ( '' === $label || '' === $value ) {
			continue;
		}

		$props[] = array(
			'@type' => 'PropertyValue',
			'name'  => $label,
			'value' => $value,
		);
	}

	return $props;
}

function gpb2b_get_breadcrumb_schema_from_items( $items, $fallback_url = '' ) {
	if ( ! is_array( $items ) || empty( $items ) ) {
		return array();
	}

	$list = array();
	$position = 1;

	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}

		$label = isset( $item['label'] ) ? trim( (string) $item['label'] ) : '';
		if ( '' === $label ) {
			continue;
		}

		$url = isset( $item['url'] ) ? trim( (string) $item['url'] ) : '';
		if ( '' === $url && '' !== $fallback_url ) {
			$url = $fallback_url;
		}

		$list[] = array(
			'@type'    => 'ListItem',
			'position' => $position,
			'name'     => $label,
			'item'     => $url,
		);

		$position++;
	}

	if ( count( $list ) < 2 ) {
		return array();
	}

	return array(
		'@context'        => 'https://schema.org',
		'@type'           => 'BreadcrumbList',
		'itemListElement' => $list,
	);
}

function gpb2b_get_product_taxonomy_names() {
	if ( function_exists( 'linsy_get_product_breadcrumb_taxonomies' ) ) {
		$taxonomies = linsy_get_product_breadcrumb_taxonomies();
		if ( is_array( $taxonomies ) ) {
			return array_values( array_filter( array_keys( $taxonomies ) ) );
		}
	}

	return array(
		'product_shape',
		'product_material',
		'product_grade',
	);
}

add_action( 'wp_head', function() {
	if ( is_admin() || ! is_singular( 'product' ) ) {
		return;
	}

	if ( post_password_required() ) {
		return;
	}

	$post_id = get_queried_object_id();
	if ( ! $post_id ) {
		return;
	}

	$title = get_the_title( $post_id );
	if ( '' === trim( (string) $title ) ) {
		return;
	}

	$schema = array(
		'@context' => 'https://schema.org',
		'@type'    => 'Product',
		'name'     => $title,
		'url'      => get_permalink( $post_id ),
		'brand'    => array(
			'@type' => 'Brand',
			'name'  => 'Linsy Copper',
		),
	);

	$desc = gpb2b_get_product_schema_description( $post_id );
	if ( '' !== $desc ) {
		$schema['description'] = $desc;
	}

	$images = gpb2b_get_product_schema_images( $post_id );
	if ( ! empty( $images ) ) {
		$schema['image'] = $images;
	}

	$props = gpb2b_get_product_schema_additional_properties( $post_id );
	if ( ! empty( $props ) ) {
		$schema['additionalProperty'] = $props;
	}

	gpb2b_schema_output_json_ld( $schema );

	if ( function_exists( 'linsy_get_product_breadcrumb_items' ) ) {
		$breadcrumb_items = linsy_get_product_breadcrumb_items( $post_id );
		$breadcrumb_schema = gpb2b_get_breadcrumb_schema_from_items( $breadcrumb_items, get_permalink( $post_id ) );
		if ( ! empty( $breadcrumb_schema ) ) {
			gpb2b_schema_output_json_ld( $breadcrumb_schema );
		}
	}
}, 20 );

add_action( 'wp_head', function() {
	if ( is_admin() ) {
		return;
	}

	$taxonomies = gpb2b_get_product_taxonomy_names();
	if ( empty( $taxonomies ) || ! is_tax( $taxonomies ) ) {
		return;
	}

	$term = get_queried_object();
	if ( ! is_object( $term ) ) {
		return;
	}

	if ( ! function_exists( 'linsy_get_taxonomy_breadcrumb_items' ) ) {
		return;
	}

	$items = linsy_get_taxonomy_breadcrumb_items( $term );
	$term_url = get_term_link( $term );
	$fallback_url = ! is_wp_error( $term_url ) ? (string) $term_url : '';
	$schema = gpb2b_get_breadcrumb_schema_from_items( $items, $fallback_url );
	if ( empty( $schema ) ) {
		return;
	}

	gpb2b_schema_output_json_ld( $schema );
}, 20 );

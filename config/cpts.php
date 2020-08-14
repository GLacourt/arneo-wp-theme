<?php
/**
 * Config file use to load CPTs.
 *
 * @package    WordPress
 */

/**
 * How to register a cpt:
 *
 * Example:
 *    return [
 *        'partner'           => [
 *            'labels'               => [
 *                'name'          => __( 'Partners' ),
 *                'singular_name' => __( 'Partner' ),
 *                'all_items'     => __( 'All Partners' ),
 *                'view_item'     => __( 'Show' ),
 *                'add_new_item'  => __( 'Add partner' ),
 *                'add_new'       => __( 'Add' ),
 *                'edit_item'     => __( 'Edit partner' ),
 *                'update_item'   => __( 'Update partner' ),
 *                'search_items'  => __( 'Search partner' ),
 *            ],
 *            'supports'             => [
 *                'title',
 *                'excerpt',
 *                'thumbnail',
 *            ],
 *            'taxonomies'           => [
 *                'partner_category',
 *            ],
 *            'rewrite'              => [
 *                'slug' => '%partner-type%/%partner-list%',
 *            ],
 *            'register_meta_box_cb' => [ $this, 'metaBoxCpt' ],
 *            'public'               => true,
 *            'show_in_rest'         => true,
 *            'hierarchical'         => false,
 *        ],
 *    ];
 */

return array();

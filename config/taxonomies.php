<?php
/**
 * Config file use to load taxonomies.
 *
 * @package    WordPress
 * @subpackage Arneo WordPress Theme
 */

/**
 * How to register supports:
 *
 * Example:
 *    return [
 *        [
 *            'partner_category',
 *            [
 *                'partner_type',
 *                'partner_type_list',
 *                'partner',
 *            ],
 *            [
 *                'label'                 => __( 'Categories' ),
 *                'labels'                => [
 *                    'name'          => __( 'Categories' ),
 *                    'singular_name' => __( 'Category' ),
 *                    'all_items'     => __( 'All Categories' ),
 *                    'edit_item'     => __( 'Edit Category' ),
 *                    'view_item'     => __( 'Show Category' ),
 *                    'update_item'   => __( 'Update Category' ),
 *                    'add_new_item'  => __( 'Add new category' ),
 *                    'new_item_name' => __( 'New category' ),
 *                    'search_items'  => __( 'Search categories' ),
 *                    'popular_items' => __( 'Popular categories' ),
 *                ],
 *                'hierarchical'          => true,
 *                'show_ui'               => true,
 *                'show_in_rest'          => true,
 *                'sow_admin_column'      => true,
 *                'query_var'             => true,
 *            ],
 *        ],
 *    ];
 */

return array();

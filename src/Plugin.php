<?php

declare(strict_types=1);

namespace PHPUnitForGraphQLAPI\GraphQLAPITesting;

use PHPUnitForGraphQLAPI\GraphQLAPITesting\RESTAPI\Endpoints\AdminRESTAPIEndpointManager;
use PHPUnitForGraphQLAPI\GraphQLAPITesting\Settings\Options;
use PHPUnitForGraphQLAPI\GraphQLAPITesting\Utilities\CustomHeaderAppender;
use WP_REST_Response;

use function add_action;
use function delete_option;
use function get_option;
use function flush_rewrite_rules;

class Plugin
{
    public function initialize(): void
    {
        /**
         * Send custom headers needed for development
         */
        new CustomHeaderAppender();

        /**
         * Initialize REST endpoints
         */
        new AdminRESTAPIEndpointManager();

        /**
         * Executing `flush_rewrite_rules` at the end of the execution
         * of the REST controller doesn't work, so do it at the
         * beginning instead, if set via a flag.
         */
        if (get_option(Options::FLUSH_REWRITE_RULES)) {
            delete_option(Options::FLUSH_REWRITE_RULES);
            add_action('init', \Closure::fromCallable('flush_rewrite_rules'), PHP_INT_MAX);
        }

        $this->adaptRESTAPIResponse();

        add_action('init', \Closure::fromCallable([$this, 'registerTestingTaxonomies']));
    }

    protected function adaptRESTAPIResponse(): void
    {
        /**
         * Remove the "_link" entry from the WP REST API response,
         * so that the GraphQL response does not include the domain,
         * and then the same tests work for both "Integration Tests"
         * and "PROD Integration Tests".
         *
         * The hooks for CPTs must be generated one by one.
         *
         * @see https://stackoverflow.com/a/53505460
         * @see wp-includes/rest-api/endpoints/class-wp-rest-posts-controller.php
         */
        $cpts = ['post', 'page', 'attachment'];
        $item19Unpacked = array_map(
            function (string $cpt) {
                return 'rest_prepare_' . $cpt;
            },
            $cpts
        );
        $hooks = array_merge(['rest_prepare_application_password', 'rest_prepare_attachment', 'rest_prepare_autosave', 'rest_prepare_block_type', 'rest_prepare_comment', 'rest_prepare_nav_menu_item', 'rest_prepare_menu_location', 'rest_prepare_block_pattern', 'rest_prepare_plugin', 'rest_prepare_status', 'rest_prepare_post_type', 'rest_prepare_revision', 'rest_prepare_sidebar', 'rest_prepare_taxonomy', 'rest_prepare_theme', 'rest_prepare_url_details', 'rest_prepare_user', 'rest_prepare_widget_type', 'rest_prepare_widget'], $item19Unpacked);
        foreach ($hooks as $hook) {
            \add_filter(
                $hook,
                \Closure::fromCallable([$this, 'removeRESTAPIResponseLink']),
                PHP_INT_MAX
            );
        }
    }

    /**
     * @param \WP_REST_Response $data
     */
    public function removeRESTAPIResponseLink($data): WP_REST_Response
    {
        foreach ($data->get_links() as $_linkKey => $_linkVal) {
            $data->remove_link($_linkKey);
        }
        return $data;
    }

    /**
     * Taxonomies used for testing the plugin
     */
    protected function registerTestingTaxonomies(): void
    {
        \register_taxonomy(
            'dummy-tag',
            [],
            $this->getTaxonomyArgs(false, __('Dummy Tag'), __('Dummy Tags'), __('dummy tag'), __('dummy tags'))
        );

        \register_taxonomy(
            'dummy-category',
            [],
            $this->getTaxonomyArgs(true, __('Dummy Category'), __('Dummy Categories'), __('dummy category'), __('dummy categories'))
        );

        \register_post_type(
            'dummy-cpt',
            $this->getCustomPostTypeArgs([
                'dummy-tag',
                'dummy-category',
            ], __('Dummy CPT'), __('Dummy CPTs'), __('dummy CPTs'))
        );
    }

    /**
     * Labels for registering the taxonomy
     *
     * @param string $name_uc Singular name uppercase
     * @param string $names_uc Plural name uppercase
     * @param string $name_lc Singulare name lowercase
     * @param string $names_lc Plural name lowercase
     * @return array<string,mixed>
     * @param bool $hierarchical
     */
    protected function getTaxonomyArgs($hierarchical, $name_uc, $names_uc, $name_lc, $names_lc): array
    {
        return array(
            'label' => $names_uc,
            'labels' => $this->getTaxonomyLabels($name_uc, $names_uc, $name_lc, $names_lc),
            'hierarchical' => $hierarchical,
            'public' => true,
            'show_ui' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud' => false,
            'show_in_rest' => true,
        );
    }

    /**
     * Labels for registering the taxonomy
     *
     * @param string $name_uc Singular name uppercase
     * @param string $names_uc Plural name uppercase
     * @param string $name_lc Singulare name lowercase
     * @param string $names_lc Plural name lowercase
     * @return array<string,string>
     */
    protected function getTaxonomyLabels($name_uc, $names_uc, $name_lc, $names_lc): array
    {
        return array(
            'name'                           => $names_uc,
            'singular_name'                  => $name_uc,
            'menu_name'                      => $names_uc,
            'search_items'                   => \sprintf(\__('Search %s', 'graphql-api'), $names_uc),
            'all_items'                      => $names_uc,//\sprintf(\__('All %s', 'graphql-api'), $names_uc),
            'edit_item'                      => \sprintf(\__('Edit %s', 'graphql-api'), $name_uc),
            'update_item'                    => \sprintf(\__('Update %s', 'graphql-api'), $name_uc),
            'add_new_item'                   => \sprintf(\__('Add New %s', 'graphql-api'), $name_uc),
            'new_item_name'                  => \sprintf(\__('Add New %s', 'graphql-api'), $name_uc),
            'view_item'                      => \sprintf(\__('View %s', 'graphql-api'), $name_uc),
            'popular_items'                  => \sprintf(\__('Popular %s', 'graphql-api'), $names_lc),
            'separate_items_with_commas'     => \sprintf(\__('Separate %s with commas', 'graphql-api'), $names_lc),
            'add_or_remove_items'            => \sprintf(\__('Add or remove %s', 'graphql-api'), $name_lc),
            'choose_from_most_used'          => \sprintf(\__('Choose from the most used %s', 'graphql-api'), $names_lc),
            'not_found'                      => \sprintf(\__('No %s found', 'graphql-api'), $names_lc),
        );
    }

    /**
     * Arguments for registering the post type
     *
     * @param string[] $taxonomies
     * @return array<string,mixed>
     * @param string $name_uc
     * @param string $names_uc
     * @param string $names_lc
     */
    protected function getCustomPostTypeArgs($taxonomies, $name_uc, $names_uc, $names_lc): array
    {
        return array(
            'public' => true,
            'show_in_nav_menus' => true,
            'show_ui' => true,
            'publicly_queryable' => true,
            'label' => $name_uc,
            'labels' => $this->getCustomPostTypeLabels($name_uc, $names_uc, $names_lc),
            'capability_type' => 'post',
            'hierarchical' => true,
            'exclude_from_search' => false,
            'show_in_admin_bar' => true,
            'show_in_menu' => true,
            'show_in_rest' => true,
            'supports' => [
                'title',
                'editor',
                'excerpt',
                'author',
                'revisions',
                'thumbnail',
                'comments',
                'custom-fields',
            ],
            // 'rewrite' => ['slug' => $slugBase],
            'taxonomies' => $taxonomies,
        );
    }

    /**
     * Labels for registering the post type
     *
     * @param string $name_uc Singular name uppercase
     * @param string $names_uc Plural name uppercase
     * @param string $names_lc Plural name lowercase
     * @return array<string,string>
     */
    protected function getCustomPostTypeLabels($name_uc, $names_uc, $names_lc): array
    {
        return array(
            'name'               => $names_uc,
            'singular_name'      => $name_uc,
            'add_new'            => sprintf(\__('Add New %s', 'graphql-api'), $name_uc),
            'add_new_item'       => sprintf(\__('Add New %s', 'graphql-api'), $name_uc),
            'edit_item'          => sprintf(\__('Edit %s', 'graphql-api'), $name_uc),
            'new_item'           => sprintf(\__('New %s', 'graphql-api'), $name_uc),
            'all_items'          => $names_uc,//sprintf(\__('All %s', 'graphql-api'), $names_uc),
            'view_item'          => sprintf(\__('View %s', 'graphql-api'), $name_uc),
            'search_items'       => sprintf(\__('Search %s', 'graphql-api'), $names_uc),
            'not_found'          => sprintf(\__('No %s found', 'graphql-api'), $names_lc),
            'not_found_in_trash' => sprintf(\__('No %s found in Trash', 'graphql-api'), $names_lc),
            'parent_item_colon'  => sprintf(\__('Parent %s:', 'graphql-api'), $name_uc),
        );
    }
}

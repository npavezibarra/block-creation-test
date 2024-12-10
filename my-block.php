<?php
/**
 * Plugin Name: My Custom Blocks
 * Description: A plugin to register custom blocks.
 * Version: 1.0
 * Author: Your Name
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function register_my_custom_blocks() {
    // My Own Block
    if ( register_block_type(
        plugin_dir_path( __FILE__ ) . 'blocks/my-own-block/block.json',
        array(
            'render_callback' => 'render_my_own_block',
        )
    ) ) {
        error_log( 'My Own Block registered successfully.' );
    } else {
        error_log( 'Failed to register My Own Block.' );
    }

    // Another Block
    if ( register_block_type(
        plugin_dir_path( __FILE__ ) . 'blocks/another-block/block.json',
        array(
            'render_callback' => 'render_another_block',
        )
    ) ) {
        error_log( 'Another Block registered successfully.' );
    } else {
        error_log( 'Failed to register Another Block.' );
    }
}
add_action( 'init', 'register_my_custom_blocks' );


// Render callback for My Own Block
function render_my_own_block( $attributes ) {
    ob_start();
    include plugin_dir_path( __FILE__ ) . 'blocks/my-own-block/render.php';
    return ob_get_clean();
}

// Render callback for Another Block
function render_another_block( $attributes ) {
    ob_start();
    include plugin_dir_path( __FILE__ ) . 'blocks/another-block/render.php';
    return ob_get_clean();
}

// Add custom block category
function my_custom_block_categories( $categories ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'custom-category',
                'title' => __( 'Custom Blocks', 'my-block' ),
            ),
        )
    );
}
add_filter( 'block_categories_all', 'my_custom_block_categories', 10, 2 );

// Enqueue block editor assets
function enqueue_block_editor_assets() {
    // Editor script and style for Another Block
    wp_enqueue_script(
        'my-block-another-block-editor-script',
        plugins_url( 'blocks/another-block/editor.js', __FILE__ ),
        array( 'wp-blocks', 'wp-element', 'wp-editor' ),
        filemtime( plugin_dir_path( __FILE__ ) . 'blocks/another-block/editor.js' )
    );

    wp_enqueue_style(
        'my-block-another-block-style',
        plugins_url( 'blocks/another-block/style.css', __FILE__ ),
        array(),
        filemtime( plugin_dir_path( __FILE__ ) . 'blocks/another-block/style.css' )
    );

    // Editor script and style for My Own Block
    wp_enqueue_script(
        'my-block-my-own-block-editor-script',
        plugins_url( 'blocks/my-own-block/editor.js', __FILE__ ),
        array( 'wp-blocks', 'wp-element', 'wp-editor' ),
        filemtime( plugin_dir_path( __FILE__ ) . 'blocks/my-own-block/editor.js' )
    );

    wp_enqueue_style(
        'my-block-my-own-block-style',
        plugins_url( 'blocks/my-own-block/style.css', __FILE__ ),
        array(),
        filemtime( plugin_dir_path( __FILE__ ) . 'blocks/my-own-block/style.css' )
    );
}
add_action( 'enqueue_block_editor_assets', 'enqueue_block_editor_assets' );

add_filter( 'block_categories_all', function( $categories ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'text',
                'title' => __( 'Text Blocks', 'my-block' ),
            ),
        )
    );
}, 10, 2 );

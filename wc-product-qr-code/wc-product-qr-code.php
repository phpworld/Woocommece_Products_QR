<?php
/*
Plugin Name: WooCommerce Product QR Code
Description: Generates a QR code for product details pages and displays it above the "Add to Cart" button.
Version: 1.1
Author: Your Name
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Hook into WooCommerce single product page
add_action('woocommerce_single_product_summary', 'display_qr_code_above_add_to_cart', 20);

function display_qr_code_above_add_to_cart() {
    global $product;
    
    // Get the current product URL
    $product_url = get_permalink($product->get_id());
    
    // Generate the QR code
    $qr_code_src = generate_qr_code($product_url);
    
    // Display the QR code above the "Add to Cart" button
    echo '<div class="product-qr-code">';
    echo '<img src="' . esc_url($qr_code_src) . '" alt="QR Code" />';
    echo '</div>';
}

// Function to generate the QR code
function generate_qr_code($url) {
    // Use the QRServer API to generate a QR code
    $qr_code_url = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' . urlencode($url);
    return $qr_code_url;
}

// Enqueue custom styles
function enqueue_custom_styles() {
    wp_enqueue_style('wc-product-qr-code-style', plugins_url('/css/style.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');
?>
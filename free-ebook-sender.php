<?php
/*
Plugin Name: Free eBook Sender for Hardcover Orders
Plugin URI: https://tales2btold.com/
Description: Automatically sends a free eBook when a customer purchases the Hardcover version of "Surviving Cushing’s Disease" and shows a message in the cart.
Version: 1.0.0
Author: Ahmed
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; 
}

/**
 * ✅ Send free eBook when Hardcover order is placed
 */
add_action('woocommerce_thankyou', 'fes_send_free_ebook_for_hardcover', 10, 1);
function fes_send_free_ebook_for_hardcover($order_id) {
    if (!$order_id) return;

    $order = wc_get_order($order_id);
    $ebook_url = 'https://tales2btold.com/wp-content/uploads/book/Tales-To-Be-Told-by-Chuck-Knueve-English-ndc6h0.pdf';
    $hardcover_variation_id = 1890; 
    $ebook_sent = false;

    // Debug note in admin
    $order->add_order_note('🧩 Free eBook Sender: Check started for order #' . $order_id);

    foreach ($order->get_items() as $item) {
        $variation_id = $item->get_variation_id();

        if ($variation_id == $hardcover_variation_id) {

            $email = $order->get_billing_email();
            $subject = 'Your Free eBook Download';
            $message = '<p>Hi there,</p>
                        <p>Thank you for purchasing the <strong>Hardcover Edition</strong> of 
                        <em>Surviving Cushing’s Disease: A Young Man’s Journey</em>.</p>
                        <p>Your free eBook is ready to download:</p>
                        <p><a href="' . esc_url($ebook_url) . '" target="_blank">
                        👉 Click here to download your eBook</a></p>
                        <p>Enjoy reading!<br>— The Team</p>';
            $headers = ['Content-Type: text/html; charset=UTF-8'];

            $sent = wp_mail($email, $subject, $message, $headers);

            if ($sent) {
                $order->add_order_note('✅ Free eBook email sent successfully to ' . $email);
                $ebook_sent = true;
                update_post_meta($order_id, '_ebook_sent', 'yes');
            } else {
                $order->add_order_note('⚠️ Free eBook email failed to send to ' . $email);
            }

            $order->save();
            break;
        }
    }

    if (!$ebook_sent) {
        $order->add_order_note('ℹ️ Free eBook not sent — no matching Hardcover variation found.');
    }
}

/**
 * ✅ Show confirmation on Thank You page
 */
add_action('woocommerce_thankyou', 'fes_show_message_on_thankyou', 20);
function fes_show_message_on_thankyou($order_id) {
    if (get_post_meta($order_id, '_ebook_sent', true) === 'yes') {
        echo '<div class="woocommerce-message" style="margin-top:20px; padding:10px; background:#f0fff0; border-left:4px solid #46b450;">
                ✅ Your free eBook has been sent to your email address!
              </div>';
        delete_post_meta($order_id, '_ebook_sent');
    }
}

/**
 * ✅ Show message under Hardcover product name in Cart & Checkout
 */
add_filter('woocommerce_cart_item_name', 'show_free_ebook_message_for_hardcover', 10, 3);
function show_free_ebook_message_for_hardcover($product_name, $cart_item, $cart_item_key) {
    $hardcover_variation_id = 1890; 
    $variation_id = isset($cart_item['variation_id']) ? $cart_item['variation_id'] : 0;

    if ($variation_id == $hardcover_variation_id) {
        $product_name .= '<br><small style="color:green;">🎁 A free eBook will be sent to your email after purchase!</small>';
    }

    return $product_name;
}

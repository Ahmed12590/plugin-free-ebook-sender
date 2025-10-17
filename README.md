Plugin Name: Free eBook Sender for Hardcover Orders
Version: 1.0.0
Author: Ahmed
Website: https://tales2btold.com/

📘 Overview

This WordPress / WooCommerce plugin automatically sends a free eBook to customers who purchase the Hardcover version of a specific book — Surviving Cushing’s Disease: A Young Man’s Journey.
It also displays a confirmation message on the Thank You page and a notice in the cart/checkout pages.

⚙️ Step-by-Step Functionality
1) Security Check

The plugin ensures it can only run inside WordPress and cannot be accessed directly via a browser.

2) Sending the Free eBook (on order completion)

When a WooCommerce order is completed, the plugin:

Retrieves the order details.

Checks if the Hardcover version (based on its variation ID) was purchased.

If yes:

Sends the eBook download link to the customer’s billing email.

Adds an admin order note confirming the email was sent.

Saves a tracking meta field to prevent duplicates.

If no Hardcover item is found, an order note is added indicating that.

3) Showing Confirmation on the Thank You Page

If the eBook email was sent successfully, a green confirmation message appears on the Thank You page:

✅ Your free eBook has been sent to your email address!

This message appears once and is then cleared from order meta.

4) Showing a Message Under Hardcover Product Name (Cart & Checkout)

When the Hardcover version is added to the cart or viewed at checkout, a message appears under the item name:

🎁 A free eBook will be sent to your email after purchase!

This helps inform customers about the free eBook offer before completing the purchase.

🧩 Hooks & Functions Used

WooCommerce Hooks:

woocommerce_thankyou

woocommerce_cart_item_name

WooCommerce Functions:

wc_get_order()

$order->get_items()

$order->get_billing_email()

$order->add_order_note()

$order->save()

WordPress Functions:

wp_mail()

update_post_meta()

get_post_meta()

delete_post_meta()

esc_url()

🧠 Configuration Notes

Hardcover Variation ID → Replace with your actual Hardcover variation ID.

eBook URL → Update with your actual eBook download link.

Email Content → Customize the subject and body text to match your brand tone and style.

🛠️ Troubleshooting

Problem: Emails not being sent
Solution:

Make sure wp_mail() is working on your server.

Use an SMTP plugin such as WP Mail SMTP to improve reliability.

Problem: eBook not sent
Solution:

Double-check the correct variation ID for the Hardcover version in:
WordPress Admin → Products → Variations

✅ Summary

This plugin enhances customer experience by:

Detecting Hardcover purchases.

Automatically sending a free eBook.

Adding order notes for admin visibility.

Showing clear confirmation messages for customers.

Simple, automated, and customer-friendly!

Website: https://tales2btold.com/
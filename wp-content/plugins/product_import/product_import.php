<?php
/*
Plugin Name: Product Import
Description: Import products from a file once a day.
*/

ini_set('display_errors', 1);
error_reporting(E_ALL);


// Hook the import function to run once a day
add_action('wp_loaded', 'import_products_once_a_day');

// Add a menu item to the admin menu
function add_import_menu_item() {
    add_menu_page(
        'Product Import',
        'Product Import',
        'manage_options',
        'product-import',
        'import_products_manually',
        'dashicons-cloud-upload',
        100
    );
}
add_action('admin_menu', 'add_import_menu_item');

function import_products_once_a_day() {
    // Path to product.xml file
    $xml_file_path = ABSPATH . 'product.xml';

    // Check if the XML file exists
    if (file_exists($xml_file_path)) {
        // Load the XML file
        $xml = simplexml_load_file($xml_file_path);

        if ($xml !== false) {
            

            // Ensure that the "sizes" and "colors" elements exist in the XML
            if (isset($xml->sizes->size) && isset($xml->colors->color)) {
                foreach ($xml->product as $product) {
                    // Extract product information from the XML
                    $product_id = (string)$product['id'];

                        // Extract product information from the XML
                        $product_id = (string)$product['id'];
                        $product_name = (string)$product['name'];
                        $product_description = (string)$product['description'];

                        // Extract size and color values from the XML, assuming they are in a format like "Small, Medium, Large"
                        $size_values = explode(', ', $product['sizes']);
                        $color_values = explode(', ', $product['colors']);

                        // Output debug information to the screen
                        // echo '<pre>';
                        // echo 'Size Values:';
                        // print_r($size_values);
                        // echo 'Color Values:';
                        // print_r($color_values);
                        // echo '</pre>';

                        // Check if the product already exists in WooCommerce by product ID
                        $existing_product = wc_get_product($product_id);

                        if (!$existing_product) {
                            // Product doesn't exist, create a new variable product
                            $new_product = new WC_Product_Variable();
                            $new_product->set_name($product_name);
                            $new_product->set_description($product_description);

                            // Add attributes for variations (e.g., size and color)
                            $attributes = array(
                                'size' => array(
                                    'name' => 'Size',
                                    'value' => $size_values,
                                    'position' => 1,
                                    'is_visible' => true,
                                    'is_variation' => true,
                                    'is_taxonomy' => false,
                                ),
                                'color' => array(
                                    'name' => 'Color',
                                    'value' => $color_values,
                                    'position' => 2,
                                    'is_visible' => true,
                                    'is_variation' => true,
                                    'is_taxonomy' => false,
                                ),
                            );

                            // Set the attributes for the product
                            $new_product->set_attributes($attributes);

                            // Create variations for each combination of size and color
                            $variations = array();

                            foreach ($size_values as $size) {
                                foreach ($color_values as $color) {
                                    // Calculate the price based on size and color
                                    $variation_price = calculate_variation_price($size, $color, $xml);

                                    $variation = new WC_Product_Variation();
                                    // Set the SKU based on size and color
                                    $variation_sku = "{$size}-{$color}";
                                    $variation->set_sku($variation_sku);
                                    $variation->set_regular_price($variation_price);
                                    $variation->set_stock_quantity(100);

                                    // Set variation attributes
                                    $variation->set_attributes(array(
                                        'size' => $size,
                                        'color' => $color,
                                    ));

                                    // Add the variation to the product
                                    $variations[] = $variation;
                                }
                            }

                            // Assign variations to the variable product
                            $new_product->set_children($variations);
                            $new_product->save();

                        } else {
                            // Product already exists, update its description if needed
                            $existing_product->set_name($product_name);
                            $existing_product->set_description($product_description);
                            $existing_product->save();
                        }
                }
            } else {
                // Handle the case where the "sizes" or "colors" elements are missing in the XML
                echo '<p>Error: XML data is missing "sizes" or "colors" elements.</p>';
            }
        } else {
            // Handle the case where the XML file could not be loaded
            echo '<p>Error: Failed to load XML file: ' . esc_html($xml_file_path) . '</p>';
        }

        // After importing, update the last run time
        set_transient('product_import_last_run', time());

    } else {
        // Handle the case where the XML file does not exist
        echo '<p>Error: XML file does not exist.</p>';
    }
}



function calculate_variation_price($size, $color, $xml_data) {
    // Assuming $xml_data is the loaded XML data containing the price attributes

    // Find the size and color in the XML data
    $size_element = null;
    $color_element = null;

    foreach ($xml_data->sizes->size as $size_element) {
        if ((string)$size_element['name'] === $size) {
            break;
        }
    }

    foreach ($xml_data->colors->color as $color_element) {
        if ((string)$color_element['name'] === $color) {
            break;
        }
    }

    if (!$size_element || !$color_element) {
        // Size or color not found in the XML data, handle the error
        return 0; // Or any default price you prefer
    }

    // Set the price based on the light pricing tier
    return (float)$size_element['light_price'];
}

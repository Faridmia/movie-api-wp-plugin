<?php
/*
Plugin Name: Horror Movie API Example Plugin
Plugin URI: https://example.com/
Description: Example using the HTTP API to parse JSON from a remote
horror movie API
Author: farid mia
Author URI: github.com/faridmia
*/
// Register a custom page for your plugin
add_action('admin_menu', 'pdev_create_menu');

function pdev_create_menu()
{

    // Create custom top-level menu
    add_menu_page(
        'PDEV Movies Page',
        'PDEV Movies',
        'manage_options',
        'pdev-movies',
        'pdev_movie_api_results',
        'dashicons-smiley',
        99
    );
}

// Request and display Movie API data
function pdev_movie_api_results()
{

    // Set your API URL
    $request = wp_remote_get('https://api.sampleapis.com/movies/horror');
    // If an error is returned, return false to end the request

    // var_dump(wp_remote_get('malformed-url'));
    if (is_wp_error($request)) {
        return false;
    }
    // Retrieve only the body from the raw response
    $body = wp_remote_retrieve_body($request);
    // Decode the JSON string
    $data = json_decode($body, true);

    // Verify the $data variable is not empty
    if (!empty($data)) {

        echo '<ul>';
        // Loop through the returned dataset
        foreach ($data as $movies) {
            echo '<li>';
            echo '<a href="https://www.imdb.com/title/' .
                esc_attr($movies['imdbId']) . '">';
            echo '<img src="' . esc_url($movies['posterURL']) .
                '" height="75"><br />';
            echo esc_html($movies['title']);
            echo '</a>';
            echo '</li>';
        }
        echo '</ul>';
    }
}

/*
$url = 'https://www.example.com/bleh';

// Send GET request
$response = wp_remote_get($url);

// Check for server response
if (is_wp_error($response)) {

    $code = $response->get_error_message();
    wp_die('Requests could not execute. Error was: ' . $code);
}

// Check that the server sent a “404 Not Found” HTTP status code
if (wp_remote_retrieve_response_code($response) == 404) {

    wp_die('Web page not found');
}

// So far, so good
echo 'Web page found!';

*/

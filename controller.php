<?php
    $path=@parse_url($_SERVER['REQUEST_URI'])['path'];
    switch ($path) {
        case '/':
            require_once 'index.php';
            break;
        case '/login':
            require_once 'php/login.php';
            break;
        case '/profile-pictures':
            require_once 'php/profile-pictures.php';
            break;
        case '/signup':
            require_once 'php/signup.php';
            break;
        default:
            http_response_code(404);
            exit('Not Found');
    }
?>
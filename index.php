<?php
if ($_SERVER['REQUEST_URI'] === '/') {
    // Redirect to /home
    header("Location: /home");
    exit; // Make sure to exit after redirection
}
if (str_starts_with($_SERVER['REQUEST_URI'], "/profiles/img/banner.svg")) {
    include("profiles/img/banner.php");
    exit;
}


include("404/index.php");

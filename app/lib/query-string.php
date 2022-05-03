
<?php

// Conditions to redirect to particular funtions through button or link click using the Query strings

//For Logout
if (isset($_GET['query']) && ($_GET['query']) === 'logout') {
    session_start();
    $_SESSION = array();
    session_destroy();
    header("location: home?message=logoutSuccess");
    exit;
}

//For theme switching
//home?query=changeTheme&theme=dark
if (isset($_GET['query']) && ($_GET['query']) === 'changeTheme') {
    $theme = $_GET['theme'];
    $functions -> changeTheme($theme, $conn);
}

?>
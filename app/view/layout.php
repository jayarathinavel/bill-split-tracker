<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ?  $title : $constants['APP_TITLE']; ?></title>
    <link rel="icon" type="image/x-icon" href="resources/favicon.png">
    <link href="resources/stylesheet.css" rel="stylesheet">
    <link href="resources/themes/<?php echo $functions -> getCurrentTheme($conn); ?>/stylesheet.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="resources/script-top.js"></script>
</head>
<?php 
    $classes = $functions -> themeSpecific($conn);
    $formFields = isset($classes['form-fields']) ? $classes['form-fields'] : 'bg-secondary text-light';
    $footerClass = isset($classes['footer-bar']) ? $classes['footer-bar'] : 'bg-dark text-light alignCenter';
?>
<body>
    <div class="layout-container">
        <nav class="<?php echo isset($classes['navbar']) ? $classes['navbar'] : 'navbar fixed-top navbar-expand-lg navbar-dark bg-dark';?>">
            <div class="container-fluid">
                <a class="navbar-brand" href="/home">Brand</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item m-1">
                            <a href="test1" class="nav-link <?php echo $page == '/test1' ? 'active' : ''; ?> <?php echo isset($classes['navbar-btn']) ? $classes['navbar-btn'] : 'btn btn-sm btn-secondary';?>"> Test Page 1 </a>
                        </li>
                        <li class="nav-item m-1">
                            <a href="test2" class="nav-link <?php echo $page == '/test2' ? 'active' : ''; ?> <?php echo isset($classes['navbar-btn']) ? $classes['navbar-btn'] : 'btn btn-sm btn-secondary';?>"> Test Page 2 </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle btn <?php echo isset($classes['navbar-btn']) ? $classes['navbar-btn'] : 'btn btn-sm btn-secondary';?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <?php echo $functions -> isLoggedIn() ? $_SESSION["username"] : 'Menu'; ?> </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <?php
                                    if(!($functions -> isLoggedIn())){
                                        echo'
                                            <li><a class="dropdown-item" href="login">Login</a></li>
                                            <li><a class="dropdown-item" href="register">Sign Up</a></li>
                                        ';
                                    }
                                    else{
                                        echo '
                                            <li><a class="dropdown-item" href="dashboard">Dashboard</a></li>
                                            <li><a class="dropdown-item" href="home?query=logout">Logout</a></li>
                                        ';
                                    }                            
                                ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div style="padding-top:80px;"></div>
        <section id="main" class="p-2">
            <?php
                if($functions -> getSuccessMessage() !== null){
                    echo '
                    <div class="alert alert-dismissible alert-warning ms-3 me-3">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <div class="text-center">'.$functions -> getSuccessMessage().'</div> 
                    </div>
                    ';
                }

                if($functions -> getErrorMessage() !== null){
                    echo '
                    <div class="alert alert-dismissible alert-danger ms-3 me-3">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <div class="text-center">'.$functions -> getErrorMessage().'</div> 
                    </div>
                    ';
                }
                include $mainContent;
                ?>
        </section>
        <footer>
            <div class="<?php echo $footerClass; ?>">
                Footer
            </div>
        </footer>
    </div>
    <script src="resources/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>
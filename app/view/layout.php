<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title><?php echo isset($title) ?  $title : $constants['APP_TITLE']; ?></title>
    <link rel="icon" type="image/x-icon" href="resources/favicon.png">
    <link href="resources/stylesheet.css" rel="stylesheet">
    <link href="resources/themes/<?php echo $functions->getCurrentTheme($conn); ?>/stylesheet.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="resources/calculator.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="resources/script-top.js"></script>
</head>
<?php
$classes = $functions->themeSpecific($conn);
$formFields = isset($classes['form-fields']) ? $classes['form-fields'] : 'bg-secondary text-light';
$footerClass = isset($classes['footer-bar']) ? $classes['footer-bar'] : 'bg-dark text-light alignCenter';
?>

<body>
    <div class="layout-container">
        <nav class="<?php echo isset($classes['navbar']) ? $classes['navbar'] : 'navbar fixed-top navbar-expand-lg navbar-dark bg-dark'; ?>">
            <div class="container-fluid">
                <a class="navbar-brand" href="/home">Bill Split Tracker</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item m-1">
                            <a href="weekly-bill-split" class="nav-link <?php echo $page == '/weekly-bill-split' ? 'active' : ''; ?> <?php echo isset($classes['navbar-btn']) ? $classes['navbar-btn'] : 'btn btn-sm btn-secondary'; ?>"> Weekly Bill Split </a>
                        </li>
                        <li class="nav-item m-1">
                            <a href="#" class="nav-link <?php echo isset($classes['navbar-btn']) ? $classes['navbar-btn'] : 'btn btn-sm btn-secondary'; ?>" data-bs-toggle="modal" data-bs-target="#calculatorModal">
                                Calculator
                            </a>
                        </li>
                        <li class="nav-item m-1">
                            <a href="more" class="nav-link <?php echo $page == '/more' ? 'active' : ''; ?> <?php echo isset($classes['navbar-btn']) ? $classes['navbar-btn'] : 'btn btn-sm btn-secondary'; ?>"> More </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle btn <?php echo isset($classes['navbar-btn']) ? $classes['navbar-btn'] : 'btn btn-sm btn-secondary'; ?>" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <?php echo $functions->isLoggedIn() ? $_SESSION["username"] : 'Menu'; ?> </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <?php
                                if (!($functions->isLoggedIn())) {
                                    echo '
                                            <li><a class="dropdown-item" href="login">Login</a></li>
                                            <li><a class="dropdown-item" href="register">Sign Up</a></li>
                                        ';
                                } else {
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
            if ($functions->getSuccessMessage() !== null) {
                echo '
                    <div class="alert alert-dismissible alert-warning ms-3 me-3">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <div class="text-center">' . $functions->getSuccessMessage() . '</div> 
                    </div>
                    ';
            }

            if ($functions->getErrorMessage() !== null) {
                echo '
                    <div class="alert alert-dismissible alert-danger ms-3 me-3">
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        <div class="text-center">' . $functions->getErrorMessage() . '</div> 
                    </div>
                    ';
            }
            include $mainContent;
            ?>
        </section>
    </div>

    <!-- Modal for Calculator -->
    <div class="modal fade" id="calculatorModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="calculatorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="calculatorModalLabel">Calculator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <main class="calculator shadow p-3 mb-5 bg-body rounded">
                        <div class="top">
                            <span class="unit">deg</span>
                            <section class="screen">
                                <div class="input"></div>
                                <div class="result"></div>
                            </section>
                        </div>
                        <div class="bottom">
                            <section class="keys">
                                <div class="column">
                                    <span data-key="7">7</span>
                                    <span data-key="4">4</span>
                                    <span data-key="1">1</span>
                                    <span data-key=".">.</span>
                                </div>
                                <div class="column">
                                    <span data-key="8">8</span>
                                    <span data-key="5">5</span>
                                    <span data-key="2">2</span>
                                    <span data-key="0">0</span>
                                </div>
                                <div class="column">
                                    <span data-key="9">9</span>
                                    <span data-key="6">6</span>
                                    <span data-key="3">3</span>
                                    <span class="equals-to" data-key="=">=</span>
                                </div>
                            </section>
                            <section class="operators">
                                <span class="delete">del</span>
                                <span data-key="÷">÷</span>
                                <span data-key="x">x</span>
                                <span data-key="-">-</span>
                                <span data-key="+">+</span>
                            </section>

                        </div>
                    </main>
                </div>
            </div>
        </div>
    </div>

    <script src="resources/script.js"></script>
    <script src="resources/calculator.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

</body>

</html>
<?php
    require $config['MODEL_PATH'].'authorization.php';
    require $config['CONTROLLER_PATH'].'authorization.php';
    session_start();
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        header("location: home");
        exit;
    }
?>
<div style="display: flex;flex-wrap: wrap;justify-content: center;">
    <div class="wrapper">
        <h2 class="text-center">Login</h2>
        <p>Please fill in your credentials to login.</p>

        <form action="<?php $authorizationController = new AuthorizationController; $authorizationController -> login($conn, $authorizationModel); ?>" method="post">
            <?php 
                if(!empty($authorizationModel -> getLogin_err())){
                    echo '<div class="alert alert-danger text-center">' . $authorizationModel -> getLogin_err() . '</div>';
                }        
            ?>

            <?php
            $isLoggedIn = $_GET['loggedIn'];
            if($isLoggedIn == 'no'){
                echo '
                <div class="alert alert-danger text-center">You must login to continue</div>
                ';  
            }
            ?>
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="<?php echo $formFields; ?> form-control <?php echo (!empty($authorizationModel -> getUsername_err())) ? 'is-invalid' : ''; ?>" value="<?php echo $authorizationModel -> getUsername(); ?>">
                <span class="invalid-feedback"><?php echo $authorizationModel -> getUsername_err(); ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="<?php echo $formFields; ?> form-control <?php echo (!empty($authorizationModel -> getPassword_err())) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $authorizationModel -> getPassword_err(); ?></span>
            </div>
            <div class="form-group pt-3 pb-3">
                <input type="submit" class="btn btn-success" value="Login">
            </div>
            <p>Don't have an account? <a href="register" class="text-decoration-none">Sign up now</a></p>
        </form>

    </div>
</div>
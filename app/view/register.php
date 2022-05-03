<?php
    require $config['MODEL_PATH'].'authorization.php';
    require $config['CONTROLLER_PATH'].'authorization.php';
?>
<div style="display: flex;flex-wrap: wrap;justify-content: center;">
    <div class="wrapper">
        <h2 class="text-center">Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php $authorizationController = new AuthorizationController; $authorizationController -> register($conn, $authorizationModel); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="<?php echo $formFields; ?> form-control <?php echo (!empty($authorizationModel -> getUsername_err())) ? 'is-invalid' : ''; ?>" value="<?php echo $authorizationModel -> getUsername(); ?>">
                <span class="invalid-feedback"><?php echo $authorizationModel -> getUsername_err(); ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class=" <?php echo $formFields; ?> form-control <?php echo (!empty($authorizationModel -> getPassword_err())) ? 'is-invalid' : ''; ?>" value="<?php echo $authorizationModel -> getPassword(); ?>">
                <span class="invalid-feedback"><?php echo $authorizationModel -> getPassword_err(); ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="<?php echo $formFields; ?> form-control <?php echo (!empty($authorizationModel -> getConfirm_password_err())) ? 'is-invalid' : ''; ?>" value="<?php echo $authorizationModel -> getConfirm_password(); ?>">
                <span class="invalid-feedback"><?php echo $authorizationModel -> getConfirm_password_err(); ?></span>
            </div>
            <div class="form-group pt-3 pb-3">
                <input type="submit" class="btn btn-success" value="Submit">
            </div>
            <p>Already have an account? <a href="login" class="text-decoration-none">Login here</a></p>
        </form>
    </div>
</div>
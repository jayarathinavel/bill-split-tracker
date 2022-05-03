<?php
    $authorizationModel = new AuthorizationModel;
    class AuthorizationController{
        function login($conn, $authorizationModel){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(empty(trim($_POST["username"]))){
                    $authorizationModel -> setUsername_err("Please enter username.");
                } else{
                    $authorizationModel -> setUsername(trim($_POST["username"]));
                }
                if(empty(trim($_POST["password"]))){
                    $authorizationModel -> setPassword_err("Please enter your password.");
                } else{
                    $authorizationModel -> setPassword(trim($_POST["password"]));
                }
                if(empty($authorizationModel -> getUsername_err()) && empty($authorizationModel -> getPassword_err())){
                    $sql = "SELECT id, username, password FROM users WHERE username = ?";
                    if($stmt = mysqli_prepare($conn, $sql)){
                        mysqli_stmt_bind_param($stmt, "s", $param_username);
                        $param_username = $authorizationModel -> getUsername();
                        if(mysqli_stmt_execute($stmt)){
                            mysqli_stmt_store_result($stmt);
                            if(mysqli_stmt_num_rows($stmt) == 1){                    
                                mysqli_stmt_bind_result($stmt, $id, $param_username, $hashed_password);
                                if(mysqli_stmt_fetch($stmt)){
                                    if(password_verify($authorizationModel -> getPassword(), $hashed_password)){
                                        session_start();
                                        $_SESSION["loggedin"] = true;
                                        $_SESSION["id"] = $id;
                                        $_SESSION["username"] = $authorizationModel -> getUsername();
                                        if(isset($_GET['redirectTo'])){
                                            $redirectTo = $_GET['redirectTo'];
                                            header("location: $redirectTo");
                                        }
                                        else{
                                            header("location: home?message=loginSuccess");
                                        }
                                    } else{
                                        $authorizationModel -> setLogin_err("Invalid username or password.");
                                    }
                                }
                            } else{
                                $authorizationModel -> setLogin_err("Invalid username or password.");
                            }
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        mysqli_stmt_close($stmt);
                    }
                }
                mysqli_close($conn);
            }
        }

        function register($conn, $authorizationModel){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(empty(trim($_POST["username"]))){
                    $authorizationModel -> setUsername_err('Please enter a username.');
                } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
                    $authorizationModel -> setUsername_err('Username can only contain letters, numbers, and underscores.');
                } else{
                    $sql = "SELECT id FROM users WHERE username = ?";
                    if($stmt = mysqli_prepare($conn, $sql)){
                        mysqli_stmt_bind_param($stmt, "s", $param_username);
                        $param_username = trim($_POST["username"]);
                        if(mysqli_stmt_execute($stmt)){
                            mysqli_stmt_store_result($stmt);
                            if(mysqli_stmt_num_rows($stmt) == 1){
                                $authorizationModel -> setUsername_err('This username is already taken.');
                            } else{
                                $authorizationModel -> setUsername(trim($_POST["username"]));
                            }
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        mysqli_stmt_close($stmt);
                    }
                }
                
                if(empty(trim($_POST["password"]))){
                    $authorizationModel -> setPassword_err('Please enter a password.');     
                } elseif(strlen(trim($_POST["password"])) < 6){
                    $authorizationModel -> setPassword_err('Password must have atleast 6 characters.');
                } else{
                    $authorizationModel -> setPassword(trim($_POST["password"]));
                }
                if(empty(trim($_POST["confirm_password"]))){
                    $authorizationModel -> setConfirm_password_err('Please confirm password.');     
                } else{
                    $authorizationModel -> setConfirm_password(trim($_POST["confirm_password"]));
                    if(empty($authorizationModel ->getPassword_err()) && ($authorizationModel ->getPassword() != $authorizationModel ->getConfirm_password())){
                        $authorizationModel ->setConfirm_password_err("Password did not match.");
                    }
                }
                if(empty($authorizationModel ->getUsername_err()) && empty($authorizationModel ->getPassword_err()) && empty($authorizationModel ->getConfirm_password_err())){
                    $sql = "INSERT INTO users (username, password) VALUES (? , ?)";
                    if($stmt = mysqli_prepare($conn, $sql)){
                        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
                        $param_username = $authorizationModel ->getUsername();
                        $param_password = password_hash($authorizationModel ->getPassword(), PASSWORD_DEFAULT); // Creates a password hash
                        if(mysqli_stmt_execute($stmt)){
                            $this -> login($conn, $authorizationModel);
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        mysqli_stmt_close($stmt);
                    }
                }
                mysqli_close($conn);
            }
        }

        function resetPassword($conn, $authorizationModel){
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                if(empty(trim($_POST["new_password"]))){
                    $authorizationModel -> setNewPasswordErr("Please enter the new password.");     
                } elseif(strlen(trim($_POST["new_password"])) < 6){
                    $authorizationModel -> setNewPasswordErr("Password must have atleast 6 characters.");
                } else{
                    $authorizationModel -> setNewPassword(trim($_POST["new_password"]));
                }
                if(empty(trim($_POST["confirm_password"]))){
                    $authorizationModel -> setConfirm_password_err("Please confirm the password.");
                } else{
                    $authorizationModel -> setConfirm_password(trim($_POST["confirm_password"]));
                    if(empty($authorizationModel -> getNewPasswordErr()) && ($authorizationModel -> getNewPassword() != $authorizationModel -> getConfirm_password())){
                        $authorizationModel -> setConfirm_password_err("Password did not match.");
                    }
                }
                if(empty($authorizationModel -> getNewPasswordErr()) && empty($authorizationModel -> getConfirm_password_err())){
                    $sql = "UPDATE users SET password = ? WHERE id = ?";
                    if($stmt = mysqli_prepare($conn, $sql)){
                        mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
                        $param_password = password_hash($authorizationModel -> getNewPassword(), PASSWORD_DEFAULT);
                        $param_id = $_SESSION["id"];
                        if(mysqli_stmt_execute($stmt)){
                            session_destroy();
                            header("location: login?message=passwordChangeSuccess");
                            exit();
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                        mysqli_stmt_close($stmt);
                    }
                }
                mysqli_close($conn);
            }
        }
    }
?>
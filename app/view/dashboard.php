<?php
    require $config['MODEL_PATH'].'authorization.php';
    require $config['CONTROLLER_PATH'].'authorization.php';
    $functions -> loginRequired('dashboard');
    $authorizationController = new AuthorizationController;
?>

<!-- Reset Password Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"> 
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alignCenter">
                    <div class="m-4">
                        <p>Please fill out this form to reset your password.</p>
                        <form action="<?php $authorizationController -> resetPassword($conn, $authorizationModel); ?>" method="post"> 
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" name="new_password" class="form-control <?php echo (!empty($authorizationModel -> getNewPasswordErr())) ? 'is-invalid' : ''; ?> <?php echo $formFields; ?>" value="<?php echo $authorizationModel -> getNewPassword(); ?>">
                                <span class="invalid-feedback"><?php echo $authorizationModel -> getNewPasswordErr(); ?></span>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($authorizationModel -> getConfirm_password_err())) ? 'is-invalid' : ''; ?> <?php echo $formFields; ?>">
                                <span class="invalid-feedback"><?php echo $authorizationModel -> getConfirm_password_err(); ?></span>
                            </div>
                            <div class="form-group mt-2">
                                <input type="submit" class="btn btn-success" value="Submit">
                                <a class="btn btn-danger ms-2" href="dashboard">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Reset Password Error Message -->
<?php
    if(($authorizationModel -> getNewPasswordErr()) !== null){
        echo '<div class="alert alert-danger text-center">' .$authorizationModel -> getNewPasswordErr(). '</div>';
    }
    elseif(($authorizationModel -> getConfirm_password_err()) !== null){
        echo '<div class="alert alert-danger text-center">' .$authorizationModel -> getConfirm_password_err(). '</div>';
    }
?>

<div class="panel m-3">
    <div id="gridcontainer">
        <div class="row grid-row">
            <!-- Side Menu Starts-->
            <div class="col-sm-3 mt-3" id="sideMenu">
                <div class="list-group">
                    <a href="#" section="1" class="menuBtn list-group-item list-group-item-action active">Dashboard</a>
					<a href="#" section="2" class="menuBtn list-group-item list-group-item-action">Reset Password</a>
					<a href="#" section="3" class="menuBtn list-group-item list-group-item-action">Change Theme</a>
					<a href="#" section="4" class="menuBtn list-group-item list-group-item-action">Section 4</a>
                </div>
            </div>
			<!-- Side Menu Ends-->
            <!-- Main Content Starts -->
            <div class="col-sm-9 mt-3">
                <div class="card">
                    <div class="card-body">
						<div id="section1" class="targetDiv">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Consequatur exercitationem necessitatibus nobis quaerat autem quas nam voluptates, laboriosam aut aliquam esse maiores amet, architecto at magni numquam. Velit, voluptas assumenda eaque ex ea adipisci officia, rem fuga fugit maiores necessitatibus! Perspiciatis, eius dolores quae ipsa repellat et quidem inventore exercitationem ratione fugiat iure totam ullam, error est minus molestiae aut ut similique sunt. Nobis magni modi impedit perspiciatis aut libero iste corporis a esse nemo nulla minus magnam eligendi velit, id reprehenderit sit eaque necessitatibus dolor repudiandae recusandae vel. Amet quod deleniti odio pariatur aliquam, architecto quisquam nesciunt quidem tempore, sit totam iusto suscipit quae doloremque ullam, explicabo veritatis porro. Qui accusantium saepe placeat cum quam earum, odit aliquid libero deserunt. Fugiat nulla repellat nam animi saepe eos velit ab quis est voluptate recusandae vitae cumque impedit rerum, aliquam magnam? Voluptas, at enim soluta aliquam distinctio ab est architecto optio cum autem nam dignissimos! Omnis facilis cum ipsam quisquam reiciendis quis fugit nemo, dolore, iusto, maxime neque architecto magnam impedit placeat atque necessitatibus accusamus vero saepe! Dolorum ab odit nisi earum illo dicta sequi quaerat beatae eum illum! Maxime, modi? Porro rerum, corporis rem illum deserunt corrupti soluta cumque culpa quis nemo blanditiis iste consectetur dolore vel eius impedit est nisi harum enim suscipit unde nam itaque perferendis maiores. Voluptatem ut reprehenderit, neque nisi beatae aliquam deleniti, natus id laborum alias dolorum repellendus facilis quis blanditiis eos necessitatibus labore! Fugiat, qui. Voluptates nisi tempore quibusdam animi nemo recusandae, accusantium quo hic? Dignissimos iure earum tempora adipisci reiciendis. Quasi vero deserunt ullam dolorem quae a. Nemo ipsum iure vero distinctio, atque laboriosam nisi voluptatem tempora quae at obcaecati mollitia inventore veniam accusantium, expedita minus. Sit laudantium, eos impedit quidem atque assumenda voluptates similique, sapiente consequatur aperiam eligendi ratione nemo in corrupti est provident quis maiores non asperiores quod. Beatae illum, dignissimos soluta perferendis expedita laboriosam ex tempore quas voluptatibus consequuntur possimus sequi delectus quia eius dolore totam esse vitae quae doloremque omnis cupiditate fugit nostrum! Aspernatur aliquid impedit officia similique deserunt minus, placeat cumque architecto, sint sed quisquam suscipit aperiam facilis nisi tenetur iusto et adipisci soluta vitae eum eaque.
						</div>

						<div id="section2" class="targetDiv displayNone">
                            <div class="alignCenter">
                                <div class="m-4">
                                    <p>Please fill out this form to reset your password.</p>
                                    <form action="<?php $authorizationController -> resetPassword($conn, $authorizationModel); ?>" method="post"> 
                                        <div class="form-group">
                                            <label>New Password</label>
                                            <input type="password" name="new_password" class="form-control <?php echo (!empty($authorizationModel -> getNewPasswordErr())) ? 'is-invalid' : ''; ?> <?php echo $formFields; ?>" value="<?php echo $authorizationModel -> getNewPassword(); ?>">
                                            <span class="invalid-feedback"><?php echo $authorizationModel -> getNewPasswordErr(); ?></span>
                                        </div>
                                        <div class="form-group">
                                            <label>Confirm Password</label>
                                            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($authorizationModel -> getConfirm_password_err())) ? 'is-invalid' : ''; ?> <?php echo $formFields; ?>">
                                            <span class="invalid-feedback"><?php echo $authorizationModel -> getConfirm_password_err(); ?></span>
                                        </div>
                                        <div class="form-group mt-2">
                                            <input type="submit" class="btn btn-success" value="Submit">
                                            <a class="btn btn-danger ms-2" href="dashboard">Cancel</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
						</div>

						<div id="section3" class="targetDiv displayNone">
                            <a href="dashboard?query=changeTheme&theme=dark" class="dropdown-item <?php echo $functions -> getCurrentTheme($conn) === 'dark' ? ' disabled' : ''; ?>"> Dark Theme </a>
                            <a href="dashboard?query=changeTheme&theme=light" class="dropdown-item <?php echo $functions -> getCurrentTheme($conn) === 'light' ? ' disabled' : ''; ?>"> Light Theme </a>
						</div>

						<div id="section4" class="targetDiv displayNone">
							Section 4
						</div>
                    </div>
                </div>
            </div>
            <!-- Main Content Ends -->
        </div>
    </div>
</div>
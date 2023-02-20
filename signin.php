<?php include('include/header.php'); ?>
<?php include('include/db.php'); ?>
<?php include('functions.php'); ?>

<?php 
    $emailError = $passwordError = "";
    $isValidatedAll = 'true';
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $ema = $pass = $isValidatedAll = 'false';
        if (empty($_POST["email"])) 
        {
            $emailError = "Email is required";
            $ema = 'false';
        } 
        else 
        {
            // validate email
            if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL))
            {
                $emailError = "Enter a Valid Email Address.";
                $ema = 'false';
            }
            else
            {
                $email = test_input($_POST["email"]);
                $ema = 'true';
            }
           
        }

        if (empty($_POST["password"])) 
        {
            $passwordError = "Password is Required.";
            $pass = 'false';
        } 
        else 
        {
            // Validate password strength
            $uppercase = preg_match('@[A-Z]@', $_POST["password"]);
            $lowercase = preg_match('@[a-z]@', $_POST["password"]);
            $number    = preg_match('@[0-9]@', $_POST["password"]);
            $specialChars = preg_match('@[^\w]@', $_POST["password"]);

            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($_POST["password"]) < 8) 
            {
                $passwordError = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
                $pass = 'false';
            }
            else
            {
                $password = test_input($_POST["password"]);
                $pass = 'true';
            }
            
        }

        if($ema == 'true')
        {
            if($pass == 'true')
            {
                $isValidatedAll = 'true';
                if( $isValidatedAll == 'true')
                {
                    $sql = "SELECT * FROM `users` Where `email` = '$email'; ";
                    $result = mysqli_query($conn, $sql);

                    if($result->num_rows == 1 )
                    {
                       $row = $result->fetch_assoc();
                       if($row['email'] == $email)
                       {
                            if($row['password'] == md5($password))
                            {
                                header("Location: http://localhost/PHP_PROJECTS/login_system/home.php?message=success");
                            }
                            else
                            {
                                echo '<div class="container mt-5">
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>oh!</strong> Your password not matched Please enter valid password .
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                            </button>
                                        </div>
                                    </div>';
                            }
                       }
                       else
                       {
                            echo '<div class="container mt-5">
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>oh!</strong> Your Email not Found please register to continue.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                        </button>
                                    </div>
                                </div>';
                       }
                    }
                    else
                    {
                        echo '<div class="container mt-5">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>oh!</strong> Incorrect email/password details.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    </button>
                                </div>
                            </div>';

                    }
                }

            }
            else
            {
                $isValidatedAll = 'false';
                if($isValidatedAll == 'false')
                {
                    $validationError = "Fill All the required details follow all the instructions.";
                }

            }
        }
        else
        {
            $isValidatedAll = 'false';
            if($isValidatedAll == 'false')
            {
                $validationError = "Fill All the required details follow all the instructions.";
            }
        }
    }
    
?>
<section class="signin-form">
    <div class="container">
        <div class="signin-form-main-div">
            <?php
            if (isset($_GET['message'])) {
                if($_GET['message'] == 'success'){ 
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>'.$_GET['message'].'fully!</strong> registered, please Login to continue.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            </button>
                        </div>';
                }
            }
            ?>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email">
                    <span class="text-danger"><?php if(!empty($emailError)){ echo "* ".$emailError; }?></span>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <span class="text-danger"><?php if(!empty($passwordError)){ echo "* ".$passwordError; }?></span>
                </div>
                <div class="col-lg-12">
                    <span class="text-danger">
                        <?php if($isValidatedAll == 'false'){ echo "* ".$validationError; }?>
                    </span>
                </div>
                <input type="submit" class="btn btn-outline btn-color px-4" value="SignIn">
            </form>
        </div>

    </div>
</section>

<?php include('include/footer.php'); ?>
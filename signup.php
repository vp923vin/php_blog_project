<?php include('include/header.php'); ?>
<?php include('include/db.php'); ?>
<?php include('functions.php'); ?>  

<?php 
    $fnameError = $lnameError = $usernameError = $phoneNumberError = $emailAddressError = $passwordError = $confirmPasswordError  = $countryError = $validationError = "";
    $isValidatedAll = 'true';
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        // $validationError = "";
        $fname = $lname = $uname = $ema = $pho = $pass = $cpass = $cont = $isValidatedAll = 'false';
        if (empty($_POST["firstName"])) 
        {
            $fnameError = "Full Name is required";
            $fname = 'false';
        }
        else 
        {
            //  Validate First Name
            if(!preg_match('/^[a-zA-Z]*$/', $_POST['firstName']))
            {
                $fnameError = 'Alphabetic characters are allowed only.';
                $fname = 'false';
            }
            else
            {
                $firstName = test_input($_POST["firstName"]);
                $fname = 'true';
            }
           
        }

        if (empty($_POST["lastName"]))
        {
            $lnameError = "Last Name is required";
            $lname = "false";
        } 
        else 
        {
            // Validate Last Name
            if(!preg_match('/^[a-zA-Z]*$/', $_POST['lastName']))
            {
                $lnameError = 'Alphabetic characters are allowed only.';
                $lname = "false";
            }
            else
            {
                $lastName = test_input($_POST["lastName"]);
                $lname = "true";
            }
            
        }

        if (empty($_POST["userName"])) 
        {
            $usernameError = "User Name is required";
            $uname = 'false';
        } 
        else 
        {

            if(!preg_match('/^[a-zA-Z0-9]{5,}$/', $_POST["userName"]))
            {
                $usernameError = "Valid User Name is required (i.e. you need atleast 5 character) alphanumeric characters are allowed only.";
                $uname = 'false';
            }
            else
            {
                //  check the username exits in the database or not
                $sql2 = "SELECT * FROM `users` where `uname`= '".$_POST['userName']."'; ";
                $result2 = mysqli_query($conn, $sql2);

                if($result2->num_rows > 0 )
                {
                    $usernameError = "This (".$_POST['userName'].") Name exits Please try with Other Username eg. test1234 || 12test || test123test";
                    $uname = 'false';
                }
                else
                {
                    $userName = test_input($_POST["userName"]);
                    $uname = 'true';
                }
                
            }
            
        }

        if (empty($_POST["phoneNumber"])) 
        {
            $phoneNumberError = "Phone Number is required";
            $pho = 'false';
        }
        else 
        {
            // validate Phone Number
            if(!preg_match('/^[0-9]{10}$/', $_POST["phoneNumber"]))
            {
                $phoneNumberError = "Phone Number is must be 10 digits."; 
                $pho = 'false';
            }
            else
            {
                $phoneNumber = test_input($_POST["phoneNumber"]);
                $pho = 'true'; 
            }
            
        }

        if (empty($_POST["emailAddress"])) 
        {
            $emailAddressError = "Email is required";
            $ema = 'false';
        } 
        else 
        {
            // validate email
            if(!filter_var($_POST["emailAddress"], FILTER_VALIDATE_EMAIL))
            {
                $emailAddressError = "Enter a Valid Email Address.";
                $ema = 'false';
            }
            else
            {
                $emailAddress = test_input($_POST["emailAddress"]);
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

        if (empty($_POST["confirmPassword"])) 
        {
            $confirmPasswordError = "Confirm Password is Required.";
            $cpass = 'false';
        } 
        else 
        {
            // Validate password strength
            $uppercase = preg_match('@[A-Z]@', $_POST["confirmPassword"]);
            $lowercase = preg_match('@[a-z]@', $_POST["confirmPassword"]);
            $number    = preg_match('@[0-9]@', $_POST["confirmPassword"]);
            $specialChars = preg_match('@[^\w]@', $_POST["confirmPassword"]);

            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($_POST["confirmPassword"]) < 8) 
            {
                $confirmPasswordError = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
                $cpass = 'false';
            }
            else
            {
                if(!empty($_POST['password'])){
                    //  check password is matching or Not
                    if($_POST['password'] != $_POST['confirmPassword'])
                    {
                        $confirmPasswordError = "Password Not Matched please Enter the Corect Password.";
                        $cpass = 'false';
                    }
                    else
                    {
                        $confirmPassword = test_input($_POST["confirmPassword"]);
                        $cpass = 'true';
                    }

                }
                else
                {
                    $confirmPasswordError = "Enter the password First to confirm your Password";
                    $cpass = 'false';
                }
                
                
            }
            
        }
    
        if (empty($_POST["country"])) 
        {
            $countryError = "Country is required, Please Select Your Country";
            $cont = "false";
        }
        else 
        {
            $country = test_input($_POST["country"]);
            $cont = "true";
        }

        if($fname == "true")
        {
            if($lname == "true")
            {
                if($uname == "true")
                {
                    if($pho == "true")
                    {
                        if($ema == "true")
                        {
                            if($pass == "true")
                            {
                                if($cpass == "true")
                                {
                                    if($cont == "true")
                                    {
                                        $isValidatedAll = 'true';
                                        if( $isValidatedAll == 'true')
                                        {
                                            $password = md5($password);
                                            $sql3 = "INSERT INTO `users` (`fname`, `lname`, `uname`, `phone`, `email`, `password`, `country` ) VALUES ('$firstName', '$lastName', '$userName', '$phoneNumber', '$emailAddress', '$password', '$country');";
                                            $result3 = mysqli_query($conn, $sql3);
                                            if($result3)
                                            {
                                                header("Location: http://localhost/PHP_PROJECTS/login_system/signin.php?message=success");
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
<section class="signup-form-section">
    <div class="container">
        <div class="signup-form-main-div">
            <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName"/>
                            <span class="text-danger"><?php if(!empty($fnameError)){ echo "* ".$fnameError; }?></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName"/>
                            <span class="text-danger"><?php if(!empty($lnameError)){ echo "* ".$lnameError; }?></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="mb-3">
                            <label for="userName" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="userName" name="userName"/>
                            <span class="text-danger"><?php if(!empty($usernameError)){ echo "* ".$usernameError; }?></span>
                        </div> 
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber"/>
                            <span class="text-danger"><?php if(!empty($phoneNumberError)){ echo "* ".$phoneNumberError; }?></span>
                        </div> 
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="mb-3">
                            <label for="emailAddress" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="emailAddress" name="emailAddress" />
                            <span class="text-danger"><?php if(!empty($emailAddressError)){ echo "* ".$emailAddressError; }?></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password"/>
                            <span class="text-danger"><?php if(!empty($passwordError)){ echo "* ".$passwordError; }?></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"/>
                            <span class="text-danger"><?php if(!empty($confirmPasswordError)){ echo "* ".$confirmPasswordError; }?></span>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="mb-3">
                            <label for="country" class="form-label">Select Your Country</label>
                            <select name="country" id="country" class="form-control">
                                <option disabled selected> Select</option>
                                <?php
                                    $sql = "SELECT * FROM `country` ;";
                                    $result = mysqli_query($conn, $sql);
                                    if( $result->num_rows > 0 )
                                    {
                                        while($row = $result->fetch_assoc())
                                        { 
                                            echo "<option value=".$row['name'].">".$row['name']."</option>";  
                                        }
                                    }

                                ?>
                            </select>
                            <span class="text-danger"><?php if(!empty($countryError)){ echo "* ".$countryError; }?></span>
                        </div>
                    </div>
                    <div class="col-lg-12">
                       <span class="text-danger">
                           <?php if($isValidatedAll == 'false'){ echo "* ".$validationError; }?>
                       </span>
                    </div>
                    <div class="col-lg-12 text-center">
                        <input type="submit" class="btn btn-outline btn-color  px-4" value="SignUp">
                    </div>
                </div>
            </form>
        </div>
        
    </div>
</section>

<?php include('include/footer.php'); ?>
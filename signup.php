<?php require 'nav.php'; ?>
<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    nav>a {
        padding-left: 1rem;
    }

    h2 {
        text-align: center;

    }

    .form-cont {
        width: 40rem;
        margin: auto;
        margin-top: 3rem;
        border: 1px solid black;
        padding: 1rem;
        height: 27rem;
        overflow: hidden;
    }

    .form-check {
        margin-top: 1rem;
    }

    .form-group {
        margin-top: 2rem;
    }

    .form-group:nth-child(1) {
        margin-top: 0;
    }

    #submit {
        margin-top: 1rem;
    }

    #login {
        text-align: right;
    }

    #terms {
        color: rgb(13, 110, 253);
        text-decoration: underline;
    }

    #terms:hover {
        cursor: pointer;
        color: blue;
    }
</style>

<h2>Sign Up</h2>
<div class='form-cont'>

    <form action='signup.php' method='POST'>
        <div class='form-group'>
            <label for='exampleInputEmail1'>Email address</label>
            <input name="email" type='email' class='form-control' id='exampleInputEmail1' aria-describedby='emailHelp'
                placeholder='Enter email'>
        </div>
        <div class='form-group'>
            <label for='exampleInputPassword1'>Password</label>
            <input name="pass1" type='password' class='form-control' placeholder='Password'>
        </div>
        <div class='form-group'>
            <label for='exampleInputPassword1'>Confirm Password</label>
            <input name="pass2" type='password' class='form-control' placeholder='Password'>
        </div>
        <div class='form-check'>
            <input type='checkbox' class='form-check-input' id='exampleCheck1' required>
            <label class='form-check-label' for='exampleCheck1'>I have read the terms and conditions</label>
        </div>
        <div onclick="alert('There are no terms and conditions')" id='terms'>Terms and conditions</div>
        <button type='submit' id='submit' class='btn btn-primary'>Sign Up</button>
    </form>
    <div id='login'>Already have an account? <a href='index.php'>Login</a></div>
</div>
<?php
if (isset($_POST['email']) && isset($_POST['pass1']) && isset($_POST['pass2'])) {
    $email = $_POST['email'];
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    require "dbconnect.php";
    if ($pass1 == $pass2) {
        $sql = "SELECT * FROM users WHERE email LIKE '$email'";
        $result = mysqli_query($con, $sql);
        if (mysqli_num_rows($result)) {
            echo "<script>alert('Account already exists with this name')</script>";
        } else {
            $personid = rand(100000, 999999);


            $sql = "INSERT INTO `users` (`email`, `password`, `personid`) VALUES ('$email', '$pass1', $personid)";
            mysqli_query($con, $sql);

            $sql = "CREATE TABLE a$personid (`id` INT NOT NULL AUTO_INCREMENT , `email` VARCHAR(50) NOT NULL , `contact_name` INT(50) NOT NULL , PRIMARY KEY (`id`))";
            mysqli_query($con, $sql);

            echo "<script>alert('account created succesfully :)')</script>";
        }
    } else {
        echo "<script>alert('Both the passwords must be same')</script>";
    }
}
?>
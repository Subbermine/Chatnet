<?php require "nav.php" ?>
<style>
    .form-cont {
        width: 40rem;
        margin: auto;
        margin-top: 3rem;
        border: 1px solid black;
        padding: 1rem;
        height: 15rem;
        overflow: hidden;
    }

    .form-group:nth-child(2) {
        margin-top: 1rem;
    }

    .form-check,
    #submit {
        margin-top: 1rem;
    }

    h2 {
        text-align: center;
        margin-top: 1rem;
    }

    #signup {
        text-align: right;
    }
</style>

<body>
    <h2>Login</h2>
    <div class="form-cont">
        <form action="index.php" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input name="email" type="email" class="form-control" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input name="password" type="password" class="form-control" id="exampleInputPassword1"
                    placeholder="Password">
            </div>
            <button type="submit" id="submit" class="btn btn-primary">Login</button>
        </form>
        <div id="signup">New here? <a href="signup.php">Sign up</a></div>
    </div>
</body>
<?php
if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "select * from users where email like '$email' AND password like '" . $password . "'";

    require "dbconnect.php";


    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result)) {
        session_start();

        $row = mysqli_fetch_assoc($result);

        echo $row["email"];

        $_SESSION["email"] = $email;
        $_SESSION["password"] = $password;
        $_SESSION["personid"] = $row["personid"];
        $_SESSION["loggedin"] = true;

        header("location: main.php");
    } else
        echo "<script>alert('Email or password is wrong')</script>";
}


?>
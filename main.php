<?php require 'nav.php';
if (!isset($_SESSION))
    session_start();
?>

<head>
    <title>Chatnet</title>
    <style>
        #cross {
            position: absolute;
            top: .8rem;
            right: 1rem;
        }

        #cross:hover {
            border: 1px solid white;
            cursor: pointer;
            padding: 0.1rem;
        }

        main {
            display: flex;
        }

        .table {
            width: 11rem;
            border-right: 1px solid black;
        }

        #add {
            width: -webkit-fill-available;
        }

        #popup {
            width: 420px;
            padding: 30px 40px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
            border-radius: 8px;
            display: none;
            background-color: rgb(22, 37, 41);
            text-align: center;
            color: white;
        }

        .form-group {
            margin-top: 1rem;
        }

        .lab {
            margin-bottom: 1rem;
        }

        #submit {
            margin-top: 1rem;
        }
    </style>
    <?php

    include "dbconnect.php";
    if (isset($_POST['name']) && isset($_POST['email'])) {
        if (!isset($_SESSION))
            session_start();

        $email = $_POST['email'];
        $name = $_POST['name'];

        $id = $_SESSION['personid'];
        require "dbconnect.php";

        $present = false;

        $sql = "SELECT * FROM `users` WHERE `email` LIKE '$email'";
        $result = mysqli_query($con, $sql);

        if ($name == '' || $email == '') {
            echo "<script>alert('Don\'t  submit empty details')</script>";

        } else {
            if (mysqli_num_rows($result)) {
                $sql = "SELECT * FROM a$id";

                $result = mysqli_query($con, $sql);


                while ($row = mysqli_fetch_assoc($result)) {
                    if ($row['email'] == $email) {
                        echo "<script>alert('Contact already present')</script>";
                        $present = true;
                    }
                }
                if (!$present) {
                    $sql = "INSERT INTO `a$id` ( `id` , `email` , `contact_name` ) VALUES ( NULL, '$email' , '$name' )";

                    $result = mysqli_query($con, $sql);
                }
            } else {
                echo "<script>alert('Account does not exists')</script>";
            }
        }
    }
    ?>
    <link rel='stylesheet' href='//cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css'>
</head>
<main>
    <table class="table">
        <thead>
            <tr>
                <th colspan="2" scope="col">
                    <button id="add" onclick='add_contact()' class='dis_button btn btn-primary'>+Add
                        contacts</button>
                </th>
            </tr>
        </thead>
        <tbody>

            <?php

            require "dbconnect.php";

            if (!isset($_SESSION))
                session_start();

            $id = $_SESSION['personid'];


            $sql = "SELECT * FROM a$id";


            $result = mysqli_query($con, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr> <th scope='row'> " . $row["contact_name"] . " </th><td>
        " . $row["email"] . "</td>
</tr>";
            } ?>

        </tbody>
    </table>



</main>

<div id='popup'>
    <span onclick="cancel()" id="cross"><i class="fa-solid fa-xmark"></i></span>
    <form action='main.php' method='post'>
        <div class='form-group'>
            <label class='lab' for='exampleInputEmail1'>Email:</label>
            <input name='email' type='email' class='form-control' id='exampleInputEmail1' aria-describedby='emailHelp'
                placeholder='Enter email'>
        </div>
        <div class='form-group'>
            <label class='lab' for='exampleInputPassword1'>Name to save the contact as:</label>
            <input name='name' type='text' class='form-control' id='exampleInputPassword1' placeholder='Enter name'>
        </div>
        <button id='submit' type='submit' class='btn btn-primary'>Add contact</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM="
    crossorigin="anonymous"></script>

<script src="//cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

<script>
    let table = new DataTable('#myTable');
    function add_contact() {
        document.getElementById('popup').style.display = "block";
        document.querySelectorAll("html *:not(#popup,form,.form-group,#submit,.lab,#exampleInputEmail1,#exampleInputPassword1)").forEach((el) => el.style.opacity = 0.9);
        let all_button = document.getElementsByClassName("dis_button");
        for (let index = 0; index < all_button.length; index++) {
            all_button[index].disabled = true;
        }


    }
    function cancel() {
        document.getElementById('popup').style.display = "none";
        document.querySelectorAll("html *:not(#popup,form,.form-group,#submit,.lab,#exampleInputEmail1,#exampleInputPassword1)").forEach((el) => el.style.opacity = 1);
        let all_button = document.getElementsByClassName("dis_button");
        for (let index = 0; index < all_button.length; index++) {
            all_button[index].disabled = false;
        }
    }
    function logout() {
        location = "logout.php";
    }
</script>
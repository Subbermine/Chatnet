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
            margin-top: 3.3rem;
        }


        #add {
            width: -webkit-fill-available;
        }

        nav {
            position: fixed;
            width: 100%;
        }

        table {
            overflow-y: scroll;
            height: 80%;
            display: block;
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

        #contacts {
            position: fixed;
            height: 52rem;
            top: 3.3rem;
        }

        #submit {
            margin-top: 1rem;
        }

        #messagearea {
            width: 100%;
            height: 100%;
            background-color: #F3EFE0;
            overflow: hidden;
        }

        #chatarea {
            width: 100%;
            height: 4rem;
            position: fixed;
            bottom: 0;
            display: flex;
            background-color: #22A39F;
            align-content: center;
            justify-content: flex-start;
            flex-direction: row-reverse;
            flex-wrap: wrap;
            align-items: center;
        }

        td>a:hover {
            color: blue;
        }


        td>a {
            text-decoration: none;
            color: black;
        }

        #chatarea>input {
            width: 68vw;
        }
    </style>

    <?php

    include "dbconnect.php";
    if (isset($_POST["contact-add"])) {
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

                        $sql = "SELECT * FROM users WHERE `email` LIKE '$email'";

                        $result = mysqli_query($con, $sql);

                        $row = mysqli_fetch_assoc($result);

                        $other_id = $row["personid"];

                        $own_email = $_SESSION["email"];

                        $sql = "INSERT INTO `a$other_id` ( `id` , `email` , `contact_name` ) VALUES ( NULL, '$own_email' , 'unknown contact' )";

                        mysqli_query($con, $sql);
                        $name = '';
                        $email = '';
                    }
                } else {
                    echo "<script>alert('Account does not exists')</script>";
                }
            }
        }
    }
    ?>
</head>
<main class="relative">
    <div id="messagearea" class="relative">
        <div id="chatarea" class="fixed">
            <button type="button" class="btn btn-secondary"><i class="fa-solid fa-arrow-right"></i></button>
            <input type="text" name="message" id="message">
        </div>
    </div>
    <div id="contacts">
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
                    echo "<tr id='" . $row["email"] . "'> <th scope='row'> " . $row["contact_name"] . " </th><td>
                    <a href='#'>" . $row["email"] . "</a></td>
                    </tr>";
                }
                $no_row = mysqli_num_rows($result);
                for ($i = 14; $i > $no_row; $i--) {
                    echo "<tr><th scope='row'>-</th><td>-</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


</main>

<div id='popup'>
    <span onclick=" cancel()" id="cross"><i class="fa-solid fa-xmark"></i></span>
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
        <button id='submit' name="contact-add" type='submit' class='btn btn-primary'>Add contact</button>
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
<script src="https://cdn.tailwindcss.com"></script>
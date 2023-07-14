<?php echo "<nav class='navbar navbar-dark bg-dark'>
    <a class='navbar-brand' href='#'>
    <i class='fa-solid fa-comments'></i> Chatnet
    </a>";
session_start();
if (isset($_SESSION["loggedin"]))
    if ($_SESSION["loggedin"])
        echo "<button id='logout' style='margin-right:1rem;' onclick='logout()' class='dis_button btn btn-outline-danger'>Log Out</button>";
echo "</nav>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'
    integrity='sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM' crossorigin='anonymous'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' integrity='sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==' crossorigin='anonymous' referrerpolicy='no-referrer' />
    <style>
    *{
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }</style>
    ";
?>
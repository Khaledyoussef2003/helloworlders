<?php
session_start();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        /* background-color: green; */
        font-family: "Poppins", sans-serif;

    }

    body {

        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        height: 100vh;
        /* margin: 0; */
        background-image: url("images/91.webp");

        background-size: cover;
        background-position: center;
    }

    .wrapper {
        width: 420px;
        background-color: aliceblue;
        color: darkgreen;
        border-radius: 10px;
        padding: 30px 40px;
    }

    .wrapper h1 {
        font-size: 36px;
        text-align: center;
    }

    .wrapper .input-box {
        width: 100%;
        height: 50px;
        /* background-color: pink; */
        margin: 30px 0;
    }

    .input-box input {
        width: 100%;
        height: 100%;
        background-color: transparent;
        border: none;
        outline: none;
        border: 2px solid lightgray;
        border-radius: 20px;
        font-size: 16px;
        color: black;
        padding: 20px 45px 20px 20px;

    }

    .input-box input ::placeholder {
        color: #fff;
    }

    .wrapper .btn {
        width: 100%;
        height: 45px;
        background-color: pink;
        border: none;
        outline: none;
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, -1);
        cursor: pointer;
        font-size: 16px;
        color: #333;
        font-weight: 600;

    }

    .wrapper .register-link {
        font-size: 15px;
        text-align: center;
        margin: 20px 0 15px;
    }

    .wrapper .register-link p a {
        /* color: #fff; */
        text-decoration: none;
        font-size: 600;

    }

    .register-link p a:hover {
        text-decoration: underline;
    }

    .file {
        /* background-color: red; */

    }
</style>

<body>

    <div class="wrapper">

        <form action="addproduct2.php" method="POST" enctype="multipart/form-data">
            <h1>Add Product</h1>
            <div class="input-box">
                <!-- <label for="">Name : </label> -->
                <input type="text" name="name" placeholder="Name of product : ">

            </div>
            <div class="input-box">

                <input type="file" name="productpic" class="file">
            </div>

            <div class="input-box">

                <input type="text" name="price" placeholder="Unit Price : ">
            </div>

            <button type="submit" class="btn">Add Product</button>
            <!-- <a href='logout.php' class="fas fa-out"><span>Logout</span> -->
           


        </form>
    </div>
</body>

</html>
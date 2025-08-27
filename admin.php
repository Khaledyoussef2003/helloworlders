













<?php
session_start();
if ($_SESSION['isloggedin'] != 1) {
    header("location:index.php");

    // echo  "<a href='logout.php'> logout </li>";

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="style.css"> -->
</head>
<style>
    :root {
        --pink: #e84393;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        outline: none;
        border: none;
        text-decoration: none;
        text-transform: capitalize;
        transition: .2s linear;

    }

    html {
        font-size: 62.5%;
        scroll-behavior: smooth;
        scroll-padding-top: 6rem;
        overflow-x: hidden;
    }

    section {
        padding: 2rem 9%;
    }

    .heading {
        text-align: center;
        font-size: 4rem;
        color: #333;
        padding: 1rem;
        margin: 2rem 0;
        background: rgba(255, 51, 153, .05);
    }

    .heading span {
        color: #e84393;
    }

    .btn {
        display: inline-block;
        margin-top: 1rem;
        border-radius: 5rem;
        background: #333;
        color: #fff;
        padding: .9rem 3.5rem;
        cursor: pointer;
        font-size: 1.7rem;
        width: 50%;
        text-align: center;
        margin-left: 25%;
    }

    .btn:hover {
        background-color: #e84393;
        color: #333;
    }

    header {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background: #fff;
        padding: 2rem 9%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 1000;
        box-shadow: 0 .5rem 1rem rgb(0, 0, 0, 1);
    }

    header .logo {
        font-size: 3rem;
        color: #333;
        font-weight: bolder;
    }

    header .logo span {
        color: #e84393;
    }

    header .navbar a {
        font-size: 2rem;
        padding: 0 1.5rem;
        color: #666;

    }

    header .navbar :hover {
        color: #e84393;



    }

    header .icons a {
        font-size: 2.5rem;
        color: #333;
        margin-left: 15px;


    }

    header .icons :hover {
        color: #e84393;
    }

    header #toggler {
        display: none;
    }

    header .fa-bars {
        font-size: 3rem;
        color: #333;
        border-radius: 5rem;
        padding: .5rem 1.5rem;
        cursor: pointer;
        border: 0.25rem solid rgb(0, 0, 0, .3);
        display: none;
    }

    .home {
        display: flex;
        align-items: center;
        min-height: 100vh;
        background: url(images/94.jfif)no-repeat;
        background-size: cover;
        background-position: center;
    }

    .home .content {
        max-width: 50rem;
    }

    .home .content h3 {
        font-size: 7.5rem;
        color: #e84393;
    }

    .home .content span {
        font-size: 3.5rem;
        color: #02cb45ff;
        padding: 1rem 0;
        line-height: 1.5;
    }

    .home .content p {
        font-size: 1.5rem;
        color: #ebebeb;
        padding: 1rem 0;
        line-height: 1.5;
    }

    .about .row {
        display: flex;
        align-items: center;
        gap: 2rem;
        flex-wrap: wrap;
        padding: 2rem 0;
        padding-bottom: 3rem;
    }

    .about .row .video-container {
        flex: 1 1 40rem;
        position: relative;
    }

    .about .row .video-container video {
        width: 100%;
        border: 1.5rem solid #fff;
        border-radius: .5rem;
        box-shadow: 0 .5rem 1rem rgb(0, 0, 0, .1);
        height: 100%;
        object-fit: cover;
    }

    .about .row .video-container h3 {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 3rem;
        background: #fff;
        width: 100%;
        padding: 1rem 2rem;
        text-align: center;
        mix-blend-mode: screen;
    }

    .about .row .content {
        flex: 1 1 40rem;
    }

    .about .row .content h3 {
        font-size: 3rem;
        color: #333;
    }

    .about .row .content p {
        font-size: 1.5rem;
        color: #999;
        padding: .5rem 0;
        padding-top: 1rem;
        line-height: 1.5;


    }

    .icons-container {
        background: #fff;
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        padding-top: 5rem;
        padding-bottom: 5rem;

    }

    .icons-container .icons {
        background: #fff;
        border: .1rem solid rgb(0, 0, 0, .1);
        padding: 2rem;
        display: flex;
        text-align: center;
        flex: 1 1 25rem;

    }

    .icons-container .icons img {
        height: 5rem;
        margin-right: 2rem;
    }

    .icons-container .icons h3 {
        color: #333;
        padding-bottom: .5rem;
        font-size: 1.5rem;

    }

    .icons-container .icons span {
        color: #555;
        font-size: 1.3rem;

    }

    .products .box-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .products .box-container .box {
        flex: 1 1 30rem;
        box-shadow: 0 .5rem 1.5rem rgb(0, 0, 0, .1);
        border-radius: .5rem;
        border: 1rem solid rgb(0, 0, 0, .1);
        position: relative;
    }

    .products .box-container .box .discount {
        position: absolute;
        top: 1rem;
        left: 1rem;
        padding: 7rem 1rem;
        font-size: 2rem;
        color: #e84393;
        background: rgba(255, 51, 153, .05);
        z-index: 1;
        border-radius: .5rem;
    }

    .products .box-container .box .image {
        position: relative;
        text-align: center;
        padding-top: 2rem;
        overflow: hidden;
    }

    .products .box-container .box .image img {
        height: 25rem;
    }

    .products .box-container .box:hover .image img {
        transform: scale(1.1);
    }

    .products .box-container .box .image .icons {
        position: absolute;
        bottom: -7rem;
        left: 0;
        right: 0;
        display: flex;
    }

    .products .box-container .box:hover .image .icons {
        bottom: 0;
    }

    .products .box-container .box .image .icons a {
        height: 5rem;
        line-height: 5rem;
        width: 50%;
        background: #e84393;
        color: #fff;
    }

    .products .box-container .box .image .icons .cart-btn {
        border-left: .1rem solid #fff7;
        border-right: .1rem solid #fff7;
        width: 100%;
    }

    .products .box-container .box .image .icons a:hover {
        background: #666;

    }

    .products .box-container .box .content {
        padding: 90px;
        text-align: center;
    }

    .products .box-container .box .content h3 {
        font-size: 2.5rem;
        color: #333;
    }

    .products .box-container .box .content .price {
        font-size: 2.5rem;
        color: #e84393;
        font-weight: bolder;
        padding-top: 1rem;
    }

    .products .box-container .box .content .price span {
        font-size: 1.5rem;
        color: #999;
        font-weight: lighter;
        /* text-decoration: line-through; */
    }

    .review .box-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .review .box-container .box {
        flex: 1 1 30rem;
        box-shadow: 0 .5rem 1.5rem rgb(0, 0, 0, .1);
        border-radius: 5rem;
        padding: 3rem 2rem;
        position: relative;
        border: .1rem solid rgb(0, 0, 0, .1);
    }

    .review .box-container .box .fa-quote-right {
        position: absolute;
        bottom: 3rem;
        right: 3rem;
        font-size: 6rem;
        color: #eee;
    }

    .review .box-container .box .user {
        display: flex;
        text-align: center;
        padding-top: 2rem;
    }

    .review .box-container .box .star i {
        color: #e84393;
        font-size: 2rem;
    }

    .review .box-container .box p {
        color: #999;
        font-size: 1.5rem;
        line-height: 1.5;
        padding-top: 2rem;
    }

    .review .box-container .box .user img {
        height: 6rem;
        width: 6rem;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 1rem;
    }

    .review .box-container .box .user h3 {
        font-size: 2rem;
        color: #333;
    }

    .review .box-container .box .user span {
        font-size: 1.5rem;
        color: #999;
    }

    .contact .row {
        display: flex;
        flex-wrap: wrap-reverse;
        gap: 1.5rem;
        align-items: center;
    }

    .contact .row form {
        flex: 1 1 40rem;
        padding: 2rem 2.5rem;
        box-shadow: 0 .5rem 1.5rem rgb(0, 0, 0, .1);
        border: 1rem solid rgb(0, 0, 0, .1);
        background: #fff;
        border-radius: .5rem;
    }

    .contact .row .image {
        flex: 1 1 40rem;
    }

    .contact .row .image img {
        flex: 1 1 40rem;
    }

    .contact .row form .box {
        padding: 1rem;
        font-size: 1.7rem;
        color: #333;
        text-transform: none;
        border: .1rem solid rgb(0, 0, 0, .1);
        border-radius: .5rem;
        margin: .7rem 0;
        width: 100%;
    }

    .contact .row form .box:focus {
        border-color: #e84393;
    }

    .contact .row form textarea {
        height: 15rem;
        resize: none;
    }

    .footer .box-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .footer .box-container .box {
        flex: 1 1 25rem;
    }

    .footer .box-container .box h3 {
        color: #333;
        font-size: 2.5rem;
        padding: 1rem 0;
    }

    .footer .box-container .box a {
        display: block;
        color: #666;
        font-size: 1.5rem;
        padding: 1rem 0;
    }

    .footer .box-container .box a :hover {
        color: #e84393;
        text-decoration: underline;
    }

    .footer .box-container .box img {
        margin-top: 1rem;
    }

    .footer .credit {
        text-align: center;
        padding: 1.5rem;
        margin-top: 1.5rem;
        padding-top: 2.5rem;
        font-size: 2rem;
        color: #333;
        border-top: .1rem solid rgb(0, 0, 0, .1);
    }

    .footer .credit span {
        color: #e84393;
    }


    @media (max-width:991px) {

        header {
            padding: 14px 41px;
        }

        section {
            padding: 2rem;
        }

        .home {
            grid-template-columns: 1fr;
            text-align: center;
        }

    }

    @media (max-width:768px) {
        header .fa-bars {
            display: block;
        }

        header .navbar {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: #eee;
            border-top: .1rem solid rgb(0, 0, 0, .1);
            clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
        }

        header #toggler :checked~.navbar {
            clip-path: polygon(0 0, 100% 0, 100% 0, 0 0);
        }

        header .navbar a {
            margin: 1.5rem;
            padding: 1.5rem;
            background: #fff;
            border: 1rem solid rgb(0, 0, 0, .1);
            display: block;
        }

        .home .content h3 {
            font-size: 5rem;

        }

        .home .content span {
            font-size: 2.5rem;

        }

        .icons-container .icons h3 {
            font-size: 2rem;
        }

        .icons-container .icons span {
            font-size: 1.7rem;
        }

    }

    @media (max-width:450px) {
        html {
            font-size: 50%;
        }

        .heading {
            font-size: 3rem;
        }

    }
</style>

<body>
    <header>

        <input type="checkbox" name="" id="toggler">
        <label for="toggler" class="fas fa-bars"></label>


        <a href="#" class="logo">flower<span>.</span></a>
        <nav class="navbar" id="navbar">
            <a href="#home">home</a>
            <a href="#about">about</a>
            <a href="#products">product</a>
            <a href="#review">review</a>
            <a href="#contact">contact</a>
            <a href="addproduct.php">Add Product</a>
            <a href="vieworders.php">View Orders</a>

        </nav>

        <div class="icons">
            <a href="#" class="fas fa-heart"></a>
            <a href="#products" class="fas fa-shopping-cart"></a>
            <a href="#footer" class="fas fa-user"></a>
            <a href="#" class="fas fa-moon" id="darkmode"></a>
            <a href='logout.php' class="fas fa-out"><span>Logout</span>

        </div>
    </header>
    <section class="home" id="home">
        <div class="content">
            <h3>fresh flowers</h3>
            <span>natural & beatiful flowers</span>
            <p> </p>
            <p> </p>
            <p> </p>
            <p> </p>
            <p>There are many things in nature for which we should be thankful.
                One of them definitely has to be flowers. There are many types of
                flowers which we see in our environment. The beautiful fragrances
                and flowers enhance the beauty of our planet earth. Through flowers essay,
                we will look at what these beautiful things do and how much joy they bring.</p>

            <a href="#products" class="btn">Go To My Products</a>


        </div>

    </section>

    <section class="about" id="about">
        <h1 class="heading"><span> about </span> us </h1>
        <div class="row">
            <div class="video-container">
                <video src="about vid.mp4.mov" loop autoplay muted></video>
                <h3>best flower sallers</h3>
            </div>
            <div class="content">
                <h3>why choosen us ?</h3>
                <p>Flowers carry a lot of importance in our lives. In India,
                    no worship of God is complete without some kind of flower.
                    Devotees make a garland of flowers to dedicate it to God.
                    In addition, we also use flowers for special occasions like weddings.
                    The bride and groom wear garlands of flowers to signify their marriage.
                    In addition, flowers smell so good that we use it in different places by planting
                    them in our garden. This way, the beauty of our place enhances.</p>
                <p>Similarly, we send flowers for someone who is sick to brighten their day.
                    We also send flowers as a token of condolence during funerals.
                    Thus, we see they have so many uses in so many areas.</p>
                <a href="#" class="btn">learn more </a>
            </div>
        </div>





    </section>





    <section class="icons-container">

        <div class="icons">
            <img src="images/13.png" alt="" width="150" height="150">
            <div>
                <h3>Free delevery</h3>
                <span>On all orders</span>
            </div>
        </div>
        <div class="icons">
            <img src="images/477-4770850_10-days-money-back-guarantee-png-transparent-png.png" alt="" width="150" height="150">
            <div>
                <h3>10 days returns</h3>
                <span>Money back guarantee</span>
            </div>
        </div>
        <div class="icons">
            <img src="images/360_F_283457004_jhd3FekfvK7qCsjkEfLqN545dKiWxdLW.jpg" alt="" width="150" height="150">
            <div>
                <h3>Offers & Gifts</h3>
                <span>On all orders</span>
            </div>
        </div>
        <div class="icons">
            <img src="images/secure-payment2785.jpg" alt="" width="150" height="150">
            <div>
                <h3>Secure payment</h3>
                <span>Protected</span>
            </div>
        </div>
        

    </section>





    <section class="products" id="products">
        <h1 class="heading">latest <span>products</span></h1>
        <div class="box-container">


            <?php
            include 'getproduct.php';
            foreach ($result as $row) {
                $id = $row['id'];
                $image = $row['image'];
                $name = $row['name'];
                $price = $row['unit_price'];
                echo "
<div class='box-container'> 
    <div class='box'>
        <div class='image'>
            <img src='images/$image'>
            <div class='icons'>
                <a href='editproduct.php?id=$id' class='fas fa-edit' style='font-size:24px'></a>
                <a href='deleteproduct.php?id=$id' class='fas fa-trash' style='font-size:24px'></a>
            </div>
        </div>
        <div class='content'>
            <h3>$name</h3>
            <div class='price'>$price</div>
        </div>
    </div>
</div>";

            }


            ?>
            <section class="review" id="review">
                <h1 class="heading">Constomer's <span>review</span> </h1>
                <div class="box-container">
                    <div class="box">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p>” Very friendly admin staff and very accommodating to fit my request on a rather late
                            delivery.
                            Felt that you guys put customer's interest at heart first. Very good service. Will
                            definitely
                            come back again and will not hesitate to recommend your good shop to others. Keep it up! God
                            Bless.”</p>
                        <div class="user">
                            <img src="images/jhone deo.png" alt="" width="200" height="200">
                            <div class="user-info">
                                <h3>john deo</h3>
                                <span>Old Constomer</span>
                            </div>
                        </div>
                        <span>
                            <div class="fas fa-quote-right"></div>
                        </span>

                    </div>



                    <div class="box">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p>“I really would like to thank Sondos for listening to all my needs and changing them for me.
                            She even showed samples for me to choose from. Sondos is really patient & a friendly seller,
                            no doubt I would deal with her again in the future.thank you so much, I am sure my friend
                            likes your flower arrangement as well.Big thanks“</p>
                        <div class="user">
                            <img src="images/stephani eid.jpg" alt="" width="200" height="200">
                            <div class="user-info">
                                <h3>Stephani Eid</h3>
                                <span>Happy Constomer</span>
                            </div>
                        </div>
                        <span>
                            <div class="fas fa-quote-right"></div>
                        </span>

                    </div>



                    <div class="box">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p> “I am very happy that Fresh Flowers marketing dep followed me
                            and I get to know this friendly and very helpful Fresh Flowers. The founder happen to pick
                            up my call,
                            reminded to check what time the recipient discharge from the hospital so as to avoid change
                            of
                            location delivery charges.Overall, we are happy and we like the beautiful flowers basket!
                            Good!”</p>
                        <div class="user">
                            <img src="images/perlla.jfif" alt="" width="200" height="200">
                            <div class="user-info">
                                <h3>Perla Helo</h3>
                                <span>Best Constomer</span>
                            </div>
                        </div>
                        <span>
                            <div class="fas fa-quote-right"></div>
                        </span>

                    </div>


                </div>

            </section>
        </div>
    </section>


    <section class="contact" id="contact">

        <h1 class="heading"><span>contact</span> us</h1>

        <div class="row">
            <form action="">
                <input type="text" placeholder="name" class="box">
                <!-- <input type="email" placeholder="email" class="box"> -->
                <!-- <input type="number" placeholder="number" class="box"> -->
                <textarea name="message" class="box" placeholder="message" id="" cols="30" rows="10"></textarea>
                <input type="text" value="send message" class="btn">
            </form>


        </div>

    </section>

    <section class="footer" id="footer">
        <div class="box-container">
            <div class="box">
                <h3>quick links</h3>
                <a href="#">home</a>
                <a href="#about">about</a>
                <a href="#products">products</a>
                <a href="#review">review</a>
                <a href="#contact">contact</a>
            </div>

            <div class="box">
                <h3>extra links</h3>
                <a href="#">my account</a>
                <a href="#">my order</a>
                <a href="#">my favorite</a>
            </div>

            <div class="box">
                <h3>Locations</h3>
                <a href="#">Denniyeh, Taran</a>
                <a href="#">Tripoli, Abou Samra</a>
                <a href="#">Tripoli, Ebbe</a>
                <a href="#">Beirut, Dekweneh</a>
            </div>

            <div class="box">
                <h3>contact info</h3>
                <a href="#contact">+961-71700905</a>
                <a href="#contact">cheikhammar50@gmail.com</a>
                <a href="#contact">North,Denniyeh,Taran,Main street St</a>
               
            </div>
        </div>

        <div class="credit">Created by <span>Ammar Al Sheikh </span>(52131417)</div>


    </section>
</body>

</html>
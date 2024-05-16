<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <link href="gaia_css/home.css" rel="stylesheet" type="text/css"/>
    <head>
        <meta charset="UTF-8">
        <title>home page</title>
        <?php 
        include 'header.php';
        ?>
   
    </head>
    <body>
        <!-- home image-->
    <img src="image/plant.png" alt="plants" width="100%" height="660px">
    <div class="title_home"> Grow your world <br> one plant at a time</div>
    <div class="subtitle_home">Enhance your space with our plants and <br>sign up for exclusive offers and updates today!</div>
    <div class="sign_page_btn"><button class="home_sign_btn">Get Started</button></div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <article>
    <p class="home_intro">
At <b>Gaia's Garden</b>, we're passionate about bringing nature's beauty into your home with our exquisite selection of plants. Whether you're an avid gardener or just starting your green journey, we have something for everyone.
<br>
<br>Explore our diverse range of indoor and outdoor plants, from vibrant succulents to majestic ferns, lush tropicals, and beyond. Each plant is carefully curated to ensure the highest quality, so you can create your own urban oasis effortlessly.
<br>
<br>With easy ordering and delivery straight to your doorstep, transforming your space into a botanical paradise has never been easier. Let us help you cultivate serenity and greenery in your life.

</p>
    </article>
<img src="image/home_show2.jpg" class="plant_show">

<br>
    <br>
    <br>
    <br>
    <br>
<img src="image/flower_show.png" class="flower_show">
<article class="article2">
    
    <p class="home_intro">
    <b style="color:#35BE19;">Exclusive Deals:</b> Enjoy special discounts and promotions on our diverse range of plants, making it easier and more affordable than ever to green up your space.<br>
   <br> <b style="color:#35BE19;">Quality Assurance:</b> Each plant in our collection is handpicked and nurtured with care, guaranteeing you receive only the healthiest and most vibrant greenery.<br>
   <br><b style="color:#35BE19;">Environmental Impact:</b> By choosing to bring plants into your home, you're not just enhancing your space; you're also contributing to a greener planet. Join us in our mission to promote sustainability and eco-conscious living.
</p>
    </article>
<br>
    <br>
    <br>
    <br>
    <br>

<?php
include('sidebar.php');

?>
    </body>
    <footer>
        <?php
        
        include 'footer.php';
        ?>
    </footer>
</html>

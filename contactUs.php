<html>
    <head>
        <meta charset="UTF-8">
        <title>Contact Us</title>
        <link href="gaia_css/contactUs.css" rel="stylesheet" type="text/css"/>
        <style>

body{
    background-image: url('gaia_img/contact.png');
}
        </style>
    </head>
    <?php include "userheader.php"; ?>
    <body>
        <?php include "sidebar.php"; ?>
        <div  class="box_contactUs">
            <h1>Contact Us</h1><br><br>
            <label>Name:</label><br><br>
                <input type="text" placeholder="Write your name" class="contact_info_cs"><br><br>
            <label>Email:</label><br><br>
                <input type="text" placeholder="Write your email" class="contact_info_cs"><br><br>
            <label>Content:</label><br><br>
                <textarea id="contact_textarea" rols="5" cols= "30" style="resize:none" placeholder="write your content"></textarea><br><br><br>
            <input type="submit" value="Submit" class="submit_ct">
        </div>
    </body>
    <?php include("footer.php"); ?>
</html>
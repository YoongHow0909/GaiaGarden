<!DOCTYPE html>
<?php 
include('helper.php');


    if(isset($_POST["submit"])){
          
    $voucher_id = trim($_POST["voucher_id"]);
    $voucher_name = trim($_POST["voucher_name"]);
    $voucher_desp = trim($_POST["voucher_desp"]);
    $started_date = trim($_POST["started_date"]);
    $exp_date = trim($_POST["exp_date"]);
    $discount = trim($_POST["discount"]);
    $usage_limit = trim($_POST["usage_limit"]);
    $voucher_cate  =trim($_POST["voucher_cate"]);
    $target_dir = "image/promotion/";
    $target_file = $target_dir . basename($_FILES["voucher_img"]["name"]);
    

        if (move_uploaded_file($_FILES["voucher_img"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO promotion (voucher_id, voucher_name, voucher_desp, started_date, exp_date, discount, usage_limit, voucher_cate,  voucher_img) 
                    VALUES (:voucher_id, :voucher_name, :voucher_desp, :started_date, :exp_date, :discount, :usage_limit, :voucher_cate, :voucher_img )";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':voucher_id' => $voucher_id,
                ':voucher_name' => $voucher_name,
                ':voucher_desp' => $voucher_desp,
                ':started_date' => $started_date,
                ':exp_date' => $exp_date,
                ':discount' => $discount,
                ':usage_limit' => $usage_limit,
                ':voucher_cate' => $voucher_cate,
                ':voucher_img' => $target_file
            ]);  
?>

<script>
alert('the promotion add successfully');

</script>

  <?php          
        } else {
            echo "Sorry, there was an error uploading your data.";
        }

    }

    ?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Add Promotion</title>
    <?php
    include('header.php');  
    ?>
</head>
<body>
    <h1>Add Promotion</h1><br>
<form action="addPromotion.php" method="POST" enctype="multipart/form-data">
<label for="voucher_id">Voucher ID: </label>
<input type="text" name="voucher_id" required><br><br>

<label for="voucher_name">Voucher Name: </label>
<input type="text" name="voucher_name" required><br><br>

<label for="voucher_desp">Voucher description: </label>
<textarea name="voucher_desp"></textarea><br><br>

<label for="start_date">Voucher start date: </label>
<input type="date" name="started_date" required><br><br>

<label for="exp_date">Voucher expired date: </label>
<input type="date" name="exp_date" required><br><br>

<label for="discount">Enter the discount amount: </label>
<input type="number" name="discount" required><br><br>

<label for="usage_limit">Voucher usage limit: </label>
<input type="number" name="usage_limit" required><br><br>

<label for="voucher_cate">Voucher Category: </label>
<input type="text" name="voucher_cate" required><br><br>

<label for="voucher_img">Voucher image: </label>
<input type="file" name="voucher_img" id="voucher_img" required><br><br>

<input type="submit" name="submit">
</form>




</body>
<footer>
<?php
include('footer.php');
?>
</footer>
    </html>
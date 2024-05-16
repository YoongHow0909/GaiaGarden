<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Payment</title>
        <link href="gaia_css/gaia-payment.css?version=51" rel="stylesheet" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $("div.selected").css("border-color", "transparent");
                $("p.errormsg").css("color", "transparent")
                $("[name='cash']").click(function() {
                    $("div[name='cash']").css("border-color", "#95E30F");
                    $("div[name='card']").css("border-color", "transparent");
                    $("div[name='tng']").css("border-color", "transparent");
                    $("div.cash").show();
                    $("div.card").hide();
                    $("div.touchngo").hide();
                    $("p[name='pay-metd-err']").css("color", "transparent");
                });
                $("[name='card']").click(function() {
                    $("div[name='cash']").css("border-color", "transparent");
                    $("div[name='card']").css("border-color", "#95E30F");
                    $("div[name='tng']").css("border-color", "transparent");
                    $("div.cash").hide();
                    $("div.card").show();
                    $("div.touchngo").hide();
                    $("p[name='pay-metd-err']").css("color", "transparent");
                });
                $("[name='touchngo']").click(function() {
                    $("div[name='cash']").css("border-color", "transparent");
                    $("div[name='card']").css("border-color", "transparent");
                    $("div[name='tng']").css("border-color", "#95E30F");
                    $("div.cash").hide();
                    $("div.card").hide();
                    $("div.touchngo").show();
                    $("p[name='pay-metd-err']").css("color", "transparent");
                });
                $("[name='visa']").click(function() {
                    $("div[name='visa']").css("border-color", "#95E30F");
                    $("div[name='master']").css("border-color", "transparent");
                });
                $("[name='master']").click(function() {
                    $("div[name='visa']").css("border-color", "transparent");
                    $("div[name='master']").css("border-color", "#95E30F");
                });
            });
        </script>
    </head>
    <body>
        <?php require_once "db_conn.php"; ?>
        <?php session_start(); ?>
        <?php
        $userID = (isset($_SESSION["user_id"]))?$_SESSION["user_id"]:"";
        $subtotal_price = 0;
        $total_price = 0;
        ?>
        <div class="pay-bill">
            <form method="POST" action="" id="payment-form">
                <?php
                    $conn = mysqli_connect($dbhost, $username, $password, $dbname, $dbport);
                    $sql = "SELECT * FROM login WHERE user_id = '$userID'";
                    $result = $conn->query($sql);
                    if($result->num_rows > 0){
                        while($record = $result->fetch_object()){
                            echo "<div class='cust-detail'>";
                                echo "<p class='cust-detailLbl'> Receiver Details: </p>";
                              printf("<p class='cust-address'> %s | (+60)%s <br/>
                                                               %s
                                      </p>", $record->name, substr_replace($record->user_phnum, '-', 2, 0)
                                      , str_replace(",", ",<br/>", $record->user_address));
                                echo "<img src='gaia_img/edit-btn.png' alt='Edit' class='editBtn' 
                                        onclick='window.location.href=\'edit.php\''/>";
                            echo "</div>";
                        }
                    }
                    $result->free();
                    $conn->close();
                ?>
                <hr class="divider-hr">
                <?php
                    if (!empty($_POST["itemckb"])) {
                        $conn = mysqli_connect($dbhost, $username, $password, $dbname, $dbport);
                        foreach ($_POST["itemckb"] as $item) {
                            $escaped[] = $conn->real_escape_string($item);
                        }
                        $sql = "SELECT * FROM cart INNER JOIN plant
                        ON cart.plant_id = plant.plant_id 
                        WHERE cart_id IN ('".implode("','",$escaped)."')";
                        $result = $conn->query($sql);
                        if($result->num_rows > 0){
                            while($record = $result->fetch_object()){
                                echo "<div class='checkout-item'>";
                                  printf("<img src='gaia_img/%s/%s' alt='%s' class='item-img'/>"
                                          , $record->plant_cate, $record->plant_img, $record->plant_name);
                                    echo "<div class='item-desc'>";
                                      printf("<h3 class='item-detail'>%s</h3>", $record->plant_name);
                                      printf("<p class='item-detail'>RM %.2f</p>", $record->plant_price);
                                        /*echo "<div class='delivery-opt'>";
                                            echo "<p style='margin: 0px;'>Delivery Option: <span style='color: red;'>*</span></p>";
                                            echo "<div class='devry-opt'>";
                                                echo "<input type='radio' id='strd-devry' name='devry-opt' value='Standard Delivery' required>";
                                                echo "<span>";
                                                    echo "<label for='strd-devry'>Standard Delivery</label>";
                                                    echo "<p class='devry-info'>+ RM 1.70<br>
                                                             Receive by 01 MON</p>";
                                                echo "</span>";
                                                echo "<input type='radio' id='fast-devry' name='devry-opt' value='Fast Delivery' required>";
                                                echo "<span>";
                                                    echo "<label for='fast-devry'>Fast Delivery</label>";
                                                    echo "<p class='devry-info'>+ RM 2.70<br>
                                                             Receive by 01 MON</p>";
                                                echo "</span>";
                                            echo "</div>";    
                                        echo "</div>";*/
                                    echo "</div>";
                                    printf("<p class='item-amt'>× %d</p>", $record->order_qty);
                                echo "</div>";
                              printf("<p class='item-price'>Order Subtotal > RM %.2f</p>"
                                      , $record->plant_price * $record->order_qty);
                              $subtotal_price += ($record->plant_price * $record->order_qty);
                              echo "<input type='hidden' name='payAmt".$record->cart_id."' value='".$record->plant_price*$record->order_qty."'>";
                            }
                            if($subtotal_price < 1000){
                                printf("<p class='item-price'>Shipping Fee +RM %.2f</p>", 25);
                                $total_price = $subtotal_price + 25;
                            }
                            echo "<br/>";
                            echo "<input type='hidden' name='payCartStr' value='".implode(",",$_POST["itemckb"])."'>";
                            printf("<p class='item-price'>Total > RM %.2f</p>", $total_price);
                        } else {
                            echo "<p>No item fetched</p>";
                        }
                        $result->free();
                        $conn->close();
                    } else {
                        echo "<p>No item received <a href='gaia-checkout.php'>Back</a></p>";
                    }
                ?>
                <hr/>
                <div style="margin-left: 10px;">
                    <p style="display: inline-block; float: left">Payment Method:<span style="color: red;">*</span></p>
                    <div class="pay-metd">
                        <div class="selected" name="cash">
                        <input type="radio" name="paymentType" value="Cash" id="cash" hidden>
                        <label for="cash"><img src="gaia_img/cashPay.png" alt="Cash Payment" name="cash" class="pay-type"/></label>
                        </div>
                        <div class="selected" name="card">
                        <input type="radio" name="paymentType" value="Card" id="card" hidden>
                        <label for="card"><img src="gaia_img/cardPay.png" alt="Card Payment" name="card" class="pay-type"/></label>
                        </div>
                        <div class="selected" name="tng">
                        <input type="radio" name="paymentType" value="Touch N Go" id="touchngo" hidden>
                        <label for="touchngo"><img src="gaia_img/touchNgo.png" alt="Touch N Go" name="touchngo" class="pay-type"/></label>
                        </div>
                        <p class="errormsg" name="pay-metd-err">Please select a payment method</p>
                    </div>
                    <div class="cash">
                        <label for="payAmt">Amount to pay: RM </label>
                        <input type="text" name="payAmt" value="<?php printf("%.2f", $total_price); ?>" size="4" readonly/><br/><br/>
                        <?php 
                            $timezone = new DateTimeZone("Asia/Kuala_Lumpur");
                            $now = new DateTime("now", $timezone);
                            $now->modify("+1 day");
                            $tommorow = $now->format("d/m/Y");
                        ?>
                        <p style="margin: 5px;">Please pay at Merchant Counter by <?php echo "$tommorow"; ?></p>
                    </div>
                    <div class="card">
                        <label for="payAmt">Amount to pay: RM </label>
                        <input type="text" name="payAmt" value="<?php printf("%.2f", $total_price); ?>" size="4" readonly/><br/><br/>
                        <label>Payment Card: </label>
                        <input type="radio" name="paymentCard" value="credit" id="credit"><label for="credit">Credit</label>
                        <input type="radio" name="paymentCard" value="debit" id="debit"><label for="debit">Debit</label><br/>
                        <p class="errormsg" name="payCardErr">Error.....................</p><br/>
                        <label class="cardType">Card Type: </label>
                        <div class="selected" name="visa">
                        <input type="radio" name="cardType" value="visa" id="visa" hidden>
                        <label for="visa"><img src="gaia_img/visa.png" alt="Visa Card" class="cardType"/></label>
                        </div>
                        <div class="selected" name="master">
                        <input type="radio" name="cardType" value="master" id="master" hidden>
                        <label for="master"><img src="gaia_img/master.png" alt="Master Card" class="cardType"/></label>
                        </div><br/>
                        <p class="errormsg" name="cardTypeErr">Error.....................</p><br/>
                        <label for="cardNum">Card Number: </label>
                        <input type="text" name="cardNum" placeholder="XXXX-XXXX-XXXX-XXXX">
                        <label for="cardCVV" style="margin-left: 50px;">Card CVV: </label>
                        <input type="text" name="cardCVV" placeholder="CVV" size="5"><br/>
                        <p class="errormsg" name="cardNumErr">Error.....................</p><p class="errormsg" name="cardCVVErr">Error.....................</p><br/>
                        <label for="cardExp" class="cardExp">Expiry Date: </label>
                        <input type="text" name="cardExp" placeholder="MM / YY" size="5" style><br/>
                        <p class="errormsg" name="cardExpErr">Error.....................</p><br/>
                    </div>
                    <div class="touchngo">
                        <label for="payAmt">Amount to pay: RM </label>
                        <input type="text" name="payAmt" value="<?php printf("%.2f", $total_price); ?>" size="4" readonly/><br/><br/>
                        <img src="gaia_img/qrcode.jpg" alt="qrcode" class="qrcode"/>
                    </div>
                </div>
                <?php
                    if ($total_price > 0) {
                        echo "<input type='submit' value='Pay' class='pay-btn'>";
                    } else {
                        echo "<input type='submit' value='Pay' class='pay-btn' disabled>";
                    }
                ?>
            </form>
        </div>
        <script>
            var payCardErr = false;
            var cardTypeErr = false;
            var cardNumErr = false;
            var cardCVVErr = false;
            var cardExpErr = false;
            $("#payment-form").submit(function() {
                event.preventDefault();
                if($("[name='paymentType']").is(":checked")) {
                    if($("[name='paymentType']:checked").val() === "Card") {
                        if(!$("[name='paymentCard']").is(":checked")) {
                            $("[name='payCardErr']").text("Please choose credit/ debit card to pay");
                            $("[name='payCardErr']").css("color", "red");
                            payCardErr = true;
                        }
                        if(!$("[name='cardType']").is(":checked")) {
                            $("[name='cardTypeErr']").text("Please choose visa/ master card to pay");
                            $("[name='cardTypeErr']").css("color", "red");
                            cardTypeErr = true;
                        }
                        if($("[name='cardNum']").val() === "") {
                            $("[name='cardNumErr']").text("Please fill in your card number");
                            $("[name='cardNumErr']").css("color", "red");
                            cardNumErr = true;
                        }
                        if($("[name='cardNum']").val().length !== 16 && !Number.isInteger($("[name='cardNum']").val())) {
                            $("[name='cardNumErr']").text("Card number must be 16-digit");
                            $("[name='cardNumErr']").css("color", "red");
                            cardNumErr = true;
                        }
                        if($("[name='cardCVV']").val() === "") {
                            $("[name='cardCVVErr']").text("Please fill in card CVV");
                            $("[name='cardCVVErr']").css("color", "red");
                            cardCVVErr = true;
                        }
                        if($("[name='cardCVV']").val().length !== 4) {
                            $("[name='cardCVVErr']").text("Card CVV must be 4-digit");
                            $("[name='cardCVVErr']").css("color", "red");
                            cardCVVErr = true;
                        }
                        if($("[name='cardExp']").val() === "") {
                            $("[name='cardExpErr']").text("Please fill in card expiry date");
                            $("[name='cardExpErr']").css("color", "red");
                            cardExpErr = true;
                        }
                        /*if($("[name='cardExp']").val().match("/^(0[1-9]|1[0-2])\/?([0-9]{4}|[0-9]{2})$/")){
                            $("[name='cardExpErr']").css("color", "red");
                            cardExpErr = true;
                        }*/
                    }
                    if(payCardErr === false && cardTypeErr === false && cardNumErr === false && cardCVVErr === false && cardExpErr === false){
                        if(confirm("Confirm Payment: RM <?php printf("%.2f", $total_price); ?>?")) {
                            $("#payment-form").attr("action", "../Gaia/gaia-insert_payment.php");
                            $("#payment-form")[0].submit(); //To submit the form, without this, it will just set action attribute only
                        } else {
                            $("#payment-form").attr("action", "");
                            event.preventDefault();
                        }
                    }
                    else {
                        $("#payment-form").attr("action", "");
                        event.preventDefault();
                    }
                } else {
                    $("p[name='pay-metd-err']").css("color", "red");
                }
            });
            $("[name='paymentCard']").on("change", function() {
                if ($(this).is(":checked")) {
                    $("[name='payCardErr']").css("color", "transparent");
                    payCardErr = false;
                }
            });
            $("[name='cardType']").on("change", function() {
                if ($(this).is(":checked")) {
                    $("[name='cardTypeErr']").css("color", "transparent");
                    cardTypeErr = false;
                }
            });
            $("[name='cardNum']").on("input", function() {
                $("[name='cardNumErr']").css("color", "transparent");
                cardNumErr = false;
            });
            $("[name='cardCVV']").on("input", function() {
                $("[name='cardCVVErr']").css("color", "transparent");
                cardCVVErr = false;
            });
            $("[name='cardExp']").on("input", function() {
                $("[name='cardExpErr']").css("color", "transparent");
                cardExpErr = false;
            });
        </script>
    </body>
</html>
<?php

session_start();

if (isset($_SESSION["user"])) {
    $query = sprintf("SELECT SUM(coins) AS coins
                             FROM users_characters 
                             JOIN characters
                             ON character_id = characters.id
                             WHERE user_id = %d",
        json_decode($_SESSION["user"])->id);

    require_once dirname(__FILE__) . "/../../Utils/simpleQueryHandler.php";
} else {
    echo json_encode(array("error" => "Unable to download data. User not logged in!"));
}
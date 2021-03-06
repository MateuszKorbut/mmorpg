<?php

session_start();

if (isset($_SESSION["user"])) {
    $query = sprintf("SELECT 
                                 race.name,
                                 COUNT(race.id) AS quantity
                             FROM characters
                             JOIN race
                             ON race_id = race.id
                             WHERE creator_id = %d
                             GROUP BY race_id
                             ORDER BY quantity DESC
                             LIMIT 1;",
        json_decode($_SESSION["user"])->id);

    require_once dirname(__FILE__) . "/../../Utils/simpleQueryHandler.php";
} else {
    echo json_encode(array("error" => "Unable to download data. User not logged in!"));
}

<?php

http_response_code(400);

require_once dirname(__FILE__) . "/../../Entities/Users/User.php";
require_once dirname(__FILE__) . "/../../Utils/databaseConnection.php";

use entities\Users\User;

session_start();

if (isset($_POST["name"]) && isset($_POST["id"]) &&
    isset($_SESSION["user"]) && json_decode($_SESSION["user"])->id == $_POST["id"])
{
        $user = new User();
        $user->id = mysqli_real_escape_string($connection, $_POST["id"]);
        $user->name = mysqli_real_escape_string($connection, $_POST["name"]);

        $query = sprintf("UPDATE %s SET name = '%s' WHERE id = %d;",
            User::TABLE_NAME, $user->name, $user->id);

        if (mysqli_query($connection, $query))
        {
            http_response_code(200);
        }
        else
        {
            echo json_encode(array(
                "error" => mysqli_error($connection),
                "query" => $query));
        }
}
else
{
    echo json_encode(array("error" => "Unable to edit character.!"));
}

$connection->close();
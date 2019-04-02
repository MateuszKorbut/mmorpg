<?php

http_response_code(400);

include "Entities/Users/User.php";
include "Utils/databaseConnection.php";

use entities\Users\User;

if (isset($_POST["name"]) && isset($_POST["password"]))
{
    $query = sprintf("SELECT * FROM %s WHERE name LIKE '%s'", User::TABLE_NAME, $_POST["name"]);
    $result = $connection->query($query);

    if ($result->num_rows == 1)
    {
        $user = $result->fetch_assoc();
        if (password_verify($_POST["password"], $user["password"]))
        {
            http_response_code(200);

            unset($user["password"]);
            $userSerialized = json_encode($user);
            $_SESSION["user"] = $userSerialized;
            echo json_encode(array("message" => "User logged in."));
        }
        else
        {
            unableToLogin();
        }
    }
    else
    {
        unableToLogin();
    }
}
else
{
    unableToLogin();
}

function unableToLogin()
{
    echo json_encode(array("error" => "Unable to login. Wrong data!"));

}

$connection->close();

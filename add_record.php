<?php
require('database.php');

//$itemnum = filter_input(INPUT_POST, 'itemnum', FILTER_VALIDATE_INT);
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);

if ($title) {
    $query = 'INSERT INTO todoitems
                (Title, Description)
                VALUES
                (:title, :description)';
    $statement = $db->prepare($query);
    //$statement->bindValue(':itemnum', $itemnum);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':description', $description);
    $statement->execute();
    $statement->closeCursor();
}

$updated = true;

include('index.php');
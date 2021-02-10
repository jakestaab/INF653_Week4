<?php
    require('database.php');
    $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_GET, "description", FILTER_SANITIZE_STRING);

?>

<?php
        $query = 'SELECT * FROM todoitems
                        ORDER BY ItemNum ASC';
        $statement = $db->prepare($query);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':description', $description);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do LIst</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    <main>
        <header>
            <h1>To Do List</h1>
        </header>

        <?php if(!empty($results)) { ?>
            <secton>
                <h2>Items</h2>
                <table>
                    <?php foreach($results as $result) {
                        $itemnum = $result['ItemNum'];
                        $title = $result['Title'];
                        $description = $result['Description'];
                    ?>
                    <tr>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $description; ?></td>
                        <td><form action="delete_record.php" method="POST">
                            <input type="hidden" name="itemnum" value="<?php echo $itemnum ?>">
                            <button class="delete">Delete</button>
                        </form></td>
                    </tr>
                </table>
            <?php } ?>
            </section>
        <?php } else { ?>
            <p>Sorry, no results.</p>
        <?php } ?>
        <section>

            <h2>ADD ITEM</h2>
            <form action="add_record.php" method="POST">
                <input type="hidden" name="itemnum" value="<?php echo $itemnum ?>">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required>
                <button>Submit</button>
            </form>
        </section>
    </main>
</body>
</html>
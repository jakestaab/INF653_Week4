<?php
    require('database.php');
    $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_GET, "description", FILTER_SANITIZE_STRING);

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
    <title>ToDo LIst</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
    <main>
        <header>
            <h1>ToDo List</h1>
        </header>

        <?php if(!empty($results)) { ?>
            <section>
                    <?php foreach($results as $result) {
                        $itemnum = $result['ItemNum'];
                        $title = $result['Title'];
                        $description = $result['Description'];
                    ?>
                <table>
                    <tr>
                        <td><span class="title"><?php echo $title; ?></span>
                            <div><?php echo $description; ?></div></td>
                        <td><form action="delete_record.php" method="POST">
                            <input type="hidden" name="itemnum" value="<?php echo $itemnum ?>">
                            <button class="delete">&#10006</button>
                        </form></td>
                    </tr>
                </table>
            <?php } ?>
            </section>
        <?php } else { ?>
            <p>There are no items on the ToDo List.</p>
        <?php } ?>

        <section>
            <h2>ADD ITEM</h2>
            <form action="add_record.php" method="POST">
                <input type="hidden" name="itemnum" value="<?php echo $itemnum ?>">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required>
                <label for="description">Description:</label>
                <input type="text" id="description" name="description" required>
                <button>Add Item</button>
            </form>
        </section>

    </main>
</body>
</html>
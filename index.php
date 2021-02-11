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

        <?php if(!empty($results)) { ?>
            <section>
                <table>
                    <tr><div class="listlabel">ToDo List</div></tr>
                    <?php foreach($results as $result) {
                        $itemnum = $result['ItemNum'];
                        $title = $result['Title'];
                        $description = $result['Description'];
                    ?>
                    <tr>
                        <td><span class="title"><?php echo $title; ?></span>
                            <div><?php echo $description; ?></div></td>
                        <td><form action="delete_record.php" method="POST">
                            <input type="hidden" name="itemnum" value="<?php echo $itemnum ?>">
                            <button class="delete">&#10006</button>
                        </form></td>
                    </tr>
                    <?php } ?>
                </table>
            </section>
        <?php } else { ?>
            <p>There are no items on the ToDo List.</p>
        <?php } ?>

        <section>
            <div class="additem">
            <form action="add_record.php" method="POST">
                <label><div class="addlabel">Add Item</div></label>
                <input type="hidden" name="itemnum" value="<?php echo $itemnum ?>">
                <div>
                    <input type="text" id="newitems" name="title" placeholder="Title" required><br>
                    <input type="text" id="newitems" name="description" placeholder="Description" required>
                </div>
                <button class="add">Add Item</button>
            </form>
            </div>
        </section>

    </main>
</body>
</html>
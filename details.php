<?php 

    include('config/db_connect.php');

    if(isset($_POST['delete'])) {

        $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

        $sql = "DELETE FROM pizzas WHERE id = $id_to_delete";

        if(mysqli_query($conn, $sql)) {
            // Success
            header('Location: index.php');
        } else {
            // Failure
            echo 'Query Error' . mysqli_error($conn);
        }

    }

    // Check GET Request ID Parameter
    if(isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        // Make SQL for querying
        $sql = "SELECT * FROM pizzas WHERE id = $id";

        // Get Query Results
        $result = mysqli_query($conn, $sql);

        // Fetch result in array Format
        $pizza = mysqli_fetch_assoc($result);

        mysqli_free_result($result);
        mysqli_close($conn);
    }

?>


<!DOCTYPE html>
<html>

<?php include('templates/header.php'); ?>

<div class="container center">
    <?php if($pizza): ?>

    <h4><?php echo htmlspecialchars($pizza['title']); ?></h4>
    <p>Created by: <?php echo htmlspecialchars($pizza['email']); ?> </p>
    <p><?php echo date($pizza['created_at']); ?></p>
    <h5>Ingredients</h5>
    <p><?php echo htmlspecialchars($pizza['ingredients']); ?></p>

    <!-- Delete Form -->
    <form action='details.php' method='POST'>
        <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id'] ?>">
        <input type="submit" value="Delete" name='delete' class='btn brand z-depth-0'>
    </form>

    <?php else: ?>

    <h5>No Such Pizza Exists!</h5>

    <?php endif ?>
</div>

<?php include('templates/footer.php'); ?>

</html>
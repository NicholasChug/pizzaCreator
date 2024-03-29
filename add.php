<?php 

    // Connect to the database
    include('config/db_connect.php');


    $title = $email = $ingredients = '';

    $errors = array('email' => '' , 'title' => '', 'ingredients' => '');

   if(isset($_POST['submit'])) {

        // Check Email
        if(empty($_POST['email'])) {
            $errors['email'] = 'An email is required <br />';
        } else {
            $email = $_POST['email'];
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email must be a valid email address';
            }
        }

        // Check Title
        if(empty($_POST['title'])) {
            $errors['title'] = 'A title is required <br />';
        } else {
            $title = $_POST['title'];
            if(!preg_match('/^[a-zA-Z\s]+$/', $title)) {
                $errors['title'] = 'Title must be letters and spaces only';
            }
        }

        // Check Ingredients List
        if(empty($_POST['ingredients'])) {
            $errors['ingredients'] = 'At least one ingredient is required <br />';
        } else {
            $ingredients = $_POST['ingredients'];
            if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)) {
                $errors['ingredients'] = 'Ingredients must be seperated by a comma';
            }
        }

        // Overall Error Check
        if(array_filter($errors)) {
            // echo 'There are errors in the form';
        } else {
            // echo 'Form is valid';
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $title = mysqli_real_escape_string($conn, $_POST['title']);
            $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);

            // Create SQL
            $sql = "INSERT INTO pizzas(title, email, ingredients) VALUES('$title', '$email', '$ingredients')";

            // Save to DB and Check
            if(mysqli_query($conn, $sql)) {
                // Success
                header('Location: index.php');
            } else {
                // Error
                echo 'Query Error' . mysqli_error($conn);
            }
        }

   } 

?>

<!DOCTYPE html>
<html lang="en">

<?php include('templates/header.php'); ?>

<section class='container grey-text'>

    <h4 class="center">Add a Pizza</h4>
    <form action="add.php" method="POST" class="white">
    <label for="">Your Email:</label>
    <input type="text" name="email" value="<?php echo htmlspecialchars($email) ?>">
    <div class='red-text'>
        <?php echo $errors['email']; ?>
    </div>
    <label for="">Pizza Title:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($title) ?>">
    <div class='red-text'>
        <?php echo $errors['title']; ?>
    </div>
    <label for="">Ingredients (comma seperated):</label>
    <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients) ?>">
    <div class='red-text'>
        <?php echo $errors['ingredients']; ?>
    </div>
    <div class="center">
        <input type="submit" value="submit" name='submit' class='btn brand z-depth-0'>
    </div>
    </form>

</section>

<?php include('templates/footer.php'); ?>


</html>
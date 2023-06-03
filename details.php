<?php 

include('./config/bd_connect.php');

 if(isset($_POST['delete'])){
    $id_to_delete = mysqli_real_escape_string($conn,$_POST['id_to_delete']);

    $sql = "DELETE FROM pizzas WHERE id = $id_to_delete";

    if (mysqli_query($conn,$sql)){
        //suppression reussie
        header('location: index.php');
    } else {
        //erreur
        echo 'query error : ' . mysqli_error($conn);
    }
 }


      //check get request id parameter
      if(isset($_GET['id'])){
        $id = mysqli_real_escape_string($conn,$_GET['id']);
      }

      //realiser la commande sql
      $sql = "SELECT * FROM pizzas WHERE id = $id";

     //avoir resultat de la commande sql 
     $result = mysqli_query($conn,$sql);

     //fetch les resultats en format tableau(array)
     $pizza = mysqli_fetch_assoc($result);


     //free result from memory
     mysqli_free_result($result);

     //close connection
     mysqli_close($conn);


?>





<!DOCTYPE html>
<html lang="en">

<?php include('./templates/header.php');   ?>




<div class="container center">

    <?php if($pizza): ?>

    <h4><?php echo htmlspecialchars($pizza['title']); ?> </h4>
    <p>Created by : <?php echo htmlspecialchars($pizza['email']); ?> </p>
    <p><?php echo date($pizza['created_at']); ?> </p>
    <h5>Ingredients:</h5>
    <p> <?php echo htmlspecialchars($pizza['ingredients']); ?> </p>

    <!---DELETE FORM-->
    <form action="details.php" method="POST">
        <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id']  ?>">
        <input type="submit" name="delete" class="btn brand z-depth-0" value="delete">

    </form>


    <?php else: ?>
    <h5>No such pizza exists</h5>

    <?php endif ?>

</div>






<?php include('./templates/footer.php');   ?>

</html>
<?php
include('./config/bd_connect.php');

//write query from all pizzas
$sql = "SELECT title,ingredients,id FROM pizzas ORDER BY created_at";

//make query & get results
$result = mysqli_query($conn,$sql);

//get results as an array
$pizzas = mysqli_fetch_all($result,MYSQLI_ASSOC);

//free result from memory
mysqli_free_result($result);

//close connection
mysqli_close($conn);



//print_r($pizzas);

//explode(',',$pizzas[0]['ingredients']);


?>


<!DOCTYPE html>
<html lang="en">
<!---on fait appel a header.php pour faire afficher le header--->
<?php include('./templates/header.php'); ?>
<h4 class="center grey-text">Pizzas</h4>
<div class="container">
    <div class="row">
        <?php foreach($pizzas as $pizza): ?>
        <div class="col s6 md3">
            <div class="card z-depth-0">
                <div class="card-content center">
                    <h6><?php echo htmlspecialchars($pizza['title']); ?></h6>
                    <ul>
                        <?php foreach(explode(',',$pizza['ingredients'])as $ing): ?>
                        <li> <?php echo htmlspecialchars($ing) ?></li>
                        <?php  
                         endforeach;
                         ?>


                    </ul>
                </div>
                <div class="card-action right-align">
                    <a class="brand-text" href="details.php?id=<?php echo $pizza['id']  ?> ">more info</a>
                </div>
            </div>
        </div>
        <?php  endforeach; ?>

        <?php  if (count($pizzas) >=4): ?>
        <p>they are 4 more pizzas</p>
        <?php  else:  ?>
        <p>they are less than 4 pizzas</p>
        <?php endif;  ?>
    </div>
</div>
<?php include('./templates/footer.php'); ?>
<!---same for footer--->


</html>
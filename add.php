<?php 
 

include('./config/bd_connect.php');


// if (isset($_GET['submit'])){   JUSTE POUR TESTER AVEC GET MAIS AVEC POST C'EST MIIEUX CAR PLUS Sécurisé(les informations de ce qui a été submit ne s'affiche pas)
  //  echo $_GET['email'];
  //  echo $_GET['title'];
  //echo $_GET['ingredients'];

 //}


 $title = $email = $ingredients = '';//initialiser les chars

$errors = array('email' => '','title' => '','ingredients' => '');/*on stockes les valeurs d'erreur dans cette array*/





 if (isset($_POST['submit']/*pour verfifier si l'on a inséré une valeur(cliqué dans le cas de submit)*/)){

  //check mail
  if (empty($_POST['email'])/*pour verfifier si l'on a pas inséré un mail*/){
     $errors['email'] ="Please enter an email   <br/>";
  }
  else {
    $email = $_POST['email'];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)/*pour verfifier sila forme du mail est valide on utilise cette methose deja existante,pour title et ingredients in utilise regex qui consiste à créer ses propres conditions*/){
       $errors['email'] = 'email must be a valid email address';
    }
  }

   //check title
if (empty($_POST['title'])/*pour verfifier si l'on a pas inséré un titre*/){
    $errors['title'] = "Please enter a title   <br/>";
  }
  else {
    $title = $_POST['title'];
    if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
        $errors['title'] = 'Title must be a valid title'; 
    }
  }



  //check ingredients
if (empty($_POST['ingredients'])/*pour verfifier si l'on a pas inséré des ingredients*/){
     $errors['ingredients'] ="Please enter ingredients   <br/>";
  }
  else {
    $ingredients = $_POST['ingredients'];
    if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
       $errors['ingredients'] ='Must be  valid ingredients with comma separated list '; 
    }
  }

if (array_filter($errors)){
    //echo 'errors in the form';
} else {
   // echo 'no errors';
   $email = mysqli_real_escape_string($conn,$_POST['email']);
   $title = mysqli_real_escape_string($conn,$_POST['title']);
   $ingredients = mysqli_real_escape_string($conn,$_POST['ingredients']);

//create the appropiate sql command
$sql = "INSERT INTO pizzas (email, title, ingredients) VALUES ('$email', '$title', '$ingredients')";

//save to db and check
if (mysqli_query($conn,$sql)){
//success
 header('Location: index.php');/*si pas d'erreurs après submit aller vers autre page*/
}else {
 echo 'query error:' . mysqli_error($conn);
}


}


 }// end post

?>


<!DOCTYPE html>
<html lang="en">
<?php include('./templates/header.php'); ?>

<section class="container grey-text">
    <h4 class="center">Add a Pizza</h4>
    <form class="white" action="add.php" method="POST">
        <label>Your Email:</label>
        <input type="text" name="email" value="<?php echo htmlspecialchars($email)  ?>">
        <!---afficher valeur insérée avant si elle existe--->
        <div class="red-text"><?php echo $errors['email'] ?></div>
        <!---afficher erreur si elle existe--->
        <label>Pizza title:</label>
        <input type="text" name="title" value="<?php echo htmlspecialchars($title)  ?>">
        <div class="red-text"><?php echo $errors['title'] ?></div>
        <label>Ingredients(comma separated):</label>
        <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients)  ?>">
        <div class="red-text"><?php echo $errors['ingredients'] ?></div>
        <div class="center">
            <input type="submit" value="submit" name="submit" class="btn brand z-depth-0">
        </div>
    </form>
</section>

<?php include('./templates/footer.php'); ?>


</html>
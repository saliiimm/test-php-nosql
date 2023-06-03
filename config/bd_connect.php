<?php

//se connecter à la bdd:
$conn = mysqli_connect('localhost','salim','test1234','ninja_pizza');
//on a mit host puis nom user puis mdps puis nom bdd


//check connection:
if (!$conn){
  echo 'connection error:' . mysqli_connect_error();
}


?>
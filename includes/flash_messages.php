<?php
if(isset($_SESSION['success']))
{

echo '<div class="alert alert-success alert-dismissable">
   		<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    		<strong>Success! </strong>'. $_SESSION['success'].'
  	  </div>';
  unset($_SESSION['success']);
}

if(isset($_SESSION['failure']))
{
echo '<div class="alert alert-danger alert-dismissable">
   		<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    		<strong>Success! </strong>'. $_SESSION['failure'].'
  	  </div>';
  unset($_SESSION['success']);
}

 ?>
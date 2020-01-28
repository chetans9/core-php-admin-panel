<?php
if(isset($_SESSION['success']))
{
	?>
	<div class="alert alert-success alert-dismissable">
  	  	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
  	  	<strong>Success!</strong> <?php echo $_SESSION['success']; ?>
  	</div>
	<?php
	unset($_SESSION['success']);
}

if(isset($_SESSION['danger']))
{
	?>
	<div class="alert alert-danger alert-dismissable">
    	<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <strong>Danger!</strong> <?php echo $_SESSION['danger']; ?>
  	</div>
	<?php
	unset($_SESSION['danger']);
}

if(isset($_SESSION['info']))
{
	?>
	<div class="alert alert-info alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
    	<strong>Info</strong> <?php echo $_SESSION['info']; ?>
  	</div>
	<?php
	unset($_SESSION['info']);
}

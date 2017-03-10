<?php
session_start();
require_once 'inc/connect.php';





?><!DOCTYPE html>
<html lang="fr">
<head>
<?php include_once 'inc/head.php'; ?>
	<meta charset="UTF-8">
	<title>Contact</title>
</head>
<body>
<?php include_once 'inc/menu.php'; ?>
	<div class="container">

    <form class="well form-horizontal" action=" " method="post"  id="contact_form">
<fieldset>

<!-- Form Name -->
<legend>Contactez-nous!</legend>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label">Prénom</label>  
  <div class="col-md-4 inputGroupContainer">
  <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input  name="first_name" placeholder="Prénom" class="form-control"  type="text">
    </div>
  </div>
</div>

<!-- Text input-->

<div class="form-group">
  <label class="col-md-4 control-label" >Nom</label> 
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
  <input name="last_name" placeholder="Nom" class="form-control"  type="text">
    </div>
  </div>
</div>

<!-- Text input-->
       <div class="form-group">
  <label class="col-md-4 control-label">E-Mail</label>  
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
  <input name="email" placeholder="E-Mail Address" class="form-control"  type="text">
    </div>
  </div>
</div>

<!-- Text area -->
  
<div class="form-group">
  <label class="col-md-4 control-label">Message</label>
    <div class="col-md-4 inputGroupContainer">
    <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
        	<textarea class="form-control"  rows="8" name="comment" placeholder="Votre message"></textarea>
  </div>
  </div>
</div>

<!-- Success message -->
<div class="alert alert-success" style="display: none" role="alert" id="success_message">Success <i class="glyphicon glyphicon-thumbs-up"></i> Merci de vous contacter, nous vous repondrons au plus vite !!!</div>

<!-- Button -->
<div class="form-group">
  <label class="col-md-4 control-label"></label>
  <div class="col-md-4">
    <button type="submit" class="btn btn-warning" >Envoyer <span class="glyphicon glyphicon-send"></span></button>
  </div>
</div>

</fieldset>
</form>
</div><!-- /.container -->
<?php include_once 'inc/script.php'; ?>
</body>
</html>
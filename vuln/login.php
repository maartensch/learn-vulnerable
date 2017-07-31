<div class="message light center margin">
<?php
if(isset($_POST['user']) && isset($_POST['pass']) )
{
if($_POST['user'] == 'admin' && $_POST['pass'] == 'admin') {

header("Location: /");
die();


}
}
?>

<h4>Login - Will redirect when guessing right info</h4>

<form method="post">
<div class="form-control">
<input type="text" name="user"  placeholer="username" />
</div>
<div class="form-control">
<input type="password" name="pass" placeholer="password" />
</div>

<div class="form-control">
<input type="submit" value="Login" />
</div>
</form>


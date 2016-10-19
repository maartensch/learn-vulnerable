<?php
if (isset($_POST['flag'])) {
    if (checkFlag($_POST['flag'])) {
        if (_contains($_POST['flag'], $_SESSION['completed'])) {
            echo "<div class=\"message warning\">You already found this flag!</div>";
        } else {
            $_SESSION['points'] += flagPoints($_POST['flag']);
            $_SESSION['completed'] .= $_POST['flag'];
            echo "<div class=\"message success\">You found a flag!</div>";
        }
    } else {
        echo "<div class=\"message error\">Not a valid flag</div>";
    }
}
?>

<h4>Your Points</h4>
<div class="message info center big">
    <h1><?= $_SESSION['points'] ?> <i class="ion-pizza"></i></h1>
</div>
<form method="post">
    <div class="control">
        <input type="text" name="flag" placeholder="Enter flag..." />
    </div>
    <div class="control">
        <input type="submit" class="button info rounded" />
    </div>
</form>
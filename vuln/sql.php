<?php
if (isset($_POST['id'])) {
    $query = "SELECT * FROM user WHERE id = '{$_POST['id']}'";
    $users = Db::getDb()->query($query);
} else {
    $query = "SELECT * FROM user";
    $users = Db::getDb()->query($query);
}

/** PDO Object to ROW conversion [quick fix] */
$tUsers = [];
foreach ($users as $u) {
    $tUsers[] = $u;
}

$users = $tUsers;

/** If results display other flags than sql_injection, make the field hidden */
$hiddenFlags = [];
$fields = ['id', 'firstname', 'lastname'];
if (_contains('union', strtolower($query))) {
    foreach ($users as $user) {
        foreach ($fields as $field) {
            if (_contains('vuln{', strtolower($user[$field])) && !_contains('sql_inj3cti0n_is_a_super_p0w3r_', strtolower($user[$field]))) {
                $hiddenFlags[] = $user[$field];
            }
        }
    }
}
?>
<div class="message light center margin">
<h4>Reward: 300 <i class="ion-pizza"></i>, Difficulty: medium</h4>
</div>

    <form method="post">
    <div class="control">
        <input type="text" name="id" placeholder="Search id..." />
    </div>
    <div class="control">
        <input type="submit" class="button info rounded" />
    </div>
</form>

<h2>Hints:</h2>
<a target="_blank" href="https://www.owasp.org/index.php/SQL_Injection">Read more about SQL Injection (OWASP Guide)</a>

<h3>Users:</h3>
<table>
    <thead>
        <tr>
            <td>id</td>
            <td>firstname</td>
            <td>lastname</td>
        </tr>
    </thead>
    <tbody>

        <?php foreach ($users as $user): ?>
            <tr>
                <?php foreach ($fields as $field): ?>
                    <td><?php
                        if (in_array($user[$field], $hiddenFlags))
                            echo '[hidden]';
                        else
                            echo $user[$field];
                        ?>
                    </td>
                <?php endforeach ?>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?php

function clearDb() {
    $tables = ['flag', 'user'];
    foreach ($tables as $table) {
        Db::getDb()->query("DROP TABLE `$table`");
    }
}
function initDb() {
    Db::getDb()->query("CREATE TABLE IF NOT EXISTS `flag` ("
            . "`id` INT NOT NULL AUTO_INCREMENT,"
            . "`cat` VARCHAR(255) NOT NULL,"
            . "`points` INT NOT NULL,"
            . "`flag` VARCHAR(255) NOT NULL,"
            . "PRIMARY KEY(`id`)"
            . ")");
    Db::getDb()->query("CREATE TABLE IF NOT EXISTS `user` ("
            . "`id` INT NOT NULL AUTO_INCREMENT,"
            . "`firstname` VARCHAR(255) NOT NULL,"
            . "`lastname` VARCHAR(255) NOT NULL,"
            . "PRIMARY KEY(`id`)"
            . ")");

    $count = Db::getDb()->query("SELECT COUNT(*) as c FROM flag");
    foreach ($count as $c) {
        if ($c['c'] == 0) {
            $rand1 = base64_encode(openssl_random_pseudo_bytes(16));
            $rand2 = base64_encode(openssl_random_pseudo_bytes(16));
            Db::getDb()->query("INSERT INTO flag(points,cat,flag) VALUES(:points,:cat,:flag)", [':points'=>'300',':cat'=>'sql-injection',':flag' => 'VULN{SQL_INJ3CTI0N_IS_A_SUPER_P0W3R_' . $rand1.'}']);
            Db::getDb()->query("INSERT INTO flag(points,cat,flag) VALUES(:points,:cat,:flag)", [':points'=>'100',':cat'=>'xss-injection',':flag' => 'VULN{XSS_IS_A_SUPER_P0W3R_' . $rand2.'}']);
            Db::getDb()->query("INSERT INTO flag(points,cat,flag) VALUES(:points,:cat,:flag)", [':points'=>'200',':cat'=>'path-traversal',':flag' => 'VULN{PATH_TRAVERSAL_IS_A_SUPER_P0W3R_' . $rand2.'}']);
        }
    }

    $count = Db::getDb()->query("SELECT COUNT(*) as c FROM user");
    foreach ($count as $c) {
        if ($c['c'] == 0) {
            Db::getDb()->query("INSERT INTO user(firstname,lastname) VALUES(:firstname,:lastname)", [':firstname' => 'Iron', ':lastname' => 'Man']);
            Db::getDb()->query("INSERT INTO user(firstname,lastname) VALUES(:firstname,:lastname)", [':firstname' => 'Jason', ':lastname' => 'Statham']);
            Db::getDb()->query("INSERT INTO user(firstname,lastname) VALUES(:firstname,:lastname)", [':firstname' => 'James', ':lastname' => 'Bond']);
        }
    }
}

function checkFlag($flag) {
    $found = false;
    $flags = Db::getDb()->query("SELECT * FROM flag WHERE flag = :flag",[':flag'=>$flag]);
    foreach($flags as $flag) {
        $found = true;
    }
    
    return $found;
}

function getFlag($cat) {
    $rflag = '';
    $flags = Db::getDb()->query("SELECT * FROM flag WHERE cat = :cat",[':cat'=>$cat]);
    foreach($flags as $flag) {
        $rflag = $flag['flag'];
    }
    
    return $rflag;
}

function flagPoints($flag) {
    $points = 0;
    $flags = Db::getDb()->query("SELECT * FROM flag WHERE flag = :flag",[':flag'=>$flag]);
    foreach($flags as $flag) {
        $points = $flag['points'];
    }
    
    return $points;
}
?>
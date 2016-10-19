<?php
if (defined('_VULN')) {
    die("Recursive protection...");
}

define('_VULN', true);
session_start();
if (!isset($_SESSION['points'])) {
    $_SESSION['points'] = 0;
}
if (!isset($_SESSION['completed'])) {
    $_SESSION['completed'] = '';
}

/* Loading functiosn and libraries */
require('lib/func.php');
_require('lib/', ['func.php']);

/** Loading DB configurations */
require('config.php');
Db::config(DB_NAME, DB_USER, DB_PASS);
initDb();

?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title><?=SITE_TITLE?></title>
        <?php
        foreach (_files('html', 'css') as $file) {
            echo '<link rel="stylesheet" href="html/' . $file . '.css" />';
        }
        ?>
        <style>
            ul.inline-block.tiles.info li a,a {
                color:<?=HIGHLIGHT_COLOR?>;
            }
            
            .button.info, .message.info {
                background:<?=HIGHLIGHT_COLOR?>!important;
            }
            </style>
    </head>
    <body>
        <div class="dark"> 
            <div class="grid">
                <div class="left">
                    <ul class="inline-block light tiles">
                        <li><a href=""><?=SITE_TITLE?></a></li>
                    </ul>
                </div>
                
                <div class="right">
                    <ul class="inline-block info tiles">
                        <li title="Your Points"><a href="?vuln=flag-checker.php"><?= $_SESSION['points'] ?> <i class="ion-pizza"></i></a></li>
                    </ul>
                </div>

                <div class="right">
                    <ul class="inline-block light tiles">
                        <?php
                        foreach (_files('vuln') as $file) {
                            echo '<li><a href="?vuln=' . $file . '.php">' . ucwords(str_replace('-', ' ', $file)) . '</a></li>';
                        }
                        ?>
                    </ul>
                </div>

                
                <div class="clear"></div>
            </div>
        </div>

        <div class="html big">
            <div class="grid">
                <?php if (isset($_GET['vuln'])): ?>
                    <h4>Page: <?= $_GET['vuln'] ?></h4>
                    <?php
                    $path = 'vuln/' . $_GET['vuln'];
                    if (is_file($path)) {
                        $file = file_get_contents($path);
                        ob_start();
                        eval('?>' . $file . '<?php');
                        $fileEvalContent = ob_get_contents();
                        ob_end_clean();

                        /** PATH TRAVERSAL DETECTION CHECK */
                        if (_contains('..', $_GET['vuln'])) {
                            echo '<div class="message">PATH TRAVERSAL Flag: ' . getFlag('path-traversal') . '</div>';
                        }

                        echo $fileEvalContent;
                    } else {
                        echo 'file not found';
                    }

                    /** XSS DETECTION CHECK */
                    if (_contains('<script>', $_GET['vuln']) && _contains('</script>', $_GET['vuln'])) {
                        echo '<div class="message">XSS Flag: ' . getFlag('xss-injection') . '</div>';
                    }
                    ?>
                
                    
                <?php else: ?>
                    <div class="html huge center">
                        <h3>Select a vulnerable page at te top</h3>

                    </div>
                <?php endif ?>
            </div>
        </div>

    </body>
</html>

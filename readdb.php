<?php
/**
 * Created by PhpStorm.
 * User: derchris
 * Date: 08/03/15
 * Time: 23:44
 */

require('inc/db.php');

$db = new \labmanager\db();

$result = $db->query('SELECT password FROM users WHERE username="admin"');
while ($row = $result->fetchArray()) {
    echo 'Password db: ' . $row['password'], PHP_EOL;
    echo 'Password md5: ' . md5('password'), PHP_EOL;
    if ($row['password'] == md5('password')) {
        echo 'Password match', PHP_EOL;
    } else {
        echo 'Password does not match', PHP_EOL;
    }
}
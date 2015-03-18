<?php
/**
 * Created by PhpStorm.
 * User: CGerbran
 * Date: 18/03/2015
 * Time: 10:13
 */

require('inc/db.php');
$db = new \labmanager\db();
$total_devices = $db->getCount('devices');
$file = 'templates/content_' . basename($_SERVER['PHP_SELF'],".php") . '.html';

include('templates/head.html');
echo '<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">';
include('templates/navbar.html');
include('templates/sidemenu.html');
echo '        </nav>';
include($file);
echo '    </div>
    <!-- /#wrapper -->';
include('templates/foot.html');

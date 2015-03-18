<?php
if ($_SERVER["SERVER_PORT"] != 443){
    header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_GET["logout"])) {
    $logout = $_GET['logout'];

    if ($logout == "yes") { //destroy the session
        session_start();
        $_SESSION = array();
        session_destroy();
        setcookie("spslogin_user", "", time() - 3600, "/labmanager");
        setcookie("spslogin_username", "", time() - 3600, "/labmanager");
        setcookie("spslogin_usermail", "", time() - 3600, "/labmanager");
        setcookie("spslogin_loggedin", "", time() - 3600, "/labmanager");
        setcookie("spslogin_remember", "", time() - 3600, "/labmanager");
        $_COOKIE['spslogin_loggedin'] = '';
        $_COOKIE['spslogin_user'] = '';
        $_COOKIE['spslogin_username'] = '';
        $_COOKIE['spslogin_remember'] = '';
        $_COOKIE['spslogin_usermail'] = '';
    }
} else {

    if (isset($_COOKIE["spslogin_loggedin"])) {
        if (!is_null($_COOKIE["spslogin_loggedin"])) {
            $redir = "Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/dashboard.php";
            header($redir);
        }
    }
}

//you should look into using PECL filter or some form of filtering here for POST variables
if (isset($_POST["username"]) && isset($_POST["password"])) {
    $username = strtoupper($_POST["username"]); //remove case sensitivity on the username
    $password = $_POST["password"];
}

if (isset($_POST["oldform"])) { //prevent null bind

    if ($username != NULL && $password != NULL){
        //include the class and create a connection
        include (dirname(__FILE__) . "/inc/adLDAP/adLDAP.php");
        try {
            $adldap = new adLDAP();
        }
        catch (adLDAPException $e) {
            echo $e;
            exit();
        }

        //authenticate the user
        if ($adldap->authenticate($username, $password)){
            //establish your session and redirect
            session_start();
            $_SESSION["username"] = $username;
            $_SESSION["userinfo"] = $adldap->user()->info($username);
            if ($_POST["remember"] != NULL) {
                setcookie("spslogin_user", $username);
                setcookie("spslogin_username", $_SESSION['userinfo']['0']['displayname']['0']);
                setcookie("spslogin_usermail", $_SESSION['userinfo']['0']['mail']['0']);
                setcookie("spslogin_remember", "yes");
                setcookie("spslogin_loggedin", "yes");
            }
            $redir = "Location: https://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/dashboard.php";
            header($redir);
            exit;
        }
    }
    $failed = 1;
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Lab Manager">
    <meta name="author" content="derchris <derchris@me.com>">

    <title>Lab Manager - Login</title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="page-header">
                    <h1>Lab Manager</h1>
                </div>

                <?php
                if (isset($logout)) {
                    if ($logout == "yes") {
                        echo '<div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                            <strong>Well done!</strong> You have successfully logged out.
                        </div>';
                    }
                }

                if (isset($failed)) {
                    echo '<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                        <strong>Oh snap!</strong> Login Failed.
                    </div>';
                }
                ?>

                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Please Sign In</h3>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="index.php" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" autofocus required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="" required>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input name="remember" type="checkbox" value="Remember Me" aria-checked="true" checked>Remember Me
                                    </label>
                                </div>
                                <input type="hidden" name="oldform" value="1">
                                <!-- Change this to a button or input when using this as a form -->
                                <button class="btn btn-lg btn-success btn-block" type="submit">Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

</body>

</html>

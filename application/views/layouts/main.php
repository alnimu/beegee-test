<?php
/**
 * @var string $content
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Beejee</title>

    <!-- Bootstrap core CSS -->
    <link href="/public/vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="/public/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/public/css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">
    <div class="header clearfix">
        <nav>
            <?php if(Application::$app->user->isGuest()):?>
            <form class="navbar-form navbar-right" role="login" method="post" action="<?=Application::$app->createUrl('default/login')?>">
                <div class="form-group">
                    <input type="text" class="form-control" name="signin[login]" placeholder="Login">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="signin[password]" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-default">Login</button>
            </form>
            <?php else:?>
                <p class="navbar-text navbar-right">
                    Signed in as <?=Application::$app->user->getName()?>
                    <a href="<?=Application::$app->createUrl('default/logout')?>">Logout</a>
                </p>
            <?php endif;?>
        </nav>
        <h3 class="text-muted">Beejee</h3>
    </div>

    <?=$content?>

    <footer class="footer">
        <p>&copy; <?=date('Y')?> Alnimu</p>
    </footer>

</div> <!-- /container -->


<script src="/public/js/ie10-viewport-bug-workaround.js"></script>
<script src="/public/vendor/jquery/dist/jquery.min.js"></script>
<script src="/public/vendor/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="/public/js/main.js"></script>
</body>
</html>


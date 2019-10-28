<?php 
session_start();
if(!isset($_SESSION['auth']['name']) && isset($_COOKIE['name'])){
    $_SESSION['auth']['name'] = $_COOKIE['name'];
}
if(isset($_SESSION['auth'])){
    $name = $_SESSION['auth']['name'];
}
if($name == null){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Comments</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="css/app.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="index.php">
                    Home
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <?php 
                    if(!isset($_SESSION['auth'])){
                        echo '<ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="register.php">Register</a>
                            </li>
                    </ul>';
                    }
                    else{
                        echo '<li class="nav-item">
                                <a class="nav-link" href="login.php">Logout</a>
                            </li>';
                            
                                    
                    }
                    ?><!-- Right Side Of Navbar -->
                    
                </div>
            </div>
        </nav>
  <?php require "db.php";
                             $pdo = DB::get(); 
                             $sql = "SELECT * FROM `comments` ORDER by id DESC";
        $statement = $pdo->prepare($sql); //подготовить
        $statement->execute(); //true || false
        $comments = $statement->fetchAll(PDO::FETCH_ASSOC);
            
        ?>
        <main class="py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="card">          
                            <?php echo $_SESSION['true'];  unset($_SESSION['true']);
                            ?>
                            <?php foreach($comments as $comment):?>
                           

                            <div class="card-body"> 
                                <div class="media">
                                  <img src="img/no-user.jpg" class="mr-3" alt="..." width="64" height="64">
                                  <div class="media-body">
                                    <h5 class="mt-0"><?= '<b>' . $comment['title'] . '</b>' ;?></h5> 
                                    <span><small><?=date("d.m.Y h:i:s",strtotime($comment['date']));?></small></span>
                                    <p>
                                        <?=$comment['description'];?>
                                    </p>
                                  </div>
                                </div>
                            </div>
                                
                 
                <?php endforeach;?>
                    <div class="col-md-12" style="margin-top: 20px;">
                        <div class="card">
                            <div class="card-header"><h3>Оставить комментарий</h3></div>
                            
                            <div class="card-body">
                                <form action="/store.php" method="post">
                                    <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Имя</label>
                                    <textarea name="title" class="form-control" id="exampleFormControlTextarea1" rows="1"><?php 
                                    if (isset($name)){echo $name;}
                                    ?></textarea>
                                  </div>
                                  <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Сообщение</label>
                                    <textarea name="description" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                  </div>
                                  <button type="submit" class="btn btn-success">Отправить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

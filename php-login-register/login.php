<?php 

require_once("config.php");
$errorname = "";
$uname_error = $pass_error ="";
if(isset($_POST['login'])){
  
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);


    $sql = "SELECT * FROM userss WHERE username=:username OR email=:email";
    $stmt = $db->prepare($sql);
    
    // bind parameter ke query
    $params = array(
        ":username" => $username,
        ":email" => $username
    );

    $stmt->execute($params);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // jika user terdaftar
    if($user){
        // verifikasi password
        if(password_verify($password, $user["password"])){
            // buat Session
            session_start();
            $_SESSION["user"] = $user;
            // login sukses, alihkan ke halaman timeline
            header("Location: ./Dashboard/index.php");
        }else{
            $pass_error = "Invalid Password or username";
        }
    }else{
        $errorname="belum regis yaa";
    }


}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>

        <form action="" method="POST">

            <div class="form-group">
                <label for="username">Username</label>
                <input class="form-control" type="text" name="username" placeholder="Username atau email" required />
                <span style="color: red"><?php echo $errorname ?> </span>
                <span style="color: red"><?= $uname_error ?></span>
            </div>
           
            <div class="form-group">
                <label for="password">Password</label>
                <input class="form-control" type="password" name="password" placeholder="Password" required />
                <span style="color: red"><?php echo $errorname ?> </span>
                <span style="color: red"><?= $pass_error ?></span>
            </div>

            <div class="form-group">
                <input class="form-check-input border border-1 border-black" type="checkbox" placeholder="Checkbox"
                id="checkbox" name="checkbox" required />
                <label for="checkbox">Remember Me</label>
                              
            </div>

            <input type="submit" class="btn btn-success btn-block" name="login" value="Masuk" />

        </form>
            
        </div>


    </div>
</div>
    
</body>
</html>
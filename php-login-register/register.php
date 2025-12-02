<?php
require_once("config.php");

$name_error = $username_error = $email_error = $password_error = "";

if (isset($_POST['register'])) {
    $name = $username = $email = $password = "";

    // Filter dan ambil data yang diinputkan
    $name = htmlspecialchars($_POST['name']);
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    // Validasi Nama
    if (empty($name)) {
        $name_error = 'Nama lengkap harus diisi!';
    } else {
        // Check apakah hanya huruf dan spasi yang diizinkan
        if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
            $name_error = 'Hanya huruf dan spasi yang diizinkan!';
        }
    }

    // Validasi Username
    if (empty($username)) {
        $username_error = 'Username harus diisi!';
    } else {
        // Check apakah hanya huruf dan spasi yang diizinkan
        if (!preg_match("/^[a-zA-Z ]*$/", $username)) {
            $username_error = 'Hanya huruf dan spasi yang diizinkan!';
        }
    }

    // Validasi Email
    if (empty($email)) {
        $email_error = 'Email harus diisi!';
    } else {
        // Check format email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $email_error = 'Format email tidak valid!';
        }
    }

    // Validasi Password
    if (empty($password)) {
        $password_error = 'Password harus diisi!';
    } else {
        // Enkripsi password sebelum disimpan ke database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Jika tidak ada pesan kesalahan, simpan data ke database
    if (empty($name_error) && empty($username_error) && empty($email_error) && empty($password_error)) {
        $sql = "INSERT INTO userss (name, username, email, password) VALUES (:name, :username, :email, :password)";
        $stmt = $db->prepare($sql);

        // Bind parameter ke query
        $params = array(
            ":name" => $name,
            ":username" => $username,
            ":password" => $hashed_password,
            ":email" => $email
        );

        // Eksekusi query untuk menyimpan ke database
        $saved = $stmt->execute($params);

        // Jika registrasi berhasil, alihkan ke halaman login
        if ($saved) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input class="form-control" type="text" name="name" placeholder="Nama kamu" required="" />
                    <span class="text-danger"><?php echo $name_error; ?></span>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input class="form-control" type="text" name="username" placeholder="Username" required="" />
                    <span class="text-danger"><?php echo $username_error; ?></span>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input class="form-control" type="email" name="email" placeholder="Alamat Email" required="" />
                    <span class="text-danger"><?php echo $email_error; ?></span>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" name="password" placeholder="Password" required="" />
                    <span class="text-danger"><?php echo $password_error; ?></span>
                </div>

                <input type="submit" class="btn btn-success btn-block" name="register" value="Daftar" />

            </form>
            
        </div>
    </div>
</div>

</body>
</html>

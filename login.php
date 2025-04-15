<?php
session_start();
require('database.php');
$error = "";

$isNotEmpty = $conn->query("SELECT EXISTS(SELECT * FROM USERS)")->fetchColumn();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];


    if (!$isNotEmpty) {
        $error = "Tidak ada pengguna yang terdaftar!";
    } else {
        $usersData = $conn->query("SELECT * FROM USERS");
        foreach ($usersData as $user) {
            if ($user['email'] === $email && $user['password'] === $password) {
                $_SESSION['logged_in_user'] = $user;
                header("Location: index.php");
                exit();
            }
        }
        $error = "Email atau password tidak valid!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/styleLogReg.css">
</head>
<body>
    <div class="container">
        <a id="back" href="index.php"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        <h2>Login ke akun Anda</h2>
        <span id="phpError"><?php if ($error): ?><p><?= "* " . $error ?></p><?php endif; ?></span>
        <form method="POST">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan email Anda..." >
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password..." >
            </div>
            <button style="font-weight: bold;" type="submit">Login</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Sign up</a>.</p>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector("form")

            form.addEventListener("submit", function (event) {
                let error = ""

                let email = document.getElementById("email").value.trim()
                let password = document.getElementById("password").value

                if(email === ""){
                    error = "Email tidak boleh kosong"
                }
                else if(password === ""){
                    error = "Password tidak boleh kosong"
                }

                if(error !== ""){
                    document.getElementById("phpError").innerHTML = `<p>* ${error}</p>`
                    event.preventDefault()
                }
            })
        })
    </script>
</body>
</html>
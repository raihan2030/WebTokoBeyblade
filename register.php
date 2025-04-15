<?php
require('database.php');
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $dob = $_POST["dob"];
    $balance = str_replace(".", "", $_POST["balance"]);

    if (strlen($name) < 3) {
        $error = "Nama minimal 3 karakter!";
    } elseif (strlen($username) < 3) {
        $error = "Username minimal 3 karakter!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Email tidak valid!";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter!";
    } elseif ($password !== $confirm_password) {
        $error = "Konfirmasi password tidak sesuai!";
    } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $dob)) {
        $error = "Format tanggal lahir salah! (YYYY-MM-DD)";
    } elseif (!ctype_digit($balance)) {
        $error = "Saldo hanya boleh angka!";
    } elseif ((double)$balance < 0) {
        $error = "Saldo tidak boleh negaitf!";
    } else{
        $query = "INSERT INTO USERS (name, username, email, password, date_of_birth, balance) VALUES (?, ?, ?, ?, ?, ?)";
        $insertStat = $conn->prepare($query);
        $insertStat->execute([$name, $username, $email, $password, $dob, (double)$balance]);
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="styles/styleLogReg.css">
</head>
<body>
    <div class="container">
        <a id="back" href="index.php"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        <h2>Daftar Akun</h2>
        <span id="phpError">
        <?php if(isset($_SESSION["error"])): ?>
            <p><?= "* " . $_SESSION["error"]; unset($_SESSION["error"]) ?></p>
        <?php endif; ?>
        </span>
        <form method="POST">
            <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" id="name" name="name" placeholder="Masukkan nama lengkap Anda..." >
                <span id="nameError" class="error"></span>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username..." >
                <span id="usernameError" class="error"></span>
            </div>
            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" placeholder="Masukkan alamat email Anda..." >
                <span id="emailError" class="error"></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password..." >
                <span id="passwordError" class="error"></span>
            </div>
            <div class="form-group">
                <label for="confirm_password">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Masukkan password sebelumnya..." >
            </div>
            <div class="form-group">
                <label for="dob">Tanggal Lahir</label>
                <input type="date" id="dob" name="dob" >
                <span id="dobError" class="error"></span>
            </div>
            <div class="form-group">
                <label for="balance">Saldo</label>
                <input type="text" id="balance" name="balance" placeholder="Masukkan saldo..."  oninput="formatNumber(this)">
                <span id="balanceError" class="error"></span>
            </div>
            <button style="font-weight: bold;" type="submit">Daftar</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Sign in</a>.</p>
    </div>

    <script>
        function formatNumber(input) {
            let value = input.value.replace(/\./g, '')
            input.value = new Intl.NumberFormat('id-ID').format(value)
        }

        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector("form")

            form.addEventListener("submit", function (event) {
                let error = ""

                clearErrors()
                
                let name = document.getElementById("name").value.trim()
                let username = document.getElementById("username").value.trim()
                let email = document.getElementById("email").value.trim()
                let password = document.getElementById("password").value
                let conf_password = document.getElementById("confirm_password").value
                let dob = document.getElementById("dob").value
                let balance = document.getElementById("balance").value.replace(/\./g, '').trim()

                if (name.length === 0) {
                    error = "Nama tidak boleh kosong"
                    showError(error, "nameError")
                } else if (name.length < 3) {
                    error = "Nama minimal 3 karakter"
                    showError(error, "nameError")
                } else if (username.length === 0) {
                    error = "Username tidak boleh kosong"
                    showError(error, "usernameError")
                } else if (username.length < 3) {
                    error = "Username minimal 3 karakter"
                    showError(error, "usernameError")
                } else if (email.length === 0) {
                    error = "Email tidak boleh kosong"
                    showError(error, "emailError")
                } else if (password.length === 0) {
                    error = "Password tidak boleh kosong"
                    showError(error, "passwordError")
                } else if (password.length < 6) {
                    error = "Password minimal 6 karakter"
                    showError(error, "passwordError")
                } else if (password !== conf_password) {
                    error = "Password tidak cocok"
                    showError(error, "passwordError")
                } else if (dob === "") {
                    error = "Tanggal lahir tidak boleh kosong"
                    showError(error, "dobError")
                } else if (balance === ""){
                    error = "Saldo tidak boleh kosong!"
                    showError(error, "balanceError")
                } else if (balance.length === 0 || isNaN(balance)) {
                    error = "Saldo hanya boleh angka!"
                    showError(error, "balanceError")
                }  else if (parseFloat(balance) < 0) {
                    error = "Saldo tidak boleh negatif!"
                    showError(error, "balanceError")
                }

                if (error !== "") {
                    event.preventDefault()
                }
            });
        });

        function showError(errorText, htmlId){
            document.getElementById(htmlId).innerHTML = `<p>* ${errorText}</p>`
        }

        function clearErrors(){
            let errorElements = document.getElementsByClassName("error")
            for(i = 0; i < errorElements.length; i++){
                errorElements[i].innerHTML = ""
            }
        }
    </script>

</body>
</html>

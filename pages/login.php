<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login SIGAP NTB</title>

    <link rel="stylesheet" href="../CSS/login.css">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">



</head>

<body>

    <h2>Menu Login</h2>

    <div class="container">

        <div class="logo">
            <img src="../Assets/images/logo-ntb.png" alt="Logo NTB">
            <h3>SIGAP NTB</h3>
        </div>

        <form id="loginForm" action="../php/masuk.php" method="POST">

            <label>Username</label>

            <div class="input-box">
                <i class="fa-solid fa-user"></i>
                <input type="text" placeholder="Masukkan username" name="userlogin" id="userlogin" class="text-input" required>
            </div>

            <label>Password</label>

            <div class="input-box">
                <i class="fa-solid fa-lock"></i>
                <input type="password" placeholder="Masukkan password" name="passlogin" id="passlogin" class="text-input" required>
            </div>

            <br>

            <button type="submit" id="btn-login" name="login">
                Login
            </button>

        </form>

    </div>


</body>
</html>

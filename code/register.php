<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Registracija</title>
        <link rel="stylesheet" type="text/css" href="st.css">
    </head>
    <body>
        <div class="main-div">
            <h1>Registracija</h1>
            <form method="POST" action="registerUser.php">
                <label for="username">Up. ime:</label>
                <input type="text" id="username" name="username" maxlength="25"><br><br>
                <label for="username">E-mail:</label>
                <input type="text" id="email" name="email" maxlength="25"><br><br>
                <label for="password">Geslo:</label>
                <input type="password" id="password" name="password" maxlength="25"><br><br>
                <button type="submit">REGISTRACIJA</button>
            </form>
            <form action="index.php">
                <button type="submit" style="margin-top: 10px">NAZAJ</button>
            </form>
            <?php if (isset($_GET['error'])): ?>
                <p><?php echo $_GET['error']; ?></p>
            <?php endif; ?>
        </div>
    </body>
</html>
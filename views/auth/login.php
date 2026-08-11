<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style-login.css">
    <title>MyCoffeShop - Login Page</title>
</head>

<body>
    <div class="main">
        <h1>MyCoffeeShop Web Page</h1>
        <h3>Silahkan Login Terlebih Dahulu</h3>

        <form action="index.php?page=proses-login" method="post">
            <label for="username">
                Username:
            </label>
            <input type="text" id="username" name="username" 
                placeholder="Enter your Username" required>

            <label for="password">
                Password:
            </label>
            <input type="password" id="password" name="password" 
                placeholder="Enter your Password" required>

            <div class="wrap">
                <button type="submit">
                    Submit
                </button>
            </div>
        </form>
        
    </div>
</body>

</html>

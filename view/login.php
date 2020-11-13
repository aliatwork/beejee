<!DOCTYPE html>
<html>
<head>


    <title>BeeJee</title>
    <link rel="stylesheet" href="/resource/bootstrap-4.5.3/css/bootstrap.css"/>

</head>
<body>

<nav class="navbar navbar-light bg-light container">
    <a class="btn btn-primary" href="/">Главная</a>
</nav>

<div class="container mt-5">

    <div class="col-lg-6 offset-lg-3">

        <h1>Авторизация</h1>

        <form class="form" action="/login" method="post">
            <div class="form-group">
                <label>Имя</label>
                <input name="name" type="text"
                       class="form-control <?php echo $errors['name'] ? 'is-invalid' : '' ?>"
                       placeholder="Имя"
                       value="<?php echo $data['name'] ?>"/>
                <div class="invalid-feedback">
                    <?php echo $errors['name'] ?>
                </div>
            </div>
            <div class="form-group">
                <label>Пароль</label>
                <input name="password" type="password"
                       class="form-control <?php echo $errors['password'] ? 'is-invalid' : '' ?>"
                       placeholder="Пароль"/>
                <div class="invalid-feedback">
                    <?php echo $errors['password'] ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Войти</button>
        </form>

    </div>


</div>


</body>
</html>

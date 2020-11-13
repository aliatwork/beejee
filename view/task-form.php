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
    <div class="col-lg-8 offset-lg-2">

        <h1>Форма заполнения задачи</h1>
        <form action="/task/create" method="post">
            <div class="form-group">
                <label>Имя пользователя</label>
                <input name="name" type="text" class="form-control <?php echo $errors['name'] ? 'is-invalid' : '' ?>"
                       placeholder="Имя пользователя"
                       value="<?php echo $data['name'] ?>"/>
                <div class="invalid-feedback">
                    <?php echo $errors['name'] ?>
                </div>
            </div>
            <div class="form-group">
                <label>Электронная почта</label>
                <input name="email" type="email" class="form-control <?php echo $errors['email'] ? 'is-invalid' : '' ?>"
                       placeholder="Электронная почта"
                       value="<?php echo $data['email'] ?>"/>
                <div class="invalid-feedback">
                    <?php echo $errors['email'] ?>
                </div>
            </div>
            <div class="form-group">
                <label>Задача</label>
                <textarea name="text" class="form-control <?php echo $errors['text'] ? 'is-invalid' : '' ?>"
                          placeholder="Задача"><?php echo $data['text'] ?></textarea>
                <div class="invalid-feedback">
                    <?php echo $errors['text'] ?>
                </div>
            </div>
            <input type="submit" value="Сохранить" class="btn btn-primary"/>
        </form>


    </div>
</div>


</body>
</html>

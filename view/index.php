<?php
include_once 'layout/header.php';
?>

<h1><?= $title ?></h1>

<table class="table table-remotes">
    <thead>
        <tr>
            <th> Вылет из аэропрта</th>
            <th> Город вылета </th>
            <th> Прилет в аэропорт </th>
            <th> Город прилета </th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $route): ?>
            <tr>
                <td> <?= $route['airoport_from_en'] ?> (<?= $route['airoport_from_ru'] ?>) </td>
                <td> <?= $route['city_from'] ?> </td>
                <td> <?= $route['airoport_to_en'] ?> (<?= $route['airoport_to_ru'] ?>) </td>
                <td> <?= $route['city_to'] ?> </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<div id="form-result"></div>
<form method="post" id="form-route" action=<?= $_SERVER['REQUEST_URI'] ?>>
    <div class="row">
        <div class="col">
            <input type="text" class="form-control" id="airport-from" name="airport-from" placeholder="От куда" />
        </div>
        <div class="col">
            <input type="text" class="form-control" id="airport-to" name="airport-to" placeholder="Куда" />
        </div>
        <div class="col">
            <input type="submit" class="btn form-control btn-primary" id="submitRoute" value="Сохранить" />
        </div>
    </div>
</form>


<?php
include_once 'layout/footer.php';
?>
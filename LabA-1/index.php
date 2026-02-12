<?php
$title = "Ильина А.А. | Группа 241-352 | ЛР А-1 | Наутилус: легенда глубин";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <?php
        $name='Легенда глубин';
        $link='index.php';
        $current_page=true;
        echo '<a href="'.$link.'"';
    ?><?php
        if($current_page) echo ' class="selected_menu"';
        echo '>'.$name.'</a>';
    ?>

    <?php
        $name='Характеристики';
        $link='nautilus.php';
        $current_page=false;
        echo '<a href="'.$link.'"';
    ?><?php
        if($current_page) echo ' class="selected_menu"';
        echo '>'.$name.'</a>';
    ?>

    <?php
        $name='Экипаж';
        $link='crew.php';
        $current_page=false;
        echo '<a href="'.$link.'"';
    ?><?php
        if($current_page) echo ' class="selected_menu"';
        echo '>'.$name.'</a>';
    ?>
</header>

<main>
    <h1>Наутилус: легенда глубин</h1>

    <h2>Подводная эпоха механики</h2>
    <p>
        Роман Жюля Верна «20 000 лье под водой» можно представить как хронику мира,
        где океан стал территорией прогресса. Пока на поверхности люди спорят о власти
        и границах, капитан Немо создал собственную цивилизацию под толщей воды.
        Его корабль «Наутилус» – инженерное чудо, похожее на механического кита,
        скользящего в тёмной бездне.
    </p>

    <h2>Капитан Немо – хозяин глубин</h2>
    <p>
        Немо – это не просто капитан. Это символ свободы, одиночества и мести.
        Он отказался от мира суши и построил подводную крепость, где шестерёнки,
        электрические цепи и металлические переборки заменяют привычную жизнь.
        «Наутилус» для него – дом, лаборатория и оружие одновременно.
    </p>

    <table>
        <?php
            echo "<tr><th>Элемент</th><th>Описание</th><th>Стимпанк-образ</th></tr>";
        ?>
        <tr>
            <td><?php echo "Наутилус"; ?></td>
            <td><?php echo "Подводный корабль"; ?></td>
            <td><?php echo "Стальной левиафан с электрическим сердцем"; ?></td>
        </tr>
    </table>

    <?php
    if(date('s') % 2 === 0) {
        $img1="images/nautilus1.jpg";
        $img2="images/nautilus2.jpg";
    } else {
        $img1="images/nautilus3.png";
        $img2="images/illustration2.jpg";
    }
    ?>

    <div class="image-row">
        <img src="<?php echo $img1; ?>" alt="Наутилус">
        <img src="<?php echo $img2; ?>" alt="Подводный мир">
    </div>

</main>

<footer>
    <?php echo "Сформировано ".date("d.m.Y")." в ".date("H-i:s", strtotime('+3 hours')); ?>
</footer>

</body>
</html>

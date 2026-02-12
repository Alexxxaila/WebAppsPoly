<?php
$title = "Ильина А.А. | Группа 241-352 | ЛР А-1 | Капитан Немо и экипаж";
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
        $current_page=false;
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
        $current_page=true;
        echo '<a href="'.$link.'"';
    ?><?php
        if($current_page) echo ' class="selected_menu"';
        echo '>'.$name.'</a>';
    ?>
</header>

<main>
    <h1>Капитан Немо и экипаж «Наутилуса»</h1>

    <h2>Люди, исчезнувшие с поверхности</h2>
    <p>
        Экипаж «Наутилуса» напоминает тайный подводный орден. Эти люди отказались от
        обычной жизни и стали частью машины. Они молчаливы, дисциплинированы и преданы
        капитану. Кажется, что для них океан стал новым небом, а металл корабля – новой землёй.
    </p>

    <h2>Профессор Аронакс и конфликт миров</h2>
    <p>
        Аронакс попадает на «Наутилус» как наблюдатель, но быстро понимает:
        перед ним не просто чудо техники, а отдельный мир. Его восхищение наукой
        сталкивается со страхом перед идеей Немо – человеком, который решил жить
        вне человечества. Их спор – это спор разума и одиночества.
    </p>

    <table>
        <?php
            echo "<tr><th>Персонаж</th><th>Роль</th><th>Описание</th></tr>";
        ?>
        <tr>
            <td><?php echo "Капитан Немо"; ?></td>
            <td><?php echo "Командир"; ?></td>
            <td><?php echo "Гений, изгнанник, хозяин глубин"; ?></td>
        </tr>
    </table>

    <?php
    if(date('s') % 2 === 0) {
        $img1="images/nemo.png";
        $img2="images/illustration1.jpg";
    } else {
        $img1="images/nemo2.png";
        $img2="images/crew1.png";
    }
    ?>

    <div class="image-row">
        <img src="<?php echo $img1; ?>" alt="Капитан Немо">
        <img src="<?php echo $img2; ?>" alt="Экипаж Наутилуса">
    </div>

</main>

<footer>
    <?php echo "Сформировано ".date("d.m.Y")." в ".date("H-i:s", strtotime('+3 hours')); ?>
</footer>

</body>
</html>

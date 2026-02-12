<?php
$title = "Ильина А.А. | Группа 241-352 | ЛР А-1 | Характеристики Наутилуса";
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
        $current_page=true;
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
    <h1>Технические характеристики «Наутилуса»</h1>

    <h2>Корпус, созданный для бездны</h2>
    <p>
        «Наутилус» – корабль, который опередил своё время. Его корпус выдерживает давление
        океана, а электрические системы делают его независимым от угля и воздуха поверхности.
        В стимпанк-стилистике это выглядит как гигантский бронзовый механизм, спрятанный
        под волнами, где каждый винт – часть идеальной машины.
    </p>

    <h2>Основные размеры и скорость</h2>
    <p>
        Ниже представлены главные параметры корабля. Они объясняют, почему «Наутилус»
        мог уходить от преследования и быть почти неуязвимым.
    </p>

    <table>
        <?php
            echo "<tr><th>Длина</th><th>Ширина</th><th>Скорость</th></tr>";
        ?>
        <tr>
            <td><?php echo "70 метров"; ?></td>
            <td><?php echo "8 метров"; ?></td>
            <td><?php echo "до 50 км/ч"; ?></td>
        </tr>
    </table>

    <?php
    if(date('s') % 2 === 0) {
        $img1="images/nautilus_scheme1.jpg";
        $img2="images/mech1.png";
    } else {
        $img1="images/nautilus_scheme2.jpg";
        $img2="images/nautilus4.png";
    }
    ?>

    <div class="image-row">
        <img src="<?php echo $img1; ?>" alt="Чертёж Наутилуса">
        <img src="<?php echo $img2; ?>" alt="Иллюстрация">
    </div>

</main>

<footer>
    <?php echo "Сформировано ".date("d.m.Y")." в ".date("H-i:s", strtotime('+3 hours')); ?>
</footer>

</body>
</html>

<?php
/**
 * Модуль delete.php
 * Удаление записей
 */

// Параметры подключения к БД
$host = 'localhost';
$user = 'labuser';
$password = 'labpass';
$dbname = 'notebook';

// Подключаемся к БД
$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die('Ошибка подключения к БД: ' . $conn->connect_error);
}
$conn->set_charset('utf8');

// Получаем список всех записей
$sql = "SELECT id, surname, name, patronymic FROM contacts ORDER BY surname, name";
$result = $conn->query($sql);

$message = '';
$messageType = '';

// Обработка удаления
if (isset($_GET['delete_id'])) {
    $deleteId = (int)$_GET['delete_id'];
    
    // Получаем фамилию удаляемой записи для сообщения
    $getNameSql = "SELECT surname, name, patronymic FROM contacts WHERE id = $deleteId";
    $nameResult = $conn->query($getNameSql);
    $deletedName = '';
    
    if ($nameResult && $nameResult->num_rows > 0) {
        $row = $nameResult->fetch_assoc();
        $deletedName = $row['surname'] . ' ' . $row['name'];
        if (!empty($row['patronymic'])) {
            $deletedName .= ' ' . $row['patronymic'];
        }
    }
    
    // Удаляем запись
    $deleteSql = "DELETE FROM contacts WHERE id = $deleteId";
    if ($conn->query($deleteSql) === TRUE) {
        $message = 'Запись "' . htmlspecialchars($deletedName) . '" успешно удалена.';
        $messageType = 'success';
        // Обновляем список
        $result = $conn->query("SELECT id, surname, name, patronymic FROM contacts ORDER BY surname, name");
    } else {
        $message = 'Ошибка при удалении записи: ' . $conn->error;
        $messageType = 'error';
    }
}

?>

<h2>Удаление записи</h2>

<?php if ($message): ?>
    <div class="message-<?php echo $messageType; ?>"><?php echo $message; ?></div>
<?php endif; ?>

<div class="links-list">
    <strong>Выберите запись для удаления:</strong><br><br>
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $displayName = $row['surname'] . ' ' . mb_substr($row['name'], 0, 1) . '.';
            if (!empty($row['patronymic'])) {
                $displayName .= ' ' . mb_substr($row['patronymic'], 0, 1) . '.';
            }
            echo '<a href="?p=delete&delete_id=' . $row['id'] . '" onclick="return confirm(\'Вы уверены, что хотите удалить запись "' . $displayName . '"?\')">' . $displayName . '</a>';
        }
    } else {
        echo '<div class="message-error">В записной книжке пока нет записей для удаления.</div>';
    }
    ?>
</div>

<a href="?p=viewer" class="btn">Вернуться к просмотру</a>

<?php $conn->close(); ?>
<?php
/**
 * Модуль edit.php
 * Редактирование существующих записей
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

// Определяем текущую запись
$currentId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Обработка отправки формы редактирования
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'edit') {
    $editId = (int)$_POST['id'];
    
    $surname = $conn->real_escape_string($_POST['surname']);
    $name = $conn->real_escape_string($_POST['name']);
    $patronymic = $conn->real_escape_string($_POST['patronymic']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $birthDate = $conn->real_escape_string($_POST['birth_date']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $email = $conn->real_escape_string($_POST['email']);
    $address = $conn->real_escape_string($_POST['address']);
    $comment = $conn->real_escape_string($_POST['comment']);
    
    $sql = "UPDATE contacts SET 
            surname='$surname', 
            name='$name', 
            patronymic='$patronymic', 
            gender='$gender', 
            birth_date='$birthDate', 
            phone='$phone', 
            email='$email', 
            address='$address', 
            comment='$comment' 
            WHERE id=$editId";
    
    if ($conn->query($sql) === TRUE) {
        $message = 'Запись успешно изменена!';
        $messageType = 'success';
        $currentId = $editId;
    } else {
        $message = 'Ошибка: запись не изменена. ' . $conn->error;
        $messageType = 'error';
    }
}

// Получаем список всех записей для отображения ссылок
$sql = "SELECT id, surname, name, patronymic FROM contacts ORDER BY surname, name";
$result = $conn->query($sql);

// Получаем данные текущей записи
$currentRecord = null;

if ($result && $result->num_rows > 0) {
    // Если передан id в GET, ищем эту запись
    if ($currentId > 0) {
        $sqlCurrent = "SELECT * FROM contacts WHERE id = $currentId";
        $currentResult = $conn->query($sqlCurrent);
        if ($currentResult && $currentResult->num_rows > 0) {
            $currentRecord = $currentResult->fetch_assoc();
        }
    }
    
    // Если запись не найдена (нет id или неверный id), берем ПЕРВУЮ
    if (!$currentRecord) {
        // Сбрасываем указатель результата на начало
        $result->data_seek(0);
        $firstRow = $result->fetch_assoc();
        $currentId = $firstRow['id'];
        
        // Получаем полные данные первой записи
        $sqlCurrent = "SELECT * FROM contacts WHERE id = $currentId";
        $currentResult = $conn->query($sqlCurrent);
        if ($currentResult && $currentResult->num_rows > 0) {
            $currentRecord = $currentResult->fetch_assoc();
        }
        
        // Сбрасываем указатель обратно для вывода списка
        $result->data_seek(0);
    }
}

?>

<h2>Редактирование записи</h2>

<?php if ($message): ?>
    <div class="message-<?php echo $messageType; ?>"><?php echo $message; ?></div>
<?php endif; ?>

<div class="links-list">
    <strong>Выберите запись для редактирования:</strong><br><br>
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $displayName = htmlspecialchars($row['surname'] . ' ' . $row['name']);
            if ($row['id'] == $currentId) {
                echo '<div class="current">' . $displayName . '</div>';
            } else {
                echo '<a href="?p=edit&id=' . $row['id'] . '">' . $displayName . '</a>';
            }
        }
    } else {
        echo '<div class="message-error">В записной книжке пока нет записей.</div>';
    }
    ?>
</div>

<?php if ($currentRecord): ?>
    <form method="post" action="" class="edit-form">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" value="<?php echo $currentRecord['id']; ?>">
        
        <div class="form-row">
            <div class="form-group">
                <label>Фамилия *</label>
                <input type="text" name="surname" value="<?php echo htmlspecialchars($currentRecord['surname']); ?>" required>
            </div>
            <div class="form-group">
                <label>Имя *</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($currentRecord['name']); ?>" required>
            </div>
            <div class="form-group">
                <label>Отчество</label>
                <input type="text" name="patronymic" value="<?php echo htmlspecialchars($currentRecord['patronymic']); ?>">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Пол</label>
                <div class="radio-group">
                    <input type="radio" name="gender" value="m" id="male" <?php echo $currentRecord['gender'] == 'm' ? 'checked' : ''; ?>>
                    <label for="male">Мужской</label>
                    <input type="radio" name="gender" value="f" id="female" <?php echo $currentRecord['gender'] == 'f' ? 'checked' : ''; ?>>
                    <label for="female">Женский</label>
                </div>
            </div>
            <div class="form-group">
                <label>Дата рождения</label>
                <input type="date" name="birth_date" value="<?php echo $currentRecord['birth_date']; ?>">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Телефон</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($currentRecord['phone']); ?>">
            </div>
            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($currentRecord['email']); ?>">
            </div>
        </div>
        
        <div class="form-group">
            <label>Адрес</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($currentRecord['address']); ?>">
        </div>
        
        <div class="form-group">
            <label>Комментарий</label>
            <textarea name="comment"><?php echo htmlspecialchars($currentRecord['comment']); ?></textarea>
        </div>
        
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="?p=viewer" class="btn">Вернуться к просмотру</a>
    </form>
<?php else: ?>
    <div class="message-error">Нет записей для редактирования.</div>
<?php endif; ?>

<?php $conn->close(); ?>
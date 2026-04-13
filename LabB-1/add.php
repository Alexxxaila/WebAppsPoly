<?php
/**
 * Модуль add.php
 * Форма для добавления новой записи и обработка отправки
 */

// Параметры подключения к БД
$host = 'localhost';
$user = 'labuser';
$password = 'labpass';
$dbname = 'notebook';

// Обработка отправки формы
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    // Подключаемся к БД
    $conn = new mysqli($host, $user, $password, $dbname);
    if ($conn->connect_error) {
        $message = 'Ошибка подключения к БД: ' . $conn->connect_error;
        $messageType = 'error';
    } else {
        $conn->set_charset('utf8');
        
        // Получаем данные из формы
        $surname = $conn->real_escape_string($_POST['surname']);
        $name = $conn->real_escape_string($_POST['name']);
        $patronymic = $conn->real_escape_string($_POST['patronymic']);
        $gender = $conn->real_escape_string($_POST['gender']);
        $birthDate = $conn->real_escape_string($_POST['birth_date']);
        $phone = $conn->real_escape_string($_POST['phone']);
        $email = $conn->real_escape_string($_POST['email']);
        $address = $conn->real_escape_string($_POST['address']);
        $comment = $conn->real_escape_string($_POST['comment']);
        
        // SQL-запрос на добавление
        $sql = "INSERT INTO contacts (surname, name, patronymic, gender, birth_date, phone, email, address, comment) 
                VALUES ('$surname', '$name', '$patronymic', '$gender', '$birthDate', '$phone', '$email', '$address', '$comment')";
        
        if ($conn->query($sql) === TRUE) {
            $message = 'Запись успешно добавлена!';
            $messageType = 'success';
        } else {
            $message = 'Ошибка: запись не добавлена. ' . $conn->error;
            $messageType = 'error';
        }
        
        $conn->close();
    }
}

// Вывод формы
?>

<h2>Добавление новой записи</h2>

<?php if ($message): ?>
    <div class="message-<?php echo $messageType; ?>"><?php echo $message; ?></div>
<?php endif; ?>

<form method="post" action="" class="add-form">
    <input type="hidden" name="action" value="add">
    
    <div class="form-row">
        <div class="form-group">
            <label>Фамилия *</label>
            <input type="text" name="surname" required>
        </div>
        <div class="form-group">
            <label>Имя *</label>
            <input type="text" name="name" required>
        </div>
        <div class="form-group">
            <label>Отчество</label>
            <input type="text" name="patronymic">
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label>Пол</label>
            <div class="radio-group">
                <input type="radio" name="gender" value="m" id="male" checked>
                <label for="male">Мужской</label>
                <input type="radio" name="gender" value="f" id="female">
                <label for="female">Женский</label>
            </div>
        </div>
        <div class="form-group">
            <label>Дата рождения</label>
            <input type="date" name="birth_date">
        </div>
    </div>
    
    <div class="form-row">
        <div class="form-group">
            <label>Телефон</label>
            <input type="text" name="phone" placeholder="+7 (XXX) XXX-XX-XX">
        </div>
        <div class="form-group">
            <label>E-mail</label>
            <input type="email" name="email">
        </div>
    </div>
    
    <div class="form-group">
        <label>Адрес</label>
        <input type="text" name="address" placeholder="Город, улица, дом, квартира">
    </div>
    
    <div class="form-group">
        <label>Комментарий</label>
        <textarea name="comment" placeholder="Дополнительная информация..."></textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">Добавить запись</button>
    <a href="?p=viewer" class="btn">Вернуться к просмотру</a>
</form>
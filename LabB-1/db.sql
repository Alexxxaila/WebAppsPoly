-- Создание базы данных
CREATE DATABASE IF NOT EXISTS notebook;
USE notebook;

-- Создание таблицы contacts
CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    surname VARCHAR(100) NOT NULL,
    name VARCHAR(100) NOT NULL,
    patronymic VARCHAR(100),
    gender ENUM('m', 'f') DEFAULT 'm',
    birth_date DATE,
    phone VARCHAR(20),
    email VARCHAR(100),
    address VARCHAR(255),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Добавление тестовых данных
INSERT INTO contacts (surname, name, patronymic, gender, birth_date, phone, email, address, comment) VALUES
('Иванов', 'Иван', 'Иванович', 'm', '1990-05-15', '+7 (123) 456-78-90', 'ivanov@example.com', 'Москва, ул. Ленина, д.1', 'Сотрудник отдела IT'),
('Петрова', 'Анна', 'Сергеевна', 'f', '1995-08-22', '+7 (234) 567-89-01', 'petrova@example.com', 'СПб, Невский пр., д.10', 'Менеджер по продажам'),
('Сидоров', 'Петр', 'Алексеевич', 'm', '1988-12-10', '+7 (345) 678-90-12', 'sidorov@example.com', 'Казань, ул. Баумана, д.5', 'Инженер-программист');
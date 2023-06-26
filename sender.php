<?php
// Подключение к базе данных
$host = 'localhost'; // Имя хоста
$username = 'a0833776_222'; // Имя пользователя базы данных
$password = 'I1rVtMLX'; // Пароль пользователя базы данных
$dbname = 'a0833776_222'; // Имя базы данных

// Создание соединения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Выбор базы данных
mysqli_select_db($conn, $dbname);

// Получение данных из формы
$tracking_code = $_POST['tracking_code'];
$sender = $_POST['sender'];
$recipient = $_POST['recipient'];
$departureDate = $_POST['departureDate'];
$status = "6";
$location = $_POST['location'];
$departureType = $_POST['departureType'];
$weight = $_POST['weight'];
$price = $_POST['price'];
$s = "1";

// Подготовка и выполнение запроса SQL для вставки данных в таблицу
$sql = "INSERT INTO DEPARTURES (tracking_code, Sender, Recipient, DepartureDate, Status, Location, DepartureType, Weight, Price, Employee)
        VALUES ('$tracking_code', '$sender', '$recipient', '$departureDate', '$status', '$location', '$departureType', '$weight', '$price', '$s')";

if ($conn->query($sql) === TRUE) {
    echo "Отправление успешно добавлено.";
} else {
    echo "<p class='error'>Ошибка: " . $sql . "<br>" . $conn->error . "</p>";
}

// Закрытие соединения с базой данных
$conn->close();
?>

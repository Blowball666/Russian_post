<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Почта России - Отслеживание</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Отслеживание</h1>   
    </header>

    <nav>
        <ul>
            <li><a href="index.html">Главная</a></li>
            <li><a href="otprav.html">Отправления</a></li>
            <li><a href="dostavka.php">Доставка</a></li>
            <li><a href="otsl.html">Отслеживание</a></li>
        </ul>
    </nav>

    <section>
        <h2>Страница отслеживания</h2>
        <?php
        if (isset($_POST['tracking_code'])) {
            $tracking_code = intval($_POST['tracking_code']);
        
            // Подключение к базе данных
            $host = 'localhost'; // Имя хоста
            $username = 'a0833776_222'; // Имя пользователя базы данных
            $password = 'I1rVtMLX'; // Пароль пользователя базы данных
            $database = 'a0833776_222'; // Имя базы данных
        
            // Установка соединения с базой данных
            $connection = mysqli_connect($host, $username, $password, $database);
        
            // Проверка соединения на ошибки
            if (mysqli_connect_errno()) {
                echo "Ошибка подключения к базе данных: " . mysqli_connect_error();
            }
        
            // Запрос к базе данных для получения результатов отслеживания
            $query = "SELECT ds.Name AS Status, l.Address AS Location 
                      FROM DEPARTURE_STATUSES ds
                      INNER JOIN LOCATIONS l ON ds.id = l.id
                      WHERE ds.id = (SELECT Status FROM DEPARTURES WHERE tracking_code = '$tracking_code')";
            $result = mysqli_query($connection, $query);
        
            // Проверка наличия результатов
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="результат-отслеживания">
                        <h3>Результаты отслеживания для кода: <?= $tracking_code ?></h3>
                        <p>Статус: <?= $row['Status'] ?></p>
                        <p>Место нахождения: <?= $row['Location'] ?></p>
                    </div>
                <?php
                }
            } else {
                echo '<p>Результаты отслеживания не найдены.</p>';
            }
            
            // Закрытие соединения с базой данных
            mysqli_close($connection);
        }
        ?>
    </section>

    <footer>
        <p>&copy; 2023 Почта России. Все права защищены.</p>
</footer>

</body>
</html>

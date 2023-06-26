<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Доставка</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <header>
        <h1>Доставка</h1>
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
        <?php
        // Подключение к базе данных
        $host = 'localhost'; // Имя хоста
        $username = 'a0833776_222'; // Имя пользователя базы данных
        $password = 'I1rVtMLX'; // Пароль пользователя базы данных
        $dbname = 'a0833776_222'; // Имя базы данных
    
        $conn = new mysqli($host, $username, $password, $dbname);
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        // Получение информации о доставке из базы данных
        $sql = "SELECT d.tracking_code, d.Sender, d.Recipient, s.Name AS status_name
                FROM DEPARTURES d
                JOIN DEPARTURE_STATUSES s ON d.Status = s.id";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
            echo "<table>
                    <tr>
                        <th>Код отслеживания</th>
                        <th>Отправитель</th>
                        <th>Получатель</th>
                        <th>Статус</th>
                    </tr>";
        
            // Вывод информации о доставке
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>".$row["tracking_code"]."</td>
                        <td>".$row["Sender"]."</td>
                        <td>".$row["Recipient"]."</td>
                        <td>".$row["status_name"]."</td>
                    </tr>";
            }
        
            echo "</table>";
        } else {
            echo "Нет информации о доставке.";
        }
    
        $conn->close();
        ?>
    </section>
    <footer>
      <p>&copy; 2023 Почта России. Все права защищены.</p>
    </footer>
  </body>
</html>
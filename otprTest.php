<?php
use PHPUnit\Framework\TestCase;

class TrackingTest extends TestCase
{
    private $connection;

    protected function setUp(): void
    {
        $this->connection = new mysqli('localhost', 'a0833776_222', 'I1rVtMLX', 'a0833776_222');
        if ($this->connection->connect_error) {
            die("Ошибка подключения к базе данных: " . $this->connection->connect_error);
        }
    }

    protected function tearDown(): void
    {
        $this->connection->close();
    }

    public function testTrackingResultsFound()
    {
        $trackingCode = 123456;
        $expectedStatus = 'Delivered';
        $expectedLocation = 'Moscow';

        // Подготовка базы данных
        $this->prepareTestData($trackingCode, $expectedStatus, $expectedLocation);

        $_POST['tracking_code'] = $trackingCode;

        // Вызов обрабатывающей функции
        ob_start();
        include 'otsl.html';
        $output = ob_get_clean();

        // Проверка наличия ожидаемых результатов
        $this->assertStringContainsString('Результаты отслеживания для кода: ' . $trackingCode, $output);
        $this->assertStringContainsString('Статус: ' . $expectedStatus, $output);
        $this->assertStringContainsString('Место нахождения: ' . $expectedLocation, $output);
    }

    public function testTrackingResultsNotFound()
    {
        $trackingCode = 654321;

        $_POST['tracking_code'] = $trackingCode;

        // Вызов обрабатывающей функции
        ob_start();
        include 'otsl.html';
        $output = ob_get_clean();

        // Проверка отсутствия результатов
        $this->assertStringContainsString('Результаты отслеживания не найдены.', $output);
    }

    private function prepareTestData($trackingCode, $status, $location)
    {
        // Вставка тестовых данных в базу
        $query = "INSERT INTO DEPARTURE_STATUSES (id, Name) VALUES (1, '$status')";
        $this->connection->query($query);

        $query = "INSERT INTO LOCATIONS (id, Address) VALUES (1, '$location')";
        $this->connection->query($query);

        $query = "INSERT INTO DEPARTURES (tracking_code, Status) VALUES ('$trackingCode', 1)";
        $this->connection->query($query);
    }
}
?>

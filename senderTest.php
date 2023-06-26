<?php
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase
{
    private $conn;

    protected function setUp(): void
    {
        $this->conn = new mysqli('localhost', 'a0833776_222', 'I1rVtMLX', 'a0833776_222');
        if ($this->conn->connect_error) {
            die("Ошибка подключения к базе данных: " . $this->conn->connect_error);
        }
    }

    protected function tearDown(): void
    {
        $this->conn->close();
    }

    public function testInsertDataIntoDeparturesTable()
    {
        $_POST['tracking_code'] = '123456';
        $_POST['sender'] = 'Иванов';
        $_POST['recipient'] = 'Петров';
        $_POST['departureDate'] = '2023-06-21';
        $_POST['location'] = 'Москва';
        $_POST['departureType'] = 'Standard';
        $_POST['weight'] = '2';
        $_POST['price'] = '1000';

        ob_start();
        include 'your_script.php';
        $output = ob_get_clean();

        $expectedOutput = 'Отправление успешно добавлено.';
        $this->assertStringContainsString($expectedOutput, $output);

        // Проверка данных вставленных в таблицу DEPARTURES
        $query = "SELECT * FROM DEPARTURES WHERE tracking_code = '123456'";
        $result = $this->conn->query($query);

        $this->assertTrue($result->num_rows > 0);

        $row = $result->fetch_assoc();
        $this->assertEquals('123456', $row['tracking_code']);
        $this->assertEquals('Иванов', $row['Sender']);
        $this->assertEquals('Петров', $row['Recipient']);
        $this->assertEquals('2023-06-21', $row['DepartureDate']);
        $this->assertEquals('6', $row['Status']);
        $this->assertEquals('Москва', $row['Location']);
        $this->assertEquals('Standard', $row['DepartureType']);
        $this->assertEquals('2', $row['Weight']);
        $this->assertEquals('1000', $row['Price']);
        $this->assertEquals('1', $row['Employee']);
    }
}
?>

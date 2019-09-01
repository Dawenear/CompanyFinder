<?php


namespace App\Models;

use DateInterval;
use DateTime;
use mysqli;

class Database
{
    /** @var mysqli */
    private $database;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        $db = include('config/config.php');
        $this->database = new mysqli($db['servername'], $db['username'], $db['password'], $db['dbname']);
        if ($this->database->connect_error) {
            die("Connection failed: " . $this->database->connect_error);
        }
    }

    /**
     * @param int $ico
     * @return AresResponse|bool
     * @throws \Exception
     */
    public function SearchForCompany($ico)
    {
        $lastMonth = new DateTime();
        $lastMonth->sub(new DateInterval('P1M'));
        $sql = 'SELECT * FROM company WHERE ico =\'' . $ico . '\' AND last_updated > \'' . $lastMonth->format('Y-m-d H:i:s') . '\'';
        $result = $this->database->query($sql);
        if ($result->num_rows === 0) {
            return false;
        }
        $row = $result->fetch_assoc();
        $data = new AresResponse();
        $data->setValues($row['ico'], $row['dic'], $row['psc'], $row['name'], $row['city'], $row['street']);
        return $data;
    }

    /**
     * @param AresResponse $data
     * @return bool
     * @throws \Exception
     */
    public function saveEntryToDB($data)
    {
        $date = new DateTime();
        if (!$this->SearchForCompany($data->getIco())) {
            $sql = <<<SQL
INSERT INTO company (`ico`, `dic`, `name`, `city`, `street`, `psc`, `last_updated`)
VALUES ('{$data->getIco()}', '{$data->getDic()}', '{$data->getName()}', '{$data->getCity()}', '{$data->getStreet()}', '{$data->getPsc()}', '{$date->format('Y-m-d H:i:s')}');
SQL;
            $this->database->query($sql);
            return true;
        }
        $sql = <<<SQL
UPDATE company SET (`dic` = '{$data->getDic()}', `name` = '{$data->getName()}', `city` = '{$data->getCity()}',
`street` = '{$data->getStreet()}', `psc` = '{$data->getPsc()}', `last_updated` = '{$date->format('Y-m-d H:i:s')}');
SQL;
        $this->database->query($sql);
        return true;

    }
}
<?php


//TODO: Add foreign key restraints between customers / cars / tasks. Ensure that cascading deletion is possible
//TODO: (if you delete a customer, their cars and associated tasks should be deleted as well)

class Database
{
    public $db;

    public function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=localhost:3306;dbname=intake', 'root', '');

            //Hiermee geef je aan dat je de een query wilt uitvoren in twee stappen:
            //Je geeft eerste een template mee van de query en daarna pas de waardes van de query
            //wanneer er dan schadelijke code in de query zit wordt dit gelezen als een string en 
            //niks mee gedaan behalfe als een string toetevoegen aan de database.
            $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            //TODO; Als login niet werkt moet de app een waarschuwing weergeven en niet crashen
            // Hij zal nu een foutmelding terug geven en niet gelijk crashen
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            echo $e->getMessage();
            die;
        }
    }

    /***
     * de methode is gebseerd op getAllRows maar dan alleen nog met een prepared statements
     */
    public function getAllRowsSafe($query, $parameters){
        $rows = [];
        $stmt = $this->db->prepare($query);
        $stmt->execute($parameters);
        foreach ($stmt as $row) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function getAllRows($sql)
    {
        $rows = [];
        foreach ($this->db->query($sql) as $row) {
            $rows[] = $row;
        }
        return $rows;
    }

    public function execQuery($sql)
    {
        $count = $this->db->exec($sql);
        return $count;
    }

    /***
     * de methode is gebseerd op execQuery maar dan alleen nog met een prepared statements
     */
    public function execQuerySafe($query, $parameters)
    {
        $preparedStatement = $this->db->prepare($query);
        $count = $preparedStatement->execute($parameters);
        return $count;
    }

}
<?php

include 'Dostawca.php';

class Towar {

    // database connection and table name
    private $conn;
    private $table_name = "towary";
    // object properties
    public $id;
    public $dostawcaid;
    public $dostawca;
    public $nazwa;
    public $opis;
    public $ilosc;
    public $idDostawcy;
    public $nazwaDostawcy;
    public $adresDostawcy;
    public $telefonDostawcy;
    public $emailDostawcy;

    // constructor with $db as database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    function readAll() {
        $query = "SELECT
      t.id, t.dostawcaid, t.nazwa, t.opis, t.ilosc,
      d.id as idDostawcy, d.nazwa as nazwaDostawcy, d.adres as adresDostawcy, d.telefon as telefonDostawcy, d.email as emailDostawcy
      FROM " . $this->table_name . " t
      join dostawcy d on d.id = t.dostawcaid;";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }
//d.id as idDostawcy, d.nazwa as nazwaDostawcy, d.adres as adresDostawcy, d.telefon as telefonDostawcy, d.email as emailDostawcy
    function getById($id) {
        $query = "SELECT t.`ID`, t.dostawcaid, t.nazwa, t.opis, t.ilosc,
      d.id as idDostawcy, d.nazwa as nazwaDostawcy, d.adres as adresDostawcy, d.telefon as telefonDostawcy, d.email as emailDostawcy
      FROM " . $this->table_name . " t join dostawcy d on d.id = t.dostawcaid
      WHERE t.id=" . $id . ";";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (extract($row)) {
            print_r($row);
            exit;
            $towar_item = array(
                "id" => $id,
                "dostawcaid" => $dostawcaid,
                "nazwa" => html_entity_decode($nazwa),
                "opis" => html_entity_decode($opis),
                "ilosc" => $ilosc,
                "dostawca" => array(
                    "id" => $idDostawcy,
                    "nazwa" => $nazwaDostawcy,
                    "adres" => $adresDostawcy,
                    "telefon" => $telefonDostawcy,
                    "email" => $emailDostawcy
                )
            );
            return $towar_item;
        }
        return false;
    }

    function dodajTowar($klient_arr) {
        $query = "INSERT INTO `towary`(`DOSTAWCAID`, `NAZWA`, `OPIS`, `ILOSC`) "
                . "VALUES ('" . $klient_arr["dostawcaid"] . "','" . $klient_arr["nazwa"] . "',"
                . "'" . $klient_arr["opis"] . "'," . $klient_arr["ilosc"] . ");";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    function edytujTowar($klient_arr) {
        $update = "";
        if (isset($klient_arr["dostawcaid"]))
            $update .= "`DOSTAWCAID`='" . $klient_arr["dostawcaid"] . "',";
        if (isset($klient_arr["nazwa"]))
            $update .= "`NAZWA`='" . $klient_arr["nazwa"] . "',";
        if (isset($klient_arr["opis"]))
            $update .= "`OPIS`='" . $klient_arr["opis"] . "',";
        if (isset($klient_arr["ilosc"]))
            $update .= "`ILOSC`=" . $klient_arr["ilosc"] . ",";
        $query = "UPDATE `towary` SET " . substr($update, 0, -1)
                . "WHERE `ID`=" . $klient_arr["id"] . ";";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    function usunTowar($klient_id) {
        $query = "DELETE FROM `towary` WHERE `ID`=" . $klient_id . ";";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

}

?>

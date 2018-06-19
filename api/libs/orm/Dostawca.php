<?php
class Dostawca {

    // database connection and table name
    private $conn;
    private $table_name = "dostawcy";

    // object properties
    public $id;
    public $nazwa;
    public $adres;
    public $telefon;
    public $email;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function readAll() {
      $query = "SELECT
      d.id, d.nazwa, d.adres, d.telefon, d.email
      FROM ".$this->table_name." d;";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }

    function getById($id) {
      $query = "SELECT
      d.id, d.nazwa, d.adres, d.telefon, d.email
      FROM ".$this->table_name." d
      WHERE d.id=".$id.";";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      extract($row);
      $towar_item=array(
          "id" => $id,
          "nazwa" => $nazwa,
          "adres" => $adres,
          "telefon" => $telefon,
          "email" => $email
      );
      return $towar_item;
    }

    function dodajDostawce($klient_arr) {
        $query = "INSERT INTO `dostawcy`(`NAZWA`, `ADRES`, `TELEFON`, `EMAIL`) "
                . "VALUES ('" . $klient_arr["nazwa"] . "','" . $klient_arr["adres"] . "',"
                . "'" . $klient_arr["telefon"] . "','" . $klient_arr["email"] . "');";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    function edytujDostawce($klient_arr) {
        $update = "";
        if (isset($klient_arr["nazwa"]))
            $update .= "`NAZWA`='" . $klient_arr["nazwa"] . "',";
        if (isset($klient_arr["adres"]))
            $update .= "`ADRES`='" . $klient_arr["adres"] . "',";
        if (isset($klient_arr["telefon"]))
            $update .= "`TELEFON`='" . $klient_arr["telefon"] . "',";
        if (isset($klient_arr["email"]))
            $update .= "`EMAIL`='" . $klient_arr["email"] . "',";
        $query = "UPDATE `dostawcy` SET " . substr($update, 0, -1)
                . "WHERE `ID`=" . $klient_arr["id"] . ";";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    function usunDostawce($klient_id) {
        $query = "DELETE FROM `dostawcy` WHERE `ID`=" . $klient_id . ";";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

}
?>

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
}
?>

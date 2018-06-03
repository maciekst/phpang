<?php
include 'Dostawca.php';

class Towar{

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
    public function __construct($db){
        $this->conn = $db;
    }

    function readAll() {
      $query = "SELECT
      t.id, t.dostawcaid, t.nazwa, t.opis, t.ilosc,
      d.id as idDostawcy, d.nazwa as nazwaDostawcy, d.adres as adresDostawcy, d.telefon as telefonDostawcy, d.email as emailDostawcy
      FROM ".$this->table_name." t
      join dostawcy d on d.id = t.dostawcaid;";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }

    function getById($id) {
      $query = "SELECT t.id, t.dostawcaid, t.nazwa, t.opis, t.ilosc,
      d.id as idDostawcy, d.nazwa as nazwaDostawcy, d.adres as adresDostawcy, d.telefon as telefonDostawcy, d.email as emailDostawcy
      FROM ".$this->table_name." join dostawcy d on d.id = t.dostawcaid
      WHERE id=".$id.";";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      extract($row);
      $towar_item=array(
        "id" => $id,
        //"dostawcaid" => $dostawcaid,
        "dostawca" => array(
              "id" => $idDostawcy,
              "nazwa" => $nazwaDostawcy,
              "adres" => $adresDostawcy,
              "telefon" => $telefonDostawcy,
              "email" => $emailDostawcy
            ),
        "nazwa" => html_entity_decode($nazwa),
        "opis" => html_entity_decode($opis),
        "ilosc" => $ilosc
      );
      return $towar_item;
    }
}
?>

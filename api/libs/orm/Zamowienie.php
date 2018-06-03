<?php
class Zamowienie {

    // database connection and table name
    private $conn;
    private $table_name = "zamowienia";

    // object properties
    public $id;
    public $klient;
    public $towar;
    public $ilosc;
    public $identyfikator;
    public $sprzedaz;
    public $idKlient;
    public $nazwaKlient;
    public $adresKlient;
    public $telefonKlient;
    public $emailKlient;
    public $idTowar;
    public $dostawca;
    public $nazwaTowar;
    public $opisTowar;
    public $iloscTowar;
    public $idDostawca;
    public $nazwaDostawca;
    public $adresDostawca;
    public $telefonDostawca;
    public $emailDostawca;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function readAll() {
      $query = "SELECT
      z.id, z.ilosc, z.identyfikator, z.sprzedaz,
      k.id as idKlient, k.nazwa as nazwaKlient, k.adres as adresKlient,
      t.id as idTowar, t.nazwa as nazwaTowar,
      d.id as idDostawca, d.nazwa as nazwaDostawca, d.adres as adresDostawca
      FROM ".$this->table_name." z
      join klienci k on k.id = z.klient
      join towary t on t.id = z.towar
      join dostawcy d on d.id = t.dostawcaid;";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }

}
?>

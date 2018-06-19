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

    function getById($id) {
        $query = "SELECT z.`ID`, z.`TOWAR` as towarid, t.`NAZWA` as towarNazwa, z.`ILOSC` as ilosc, z.`KLIENT` as klient,
            k.`NAZWA` as klientNazwa,
            z.`IDENTYFIKATOR` as identyfikator, z.`SPRZEDAZ` as sprzedaz
            FROM `zamowienia` z
            JOIN `towary` t ON t.`ID` = z.`TOWAR`
            JOIN `klienci` k ON k.`ID` = z.`KLIENT`
            WHERE z.`ID`=" . $id . ";";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
        $towar_item = array(
            "id" => $id,
            "towar" => $towarid,
            "towarNazwa" => $towarNazwa,
            "ilosc" => $ilosc,
            "klient" => $klient,
            "klientNazwa" => $klientNazwa,
            "identyfikator" => $identyfikator,
            "sprzedaz" => $sprzedaz
        );
        return $towar_item;
    }

    function dodajZamowienie($klient_arr) {
        $query = "INSERT INTO `zamowienia`(`TOWAR`, `ILOSC`, `KLIENT`, `IDENTYFIKATOR`, `SPRZEDAZ`) "
                . "VALUES (" . $klient_arr["towar"] . "," . $klient_arr["ilosc"] . ","
                . "" . $klient_arr["klient"] . ",'" . $klient_arr["identyfikator"] . "','"
                . $klient_arr["sprzedaz"] . "');";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    function edytujZamowienie($klient_arr) {
        $update = "";
        if (isset($klient_arr["towar"]))
            $update .= "`TOWAR`='" . $klient_arr["towar"] . "',";
        if (isset($klient_arr["ilosc"]))
            $update .= "`ILOSC`='" . $klient_arr["ilosc"] . "',";
        if (isset($klient_arr["klient"]))
            $update .= "`KLIENT`='" . $klient_arr["klient"] . "',";
        if (isset($klient_arr["identyfikator"]))
            $update .= "`IDENTYFIKATOR`='" . $klient_arr["identyfikator"] . "',";
        if (isset($klient_arr["sprzedaz"]))
            $update .= "`SPRZEDAZ`='" . $klient_arr["sprzedaz"] . "',";
        $query = "UPDATE `zamowienia` SET " . substr($update, 0, -1)
                . "WHERE `ID`=" . $klient_arr["id"] . ";";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    function usunZamowienie($klient_id) {
        $query = "DELETE FROM `zamowienia` WHERE `ID`=" . $klient_id . ";";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

}
?>

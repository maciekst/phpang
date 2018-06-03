<?php
include_once 'Database.php';
include_once 'orm/Zamowienie.php';

class zamowienia {

  static function list($empty) {
    $database = new Database();
    $db = $database->getConnection();

    $towar = new Zamowienie($db);
    $stmt = $towar->readAll();
    $num = $stmt->rowCount();

    if($num>0) {
        $towar_arr=array();
        $towar_arr['zamowienia']=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $towar_item=array(
                "id" => $id,
                "ilosc" => $ilosc,
                "identyfikator" => $identyfikator,
                "sprzedaz" => $sprzedaz,
                "klient" => array(
                  "id" => $idKlient,
                  "nazwa" => $nazwaKlient,
                  "adres" => $adresKlient
                ),
                "towar" => array(
                  "id" => $idTowar,
                  "nazwa" => $nazwaTowar,
                  "dostawca" => array(
                    "id" => $idDostawca,
                    "nazwa" => $nazwaDostawca,
                    "adres" => $adresDostawca
                  )
                )
            );
            array_push($towar_arr['zamowienia'], $towar_item);
        }
        echo json_encode($towar_arr);
    } else {
        echo json_encode( array("message" => "Brak zamowien") );
    }

  }

}

?>

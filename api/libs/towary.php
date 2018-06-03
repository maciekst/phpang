<?php
include_once 'Database.php';
include_once 'orm/Towar.php';

class towary {

  static function list($empty) {
    $database = new Database();
    $db = $database->getConnection();

    $towar = new Towar($db);
    $stmt = $towar->readAll();
    $num = $stmt->rowCount();

    if($num>0) {
        $towar_arr=array();
        $towar_arr['towary']=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
            array_push($towar_arr['towary'], $towar_item);
        }
        echo json_encode($towar_arr);
    } else {
        echo json_encode( array("message" => "Brak towarow") );
    }

  }

}

?>

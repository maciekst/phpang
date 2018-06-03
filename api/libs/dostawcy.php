<?php
include_once 'Database.php';
include_once 'orm/Dostawca.php';

class dostawcy {

  static function list($empty) {
    $database = new Database();
    $db = $database->getConnection();

    $towar = new Dostawca($db);
    $stmt = $towar->readAll();
    $num = $stmt->rowCount();

    if($num>0) {
        $towar_arr=array();
        $towar_arr['dostawcy']=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $towar_item=array(
                "id" => $id,
                "nazwa" => $nazwa,
                "adres" => $adres,
                "telefon" => $telefon,
                "email" => $email
            );
            array_push($towar_arr['dostawcy'], $towar_item);
        }
        echo json_encode($towar_arr);
    } else {
        echo json_encode( array("message" => "Brak dostawcow") );
    }

  }

}

?>

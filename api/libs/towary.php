<?php

include_once 'Database.php';
include_once 'orm/Towar.php';

class towary {

    static function lista($empty) {
        $database = new Database();
        $db = $database->getConnection();

        $towar = new Towar($db);
        $stmt = $towar->readAll();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $towar_arr = array();
            $towar_arr['towary'] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $towar_item = array(
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
            echo json_encode(array("message" => "Brak towarow"));
        }
    }

    static function dodaj($klient_json) {
        if (strlen($klient_json) > 10) {
            $database = new Database();
            $db = $database->getConnection();
            $klient = new Towar($db);
            $klient_arr = json_decode($klient_json, true);
            if ($klient->dodajTowar($klient_arr)) {
                echo '{"message":"ok"}';
            } else {
                echo '{"message":"failure"}';
            }
        } else {
            echo '{"message":"empty parameter"}';
        }
    }

    static function edytuj($klient_json) {
        if (strlen($klient_json) > 10) {
            $database = new Database();
            $db = $database->getConnection();
            $klient = new Towar($db);
            $klient_arr = json_decode($klient_json, true);
            if ($klient->edytujTowar($klient_arr)) {
                echo '{"message":"ok"}';
            } else {
                echo '{"message":"failure"}';
            }
        } else {
            echo '{"message":"empty parameter"}';
        }
    }

    static function usun($klient_id) {
        if (strlen($klient_id) > 0) {
            $database = new Database();
            $db = $database->getConnection();
            $klient = new Towar($db);
            if ($klient->usunTowar($klient_id)) {
                echo '{"message":"ok"}';
            } else {
                echo '{"message":"failure"}';
            }
        } else {
            echo '{"message":"empty parameter"}';
        }
    }

    static function podglad($klient_id) {
        if (isset($klient_id)) {
            $database = new Database();
            $db = $database->getConnection();
            $klient = new Towar($db);
            echo json_encode($klient->getById($klient_id));
        } else {
            echo '{"message":"empty parameter"}';
        }
    }

}

?>

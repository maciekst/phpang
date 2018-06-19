<?php

include_once 'Database.php';
include_once 'orm/Zamowienie.php';

class zamowienia {

    static function lista($empty) {
        $database = new Database();
        $db = $database->getConnection();

        $towar = new Zamowienie($db);
        $stmt = $towar->readAll();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $towar_arr = array();
            $towar_arr['zamowienia'] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $towar_item = array(
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
            echo json_encode(array("message" => "Brak zamowien"));
        }
    }

    static function dodaj($klient_json) {
        if (strlen($klient_json) > 10) {
            $database = new Database();
            $db = $database->getConnection();
            $klient = new Zamowienie($db);
            $klient_arr = json_decode($klient_json, true);
            if ($klient->dodajZamowienie($klient_arr)) {
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
            $klient = new Zamowienie($db);
            $klient_arr = json_decode($klient_json, true);
            if ($klient->edytujZamowienie($klient_arr)) {
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
            $klient = new Zamowienie($db);
            if ($klient->usunZamowienie($klient_id)) {
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
            $klient = new Zamowienie($db);
            echo json_encode($klient->getById($klient_id));
        } else {
            echo '{"message":"empty parameter"}';
        }
    }

}

?>

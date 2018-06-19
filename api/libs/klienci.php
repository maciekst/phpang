<?php

include_once 'Database.php';
include_once 'orm/Klient.php';

class klienci {

    static function lista($empty) {
        $database = new Database();
        $db = $database->getConnection();

        $towar = new Klient($db);
        $stmt = $towar->readAll();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $towar_arr = array();
            $towar_arr['klienci'] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $towar_item = array(
                    "id" => $id,
                    "nazwa" => $nazwa,
                    "adres" => $adres,
                    "telefon" => $telefon,
                    "email" => $email
                );
                array_push($towar_arr['klienci'], $towar_item);
            }
            echo json_encode($towar_arr);
        } else {
            echo json_encode(array("message" => "Brak klientow"));
        }
    }

    static function dodaj($klient_json) {
        if (strlen($klient_json) > 10) {
            $database = new Database();
            $db = $database->getConnection();
            $klient = new Klient($db);
            $klient_arr = json_decode($klient_json, true);
            if ($klient->dodajKlienta($klient_arr)) {
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
            $klient = new Klient($db);
            $klient_arr = json_decode($klient_json, true);
            if ($klient->edytujKlienta($klient_arr)) {
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
            $klient = new Klient($db);
            if ($klient->usunKlienta($klient_id)) {
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
            $klient = new Klient($db);
            echo json_encode($klient->getById($klient_id));
        } else {
            echo '{"message":"empty parameter"}';
        }
    }

}

?>

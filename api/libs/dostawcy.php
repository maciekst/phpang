<?php

include_once 'Database.php';
include_once 'orm/Dostawca.php';

class dostawcy {

    static function lista($empty) {
        $database = new Database();
        $db = $database->getConnection();

        $towar = new Dostawca($db);
        $stmt = $towar->readAll();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $towar_arr = array();
            $towar_arr['dostawcy'] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                extract($row);
                $towar_item = array(
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
            echo json_encode(array("message" => "Brak dostawcow"));
        }
    }

    static function dodaj($klient_json) {
        if (strlen($klient_json) > 10) {
            $database = new Database();
            $db = $database->getConnection();
            $klient = new Dostawca($db);
            $klient_arr = json_decode($klient_json, true);
            if ($klient->dodajDostawce($klient_arr)) {
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
            $klient = new Dostawca($db);
            $klient_arr = json_decode($klient_json, true);
            if ($klient->edytujDostawce($klient_arr)) {
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
            $klient = new Dostawca($db);
            if ($klient->usunDostawce($klient_id)) {
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
            $klient = new Dostawca($db);
            echo json_encode($klient->getById($klient_id));
        } else {
            echo '{"message":"empty parameter"}';
        }
    }

}

?>

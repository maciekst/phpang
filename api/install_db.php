<?php

// sklep
// mini tabela config - konfiguracje
// dostawcy -> towary -> klienci

/*
CREATE DATABASE IF NOT EXISTS `angularphpsklep` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;
USE `angularphpsklep`;

SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'angularphpsklep'

*/

$servername = "localhost";
$username = "root";
$password = '';
$dbName = "angularphpsklep";
$dbVersion = (float)1;
$updateDb = false;
$raport = 'Raport tworzenia bazy: <br />';

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("MySQL Connection failed: " . $conn->connect_error);
}
$conn->autocommit=true;
$sql = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'angularphpsklep';";
$conn->query($sql);
if($conn->affected_rows < 1) {
  $sql = "CREATE DATABASE `angularphpsklep` DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci;";
  $conn->query($sql);
  $conn->select_db($dbName);
  $updateDb = true;
  $raport .= 'Baza utworzona<br />';
  $sql = 'DROP TABLE IF EXISTS `config`;';
  $conn->query($sql);
  $sql = 'CREATE TABLE `config` (
    `KLUCZ` varchar(30) COLLATE utf8_polish_ci NOT NULL,
    `WARTOSC` varchar(150) COLLATE utf8_polish_ci NOT NULL,
    `OPIS` text COLLATE utf8_polish_ci
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;';
  $conn->query($sql);
  $sql = 'ALTER TABLE `config` ADD PRIMARY KEY (`KLUCZ`);';
  $conn->query($sql);
  $sql = "INSERT INTO `config` (`KLUCZ`, `WARTOSC`, `OPIS`) VALUES ('DB_VER', '1', 'DB_VERSION');";
  $conn->query($sql);
  $raport .= 'Tabela konfiguracji utworzona<br />';
} else {
  $conn->select_db($dbName);
  $sql = "SELECT `WARTOSC` FROM `CONFIG` WHERE `KLUCZ`='DB_VER' LIMIT 1;";
  $result = $conn->query($sql);
  $realDbVer = $result->fetch_object();
  if((float)$realDbVer->WARTOSC < $dbVersion) {
    $sql = 'DROP TABLE zamowienia;';
    $conn->query($sql);
    $sql = 'DROP TABLE towary;';
    $conn->query($sql);
    $sql = 'DROP TABLE klienci;';
    $conn->query($sql);
    $sql = 'DROP TABLE dostawcy;';
    if($conn->query($sql)) {
      $updateDb = true;
      $raport .= 'Tabele usuniete<br />';
    } else {
      $raport .= 'Błąd usuwania tabel: '.$conn->error.'<br />';
    }
  } else {
    $raport .= 'Baza danych aktualna<br />';
  }
}

if($updateDb) {
  $sql = 'CREATE TABLE `dostawcy` (
    `ID` int(11) NOT NULL,
    `NAZWA` varchar(150) COLLATE utf8_polish_ci NOT NULL,
    `ADRES` varchar(250) COLLATE utf8_polish_ci DEFAULT NULL,
    `TELEFON` varchar(30) COLLATE utf8_polish_ci DEFAULT NULL,
    `EMAIL` varchar(40) COLLATE utf8_polish_ci DEFAULT NULL,
    `DODANO` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;';
  if($conn->query($sql)) {
    $raport .= 'Utworzono tabele dostawcy<br />';
    $sql = 'CREATE TABLE `klienci` (
      `ID` int(11) NOT NULL,
      `NAZWA` varchar(150) COLLATE utf8_polish_ci NOT NULL,
      `ADRES` varchar(250) COLLATE utf8_polish_ci NOT NULL,
      `TELEFON` varchar(40) COLLATE utf8_polish_ci DEFAULT NULL,
      `EMAIL` varchar(50) COLLATE utf8_polish_ci DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;';
    if($conn->query($sql)) {
      $raport .= 'Utworzono tabele klienci<br />';
      $sql = 'CREATE TABLE `towary` (
        `ID` int(11) NOT NULL,
        `DOSTAWCAID` int(11) NOT NULL,
        `NAZWA` varchar(120) COLLATE utf8_polish_ci NOT NULL,
        `OPIS` text COLLATE utf8_polish_ci,
        `ILOSC` decimal(12,4) NOT NULL DEFAULT 0.0000
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;';
      if($conn->query($sql)) {
        $raport .= 'Utworzono tabele klienci<br />';
        $sql = 'CREATE TABLE `zamowienia` (
          `ID` int(11) NOT NULL,
          `TOWAR` int(11) NOT NULL,
          `ILOSC` decimal(12,4) NOT NULL DEFAULT 0.0000,
          `KLIENT` int(11) NOT NULL,
          `IDENTYFIKATOR` varchar(50) COLLATE utf8_polish_ci NOT NULL,
          `SPRZEDAZ` date NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;';
        if($conn->query($sql)) {
          $raport .= 'Utworzono tabele zamowienia<br />';
          $sql = 'ALTER TABLE `dostawcy` ADD PRIMARY KEY (`ID`);';
          $conn->query($sql);
          $sql = 'ALTER TABLE `klienci` ADD PRIMARY KEY (`ID`);';
          $conn->query($sql);
          $sql = 'ALTER TABLE `towary` ADD PRIMARY KEY (`ID`), ADD KEY `DOSTAWCAID` (`DOSTAWCAID`);';
          $conn->query($sql);
          $sql = 'ALTER TABLE `zamowienia`
            ADD PRIMARY KEY (`ID`),
            ADD UNIQUE KEY `UNIQUE_IDENTYFIKATOR` (`IDENTYFIKATOR`),
            ADD KEY `TOWAR` (`TOWAR`),
            ADD KEY `KLIENT` (`KLIENT`);';
          $conn->query($sql);
          $sql = 'ALTER TABLE `dostawcy`
            MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;';
          $conn->query($sql);
          $sql = 'ALTER TABLE `klienci`
            MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;';
          $conn->query($sql);
          $sql = 'ALTER TABLE `towary`
            MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;';
          $conn->query($sql);
          $sql = 'ALTER TABLE `zamowienia`
            MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;';
          $conn->query($sql);
          $sql = 'ALTER TABLE `towary`
            ADD CONSTRAINT `towary_ibfk_1` FOREIGN KEY (`DOSTAWCAID`) REFERENCES `dostawcy` (`ID`);';
          $conn->query($sql);
          $sql = 'ALTER TABLE `zamowienia`
            ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`TOWAR`) REFERENCES `towary` (`ID`),
            ADD CONSTRAINT `zamowienia_ibfk_2` FOREIGN KEY (`KLIENT`) REFERENCES `klienci` (`ID`);';
          if($conn->query($sql)) {
            $raport .= 'Utworzono klucze dla tabel<br />';
            $sql = "INSERT INTO `dostawcy` (`ID`, `NAZWA`, `ADRES`, `TELEFON`, `EMAIL`, `DODANO`) VALUES
            (1, 'SAD MARIANA', 'ROWNIEZ SAD MARIANA', NULL, NULL, '2018-05-26 17:22:54');";
            $conn->query($sql);
            $sql = "INSERT INTO `klienci` (`ID`, `NAZWA`, `ADRES`, `TELEFON`, `EMAIL`) VALUES
            (1, 'ZOSIA', 'DOM ZOSI', '608000000', NULL);";
            $conn->query($sql);
            $sql = "INSERT INTO `towary` (`ID`, `DOSTAWCAID`, `NAZWA`, `OPIS`, `ILOSC`) VALUES
            (1, 1, 'JABLKA', 'swieze jabluszka dla wszystkich', 50.0000);";
            $conn->query($sql);
            $sql = "INSERT INTO `zamowienia` (`ID`, `TOWAR`, `ILOSC`, `KLIENT`, `IDENTYFIKATOR`, `SPRZEDAZ`) VALUES
            (1, 1, '2.0000', 1, 'japkazosi', '2018-05-26');";
            if($conn->query($sql)) {
              $raport .= 'Zasilono tabele poczatkowymi danymi<br />';
              $sql = "UPDATE `CONFIG` SET `WARTOSC` = '".(string)$dbVersion."' WHERE `KLUCZ`='DB_VER';";
              if($conn->query($sql)) {
                $raport .= 'Podniesiono wersje bazy do aktualnej( '.(string)$dbVersion.' )<br />';
              }
            }
          }
        }
      }
    }
  } else {
    $raport .= 'Nie udało się utworzyć tabeli dostawcy<br />';
  }
}

//jak chcesz sprawdzic co sie posypalo :)
echo $raport;

?>

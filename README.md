# Instalacja
## Wywołać z okna przeglądarki stronę /api/install_db.php

# Funkcje API:

## 1. Testowanie API
localhost/<nazwa-projektu>/api/test.php

## 2. API !!!
localhost/<nazwa-projektu>/rest-api/<nazwa-klasy>/<nazwa-akcji>/<dodatkowe-parametry>

<nazwa-klasy> :
Dostępne klasy: towary, klienci, dostawcy, zamowienia

<nazwa-akcji>
Dostępne akcje: lista, dodaj, edytuj, usun

<dodatkowe-parametry>
zapisane jako obiekt w json :-)

Szczegóły akcji!
lista - nie przyjmuje parametrów, zawsze zwraca wszystko
dodaj - parametr z obiektem w json bez id np. klient - http://localhost:9090/rest-api/klienci/dodaj/{"nazwa":"k2","adres":"adr2","telefon":"tel","email":"mail2"}
edytuj - parametry w json - id oraz parametry do zmiany, np. http://localhost:9090/rest-api/klienci/edytuj/{"id":4,"nazwa":"k2test"}
usun - jeden parametr - id, np. http://localhost:9090/rest-api/klienci/usun/4
podglad - jeden parametr - id, np. http://localhost:9090/rest-api/klienci/podglad/1

Nazwy obiektów można sprawdzić wywolujac liste. Sa to te niezagniezdzone.
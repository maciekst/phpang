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
Dostępne akcje: list, add, edit, remove

<dodatkowe-parametry>
Rozdzielamy je podwójnym przecinkiem -> ,,

Szczegóły akcji!
list - nie przyjmuje parametrów, zawsze zwraca wszystko

## 3. Dzialajace przyklady wywolan api:
http://localhost/<nazwa-projektu>/rest-api/klienci
http://localhost/<nazwa-projektu>/rest-api/towary
http://localhost/<nazwa-projektu>/rest-api/dostawcy
http://localhost/<nazwa-projektu>/rest-api/zamowienia

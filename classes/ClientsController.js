app.controller('ClientsController', function($scope, $http) {
    $scope.getAllClients = function() {
        $http.get('http://localhost:9090/api/api.php?module=klienci&action=lista&extra-param=').
        then(function(response) {
            $scope.clientsList = response.data.klienci;
        });
    }
    $scope.addEntity = function() {
        $scope.client = {
            nazwa : $scope.name.fieldValue,
            email : $scope.email.fieldValue,
            adres : $scope.address.fieldValue,
            telefon : $scope.phoneNumber.fieldValue

        }
        $http.get('http://localhost:9090/api/api.php?module=klienci&action=dodaj&extra-param='+JSON.stringify($scope.client));
        $scope.getAllClients();
    }

    $scope.deleteEntity = function(id) {
        $http.get('http://localhost:9090/api/api.php?module=klienci&action=usun&extra-param='+id);
        $scope.getAllClients();
    }

    $scope.toggleInputDataForm = function () {
        $scope.inputDataActive = ! $scope.inputDataActive;
    }

    $scope.inputDataActive = false;
    $scope.name = new ParamItem("name","Imię");
    $scope.email = new ParamItem("email","Email");
    $scope.phoneNumber = new ParamItem("phoneNumber","Telefon");
    $scope.address = new ParamItem("address","Adres");
    $scope.paramsItems = [
            $scope.name,
            $scope.email,
            $scope.phoneNumber,
            $scope.address
        ];
});
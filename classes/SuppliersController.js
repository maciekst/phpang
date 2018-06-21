app.controller('SuppliersController', function($scope, $http) {
    $scope.getAllSuppliers = function() {
        $http.get('http://localhost:9090/api/api.php?module=dostawcy&action=lista&extra-param=').
        then(function(response) {
            $scope.suppliers = response.data.dostawcy;
        });
        return $scope.suppliers;
    }

    $scope.addEntity = function() {
        // $scope.name = $scope.paramsItems.filter(function (value) { return value.key == "name" }).fieldValue;
        $scope.supplier = {
            nazwa : $scope.name.fieldValue,
            email : $scope.email.fieldValue,
            adres : $scope.address.fieldValue,
            telefon : $scope.phoneNumber.fieldValue

        }
        $http.get('http://localhost:9090/api/api.php?module=dostawcy&action=dodaj&extra-param='+JSON.stringify($scope.supplier));
        $scope.getAllSuppliers();
    }

    $scope.deleteEntity = function(id) {
        $http.get('http://localhost:9090/api/api.php?module=dostawcy&action=usun&extra-param='+id);
        $scope.getAllSuppliers();
    }

    $scope.toggleInputDataForm = function () {
        $scope.inputDataActive = ! $scope.inputDataActive;
    }

    $scope.name = new ParamItem("name","Nazwa");
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
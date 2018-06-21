
app.controller('ProductController', function($scope, $http) {
    $scope.getAllProducts = function() {
        $http.get('http://localhost:9090/api/api.php?module=towary&action=lista&extra-param=').
        then(function(response) {
            $scope.products = response.data.towary;
        });

    }

    $scope.supplier = new ParamItem("supplier","Dostawca");
    $scope.name = new ParamItem("name","Nazwa");
    $scope.description = new ParamItem("description", "Opis");
    $scope.amount = new ParamItem("amount", "Ilość");

    $scope.paramsItems = [
        $scope.supplier,
        $scope.name,
        $scope.description,
        $scope.amount
    ];

    $scope.getAllSuppliers = function() {
        $http.get('http://localhost:9090/api/api.php?module=dostawcy&action=lista&extra-param=').
        then(function(response) {
            $scope.suppliers = response.data.dostawcy;
        });
        // return $scope.suppliers;
    }

    $scope.deleteEntity = function(id) {
        $http.get('http://localhost:9090/api/api.php?module=towary&action=usun&extra-param='+id);
        $scope.getAllSuppliers();
    }


    $scope.toggleInputDataForm = function () {
        $scope.inputDataActive = ! $scope.inputDataActive;
        if ($scope.inputDataActive) {
            $scope.getAllSuppliers();
        }
    }

    $scope.addEntity = function () {
        $scope.product = {
            nazwa : $scope.name.fieldValue,
            dostawcaId : $scope.supplier.fieldValue,
            opis : $scope.description.fieldValue,
            ilosc : $scope.amount.fieldValue
        };
        $http.get('http://localhost:9090/api/api.php?module=towary&action=dodaj&extra-param='+JSON.stringify($scope.product));
        $scope.getAllProducts();

    }
});
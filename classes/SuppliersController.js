app.controller('SuppliersController', function($scope, $http) {
    $scope.getAllSuppliers = function() {
        $http.get('http://localhost:9090/api/api.php?module=dostawcy&action=list&extra-param=').
        then(function(response) {
            $scope.suppliers = response.data.dostawcy;
        });
    }
});
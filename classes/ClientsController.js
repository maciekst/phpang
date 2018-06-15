app.controller('ClientsController', function($scope, $http) {
        $scope.getAllClients = function() {
            $http.get('http://localhost:9090/api/api.php?module=klienci&action=list&extra-param=').
            then(function(response) {
                $scope.clientsList = response.data.klienci;
            });
        }
    });
app.controller('ClientsController', function($scope, $http) {
        $scope.getAllClients = function() {
            $http.get('http://localhost:9090/phpang/api/api.php?module=klienci&action=lista&extra-param=').
            then(function(response) {
                $scope.clientsList = response.data.klienci;
            });
        }
    });
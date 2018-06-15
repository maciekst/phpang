app.controller('OrdersController', function($scope, $http) {
    $scope.getAllOrders = function() {
        $http.get('http://localhost:9090/api/api.php?module=zamowienia&action=list&extra-param=').
        then(function(response) {
            $scope.ordersList = response.data.zamowienia;
        });
    }
});
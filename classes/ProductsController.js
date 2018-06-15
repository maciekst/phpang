
app.controller('ProductController', function($scope, $http) {
    $scope.getAllProducts = function() {
        $http.get('http://localhost:9090/api/api.php?module=towary&action=list&extra-param=').
        then(function(response) {
            $scope.products = response.data.towary;
        });
    }
});
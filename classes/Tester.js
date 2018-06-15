app.controller('Tester', function($scope, $http) {
    $http.get('http://localhost:9090/api/test.php').
        then(function(response) {
            $scope.testData = response.data;
        });
});
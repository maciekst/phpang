angular.module('apka', [])
.controller('Tester', function($scope, $http) {
    $http.get('http://localhost/phpang/api/test.php').
        then(function(response) {
            $scope.testData = response.data;
        });
});
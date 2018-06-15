app.controller('ControlPanelController', function($scope) {
    $scope.clientViewName = "Clients";
    $scope.productsViewName = "Products";
    $scope.showClientsPanel = function() {
        $scope.activePanel = $scope.clientViewName;
    }
    $scope.showProductsPanel = function() {
        $scope.activePanel = $scope.productsViewName;
    }
});
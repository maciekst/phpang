app.controller('ControlPanelController', function($scope) {
    $scope.clientViewName = "Clients";
    $scope.productsViewName = "Products";
    $scope.ordersViewName = "Orders";
    $scope.suppliersViewName = "Suppliers";
    $scope.showClientsPanel = function() {
        $scope.activePanel = $scope.clientViewName;
    }
    $scope.showProductsPanel = function() {
        $scope.activePanel = $scope.productsViewName;
    }
    $scope.showOrdersPanel = function() {
        $scope.activePanel = $scope.ordersViewName;
    }
    $scope.showSupplierPanel = function() {
        $scope.activePanel = $scope.suppliersViewName;
    }
});
angular.module('secuneg', ['ngMaterial', 'ngMessages', 'ngTasty', 'ui.bootstrap','datePicker']).
        controller('ToastCtrl', function($scope, $mdToast) {
            $scope.closeToast = function() {
                $mdToast.hide();
            };
        })
        .controller('AppCtrl', ['$scope', '$mdSidenav', function($scope, $mdSidenav) {
                $scope.oneAtATime = true;
                $scope.toggleSidenav = function(menuId) {
                    $mdSidenav(menuId).toggle();
                };
                $scope.navigateTo = function(url) {
                    window.location=(base_url+url);
                };
            }]).config(function($mdThemingProvider) {
  $mdThemingProvider.theme('default')
    .primaryPalette('blue')
    .accentPalette('cyan');
});
function hacerToast(type, msg, toast) {

    toast.show({
        controller: 'ToastCtrl',
        template: '<md-toast class="md-toast ' + type + '"> <span flex>' + msg + '</span> <md-button ng-click="closeToast();">OK</md-button></md-toast>',
        hideDelay: 6000,
        position: 'top rigt'
    });
};

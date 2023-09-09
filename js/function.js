var app = angular.module('mom', ['ngMaterial']);


app.config(function($mdDateLocaleProvider) {
    $mdDateLocaleProvider.formatDate = function(date) {
        return new Date(date).toLocaleDateString();        
    };
});
app.directive('mdDatepicker', function () {
    function link(scope, element, attrs, ngModel) {
        var parser = function (val) {
            //val = new Date(val).toLocaleDateString();
            val = new Date(val);
            val = new Date(Date.UTC(val.getFullYear(), val.getMonth(), val.getDate(), val.getHours(), val.getMinutes(), val.getSeconds()));
            return val;
        };
        var formatter = function (val) {
            if (!val || val == "00-00-0000") {
                //return val;
            } else {
                val = val.split("-");
                val = new Date(val[2], val[1]-1, val[0]);
                return val;
            }
        };
        ngModel.$parsers.push(parser);
        ngModel.$formatters.push(formatter);
    }
    return {
        require: 'ngModel',
        link: link,
        restrict: 'EA',
        priority: 1
    }
});

app.controller("start", function($scope, $http, $mdDialog, $rootScope, $mdToast) {
    $rootScope.limit = 20;
    $rootScope.minDate = new Date();
    

    $scope.login_controlla = function() {
        $http({
            method : "POST",
            url : url + 'ajax/login_controlla.php'
        }).then(
            function success(save) {
                if(save.data.status) {
                    $scope.utente = save.data.response;
                }
                else {
                    // $rootScope.alert_error(save.data.response);
                    // window.location = "index.html";
					$scope.utente = null;
                }
                $scope.login_controlla_completed = true;
            }, 
            function error(response) {
                // $rootScope.alert_error(response.statusText + " \n\n Non c'è connessione!");
                // $scope.logout();
				$scope.utente = null;
                $scope.login_controlla_completed = true;
            }
        );
    }
    $scope.login_controlla();

    $scope.logout = function() {
        $http({
            method : "POST",
            url : url + 'ajax/logout.php'
        }).then(function success(save) {
            if(save.data) {
				$scope.utente = null;
                localStorage.clear();
                window.location = "index.html";
            }
            else {
                $rootScope.alert_error("Logout fallito");
            }

        }, function error(response) {
            // $rootScope.alert_error(response.statusText + " \n\n Non c'è connessione!");
            window.location = "index.html";
        });
    }
    // LOCATION
    $scope.get_page = function() {
        return document.location.pathname.match(/[^\/]+$/)[0];
    };


	$rootScope.go_to = function(path) {
		location.href = path;
	}


    $rootScope.alert_error = function(text) {
        $mdDialog.show(
            $mdDialog.alert()
                .parent(angular.element(document.querySelector('#popupContainer')))
                .clickOutsideToClose(true)
                .title('Errore! :(')
                .textContent(text)
                .ariaLabel('Alert Dialog Demo')
                .ok('Ok!')
        );
    }
    $rootScope.alert_warning = function(text) {
        $mdDialog.show(
            $mdDialog.alert()
                .parent(angular.element(document.querySelector('#popupContainer')))
                .clickOutsideToClose(true)
                .title('Attenzione!')
                .textContent(text)
                .ariaLabel('Alert Dialog Demo')
                .ok('Ok!')
        );
    }
    $rootScope.alert_success = function(text) {
        $mdDialog.show(
            $mdDialog.alert()
                .parent(angular.element(document.querySelector('#popupContainer')))
                .clickOutsideToClose(true)
                .title('Completato!')
                .textContent(text)
                .ariaLabel('Alert Dialog Demo')
                .ok('Ok!')
        );
    }


    var last = {
        bottom: false,
        top: true,
        left: false,
        right: true
    };
  
    $scope.toastPosition = angular.extend({},last);
    $scope.getToastPosition = function() {
        sanitizePosition();

        return Object.keys($scope.toastPosition)
            .filter(function(pos) { return $scope.toastPosition[pos]; })
            .join(' ');
    };
    function sanitizePosition() {
      var current = $scope.toastPosition;
  
      if ( current.bottom && last.top ) current.top = false;
      if ( current.top && last.bottom ) current.bottom = false;
      if ( current.right && last.left ) current.left = false;
      if ( current.left && last.right ) current.right = false;
  
      last = angular.extend({},current);
    }
    $rootScope.toast = function(text) {
        var pinTo = $scope.getToastPosition();
        $mdToast.show(
            $mdToast.simple()
            .textContent(text)
            .position(pinTo )
            .hideDelay(3000)
        );
    }


});


// dialog
function DialogController($scope, $mdDialog, message) {
    $scope.message = message;

    $scope.hide = function() {
        $mdDialog.hide();
    };
    $scope.cancel = function() {
        $mdDialog.cancel();
    };
    $scope.answer = function(answer) {
        $mdDialog.hide(answer);
    };
}
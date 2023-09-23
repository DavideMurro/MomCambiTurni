var app = angular.module('mom');
app.controller("visualizza", function($scope, $http, $mdDialog, $rootScope) {


    $scope.select_cambi = function() {
		$rootScope.pl_loading = true;
        
        $http({
            method : "POST",
            url : url + 'ajax/select_cambi.php',
        }).then(
            function success(response) {
                $scope.cambi = response.data;
                $rootScope.pl_loading = false;
            }, 
            function error(response) {
                $rootScope.alert_error(response.statusText);
                $rootScope.pl_loading = false;
            }
        );
    }
    $scope.select_cambi_last = function() {
        $http({
            method : "POST",
            url : url + 'ajax/select_cambi_last.php',
        }).then(
            function success(response) {
                $scope.cambi = response.data;
                $scope.select_cambi_last_completed = true;
            }, 
            function error(response) {
                $rootScope.alert_error(response.statusText);
                $scope.select_cambi_last_completed = true;
            }
        );
    }
    $scope.delete_cambio = function(cambio, turno) {
		$rootScope.pl_loading = true;
        
        var id = cambio.id;
        if(turno) {
        	var index = $scope.cambi.response[turno].indexOf(cambio);
        } else {
        	var index = $scope.cambi.response.indexOf(cambio);
        }

        $http({
            method : "POST",
            url : url + 'ajax/delete_cambio.php',
            data : {
                id: id
            }
        }).then(
            function success(response) {
                if(response.data.status) {
                    $rootScope.toast("Eliminazione avvenuta con successo!");
        			if(turno) {
                    	$scope.cambi.response[turno].splice(index, 1);    
                    } else {
                        $scope.cambi.response.splice(index, 1);
                    }
                }
                else {
                    $rootScope.alert_warning(response.data.response);
                }
                $rootScope.pl_loading = false;
            }, 
            function error(response) {
                $rootScope.alert_error(response.statusText);
                $rootScope.pl_loading = false;
            }
        );
    }
    $scope.seleziona_cambio = function(cambio, turno) {
        var id = cambio.id;        
        var index = $scope.cambi.response[turno].indexOf(cambio);

        $http({
            method : "POST",
            url : url + 'ajax/seleziona_cambio.php',
            data : {
                id: id
            }
        }).then(
            function success(response) {
                if(response.data.status) {
                    $rootScope.toast("Prenotazione avvenuta con successo! Contatta il tuo collega " + cambio.nome + "!");
                    $scope.cambi.response[turno][index].utente_prenotato = response.data.response;
                }
                else {
                    $rootScope.alert_warning(response.data.response);
                }
            }, 
            function error(response) {
                $rootScope.alert_error(response.statusText);
            }
        );
    }
});


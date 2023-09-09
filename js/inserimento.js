var app = angular.module('mom');
app.controller("inserimento", function($scope, $http, $mdDialog, $rootScope) {
	$scope.mindate = new Date();

	$scope.insert_cambio = function() {
		$rootScope.pl_loading = true;
		$scope.invio = true;

		if($scope.inserimento.$valid) {
			if($scope.inserimento.ora) {
				$scope.inserimento.ora.inizio = document.getElementById('ora_inizio').value;
				$scope.inserimento.ora.fine = document.getElementById('ora_fine').value;
			}

			$http({
	            method : "POST",
	            url : url + 'ajax/insert_cambio.php',
	            data: {
	            	form: $scope.inserimento,
	            }
	        }).then(
	            function success(response) {
	                if(response.data.status) {
	                    $rootScope.toast("Inserimento avvenuto con successo!");

						//document.getElementById("inserimento").reset();
					    //$scope.inserimento.$setPristine();
					    //$scope.inserimento.$setUntouched();
                        
                        location.reload();
	                }
	                else {
	                    $rootScope.alert_warning(response.data.response);
	                }

					$scope.invio = false;
					$rootScope.pl_loading = false;
	            }, 
	            function error(response) {
	                $rootScope.alert_error(response.statusText);
					$scope.invio = false;
					$rootScope.pl_loading = false;
	            }
	        );

		} else {
			$rootScope.alert_warning("Campi non compilati e/o errati. Ricontrolla");
			$scope.invio = false;
			$rootScope.pl_loading = false;
		}
	}
    
    
	$scope.datainizio_datafine = function() {
        val = new Date($scope.inserimento.data);
        val = val.getDate() + "-" + (val.getMonth()+1) + "-" + val.getFullYear();
    	$scope.inserimento.datafine = val;
    }

});


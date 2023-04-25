angular.module('starshipPilotsApp', []);

angular.module('starshipPilotsApp', []).controller('StarshipPilotController', function($scope, $http) {
    $http.get('http://127.0.0.1:8000/api/pilots').then(function(response) {
        $scope.pilots = response.data;
    });

    $http.get('http://127.0.0.1:8000/api/starships').then(function(response) {
        $scope.starships = response.data;
    });

    $http.get('http://127.0.0.1:8000/api/starshipPilot').then(function(response) {

        $scope.starship_pilot = response.data;

    });

    //Obtener nombres de las naves
    $scope.getStarshipName = function(starship_id) {
        for (var i = 0; i < $scope.starships.length; i++) {
            if ($scope.starships[i].id === starship_id) {
                return $scope.starships[i].name;
            }
        }
    };

    //Obtener precios de las naves
    $scope.getStarshipPrice = function(starship_id) {
        for (var i = 0; i < $scope.starships.length; i++) {
            if ($scope.starships[i].id === starship_id) {
                return $scope.starships[i].cost_in_credits;
            }
        }
    };

    //Pasar a base 15
    $scope.base10to15 = function(number) {
        const codes = "0123456789ßÞ¢μ¶";
        let result = "";
        do {
            result = codes[number % 15] + result;
            number = Math.floor(number / 15);
        } while (number > 0);
        return result;
    };

    //Obtener nombres de los pilotos
    $scope.getPilotName = function(pilot_id) {
        for (var i = 0; i < $scope.pilots.length; i++) {
            if ($scope.pilots[i].id === pilot_id) {
                return $scope.pilots[i].name;
            }
        }
    };
    //Agrupar pilotos por nave separados por ,
    $scope.groupPilotsByStarship = function() {
        let grouped = {};

        for (let i = 0; i < $scope.starship_pilot.length; i++) {
            let entry = $scope.starship_pilot[i];
            let starshipId = entry.starship_id;

            if (!grouped[starshipId]) {
                grouped[starshipId] = {
                    starship_id: starshipId,
                    pilots: []
                };
            }
            grouped[starshipId].pilots.push(entry.pilot_id);
        }

        return Object.values(grouped);
    };

    $scope.getPilotsList = function(pilotIds) {
        let pilotNames = pilotIds.map(function(pilotId) {
            return $scope.getPilotName(pilotId);
        });
        return pilotNames.join(', ');
    };

    $scope.linkPilot = function() {
        var starship_id = $scope.selectedStarship.id;
        var pilot_id = $scope.selectedPilot.id;

        $http.post('http://127.0.0.1:8000/api/linkPilot', { starship_id: starship_id, pilot_id: pilot_id })
            .then(function(response) {
                $scope.starship_pilot = response.data;
                $scope.selectedPilot = null;
                $scope.selectedStarship = null;
                $scope.linkPilotForm.$setPristine();
                $scope.linkPilotForm.$setUntouched();
                $scope.successMessage = 'Piloto vinculado correctamente';
                $scope.errorMessage = null;
            })
            .catch(function(error) {
                $scope.errorMessage = 'Error: ' + error.data.message;
                $scope.successMessage = null;
            });
    };

    $scope.unlinkPilot = function() {
        var starship_id = $scope.selectedStarship.id;
        var pilot_id = $scope.selectedPilot.id;

        $http.post('http://127.0.0.1:8000/api/starships/unlinkPilot', { starship_id: starship_id, pilot_id: pilot_id })
            .then(function(response) {
                $scope.starship_pilot = response.data;
                $scope.selectedPilot = null;
                $scope.selectedStarship = null;
                $scope.unlinkPilotForm.$setPristine();
                $scope.unlinkPilotForm.$setUntouched();
                $scope.successMessage = 'Piloto desvinculado correctamente';
                $scope.errorMessage = null;
            })
            .catch(function(error) {
                $scope.errorMessage = 'Error: ' + error.data.message;
                $scope.successMessage = null;
            });
    };

    $scope.deletePilot = function() {
        var pilot_name = $scope.deletePilotName;

        $http.post('http://127.0.0.1:8000/api/deletePilot', { name: pilot_name })
            .then(function(response) {
                $scope.pilots = response.data.pilots;
                $scope.starship_pilot = response.data.starship_pilot;
                $scope.successMessage = 'Piloto eliminado correctamente';
                $scope.errorMessage = null;
            })
            .catch(function(error) {
                $scope.errorMessage = 'Error: ' + error.data.message;
                $scope.successMessage = null;
            });
    };

});
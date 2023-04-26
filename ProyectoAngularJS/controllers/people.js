angular.module('peopleApp', [])
    .controller('PeopleController', function($scope, $http) {
        $http.get('http://127.0.0.1:8000/api/pilots')
            .then(function(response) {
                console.log(response.data);
                $scope.people = response.data;
            });

    });
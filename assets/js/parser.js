require('angular');

angular.module('parserApp', [])
    .controller('ParserController', function ($http) {
        let parser = this;

        parser.existFile = false;

        parser.searchProfile = function () {
            parser.existFile = false;

            $http({
                method: 'GET',
                url: '/profile',
                params: {
                    'keyword': parser.searchKeyword
                }
            }).then(function success(response) {
                parser.existFile = true;
            }, function error(response) {
                console.log(response);
            });

            parser.searchKeyword = null;
        };
    });

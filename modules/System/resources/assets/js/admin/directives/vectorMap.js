(function () {
    'use strict';

    /**
     * vectorMap - Directive for Vector map plugin
     */
    function vectorMap() {
        return {
            restrict: 'A',
            scope: {
                myMapData: '=',
            },
            link: function (scope, element, attrs) {
                element.vectorMap({
                    map: 'world_mill_en',
                    backgroundColor: "transparent",
                    regionStyle: {
                        initial: {
                            fill: '#e4e4e4',
                            "fill-opacity": 0.9,
                            stroke: 'none',
                            "stroke-width": 0,
                            "stroke-opacity": 0
                        }
                    },
                    series: {
                        regions: [
                            {
                                values: scope.myMapData,
                                scale: ["#1ab394", "#22d6b1"],
                                normalizeFunction: 'polynomial'
                            }
                        ]
                    },
                });
            }
        }
    }

    angular
        .module('system')
        .directive('vectorMap', vectorMap);

})();
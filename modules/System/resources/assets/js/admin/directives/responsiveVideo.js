(function () {
    'use strict';


    /**
     * responsibleVideo - Directive for responsive video
     */
    function responsiveVideo() {
        return {
            restrict: 'A',
            link: function (scope, element) {
                var figure = element;
                var video = element.children();
                video
                    .attr('data-aspectRatio', video.height() / video.width())
                    .removeAttr('height')
                    .removeAttr('width')

                //We can use $watch on $window.innerWidth also.
                $(window).resize(function () {
                    var newWidth = figure.width();
                    video
                        .width(newWidth)
                        .height(newWidth * video.attr('data-aspectRatio'));
                }).resize();
            }
        }
    }

    angular
        .module('system')
        .directive('responsiveVideo', responsiveVideo);

})();
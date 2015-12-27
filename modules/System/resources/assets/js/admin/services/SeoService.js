(function () {
    'use strict';

    angular.module('system')
        .factory('SeoService', function (Seo, $timeout) {

            function Service() {

                this.searching = false;
                this.timeouts = [];

                var me = this;

                this.list = function (type, id, locale, success) {
                    Seo.list(type, id, locale, success);
                };

                this.update = function (type, id, locale, seo) {

                    var key = id + 'locale' + locale;

                    if (this.timeouts[key]) {
                        $timeout.cancel(this.timeouts[key]);
                    }

                    this.timeouts[key] = $timeout(function () {
                        return Seo.update(type, id, locale, seo);
                    }, 400);
                };

            }

            return new Service();

        });

})();
(function () {
    'use strict';

    angular.module('shop')
        .factory('CategoryService', function (Category, $timeout, $http) {

            function Service() {

                this.searching = false;
                this.timeouts = [];

                var me = this;

                this.list = function (type, id, success) {
                    Category.list({
                        ownerType: type,
                        ownerId: id
                    }, success);
                };

                this.update = function (category) {

                    if (this.timeouts[category.id])
                    {
                        $timeout.cancel(this.timeouts[category.id]);
                    }

                    var temp = angular.copy(category);

                    this.timeouts[category.id] = $timeout(function () {
                        return temp.$update();
                    }, 400);
                };

                this.create = function (payload) {
                    var category = new Category({
                        original_id: payload.original_id ? payload.original_id : null,
                        translations : {}
                    });

                    category.translations[payload.locale] = {
                        name: payload.name
                    };

                    return category.$save()
                };

                this.link = function (type, id, category, success) {
                    category = new Category(category);
                    category.$update({
                        ownerType: type,
                        ownerId: id,
                    }, success);
                };

                this.delete = function (type, id, category, success, error) {
                    return category.$delete({
                        ownerType: type,
                        ownerId: id,
                    }).then(success, error);
                };

                this.search = function (params) {
                    return $http.get('api/admin/shop/categories', {
                        params: params
                    }).then(function(response)
                    {
                        return response.data;
                    });
                };

            }

            return new Service();

        });

})();
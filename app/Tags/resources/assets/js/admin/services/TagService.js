angular.module('tags')
    .factory('TagService', function (Tag, $timeout) {

        function Service() {

            this.searching = false;
            this.timeouts = [];

            var me = this;

            this.list = function(type, id, success){
                Tag.list({
                    ownerType: type,
                    ownerId: id
                }, success);
            };

            this.update = function (type, id, tag) {

                if (this.timeouts[tag.id]) {
                    $timeout.cancel(this.timeouts[tag.id]);
                }

                this.timeouts[tag.id] = $timeout(function () {
                    return tag.$update({
                        ownerType: type,
                        ownerId: id
                    });
                }, 400);
            };

            this.create = function (type, id, locale, name, success) {
                tag = new Tag({
                    locale: locale,
                    name: name
                });

                tag.$save({
                    ownerType: type,
                    ownerId: id
                }, success);
            };

            this.link = function (type, id, tag, success) {
                tag = new Tag(tag);
                tag.$update({
                    ownerType: type,
                    ownerId: id,
                }, success);
            };

            this.delete = function (type, id, tag, success, error) {
                return tag.$delete({
                    ownerType: type,
                    ownerId: id,
                }).then(success, error);
            };

            this.search = function (type, id, locale, value) {

                return Tag.query({
                    ownerType: type,
                    ownerId: id,
                    value: value,
                    locale: locale
                }).$promise;
            };

        }

        return new Service();

    });
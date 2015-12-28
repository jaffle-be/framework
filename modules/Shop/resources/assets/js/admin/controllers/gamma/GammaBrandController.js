(function () {
    'use strict';

    angular.module('shop')
        .controller('GammaBrandController', function ($scope, GammaService, Pusher, toaster, System) {

            this.options = {};
            this.gamma = GammaService;
            this.page = 1;
            this.totalItems = 0;

            var me = this;

            me.brands = [];


            this.load = load;
            this.save = save;
            this.subSave = subSave;
            this.saveDetail = saveDetail;
            this.hasAnythingSelected = hasAnythingSelected;
            this.selectedBrand = false;
            this.searchBrand = searchBrand;
            this.clearSelection = clearSelection;

            Pusher.channel.bind('brand_categories.attached', attachBrandCategory);
            Pusher.channel.bind('brand_categories.detached', detachBrandCategory);
            Pusher.channel.bind('gamma.gamma_notification.created', createNotification);
            Pusher.channel.bind('gamma.gamma_notification.confirmed', acceptNotification);
            Pusher.channel.bind('gamma.gamma_notification.denied', denyNotification);
            Pusher.channel.bind('gamma.gamma_selection.deleted', unselectGamma);
            Pusher.channel.bind('gamma.gamma_selection.created', selectGamma);
            Pusher.channel.bind('gamma.brand_selection.created', activateBrand);
            Pusher.channel.bind('gamma.brand_selection.deleted', deactivateBrand);
            Pusher.channel.bind('gamma.category_selection.created', activateCategory);
            Pusher.channel.bind('gamma.category_selection.deleted', deactivateCategory);

            this.load();

            function attachBrandCategory(combinations) {
                //at this moment, there is only one combination per event,
                //due to the way the backend is wired up
                //when attaching, we have a fully loaded payload, not simply ids
                var combination = _.first(combinations);
                var brand = _.first(_.where(me.brands, {id: combination.brand.id}));

                //if the brand is on the page, we'll need to add the category
                if (brand) {
                    brand.categories.push(combination.category);
                    $scope.$apply();
                }
            }

            function detachBrandCategory(combinations) {
                var combination = _.first(combinations);
                var brand = _.first(_.where(me.brands, {id: combination.brand_id}));

                if (brand) {
                    _.remove(brand.categories, function (item) {
                        return item.id == combination.category_id;
                    });
                    $scope.$apply();
                }
            }

            function createNotification(combination) {
                var brand = _.first(_.where(me.brands, {id: combination.brand_id}));

                if (brand) {
                    var category = _.first(_.where(brand.categories, {id: combination.category_id}));

                    if (category) {
                        category.inReview = true;
                        category.selected = combination.type == 'activate';
                        $scope.$apply();
                    }
                }
            }

            function acceptNotification(combination) {
                var brand = _.first(_.where(me.brands, {id: combination.brand_id}));

                if (brand) {
                    var category = _.first(_.where(brand.categories, {id: combination.category_id}));

                    if (category) {
                        category.inReview = false;
                        category.selected = combination.type == 'activate';
                        $scope.$apply();
                    }
                }
            }

            function denyNotification(combination) {
                var brand = _.first(_.where(me.brands, {id: combination.brand_id}));

                if (brand) {
                    var category = _.first(_.where(brand.categories, {id: combination.category_id}));

                    if (category) {
                        category.inReview = false;
                        category.selected = !(combination.type == 'activate');
                        $scope.$apply();
                    }
                }
            }

            function unselectGamma(combination) {
                var brand = _.first(_.where(me.brands, {id: combination.brand_id}));

                if (brand) {
                    var category = _.first(_.where(brand.categories, {id: combination.category_id}));

                    if (category) {
                        category.selected = false;
                        $scope.$apply();
                    }
                }
            }

            function selectGamma(combination) {
                var brand = _.first(_.where(me.brands, {id: combination.brand_id}));

                if (brand) {
                    var category = _.first(_.where(brand.categories, {id: combination.category_id}));

                    if (category) {
                        category.selected = true;
                        $scope.$apply();
                    }
                }
            }

            function activateBrand(combination) {
                var brand = _.first(_.where(me.brands, {id: combination.brand_id}));

                if (brand) {
                    brand.activated = true;
                    $scope.$apply();
                }
            }

            function deactivateBrand(combination) {
                var brand = _.first(_.where(me.brands, {id: combination.brand_id}));

                if (brand) {
                    brand.activated = false;
                    $scope.$apply();
                }
            }

            function activateCategory(combination) {

                _.each(me.brands, function (brand) {
                    var category = _.first(_.where(brand.categories, {id: combination.category_id}));
                    if (category) {
                        category.activated = true;
                    }
                });

                $scope.$apply();
            }

            function deactivateCategory(combination) {
                _.each(me.brands, function (brand) {

                    var category = _.first(_.where(brand.categories, {id: combination.category_id}));
                    if (category) {
                        category.activated = false;
                    }
                });

                $scope.$apply();
            }

            function save(brand) {
                GammaService.brand(brand.id, brand.activated).then(function () {

                }, function (response) {
                    showError(response);
                    brand.activated = !brand.activated;
                });
            }

            function subSave(category) {
                GammaService.category(category.id, category.activated).then(function () {

                }, function (response) {
                    showError(response);
                    category.activated = !category.activated;
                });
            }

            function saveDetail(brand, category) {
                GammaService.detail({
                    brand: brand.id,
                    category: category.id,
                    status: category.selected
                }, function () {
                }, function (response) {
                    showError(response);
                    category.selected = !category.selected;
                });
            };

            function load(item) {

                System.then(function(){
                    me.options = System.options;
                });

                var data = {
                    page: me.page
                };

                //this was passed through the autosuggest
                if (typeof item !== 'undefined') {
                    //value is the id
                    data.brand = item.value;
                    //also remember the selection, so we can clear it
                    //to reload all the results instead of the filtered one.
                    me.selectedBrand = item.value;
                }

                GammaService.brands(data, function (response) {
                    me.brands = response.data;
                    me.page = response.current_page;
                    me.totalItems = response.total;
                });
            }

            function hasAnythingSelected(brand) {
                return _.where(brand.categories, {
                        selected: true
                    }).length > 0;
            }

            function showError(response) {
                var headers = response.headers();
                toaster.error(headers.statustext);
            }

            function searchBrand(value) {
                return GammaService.searchBrand({
                    query: value,
                    locale: me.options.locale
                });
            }

            function clearSelection() {
                me.selectedBrand = false;
                me.searchInput = '';
                me.load();
            }

        });

})();

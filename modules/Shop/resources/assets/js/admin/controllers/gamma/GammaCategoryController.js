(function () {
    'use strict';

    angular.module('shop')
        .controller('GammaCategoryController', function ($scope, GammaService, Pusher, toaster) {

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
            this.selectedCategory = false;
            this.searchCategory = searchCategory;
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
                var category = _.first(_.where(me.categories, {id: combination.category.id}));

                //if the brand is on the page, we'll need to add the category
                if (category)
                {
                    category.brands.push(combination.brand);
                    $scope.$apply();
                }
            }

            function detachBrandCategory(combinations) {
                var combination = _.first(combinations);
                var category = _.first(_.where(me.categories, {id: combination.category_id}));

                if (category)
                {
                    _.remove(category.brands, function (item) {
                        return item.id == combination.brand_id;
                    });
                    $scope.$apply();
                }
            }

            function createNotification(combination) {
                var category = _.first(_.where(me.categories, {id: combination.category_id}));

                if (category)
                {
                    var brand = _.first(_.where(category.brands, {id: combination.brand_id}));

                    if (brand)
                    {
                        brand.inReview = true;
                        brand.selected = combination.type == 'activate';
                        $scope.$apply();
                    }
                }
            }

            function acceptNotification(combination) {
                var category = _.first(_.where(me.categories, {id: combination.category_id}));

                if (category)
                {
                    var brand = _.first(_.where(category.brands, {id: combination.brand_id}));

                    if (brand)
                    {
                        brand.inReview = false;
                        brand.selected = combination.type == 'activate';
                        $scope.$apply();
                    }
                }
            }

            function denyNotification(combination) {
                var category = _.first(_.where(me.categories, {id: combination.category_id}));

                if (category)
                {
                    var brand = _.first(_.where(category.brands, {id: combination.brand_id}));

                    if (brand)
                    {
                        brand.inReview = false;
                        brand.selected = !(combination.type == 'activate');
                        $scope.$apply();
                    }
                }
            }

            function unselectGamma(combination) {
                var category = _.first(_.where(me.categories, {id: combination.category_id}));

                if (category)
                {
                    var brand = _.first(_.where(category.brands, {id: combination.brand_id}));

                    if (brand)
                    {
                        brand.selected = false;
                        $scope.$apply();
                    }
                }
            }

            function selectGamma(combination) {
                var category = _.first(_.where(me.categories, {id: combination.category_id}));

                if (category)
                {
                    var brand = _.first(_.where(category.brands, {id: combination.brand_id}));
                    if (brand)
                    {
                        brand.selected = true;
                        $scope.$apply();
                    }
                }
            }

            function activateBrand(combination) {
                _.each(me.categories, function (category) {
                    var brand = _.first(_.where(category.brands, {id: combination.brand_id}));
                    if (brand)
                    {
                        brand.activated = true;
                    }
                });

                $scope.$apply();
            }

            function deactivateBrand(combination) {
                _.each(me.categories, function (category) {
                    var brand = _.first(_.where(category.brands, {id: combination.brand_id}));
                    if (brand)
                    {
                        brand.activated = false;
                    }
                });

                $scope.$apply();
            }

            function activateCategory(combination) {
                var category = _.first(_.where(me.categories, {id: combination.category_id}));
                if (category)
                {
                    category.activated = true;
                    $scope.$apply();
                }
            }

            function deactivateCategory(combination) {
                var category = _.first(_.where(me.categories, {id: combination.category_id}));
                if (category)
                {
                    category.activated = false;
                    $scope.$apply();
                }
            }

            function save(category) {
                GammaService.category(category.id, category.activated).then(function () {
                }, function (response) {
                    showError(response);
                    category.activated = !category.activated;
                });
            }

            function subSave(brand) {
                GammaService.brand(brand.id, brand.activated).then(function () {
                }, function (response) {
                    showError(response);
                    brand.activated = !brand.activated;
                });
            }

            function saveDetail(category, brand) {
                GammaService.detail({
                    brand: brand.id,
                    category: category.id,
                    status: brand.selected
                }, function () {
                }, function (response) {
                    showError(response);
                    brand.selected = !brand.selected;
                });
            };

            function load(item) {

                var data = {
                    page: me.page
                };

                //this was passed through the autosuggest
                if(typeof item !== 'undefined')
                {
                    //value is the id
                    data.category = item.value;
                    //also remember the selection, so we can clear it
                    //to reload all the results instead of the filtered one.
                    me.selectedCategory = item.value;
                }

                GammaService.categories(data, function (response) {
                    me.categories = response.data;
                    me.page = response.current_page;
                    me.totalItems = response.total;
                });
            }

            function hasAnythingSelected(category) {
                return _.where(category.brands, {
                        selected: true
                    }).length > 0;
            }

            function showError(response) {
                var headers = response.headers();
                toaster.error(headers.statustext);
            }

            function searchCategory(value)
            {
                return GammaService.searchCategory({
                    query: value,
                    locale: me.options.locale
                });
            }

            function clearSelection()
            {
                me.selectedCategory = false;
                me.searchInput = '';
                me.load();
            }

        });

})();
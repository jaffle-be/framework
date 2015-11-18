(function () {
    'use strict';

    angular.module('shop')
        .controller('ProductDetailController', function ($scope, Category, Product, ProductService, $state, $sce, CategoryService) {

            this.products = ProductService;

            var me = this,
                id = $state.params.id;

            this.categoryInput = '';
            this.createCategory = createCategory;
            this.searchCategory = searchCategory;
            this.addCategory = addCategory;
            this.updateCategory = updateCategory;
            this.deleteCategory = deleteCategory;


            this.load = function (id) {

                if (id)
                {
                    this.products.find(id, function (product) {
                        me.product = product;
                    });
                }
                else
                {
                    me.product = new Product();
                }
            };

            this.save = function () {
                ProductService.save(me.product).then(function(response){
                    me.product.translations[me.options.locale].slug = response.translations[me.options.locale].slug
                });
            };

            this.delete = function () {
                ProductService.delete(me.product, function () {
                    $state.go('admin.shop.products');
                });
            };

            this.renderHtml = function (html_code) {
                return $sce.trustAsHtml(html_code);
            };


            function createCategory()
            {
                CategoryService.create(me.options.locale, me.categoryInput).then(function(response)
                {
                    var category = new Category(response);
                    me.categoryInput = '';
                    me.addCategory({value: category.id});
                });
            }

            function searchCategory(query)
            {
                return CategoryService.search({
                    query: query,
                    locale: me.options.locale
                });
            }

            function addCategory(item)
            {
                ProductService.addCategory({
                    product_id: me.product.id,
                    category_id: item.value
                }).then(function(response)
                {
                    var category = new Category(response);
                    me.product.categories.push(category);
                    me.categoryInput = '';
                });
            }

            function updateCategory(category)
            {
                CategoryService.update(category);
            }

            function deleteCategory(item)
            {
                ProductService.removeCategory({
                    product_id: me.product.id,
                    category_id: item.id
                }).then(function(response)
                {
                    _.remove(me.product.categories, function(category){
                        return category.id == item.id
                    });
                });
            }

            this.load(id);

        });

})();
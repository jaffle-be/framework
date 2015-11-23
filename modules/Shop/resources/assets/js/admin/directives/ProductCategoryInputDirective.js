(function () {
    'use strict';

    angular.module('shop')
        .directive('categoryInput', CategoryInput);

    function CategoryInput(){
        return {
            restrict: 'E',
            templateUrl: '/templates/admin/shop/category-input',
            translude: true,
            scope: {
                product: '=',
                locale: '=',
            },
            controller: InputController,
            controllerAs: 'vm',
            bindToController: true,
        }
    }


    InputController.$inject = ['CategoryService', 'ProductService', 'Category'];
    function InputController(CategoryService, ProductService, Category)
    {
        this.services = {
            categories: CategoryService,
            products: ProductService
        };
        this.models = {
            category: Category
        };
        this.categoryInput = '';
        this.hasCategory = function()
        {
            return this.product.hasMainCategory;
        };
        this.createCategory = createCategory;
        this.searchCategory = searchCategory;
        this.addCategory = addCategory;
        this.updateCategory = updateCategory;
        this.deleteCategory = deleteCategory;
    }

    function createCategory()
    {
        //if there are categories,
        //add as synonym

        var me = this;
        var payload = {
            locale: me.locale,
            name: me.categoryInput,
        };

        if(me.hasCategory())
        {
            //add the original idd to the payload,
            //so we know which category we need to create the synonym for.
            payload.original_id = _.first(_.where(me.product.categories, {original_id: null})).id;
        }

        me.services.categories.create(payload).then(function(response)
        {
            var category = new me.models.category(response);
            me.categoryInput = '';
            me.addCategory({value: category.id});
        });
    }

    function searchCategory(query)
    {
        //we do not always want to trigger a search
        //if we have a category set (with all its synonyms)
        //we'll make sure that the search is disabled, so
        //the input will be used as a synonym creator
        var me = this;
        if(me.hasCategory())
        {
            return [];
        }

        return me.services.categories.search({
            query: query,
            locale: me.locale
        });
    }

    function addCategory(item)
    {
        var me = this;
        var payload = {
            product_id: me.product.id,
            category_id: item.value
        };

        me.services.products.addCategory(payload).then(function(response)
        {
            //the actual response will always be an array
            //since we're able to add a category with synonyms.
            _.each(response.categories, function(data){
                var category = new me.models.category(data);
                me.product.categories.push(category);
            });

            if(response.baseProperties)
            {
                me.product.baseProperties = response.baseProperties;
                me.product.propertyGroups = response.propertyGroups;
                me.product.hasMainCategory = true;
            }

            me.categoryInput = '';
        });
    }

    function updateCategory(category)
    {
        var me = this;
        me.services.categories.update(category);
    }

    function deleteCategory(item)
    {
        var me = this;
        me.services.products.removeCategory({
            product_id: me.product.id,
            category_id: item.id
        }).then(function(response)
        {
            if(typeof response.status !== 'undefined')
            {
                //we either did nothing, or flushed
                if(response.status == 'flushed')
                {
                    me.product.categories = [];
                    me.product.baseProperties = [];
                    me.product.propertyGroups = [];
                    me.product.hasMainCategory = false;
                }
            }
            //the category removed was a synonym, only remove that one
            else{
                _.remove(me.product.categories, function(category){
                    return category.id == item.id
                });
            }

        });
    }


})();
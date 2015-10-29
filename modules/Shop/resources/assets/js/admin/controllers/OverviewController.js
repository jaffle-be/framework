angular.module('shop')
    .controller('ProductController', function (Product, ProductService, $state, $scope, $sce) {

        $scope.renderHtml = function(html_code)
        {
            return $sce.trustAsHtml(html_code);
        };

        //start with true so we don't see the layout flash
        this.loading = true;
        this.rpp = 15;
        this.total = 0;
        this.products = [];

        var me = this;

        this.getPage = function(start)
        {
            return page = Math.ceil(start / this.rpp) + 1;
        };

        this.list = function(table) {

            me.table = table;
            me.loading = true;
            //cannot use this here
            var page = me.getPage(table.pagination.start);

            me.loadProducts(page);
        };

        this.loadProducts = function(page)
        {
            var me = this;

            Product.query({
                page: page,
                query: me.table.search.predicateObject ? me.table.search.predicateObject.query : '',
                locale: me.options.locale,
            }, function (response) {

                me.total = response.total;
                me.products = response.data;
                me.table.pagination.numberOfPages = response.last_page;
                me.loading = false;
            });
        };

        this.newProduct = function()
        {
            var product = new Product();
            ProductService.save(product, function(newProduct)
            {
                $state.go('admin.product.detail', {id: newProduct.id});
            });
        };

        this.delete = function()
        {
            var products = this.selectedProducts();

            ProductService.batchDelete(products, function()
            {
                me.loadProducts();
            });

        };

        this.batchPublish = function()
        {
            var products = this.selectedProducts();

            ProductService.batchPublish(products, me.options.locale, function()
            {

            });
        };

        this.batchUnpublish = function()
        {
            var products = this.selectedProducts();

            ProductService.batchUnpublish(products, me.options.locale, function()
            {

            });
        };

        this.selectedProducts = function()
        {
            var products = [],
                me = this;

            _.each(this.products, function(product)
            {
                if(product.isSelected)
                {
                    products.push(product.id);
                }
            });

            return products;
        }
    });
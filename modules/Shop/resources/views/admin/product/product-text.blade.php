<div class="ibox">

    <div class="ibox-title">
        <div class="row">
            <div class="col-xs-8">
                <h5>{{ Lang::get('shop::admin.product.details') }}</h5>
            </div>
            <div class="col-xs-4 text-right">
                <span id="reset" class="btn-sm btn btn-danger" ng-really="vm.delete()"><i class="fa fa-trash"></i></span>
            </div>
        </div>
    </div>

    <div class="ibox-content">

        <form ng-submit="vm.save()" name="productForm" novalidate>

            <input name="locale" type="hidden" value="@{{ vm.options.locale }}"/>

            <div class="row">

                <div class="col-xs-8">
                    <div class="form-group">
                        <label for="title" class="control-label">{{ Lang::get('shop::admin.product.name') }}</label>

                        <div>
                            <input ng-change="vm.save()" autocomplete="off" type="text" name="name" id="name" class="form-control" ng-model="vm.product.translations[vm.options.locale].name"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="title" class="control-label">{{ Lang::get('shop::admin.product.title') }}</label>

                        <div>
                            <input ng-change="vm.save()" autocomplete="off" type="text" name="title" id="title" class="form-control" ng-model="vm.product.translations[vm.options.locale].title"/>
                        </div>
                    </div>

                </div>

                <div class="col-xs-4">

                    <div class="form-group">

                        <div class="control-label">&nbsp;</div>

                        <input type="checkbox" class="filled-in" id="published" ng-model="vm.product.translations[vm.options.locale].published" ng-change="vm.save()"/>
                        <label for="published">{{ Lang::get('shop::admin.product.published') }}</label>

                    </div>
                </div>

                <div class="clearfix"></div>

            </div>

            <div class="form-group">
                <label for="slug" class="control-label">{{ Lang::get('shop::admin.product.slug') }}</label>

                <span class="form-control slug" ng-bind="vm.product.translations[vm.options.locale].slug"></span>
            </div>

            <div class="row">

                <div class="col-md-6">
                    <label for="title" class="control-label">{{ Lang::get('shop::admin.product.ean') }}</label>

                    <div>
                        <input ng-change="vm.save()" autocomplete="off" type="text" name="ean" id="ean" class="form-control" ng-model="vm.product.ean"/>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="title" class="control-label">{{ Lang::get('shop::admin.product.upc') }}</label>

                    <div>
                        <input ng-change="vm.save()" autocomplete="off" type="text" name="upc" id="upc" class="form-control" ng-model="vm.product.upc"/>
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label for="content" class="control-label">{{ Lang::get('shop::admin.product.content') }}</label>

                <div>
                    <textarea auto-size class="form-control autosize-lg" ng-model="vm.product.translations[vm.options.locale].content" ng-change="vm.save()"></textarea>
                </div>
            </div>

            <div class="clearfix"></div>
        </form>

    </div>

</div>
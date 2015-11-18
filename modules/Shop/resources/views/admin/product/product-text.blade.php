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

                <div class="col-md-6 col-xs-8">
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

                <div class="col-md-6 col-xs-4">

                    <div class="form-group">
                        <label for="slug" class="control-label">{{ Lang::get('shop::admin.product.slug') }}</label>

                        <span class="form-control slug" ng-bind="vm.product.translations[vm.options.locale].slug"></span>
                    </div>


                    <div class="form-group">

                        <div class="control-label">&nbsp;</div>

                        <input type="checkbox" class="filled-in" id="published" ng-model="vm.product.translations[vm.options.locale].published" ng-change="vm.save()"/>
                        <label for="published">{{ Lang::get('shop::admin.product.published') }}</label>

                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="title" class="control-label">{{ Lang::get('shop::admin.product.brand') }}</label>

                        <div class="form-control slug" ng-bind-html="vm.renderHtml(vm.product.brand.translations[vm.options.locale].name)"></div>
                    </div>

                </div>


        </form>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="title" class="control-label">{{ Lang::get('shop::admin.product.categories') }}</label>

                        {{--<div>--}}
                        {{--<input ng-change="vm.save()" autocomplete="off" type="text" name="title" id="title" class="form-control" ng-model="vm.product.translations[vm.options.locale].title"/>--}}
                        {{--</div>--}}

                        <form ng-submit="vm.createCategory()" novalidate name="categoryForm">

                            <div class="form-group">

                                <div class="input-group">

                                    <div class="input-group-addon">
                                        <i class="fa fa-refresh" ng-show="searching"></i><i class="fa fa-search" ng-hide="searching"></i>
                                    </div>

                                    <input type="text" class="form-control" placeholder="{{ Lang::get('shop::admin.category') }}"
                                           uib-typeahead="category.label for category in vm.searchCategory($viewValue, locale)"
                                           typeahead-loading="searching"
                                           typeahead-on-select="vm.addCategory($item, $model, $label)"
                                           typeahead-wait-ms="400"
                                           ng-model="vm.categoryInput">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-success"><i class="fa fa-plus"></i>
                                        </button>
                                    </div>

                                </div>

                            </div>

                        </form>

                        <div class="clearfix"></div>

                        <ul class="nav">
                            <li ng-repeat="category in vm.product.categories">

                                <div class="form-group">

                                    <div class="input-group">
                                        <input autocomplete="off" ng-change="vm.updateCategory(category)" class="form-control" type="text" name="@{{ locale }}" ng-model="category.translations[vm.options.locale].name"/>

                                        <div class="input-group-btn">
                                            <button ng-really="vm.deleteCategory(category)" class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </li>
                        </ul>
                    </div>

                </div>

            </div>

            <hr>


    <form ng-submit="vm.save()" name="productForm" novalidate>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="title" class="control-label">{{ Lang::get('shop::admin.product.ean') }}</label>

                        <div>
                            <input ng-change="vm.save()" autocomplete="off" type="text" name="ean" id="ean" class="form-control" ng-model="vm.product.ean"/>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">

                    <div class="form-group">
                        <label for="title" class="control-label">{{ Lang::get('shop::admin.product.upc') }}</label>

                        <div>
                            <input ng-change="vm.save()" autocomplete="off" type="text" name="upc" id="upc" class="form-control" ng-model="vm.product.upc"/>
                        </div>
                    </div>

                </div>

            </div>

            <hr>

            <div class="form-group">
                <label for="content" class="control-label">{{ Lang::get('shop::admin.product.content') }}</label>

                <div>
                    <textarea auto-size class="form-control autosize-lg" ng-model="vm.product.translations[vm.options.locale].content" ng-change="vm.save()"></textarea>
                </div>
            </div>

        </form>

    </div>

</div>
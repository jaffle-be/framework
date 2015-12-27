<div class="ibox" ng-show="!vm.campaign.translations[vm.options.locale].mail_chimp_campaign_id">

    <div class="ibox-content">

        <div class="newsletter-widget" ng-show="vm.campaign.use_intro">

            <div class="newsletter-widget-content">
                <h3 ng-bind-html="vm.renderHtml(vm.showTitle(vm.campaign.translations[vm.options.locale].title))"></h3>
                <br>
                <span
                    ng-bind-html="vm.renderHtml(vm.showText(vm.campaign.translations[vm.options.locale].intro))"></span>
            </div>

            <div class="clearfix"></div>
        </div>

        <div ng-repeat="widget in vm.campaign.widgets" class="newsletter-widget" ng-show="!vm.editing">

            <div class="newsletter-widget-tools col-xs-12">
                <div class="text-center">
                    <button class="btn btn-primary" ng-click="vm.startEditing(widget)"><i class="fa fa-pencil"></i>
                    </button>
                    <button class="btn btn-danger" ng-really="vm.removeWidget(widget)"><i class="fa fa-trash"></i>
                    </button>
                </div>

            </div>

            <div class="newsletter-widget-content" ng-show="!vm.editing"
                 ng-include="'widgets/newsletter/items/' + widget.path"></div>


        </div>

        <div ng-show="vm.editing" class="newsletter-widget newsletter-widget-editor">
            <div class="newsletter-widget-tools">
                <button class="btn btn-info" ng-click="vm.stopEditing()"><i class="fa fa-close"></i></button>
            </div>

            <div class="newsletter-widget-header">

                <div class="switch">
                    <label>
                        <input id="widget@{{ widget.id }}" type="checkbox" ng-model="vm.editing.manual"
                               ng-change="vm.saveWidget(vm.editing)">
                        {{ Lang::get('marketing::admin.manual-item') }}
                        <span class="lever"></span>
                    </label>
                </div>

                <div class="clearfix"></div>

            </div>

            <div ng-show="!vm.editing.manual">
                <div class="form-group">

                    <div ng-switch="" on="vm.configItemCount(vm.editing)">

                        <div ng-switch-when="1">
                            <div class="input-group">

                                <div class="input-group-addon">
                                    <i class="fa fa-search"></i>
                                </div>

                                <input type="text" class="form-control"
                                       uib-typeahead="item.label for item in vm.searchElement($viewValue, vm.options.locale)"
                                       typeahead-loading="searching"
                                       typeahead-on-select="vm.linkElement($item, 'one')"
                                       typeahead-wait-ms="400"
                                       ng-model="input">

                            </div>

                        </div>

                        <div ng-switch-when="2">

                            <h3>{{ Lang::get('marketing::admin.left') }}</h3>

                            <div class="form-group">
                                <div class="input-group">

                                    <div class="input-group-addon">
                                        <i class="fa fa-search"></i>
                                    </div>

                                    <input type="text" class="form-control"
                                           uib-typeahead="item.label for item in vm.searchElement($viewValue, vm.options.locale)"
                                           typeahead-loading="searching"
                                           typeahead-on-select="vm.linkElement($item, 'one')"
                                           typeahead-wait-ms="400"
                                           ng-model="input_one">

                                </div>

                            </div>

                            <h3>{{ Lang::get('marketing::admin.right') }}</h3>

                            <div class="form-group">
                                <div class="input-group">

                                    <div class="input-group-addon">
                                        <i class="fa fa-search"></i>
                                    </div>

                                    <input type="text" class="form-control"
                                           uib-typeahead="item.label for item in vm.searchElement($viewValue, vm.options.locale)"
                                           typeahead-loading="searching"
                                           typeahead-on-select="vm.linkElement($item, 'two')"
                                           typeahead-wait-ms="400"
                                           ng-model="input_two">

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            </div>

            <div ng-show="vm.editing.manual" ng-switch="" on="vm.configItemCount(vm.editing)">

                <div ng-switch-when="1">

                    <div class="form-group">
                        <label class="control-label">{{ Lang::get('marketing::admin.title') }}</label>
                        <input type="text" class="form-control"
                               ng-model="vm.editing.translations[vm.options.locale].title"
                               ng-change="vm.saveWidget(vm.editing)">
                    </div>

                    <div class="form-group">
                        <label class="control-label">{{ Lang::get('marketing::admin.text') }}</label>
                        <textarea class="form-control" auto-size
                                  ng-model="vm.editing.translations[vm.options.locale].text"
                                  ng-change="vm.saveWidget(vm.editing)"></textarea>
                    </div>

                    <div>
                        <label class="control-label">{{ Lang::get('marketing::admin.images') }}</label>
                    </div>

                    <div ng-repeat="image in vm.campaign.images" style="max-width: 150px;" class="pull-left">
                        <input type="radio" id="widget@{{ vm.editing.id }}image@{{ image.id }}"
                               ng-model="vm.editing.image_id" ng-value="image.id"
                               ng-change="vm.selectWidgetImage('image_id')"/>
                        <label for="widget@{{ vm.editing.id }}image@{{ image.id}}" style="height: auto;"><img
                                class="img-responsive" ng-src="@{{image.path}}"/></label>
                    </div>


                    <div class="clearfix"></div>

                </div>

                <div ng-switch-when="2">

                    <h3>{{ Lang::get('marketing::admin.left') }}</h3>

                    <div class="form-group">
                        <label class="control-label">{{ Lang::get('marketing::admin.title') }}</label>
                        <input type="text" class="form-control"
                               ng-model="vm.editing.translations[vm.options.locale].title_left"
                               ng-change="vm.saveWidget(vm.editing)">
                    </div>

                    <div class="form-group">
                        <label class="control-label">{{ Lang::get('marketing::admin.text') }}</label>
                        <textarea class="form-control" auto-size
                                  ng-model="vm.editing.translations[vm.options.locale].text_left"
                                  ng-change="vm.saveWidget(vm.editing)"></textarea>
                    </div>

                    <div>
                        <label class="control-label">{{ Lang::get('marketing::admin.images') }}</label>
                    </div>

                    <div ng-repeat="image in vm.campaign.images">
                        <input type="radio" id="widget@{{ vm.editing.id }}image_left@{{ image.id }}"
                               ng-model="vm.editing.image_left_id" ng-value="image.id"
                               ng-change="vm.selectWidgetImage('image_left_id')"/>
                        <label for="widget@{{ vm.editing.id }}image_left@{{ image.id}}" style="height: auto;"><img
                                class="img-responsive" ng-src="@{{image.path}}"/></label>
                    </div>

                    <div class="clearfix"></div>

                    <h3>{{ Lang::get('marketing::admin.right') }}</h3>

                    <div class="form-group">
                        <label class="control-label">{{ Lang::get('marketing::admin.title') }}</label>
                        <input type="text" class="form-control"
                               ng-model="vm.editing.translations[vm.options.locale].title_right"
                               ng-change="vm.saveWidget(vm.editing)">
                    </div>

                    <div class="form-group">
                        <label class="control-label">{{ Lang::get('marketing::admin.text') }}</label>
                        <textarea class="form-control" auto-size
                                  ng-model="vm.editing.translations[vm.options.locale].text_right"
                                  ng-change="vm.saveWidget(vm.editing)"></textarea>
                    </div>

                    <div>
                        <label class="control-label">{{ Lang::get('marketing::admin.images') }}</label>
                    </div>

                    <div ng-repeat="image in vm.campaign.images" style="max-width: 150px;">
                        <input type="radio" id="widget@{{ vm.editing.id }}image_right@{{ image.id }}"
                               ng-model="vm.editing.image_right_id" ng-value="image.id"
                               ng-change="vm.selectWidgetImage('image_right_id')"/>
                        <label for="widget@{{ vm.editing.id }}image_right@{{ image.id}}" style="height: auto;"><img
                                class="img-responsive" ng-src="@{{image.path}}"/></label>
                    </div>

                    <div class="clearfix"></div>

                </div>

            </div>


        </div>

        <div class="clearfix"></div>

    </div>

</div>

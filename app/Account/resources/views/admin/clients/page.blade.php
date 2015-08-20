<div class="wrapper wrapper-content">

    <div class="ibox" ng-controller="ClientsController as vm" ng-init="vm.options = {{ system_options() }}">

        <div class="ibox-title">
            <h5>{{ Lang::get('account::admin.clients.clients') }}</h5>
        </div>

        <div class="ibox-content">

            <tabset>

                <tab ng-repeat="locale in vm.options.locales" heading="@{{ locale.locale }}" active="vm.options.locales[locale.locale].active" select="vm.options.locale = locale.locale">

                </tab>
            </tabset>


            <div class="row">

                <div class="col-md-4">

                    <p class="text-center">
                        <button class="btn btn-primary" ng-click="vm.freshClient()">
                            <i class="fa fa-plus"></i> {{ Lang::get('account::admin.clients.create') }}</button>
                    </p>

                    <ul class="nav clients">
                        <li ng-repeat="client in vm.clients">

                            <div class="row">
                            <span class="col-xs-6">
                                <img ng-show="client.images" ng-src="@{{ client.images.thumbnail('x90') }}" alt=""> @{{ client.name }}
                            </span>
                            <span class="col-xs-6 text-right"><button class="btn btn-info" ng-click="vm.startEditing(client)">
                                    <i class="fa fa-pencil"></i></button>
                            </span>
                            </div>

                        </li>
                    </ul>

                </div>

                <div class="col-md-7 col-md-offset-1" ng-hide="!vm.client">

                    <div class="text-right">
                        <button type="button" class="btn btn-primary" ng-hide="vm.client.id || vm.saving" ng-click="vm.createClient()">
                            <i class="fa fa-save"></i></button>
                        <button type="button" class="btn btn-danger" ng-show="vm.client.id" ng-click="vm.deleteClient()">
                            <i class="fa fa-trash"></i></button>
                        <button type="button" class="btn btn-info" ng-click="vm.stopEditing()"><i class="fa fa-remove"></i>
                        </button>
                    </div>

                    <div class="form-group">

                        <label for="">{{ Lang::get('account::admin.clients.name') }}</label>

                        <input type="text" class="form-control" ng-model="vm.client.name" ng-change="vm.save()">

                    </div>

                    <div class="form-group">

                        <label for="">{{ Lang::get('account::admin.clients.website') }}</label>

                        <input type="text" class="form-control" ng-model="vm.client.website" ng-change="vm.save()">

                    </div>

                    <div class="form-group">

                        <label for="">{{ Lang::get('account::admin.clients.description') }}</label>

                        <input summernote config="vm.options.summernote" type="text" class="form-control" ng-model="vm.client.translations[vm.options.locale].description" ng-change="vm.save()">

                    </div>

                    <image-input ng-hide="!vm.client.id" locale="vm.options.locale" owner-type="'client'" owner-id="vm.client.id" limit="'1'" wait-for="vm.client.id" edits-many="'true'" handlers="vm.imageHandlers"></image-input>

                </div>

            </div>

        </div>

    </div>

</div>
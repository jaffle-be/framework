<div class="row wrapper-content" ng-controller="ClientsController as vm" ng-init="vm.options = {{ system_options() }}">

    @include('system::admin.locale-tabs')

    <div class="ibox">

        <div class="ibox-title">
            <h5>{{ Lang::get('account::admin.clients.clients') }}</h5>
        </div>

        <div class="ibox-content">

            <div class="row">

                <div class="col-md-4">

                    <p class="text-center">
                        <button class="btn btn-primary" ng-click="vm.freshClient()">
                            <i class="fa fa-plus"></i> {{ Lang::get('account::admin.clients.create') }}</button>
                    </p>

                    <ul class="nav clients">
                        <li ng-repeat="client in vm.clients">

                            <div class="row">
                            <span class="col-xs-10">
                                <img ng-show="client.images && client.images[0]"
                                     ng-src="@{{ client.images[0].thumbnail('x90') }}" alt=""> @{{ client.name }}
                            </span>
                            <span class="col-xs-2 text-right"><button class="btn btn-info"
                                                                      ng-click="vm.startEditing(client)">
                                    <i class="fa fa-pencil"></i></button>
                            </span>
                            </div>

                        </li>
                    </ul>

                </div>

                <div class="col-md-7 col-md-offset-1" ng-hide="!vm.client">

                    <div class="text-right">
                        <button type="button" class="btn btn-primary" ng-hide="vm.client.id || vm.saving"
                                ng-click="vm.createClient()">
                            <i class="fa fa-save"></i></button>
                        <button type="button" class="btn btn-danger" ng-show="vm.client.id"
                                ng-really="vm.deleteClient()">
                            <i class="fa fa-trash"></i></button>
                        <button type="button" class="btn btn-info" ng-click="vm.stopEditing()">
                            <i class="fa fa-remove"></i>
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

                        <textarea class="form-control autosize-lg" auto-size type="text" class="form-control"
                                  ng-model="vm.client.translations[vm.options.locale].description"
                                  ng-change="vm.save()"></textarea>

                    </div>

                    <image-input ng-hide="!vm.client.id" locale="vm.options.locale" owner-type="'client'"
                                 owner-id="vm.client.id" limit="'1'" images="vm.client.images"
                                 handlers="vm.imageHandlers"></image-input>

                </div>

            </div>

        </div>

    </div>

</div>

@include('media::admin.image')

<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('portfolio::admin.project.client') }}</h5>
    </div>

    <div class="ibox-content">

        <div class="row">

            <div class="col-xs-6" ng-repeat="client in vm.clients">

                <div>
                    <input type="radio" name="client" id="client@{{ client.id }}" ng-model="vm.project.client_id"
                           ng-value="client.id" ng-change="vm.save()">
                    <label for="client@{{ client.id }}">@{{ client.name }}</label>
                </div>

            </div>

        </div>

    </div>

</div>

<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('portfolio::admin.project.collaborators') }}</h5>
    </div>

    <div class="ibox-content">

        <ul class="nav project-collaborators">

            <li class="clearfix" ng-repeat="collaborator in vm.collaborators">

                <div class="img-wrapper">
                    <img ng-show="collaborator.images[0].path" ng-src="@{{ collaborator.images[0].path }}"
                         alt="@{{ collaborator.firstname + ' ' + collaborator.lastname }}">
                </div>

                <div class="wrapper">
                    <input type="checkbox" value="collaborator.id" class="filled-in" id="member@{{ collaborator.id }}"
                           ng-model="collaborator.selected" ng-change="vm.toggleCollaboration(collaborator)"/>
                    <label for="member@{{ collaborator.id }}" class="clearfix">
                        <span>@{{ collaborator.firstname + ' ' + collaborator.lastname }}</span>
                        <span>@{{ collaborator.email }}</span>
                        <span class="clearfix"></span>
                    </label>
                </div>
            </li>

        </ul>


    </div>

</div>

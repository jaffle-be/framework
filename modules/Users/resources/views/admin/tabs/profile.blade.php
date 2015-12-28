<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('users::admin.profile.interface-language') }}</h5>
    </div>

    <div class="ibox-content">

        <div class="form-group col-md-3" ng-repeat="locale in vm.options.systemLocales">
            <input type="radio" name="locales" id="@{{ locale.slug }}" class="filled-in" ng-model="vm.profile.locale_id" ng-value="locale.id" ng-change="vm.changeLanguage()">
            <label for="@{{ locale.slug }}">@{{ locale.translations[locale.slug].name }}</label>
        </div>

        <div class="clearfix"></div>

    </div>

</div>

<div ng-show="vm.profile.locale_id">

    <div class="row">

        <div class="col-md-6">
            <div class="ibox">

                <div class="ibox-title">
                    <h5>{{ Lang::get('users::admin.profile.basic-info') }}</h5>
                </div>

                <div class="ibox-content">

                    @include('users::admin.elements.profile')

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div address-input address-id="{{ $user->address ? $user->address->id : null }}"
                 address-owner-type="'user'"
                 address-owner-id="{{ $user->id }}"></div>

        </div>

    </div>

    <div social-links-input owner-id="{{ $user->id }}" owner-type="'user'"></div>


</div>


<div class="wrapper-content" ng-controller="ProfileController as vm" ng-init="vm.options = {{ system_options() }}">

    @include('system::locale-tabs')

    <div class="col-md-6">
        <div class="ibox">

            <div class="ibox-title">
                <h5>{{ Lang::get('users::admin.profile.basic-info') }}</h5>
            </div>

            <div class="ibox-content">

                @include('users::admin.elements.profile')

            </div>

        </div>


        <div address-input address-id="{{ $user->address ? $user->address->id : null }}" address-owner-type="'user'" address-owner-id="{{ $user->id }}"></div>

    </div>

    <div class="col-md-6">

        <div social-links-input owner-id="{{ $user->id }}" owner-type="'user'"></div>

    </div>

    <div class="col-md-6">

        <div class="ibox">

            <div class="ibox-title">
                <h5>{{ Lang::get('users::admin.profile.bio') }}</h5>
            </div>

            <div class="ibox-content">

                <div class="form-group">
                	<label for="bio" class="control-label"></label>
                	<div summernote config="vm.options.summernote" id="bio" ng-model="vm.profile.translations[vm.options.locale].bio" ng-change="vm.save()"></div>
                </div>
                
                <div class="form-group">
                	<label for="quote" class="control-label">{{ Lang::get('users::admin.quote') }}</label>
                	<div>
                		<input type="text" name="quote" id="quote" class="form-control" ng-model="vm.profile.translations[vm.options.locale].quote" ng-change="vm.save()"/>
                	</div>
                </div>

                <div class="form-group">
                    <label for="quote_author" class="control-label">{{ Lang::get('users::admin.quote-author') }}</label>
                    <div>
                        <input type="text" name="quote_author" id="quote_author" class="form-control" ng-model="vm.profile.translations[vm.options.locale].quote_author" ng-change="vm.save()"/>
                    </div>
                </div>

            </div>

        </div>

    </div>


    <div class="col-md-6">

        <div class="ibox">

            <div class="ibox-title">
                <h5>{{ Lang::get('users::admin.profile.skills') }}</h5>
            </div>

            <div class="ibox-content">

                @include('users::admin.elements.skills')

                <div class="clearfix"></div>

            </div>

        </div>

    </div>


    <div class="clearfix"></div>
</div>
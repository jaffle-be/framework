<div class="wrapper-content" ng-controller="ProfileController as vm">

    <div class="ibox">

        <div class="ibox-title">
            <h5>{{ Lang::get('users::profile.basic-info') }}</h5>
        </div>

        <div class="ibox-content">

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">

                        <label for="email">
                            {{ Lang::get('users::profile.email') }}
                        </label>

                        <input autocomplete="off" class="form-control" type="text" name="email" id="email" disabled value="{{ $user->email }}"/>

                    </div>

                    <div class="form-group">

                        <label for="firstname">
                            {{ Lang::get('users::profile.firstname') }}
                        </label>

                        <input autocomplete="off" class="form-control" type="text" name="firstname" id="firstname" ng-model="vm.profile.firstname" ng-change="vm.save()"/>

                    </div>


                    <div class="form-group">

                        <label for="lastname">
                            {{ Lang::get('users::profile.lastname') }}
                        </label>

                        <input autocomplete="off" class="form-control" type="text" name="lastname" id="lastname" ng-model="vm.profile.lastname" ng-change="vm.save()"/>

                    </div>


                    <div class="form-group">

                        <label for="phone">
                            {{ Lang::get('users::profile.phone') }}
                        </label>

                        <input autocomplete="off" class="form-control" type="text" name="phone" id="phone" ng-model="vm.profile.phone" ng-change="vm.save()"/>

                    </div>

                    <div class="form-group">

                        <label for="website">
                            {{ Lang::get('users::profile.website') }}
                        </label>

                        <input class="form-control" type="text" name="website" id="website" ng-model="vm.profile.website" ng-change="vm.save()"/>

                    </div>

                    <div class="form-group">

                        <label for="vat">
                            {{ Lang::get('users::profile.vat') }}
                        </label>

                        <input autocomplete="off" class="form-control" type="text" name="vat" id="vat" ng-model="vm.profile.vat" ng-change="vm.save()"/>

                    </div>


                    <input-errors errors="vm.profileErrors"></input-errors>
                </div>

                <div class="col-md-6">

                    <image-input locale="vm.options.locale" owner-type="'user'" owner-id="{{ Auth::user()->id }}" wait-for="vm.loaded" no-text="'true'"></image-input>

                </div>


            </div>

        </div>

    </div>


    <div address-input address-id="{{ $user->address ? $user->address->id : null }}" address-owner-type="'user'" address-owner-id="{{ $user->id }}"></div>


</div>
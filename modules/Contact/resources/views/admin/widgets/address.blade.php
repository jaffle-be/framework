<div class="ibox">

    <div class="ibox-title">
        <h5>{{ Lang::get('contact::admin.address') }}</h5>
    </div>

    <div class="ibox-content">

        <div class="row">
            <div class="col-md-6">

                <form novalidate>

                    <input id="latitude" name="latitude" type="hidden" ng-model="address.latitude"/>
                    <input id="longitude" name="longitude" type="hidden" ng-model="address.longitude"/>

                    <div class="row">
                        <div class="form-group col-xs-12">
                            <label for="address_suggest">{{ Lang::get('contact::admin.search') }}</label>
                            <input class="form-control" type="text" name="address_suggest"
                                   id="address_suggest"/>

                            <p>
                            <ul>
                                <li ng-repeat="error in errors">@{{ error[0] }}</li>
                            </ul>

                            </p>
                        </div>

                        <div ng-show="searched">

                            <div class="form-group col-xs-8">
                                <label for="street">{{ Lang::get('contact::admin.street') }}</label>
                                <input class="form-control" type="text" name="street" id="street"
                                       ng-model="address.street"/>
                            </div>

                            <div class="form-group col-xs-4">
                                <label for="box">{{ Lang::get('contact::admin.box') }}</label>
                                <input class="form-control" type="text" name="box" id="box"
                                       ng-model="address.box"/>
                            </div>

                            <div class="form-group col-xs-4">
                                <label for="postcode">{{ Lang::get('contact::admin.postcode') }}</label>
                                <input class="form-control" type="text" name="postcode" id="postcode"
                                       ng-model="address.postcode"/>
                            </div>

                            <div class="form-group col-xs-8">
                                <label for="city">{{ Lang::get('contact::admin.city') }}</label>
                                <input class="form-control" type="text" name="city" id="city"
                                       ng-model="address.city"/>
                            </div>

                            <div class="form-group col-xs-12">
                                <label for="country">{{ Lang::get('contact::admin.country') }}</label>
                                <select class="form-control" name="country"
                                        id="country" ng-model="address.country.iso_code_2">

                                    <option value=""></option>
                                    @foreach($countries as $code => $country)
                                        <option value="{{ $code }}">{{ $country }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="form-group col-xs-12 text-center">
                                <button type="button" ng-click="ctrl.save()"
                                        class="btn btn-lg btn-primary">{{ Lang::get('contact::admin.save') }}</button>
                            </div>

                        </div>

                    </div>

                </form>

            </div>

            <div class="col-md-6">
                <div id="map" style="height: 400px;"></div>
            </div>
        </div>

    </div>

</div>

<div class="row wrapper wrapper-content">

    <div class="row">
        <div class="col-xs-12">

            <div address-input address-id="{{ $address ? $address->id : null }}" address-owner-type="'account'" address-owner-id="{{ $contact->id }}"></div>

        </div>
    </div>

    <div class="row" ng-controller="AccountContactController as vm">

        <form ng-submit="vm.save()" novalidate name="accountContactForm">

            <div class="col-xs-12 col-md-6">

                <div class="ibox">

                    <div class="ibox-title">
                        <h5>Other info</h5>
                    </div>

                    <div class="ibox-content">

                        <image-input owner-type="'account-logo'" owner-id="{{ $account->id }}" locale="vm.options.locale" limit="1"></image-input>

                        <input-errors errors="vm.errors"></input-errors>


                        <div class="row">


                            <div class="form-group col-xs-12">
                                <label for="">Email</label>
                                <input class="form-control" type="text" name="email" id="email" ng-model="vm.info.email" ng-change="vm.save()"/>
                            </div>


                            <div class="form-group col-xs-12">
                                <label for="">Phone</label>
                                <input class="form-control" type="text" name="phone" id="phone" ng-change="vm.save()" ng-model="vm.info.phone"/>
                            </div>

                            <div class="form-group col-xs-12">
                                <label for="">Vat number</label>
                                <input class="form-control" type="text" name="vat" id="vat" ng-change="vm.save()" ng-model="vm.info.vat"/>

                            </div>

                            <div class="form-group col-xs-12">
                                <label for="">Website</label>
                                <input class="form-control" type="text" name="website" ng-change="vm.save()" id="website" ng-model="vm.info.website"/>
                            </div>

                            <div class="form-group col-xs-12">
                                <label>Hours</label>
                                <textarea class="form-control" name="hours" ng-change="vm.save()" ng-model="vm.info.hours"></textarea>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-xs-12 col-md-6">

                <div class="ibox" ng-init="vm.options = {{ system_options() }}">

                    <div class="ibox-title">
                        <h5>Site settings</h5>
                    </div>

                    <div class="ibox-content">

                        <tabset justified="true">

                            <tab ng-repeat="locale in vm.options.locales" heading="@{{ locale.locale }}"
                                 active="vm.options.locales[locale.locale].active">
                                <div class="row">

                                    <div class="form-group col-xs-12">
                                        <label for="">Contact form description</label>
                                        <textarea class="form-control" rows="5" name="form_description" ng-change="vm.save()" ng-model="vm.info.translations[locale.locale].form_description"></textarea>
                                    </div>

                                    <div class="form-group col-xs-12">
                                        <label for="">Contact widget title</label>
                                        <input class="form-control" type="text" name="widget_title" ng-change="vm.save()" ng-model="vm.info.translations[locale.locale].widget_title"/>
                                    </div>

                                    <div class="form-group col-xs-12">
                                        <label for="">Contact widget content</label>
                                        <textarea class="form-control" rows="5" name="widget_content" ng-change="vm.save()" ng-model="vm.info.translations[locale.locale].widget_content"></textarea>
                                    </div>

                                </div>
                            </tab>
                        </tabset>

                    </div>

                </div>

            </div>

        </form>

    </div>


</div>
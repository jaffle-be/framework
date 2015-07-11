<div class="row wrapper wrapper-content" ng-controller="AccountContactController as vm">

        <div class="row">
            <div class="col-xs-12">

                <div address-input address-id="{{ $address ? $address->id : null }}" address-owner-type="'account'" address-owner-id="{{ $account->id }}"></div>

            </div>
        </div>

    <form ng-submit="vm.submit()" novalidate name="accountContactForm">

        <div class="row">

            <div class="col-xs-12 col-md-6">

                <div class="ibox">

                    <div class="ibox-title">
                        <h5>Other info</h5>
                    </div>

                    <div class="ibox-content">

                        <div class="row">

                            <div class="form-group col-xs-12">
                                <label for="">Email</label>
                                <input class="form-control" type="text" name="email" id=""/>
                            </div>

                            <div class="form-group col-xs-12">
                                <label for="">Phone</label>
                                <input class="form-control" type="text" name="phone" id=""/>
                            </div>
                            
                            <div class="form-group col-xs-12">
                                <label for="">Vat number</label>
                                <input class="form-control" type="text" name="vat" id=""/>
                            </div>

                            <div class="form-group col-xs-12">
                                <label for="">Website</label>
                                <input class="form-control" type="text" name="website" id=""/>
                            </div>

                            <div class="form-group col-xs-12">
                                <label>Hours</label>
                                <textarea class="form-control" name="hours"></textarea>
                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-xs-12 col-md-6">

                <div class="ibox">

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
                                        <textarea class="form-control" name="description"></textarea>
                                    </div>

                                    <div class="form-group col-xs-12">
                                        <label for="">Contact widget title</label>
                                        <input class="form-control" type="text" name="widget_title"/>
                                    </div>

                                    <div class="form-group col-xs-12">
                                        <label for="">Contact widget content</label>
                                        <textarea class="form-control" name="widget_content"></textarea>
                                    </div>

                                </div>
                            </tab>
                        </tabset>

                    </div>

                </div>

            </div>

        </div>

    </form>


</div>
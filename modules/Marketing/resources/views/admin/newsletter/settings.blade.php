<div class="ibox" ng-show="!vm.campaign.translations[vm.options.locale].mail_chimp_campaign_id">

    <div class="ibox-title">
        <div class="row">
            <div class="col-xs-8">
                <h5>{{ Lang::get('marketing::admin.campaign.details') }}</h5>
            </div>
            <div class="col-xs-4 text-right">
                <span id="send" ng-show="vm.campaign.translations[vm.options.locale]" class="btn-sm btn btn-success" ng-confirm="vm.prepareToSend()"><i class="fa fa-send"></i></span>
                <span id="reset" class="btn-sm btn btn-danger" ng-really="vm.delete()"><i class="fa fa-trash"></i></span>
            </div>
        </div>
    </div>

    <div class="ibox-content">

        <form ng-submit="vm.save()" name="campaignForm" novalidate>

            <input name="locale" type="hidden" value="@{{ vm.options.locale }}"/>

            <div class="row">

                <div class="col-md-6">

                    <div class="row">

                        <div class="form-group col-xs-8">
                            <label for="subject" class="control-label">{{ Lang::get('marketing::admin.campaign.subject') }}</label>

                            <div>
                                <input ng-change="vm.save()" autocomplete="off" type="text" name="subject" id="subject" class="form-control" ng-model="vm.campaign.translations[vm.options.locale].subject"/>
                            </div>
                        </div>

                        <div class="form-group col-xs-offset-1 col-xs-3">

                            <div class="switch">
                                <label>
                                    <input id="campaignIntro" type="checkbox" ng-model="vm.campaign.use_intro" ng-change="vm.save()">
                                    {{ Lang::get('marketing::admin.use_intro') }}
                                    <span class="lever"></span>
                                </label>
                            </div>

                        </div>
                    </div>

                    <div class="form-group" ng-show="vm.campaign.use_intro">
                        <label for="title" class="control-label">{{ Lang::get('marketing::admin.campaign.title') }}</label>

                        <div>
                            <input ng-change="vm.save()" autocomplete="off" type="text" name="title" id="title" class="form-control" ng-model="vm.campaign.translations[vm.options.locale].title"/>
                        </div>
                    </div>

                </div>

                <div class="col-md-6" ng-show="vm.campaign.use_intro">

                    <div class="form-group">
                        <label for="content" class="control-label">{{ Lang::get('marketing::admin.campaign.intro') }}</label>

                        <div>
                            <textarea style="height: 130px;" auto-size class="form-control" ng-model="vm.campaign.translations[vm.options.locale].intro" ng-change="vm.save()"></textarea>
                        </div>
                    </div>

                </div>


            </div>

            <div class="clearfix"></div>
        </form>

    </div>

</div>
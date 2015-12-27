<script type="text/ng-template" id="templates/admin/media/video/widget">
    <div class="video-widget">

        <uib-tabset justified="true">

            <uib-tab class="youtube" select="vm.setMode('youtube')">
                <uib-tab-heading><i class='fa fa-youtube'></i>&nbsp;Youtube</uib-tab-heading>
            </uib-tab>

            <uib-tab class="vimeo" select="vm.setMode('vimeo')">
                <uib-tab-heading><i class='fa fa-vimeo'></i>&nbsp;Vimeo</uib-tab-heading>
            </uib-tab>

        </uib-tabset>

        {{--videoinput--}}
        <div class="form-group">

            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-search" ng-show="!vm.youtube.loading"></i>
                    <i class="fa fa-refresh" ng-show="vm.youtube.loading"></i>
                </div>

                <input type="text" class="form-control" placeholder="{{ Lang::get('blog::admin.post.video_url') }}"
                       uib-typeahead="vm.youtube.title(video) for video in vm.search()" ng-model="vm.youtube.input.url"
                       typeahead-loading="vm.youtube.loading"
                       typeahead-wait-ms="400"
                       typeahead-on-select="vm.youtube.select($item)"
                    >
            </div>

            <div class="preview" ng-show="vm.youtube.preview">

                <img class="img-responsive pull-left" ng-src="@{{ vm.youtube.img(vm.youtube.preview) }}">

                <h3>@{{ vm.youtube.title(vm.youtube.preview) }}
                    <strong class="pull-right">@{{ vm.youtube.date(vm.youtube.preview) | fromNow }}</strong></h3>

                <p>
                    @{{ vm.youtube.description(vm.youtube.preview) }}
                </p>


            </div>
        </div>

        <div class="form-group">
            <input type="text" autocomplete="off" ng-model="vm.youtube.input.title" class="form-control"
                   placeholder="{{ Lang::get('blog::admin.post.title') }}">
        </div>

        <button class="btn btn-block btn-primary" ng-click="vm.youtube.addVideo(videos, locale, ownerType, ownerId)">
            add
        </button>

        <hr ng-show="videos[locale].length">

        {{--videolist--}}
        <div class="videos" ng-show="videos[locale]">

            <ul class="clearfix">
                <li ng-repeat="video in videos[locale] track by $index" class="item video">

                    <div class="media-image">
                        <img class="img-responsive" ng-src="@{{ video.provider_thumbnail }}"/>

                        <div class="tools">
                            <div class="tools-inner">
                                <span><i ng-show="($index != videos.length - 1)" ng-click="vm.moveDown(video, $index)"
                                         class="fa fa-arrow-down"></i></span>
                                <span><i ng-show="($index != 0)" ng-click="vm.moveUp(video, $index)"
                                         class="fa fa-arrow-up"></i></span>
                                <span><i class="fa fa-trash" ng-really="vm.deleteVideo(video)"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" ng-hide="!locale">
                        <input autocomplete="off" ng-change="vm.updateVideo(video)" class="form-control" type="text"
                               ng-model="video.title" placeholder="{{ Lang::get('blog::admin.title') }}"/>
                    </div>

                    <div class="form-group" ng-hide="!locale">
                        <textarea auto-size class="form-control" ng-model="video.description"
                                  ng-change="vm.updateVideo(video)"
                                  placeholder="{{ Lang::get('blog::admin.description') }}"></textarea>
                    </div>

                </li>
            </ul>

        </div>

    </div>
</script>

<script type="text/ng-template" id="templates/admin/media/video/widget">
    <div class="video-widget">

        <tabset justified="true">

            <tab class="youtube" select="ctrl.setMode('youtube')">
                <tab-heading><i class='fa fa-youtube'></i>&nbsp;Youtube</tab-heading>
            </tab>

            <tab class="vimeo" select="ctrl.setMode('vimeo')">
                <tab-heading><i class='fa fa-vimeo'></i>&nbsp;Vimeo</tab-heading>
            </tab>

        </tabset>

        {{--videoinput--}}
        <div class="form-group">

            <div class="input-group">
                <div class="input-group-addon">
                    <i class="fa fa-search" ng-show="!ctrl.youtube.loading"></i>
                    <i class="fa fa-refresh" ng-show="ctrl.youtube.loading"></i>
                </div>

                <input type="text" class="form-control" placeholder="{{ Lang::get('blog::admin.post.video_url') }}"
                       typeahead="ctrl.youtube.title(video) for video in ctrl.search()" ng-model="ctrl.youtube.input.url"
                       typeahead-loading="ctrl.youtube.loading"
                       typeahead-wait-ms="400"
                       typeahead-on-select="ctrl.youtube.select($item)"
                        >
            </div>

            <div class="preview" ng-show="ctrl.youtube.preview">

                <img class="img-responsive pull-left" ng-src="@{{ ctrl.youtube.img(ctrl.youtube.preview) }}">

                <h3>@{{ ctrl.youtube.title(ctrl.youtube.preview) }}
                    <strong class="pull-right">@{{ ctrl.youtube.date(ctrl.youtube.preview) | fromNow }}</strong></h3>

                <p>
                    @{{ ctrl.youtube.description(ctrl.youtube.preview) }}
                </p>


            </div>
        </div>

        <div class="form-group">
            <input type="text" autocomplete="off" ng-model="ctrl.youtube.input.title" class="form-control" placeholder="{{ Lang::get('blog::admin.post.title') }}">
        </div>

        <button class="btn btn-block btn-primary" ng-click="ctrl.youtube.addVideo(ctrl.videos, locale, ownerType, ownerId)">add</button>

        <hr ng-show="ctrl.videos[locale].length">

        {{--videolist--}}
        <div class="videos" ng-show="ctrl.videos[locale]">

            <ul class="clearfix">
                <li ng-repeat="video in ctrl.videos[locale] track by $index" class="item video">

                    <div class="media-image">
                        <img class="img-responsive" ng-src="@{{ video.provider_thumbnail }}"/>

                        <div class="tools">
                            <div class="tools-inner">
                                <span><i ng-show="($index != ctrl.videos.length - 1)" ng-click="ctrl.moveDown(video, $index)" class="fa fa-arrow-down"></i></span>
                                <span><i ng-show="($index != 0)" ng-click="ctrl.moveUp(video, $index)" class="fa fa-arrow-up"></i></span>
                                <span><i class="fa fa-trash" ng-really="ctrl.deleteVideo(video)"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" ng-hide="!locale">
                        <input autocomplete="off" ng-change="ctrl.updateVideo(video)" class="form-control" type="text" ng-model="video.title" placeholder="{{ Lang::get('blog::admin.title') }}"/>
                    </div>

                    <div class="form-group" ng-hide="!locale">
                        <textarea auto-size class="form-control" ng-model="video.description" ng-change="ctrl.updateVideo(video)" placeholder="{{ Lang::get('blog::admin.description') }}"></textarea>
                    </div>

                </li>
            </ul>

        </div>

    </div>
</script>
<div class="ibox" ng-show="!vm.campaign.translations[vm.options.locale].mail_chimp_campaign_id">

    <div class="ibox-title">
        <h5>{{ Lang::get('marketing::admin.widgets') }}</h5>
    </div>

    <div class="ibox-tabs">

        <uib-tabset justified="true">

            <uib-tab heading="{{ Lang::get('marketing::admin.widgets') }}" active="vm.pageTabs[0]">

                <div class="ibox-tabs">

                    <uib-tabset justified="true">
                        <uib-tab heading="{{ Lang::get('marketing::admin.one-per-row') }}" active="vm.widgetTabs[0]" select="vm.itemsPerRow = 1">
                        </uib-tab>
                        <uib-tab heading="{{ Lang::get('marketing::admin.two-per-row') }}" active="vm.widgetTabs[1]" select="vm.itemsPerRow = 2">
                        </uib-tab>
                    </uib-tabset>

                </div>

                <div class="ibox-content">
                    <div ng-repeat="widget in vm.campaign.availableWidgets" ng-include="'widgets/newsletter/placeholders/' + widget.name" ng-show="vm.itemsPerRow == widget.items"></div>
                </div>

            </uib-tab>

            <uib-tab heading="{{ Lang::get('marketing::admin.images') }}" active="vm.pageTabs[1]">

                <div class="ibox-content">
                    <image-input owner-type="'newsletter'" owner-id="$state.params.id" locale="vm.options.locale" images="vm.campaign.images"></image-input>
                </div>

            </uib-tab>

        </uib-tabset>

    </div>

</div>

<?

$data = [
        'img'   => 'http://placekitten.com/g/1120/800',
        'title' => 'Title',
        'text'  => 'A kitten or kitty is a juvenile domesticated cat. A feline litter usually consists of two to five kittens. To survive, kittens need the care of their mother for the first several weeks of their life. Kittens are highly social animals and spend most of their waking hours playing and interacting with available companions.',
];

$data = array_merge($data, ['left' => $data], ['right' => $data]);

?>

@foreach($widgets as $widget)
    <script type="text/ng-template" id="widgets/newsletter/placeholders/{{ $widget['name'] }}">

        <div class="newsletter-widget">

            <div class="newsletter-widget-tools">
                <button class="btn btn-primary" ng-click="vm.addWidget('{{ $widget['name'] }}') ">
                    <i class="fa fa-plus"></i></button>
            </div>

            <div class="newsletter-widget-content">
                @include('marketing::admin.newsletter.widgets.placeholders.' . $widget['name'], $data)
            </div>


        </div>

    </script>
@endforeach

@foreach($widgets as $widget)
    <script type="text/ng-template" id="widgets/newsletter/items/{{ $widget['name'] }}">

    {{--//builders will wrap withing newsletter-widget--}}

            @include('marketing::admin.newsletter.widgets.items.' . $widget['name'], $data)


    </script>
@endforeach

@include('media::admin.image')
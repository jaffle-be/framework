
    <div class="row">

        <div ng-switch on="widget.manual">

            <div ng-switch-when="true">
                <div class="col-xs-8">
                    <h3>{{ vm.showTitle(widget.translations[vm.options.locale].title) }}</h3>
                    <br>
                    {{ vm.showText(widget.translations[vm.options.locale].text) }}
                </div>

                <div class="col-xs-4">
                    <div>
                        <img ng-src="{{ vm.showImage(widget.image) }}" class="img-responsive">
                    </div>
                </div>
            </div>

            <div ng-switch-when="false">
                <div class="col-xs-8">
                    <h3 ng-bind-html="vm.renderHtml(vm.showResourceTitle('one', widget))"></h3>
                    <br>
                    <span ng-bind-html="vm.renderHtml(vm.showResourceText('one', widget))"></span>
                </div>

                <div class="col-xs-4">
                    <div>
                        <img ng-src="{{ vm.showResourceImage('one', widget) }}" class="img-responsive">
                    </div>
                </div>
            </div>
        </div>

    </div>

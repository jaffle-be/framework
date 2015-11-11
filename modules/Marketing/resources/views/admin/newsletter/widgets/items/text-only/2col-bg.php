<div class="bg-color">

    <div class="row">

        <div ng-switch on="widget.manual">

            <div ng-switch-when="true">
                <div class="col-xs-6">
                    <h3>{{ vm.showTitle(widget.translations[vm.options.locale].title_left) }}</h3>
                    <br>
                    {{ vm.showText(widget.translations[vm.options.locale].text_left) }}
                </div>

                <div class="col-xs-6">
                    <h3>{{ vm.showTitle(widget.translations[vm.options.locale].title_right) }}</h3>
                    <br>
                    {{ vm.showText(widget.translations[vm.options.locale].text_right) }}
                </div>
            </div>

            <div ng-switch-when="false">
                <div class="col-xs-6">
                    <h3 ng-bind-html="vm.renderHtml(vm.showResourceTitle('one', widget))"></h3>
                    <br>
                    <span ng-bind-html="vm.renderHtml(vm.showResourceText('one', widget))"></span>
                </div>

                <div class="col-xs-6">
                    <h3 ng-bind-html="vm.renderHtml(vm.showResourceTitle('two', widget))"></h3>
                    <br>
                    <span ng-bind-html="vm.renderHtml(vm.showResourceText('two', widget))"></span>
                </div>
            </div>
        </div>

    </div>


</div>
/**
 * dropZone - Directive for Drag and drop zone file upload plugin
 */
function dropzone() {
    return function (scope, element, attrs) {
        var config, dropzone;

        config = scope[attrs.dropzone];

        // create a Dropzone for the element with the given options
        dropzone = new Dropzone(element[0], config.options);

        // bind the given event handlers
        angular.forEach(config.handlers, function (handler, event) {
            dropzone.on(event, handler);
        });
    };
}

angular
    .module('system')
    .directive('dropzone', dropzone)
angular.module('system')
    .factory('InputTranslationHandler', function () {
        //need to adjust translations to an object
        //since it will not send the languages
        //if they are sent as an array
        return function (locales, original) {
            var translations = {};

            for (var locale in locales)
            {
                if (original[locale])
                {
                    translations[locale] = original[locale];
                }
            }

            return translations;
        }
    });
angular.module('blog')
    .factory('Blog', function ($resource) {
        return $resource('api/admin/blog/:id', {id: '@id'}, {
            query: {
                isArray: false
            },
            get: {
                method: 'GET'
            },
            update: {
                method: 'PUT'
            }
        });
    })
    .factory('BlogImage', function ($resource) {
        var placeholders = {
            imageId: '@id',
            postId: '@postId'
        };

        return $resource('api/admin/blog/:postId/image/:imageId', placeholders, {
            query: {
                isArray: false
            },
            update: {
                method: 'PUT'
            }
        });
    })
    .factory('BlogTag', function ($resource) {

        var placeholders = {
            tagId: '@id',
            postId: '@postId'
        };

        return $resource('api/admin/blog/:postId/tag/:tagId', placeholders, {
            query: {isArray: false},
            update: {
                method: 'PUT'
            }
        });
    });
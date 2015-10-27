angular.module('contact')
    .factory('AddressService', function(ContactAddress)
    {
        function Service()
        {
            this.find = function(id, callback)
            {
                ContactAddress.get({
                    id: id
                }, callback);
            };

            this.save = function (address, callback, error) {

                if(!address.id)
                {
                    address.$save().then(callback, error);
                }
                else{
                    var destination = angular.copy(address);
                    destination.$update().then(callback, error);
                }

            };
        }

        return new Service();
    });
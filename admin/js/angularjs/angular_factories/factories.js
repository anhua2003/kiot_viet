app.factory('globalServices', function ($http) {
    return {
        hintClient: function (clients, string) {
            var output = [];
            if (string !== '') {
                string = string.toLowerCase();
                angular.forEach(clients, function (client) {
                    if (client.slug.toLowerCase().includes(string) || client.title.toLowerCase().includes(string)  || client.mobile.includes(string)) {
                        output.push(client);
                    }
                });
                $('#txt_searching').css({'border-bottom-left-radius': '0px', 'border-bottom-right-radius': '0px'})
            } else {
                $('#txt_searching').css({'border-bottom-left-radius': '8px', 'border-bottom-right-radius': '8px'})
            }
            return output;
        }
    };
});
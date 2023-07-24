app.service('modalService', ['$uibModal',
    function ($uibModal) {
        var modal;
        var modalDefaults = {
            backdrop: true,
            keyboard: false,
            modalFade: true,
            templateUrl: domain + '/templates/modal.html',
            windowClass: 'modalAlert custom-md',
        };

        var modalConfirm = {
            title: '',
            content: ''
        };

        this.showModal = function (customModalDefaults, customModalOptions) {
            if (!customModalDefaults) customModalDefaults = {};
            customModalDefaults.backdrop = 'static';
            return this.show(customModalDefaults, customModalOptions);
        };

        this.show = function (customModalDefaults, customModalOptions) {
            //Create temp objects to work with since we're in a singleton service
            var tempModalDefaults = {};
            var tempModalOptions = {};

            //Map angular-ui modal custom defaults to modal defaults defined in service
            angular.extend(tempModalDefaults, modalDefaults, customModalDefaults);

            //Map modal.html $scope custom properties to defaults defined in service
            angular.extend(tempModalOptions, modalConfirm, customModalOptions);

            if (!tempModalDefaults.controller) {
                tempModalDefaults.controller = function ($scope, $uibModalInstance) {
                    $scope.modalConfirm = tempModalOptions;
                    $scope.modalConfirm.ok = function (result) {
                        $uibModalInstance.close(result);
                    };
                    $scope.modalConfirm.close = function (result) {
                        $uibModalInstance.dismiss('cancel');
                    };
                }
            }
            return $uibModal.open(tempModalDefaults).result;
        };
    }]);
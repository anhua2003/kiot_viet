app.directive('ckeditor', function () {
    return {
        restrict: 'A',
        link: function ($scope, element, attr, ngModel) {
            var ckeditor = CKEDITOR.replace(element[0].id);
            ckeditor.on('change', function () {
                var content = this.getData();
                $scope.dataNotification.content = content;
                // $scope.$apply();
            })
        }
    }
});
app.directive('fileInput', ['$parse', function ($parse) {
    var validFormats = ['jpeg', 'jpg', 'png', 'bitmap'];
    return {
        restrict: 'A',
        link: function ($scope, element, attrs) {
            element.bind('change', function () {
                //Get name selected file (included extension)
                var value = element.val();
                //Substring to get the extension name
                var ext = value.substring(value.lastIndexOf('.') + 1).toLowerCase();
                //Check if extension is in allow extension array
                if (validFormats.indexOf(ext) !== -1) {
                    $parse(attrs.fileInput).assign($scope, element[0].files[0]);
                    $scope.$apply();
                    $scope.setImage();
                } else {
                    msgError('Chỉ chấp nhận định dạng ảnh *.jpg | *.jpeg | *.png',3800);
                    element.val('');
                    $scope.$apply();
                }
            })
        }
    }
}]);
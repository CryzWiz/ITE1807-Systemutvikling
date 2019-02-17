/**
 * Created by Allan Arnesen on 31.03.2017.
 */

var app = angular.module("test",[]);
app.controller("Ctrl1",function($scope){

        //var test1 = getTotalEstimatedHours(projectID);
        //var test2 = getTotalRegisteredHours(projectID);
        $scope.val1 = $('#registeredHoursForProject').val();
        $scope.val2 = 22;
        $scope.val3 = $('#completedProjectTasks').val();

        $scope.$watch('[val1,val2]', function (newValue, oldValue) {

            //$scope.val3 = parseInt($scope.val1) + parseInt($scope.val2);

        });


    })
    .directive('toggle', function(){
        return {
            restrict: 'A',
            link: function(scope, element, attrs){
                if (attrs.toggle=="tooltip"){
                    $(element).tooltip();
                }
                if (attrs.toggle=="popover"){
                    $(element).popover();
                }
            }
        };
    })
    .directive("progressBar", ["$timeout", function ($timeout) {
        return {
            restrict: "EA",
            scope: {
                total: '=total',
                complete: '=complete',
                barClass: '@barClass',
                completedClass: '=?'
            },
            transclude: true,
            link: function (scope, elem, attrs) {

                scope.label = attrs.label;
                scope.completeLabel = attrs.completeLabel;
                scope.showPercent = (attrs.showPercent) || false;
                scope.completedClass = (scope.completedClass) || 'progress-bar-danger';

                scope.$watch('complete', function () {

                    //change style at 100%
                    var progress = scope.complete/scope.total;
                    if (progress >= 1) {
                        $(elem).find('.progress-bar').addClass(scope.completedClass);
                    }
                    else if (progress < 1) {
                        $(elem).find('.progress-bar').removeClass(scope.completedClass);
                    }

                });

            },
            template:
            "<span class='small'>{{total}} {{label}}</span>" +
            "<div class='progress'>"+
            "   <div class='progress-bar {{barClass}}' title='{{complete/total * 100 | number:0 }}%' style='width:{{complete/total * 100}}%;'>{{showPercent ? (complete/total*100) : complete | number:0}} {{completeLabel}}</div>" +
            "</div>"
        };
    }])

//$(document).ready(function(){});
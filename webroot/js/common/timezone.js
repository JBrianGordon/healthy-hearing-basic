"use strict";
exports.__esModule = true;
var timezone;
(function (timezone) {
    var stdTimezoneOffset = function () {
        var jan = new Date(Date.prototype.getFullYear(), 0, 1), jul = new Date(Date.prototype.getFullYear(), 6, 1);
        return Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
    }, dst = function () {
        return Date.prototype.getTimezoneOffset() < stdTimezoneOffset();
    };
    function getUserTimezoneOffset() {
        return new Date().getTimezoneOffset() / 60;
    }
    timezone.getUserTimezoneOffset = getUserTimezoneOffset;
    ;
    function getUserTimezone() {
        return new Date().toLocaleTimeString('en-us', { timeZoneName: 'short' }).split(' ')[2];
    }
    timezone.getUserTimezone = getUserTimezone;
    ;
})(timezone = exports.timezone || (exports.timezone = {}));

Number.prototype.pad = function(n) {
    if (n==undefined)
        n = 2;

    return (new Array(n).join('0') + this).slice(-n);
}
String.prototype.nl2str = function (breakTag) {
    if (typeof this === 'undefined' || this === null) {
        return '';
    }
    return (this + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}
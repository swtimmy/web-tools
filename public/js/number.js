Number.prototype.pad = function(n) {
    if (n==undefined)
        n = 2;

    return (new Array(n).join('0') + this).slice(-n);
}
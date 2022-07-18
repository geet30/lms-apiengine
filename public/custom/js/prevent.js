(function (global) {

    if(typeof (global) === "undefined") {
        throw new Error("window is undefined");
    }

    const isChrome = global.chrome != undefined;
    const isFirefox = typeof InstallTrigger !== 'undefined';

    function preventBack(){ global.history.forward(); }
    if (!isFirefox) {
        setTimeout(global.history.forward(), 0);
        global.onunload=function(){null};
    } else {
        global.history.pushState(null, null, global.location.href);        
        global.onpopstate = function() {
            global.history.pushState(null, "", global.location.href);
        };
    }
})(window);

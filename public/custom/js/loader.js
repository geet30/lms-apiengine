"use strict";

/*
 * Loader Functionality
*/
const CardLoader = function (options) {

    const spinnerHTML = '<div class="overlay-layer card-rounded loader-zindex bg-dark bg-opacity-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';
    this.elementDOM = ''

    this.show = function (idOrClass) {
        this.elementDOM = $(idOrClass);
        this.elementDOM.addClass('overlay overlay-block')
        $(this.elementDOM).append(spinnerHTML)
    }

    this.hide = function () {
        this.elementDOM.removeClass('overlay overlay-block');
        this.elementDOM.find('.overlay-layer').remove();
    };

};
const CardLoaderInstance = new CardLoader();

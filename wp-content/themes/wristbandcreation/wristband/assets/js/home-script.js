jQuery(document).ready(function ($) {
    if (736 === $(window).width()) {
        $("#home-fusion-content-boxes .fusion-column").click(function () {
            window.location.href = window.location+"/order-now/";
        });
    }
});
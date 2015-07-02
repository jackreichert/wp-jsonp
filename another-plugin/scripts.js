jQuery(document).ready(function ($) {
    // client side response processing of getStuff response
    var getStuff = function (response) {
        console.log(response);
    }

    jQuery(document).ready(function (e) {
        // make the jsonp call: ajax_action, method, variables, callback
        wp_jsonp("wp_jsonp", "getStuff", {variable: "hello world"}, getStuff);
    });
});

const $ = require('jquery');
require('bootstrap');
require('../css/app.css');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});
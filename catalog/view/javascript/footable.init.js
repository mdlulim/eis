/*FooTable Init*/
$(function () {
	"use strict";
	
	/*Init FooTable*/
	$('.cart-info>table.table').footable({
        "paging": {
            "enabled": true
        },
        "filtering": {
            "enabled": true
        },
        "sorting": {
            "enabled": true
        }
    });
	
});
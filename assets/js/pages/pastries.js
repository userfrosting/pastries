$(document).ready(function() {

    $("#widget-pastries").ufTable({
        dataUrl: site.uri.public + "/api/pastries",
        useLoadingTransition: site.uf_table.use_loading_transition
    });



    // Bind creation button
    bindPastryCreationButton($("#widget-pastries"));

    // Bind table buttons
    $("#widget-pastries").on("pagerComplete.ufTable", function() {
        bindPastriesTableButtons($(this));
    });
});
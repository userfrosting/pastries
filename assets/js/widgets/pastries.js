/**
 * Set up the form in a modal after being successfully attached to the body.
 */
function attachPastryForm() {
    $("body").on('renderSuccess.ufModal', function(data) {
        var modal = $(this).ufModal('getModal');
        var form = modal.find('.js-form');

        // Set up any widgets inside the modal
        form.find(".js-select2").select2({
            width: '100%'
        });

        // Set up the form for submission
        form.ufForm({
            validator: page.validators
        }).on("submitSuccess.ufForm", function() {
            // Reload page on success
            window.location.reload();
        });
    });
}


function bindPastriesTableButtons(el, options) {
    if (!options) options = {};

    /**
     * Buttons that launch a modal dialog
     */
    // Edit pastry details button
    el.find('.js-pastry-edit').click(function(e) {
        e.preventDefault();

        $("body").ufModal({
            sourceUrl: site.uri.public + "/modals/pastries/edit",
            ajaxParams: {
                pastry_name: $(this).data('name')
            },
            msgTarget: $("#alerts-page")
        });

        attachPastryForm();
    });

    // Delete user button
    el.find('.js-pastry-delete').click(function(e) {
        e.preventDefault();

        $("body").ufModal({
            sourceUrl: site.uri.public + "/modals/pastries/confirm-delete",
            ajaxParams: {
                pastry_name: $(this).data('name')
            },
            msgTarget: $("#alerts-page")
        });

        $("body").on('renderSuccess.ufModal', function() {
            var modal = $(this).ufModal('getModal');
            var form = modal.find('.js-form');

            form.ufForm()
                .on("submitSuccess.ufForm", function() {
                    // Navigate or reload page on success
                    if (options.delete_redirect) window.location.href = options.delete_redirect;
                    else window.location.reload();
                });
        });
    });

}

function bindPastryCreationButton(el) {
    // Link create button
    el.find('.js-pastry-create').click(function(e) {
        e.preventDefault();

        $("body").ufModal({
            sourceUrl: site.uri.public + "/modals/pastries/create",
            msgTarget: $("#alerts-page")
        });

        attachPastryForm();
    });
};
$(document).ready(function() {
    var dell_item = function () {
        var itemID = $(this).data('catalog-item-id');
        var modificatorID = $(this).data('modificator-id');
        swal({
                title: "Delete modificator?",
                text: "",
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Delete",
                cancelButtonText: "NO"
            },
            function () {
                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    type: "post",
                    url: "/catalog/delete-default-modificator.html",
                    data: {
                        'catalogItemID': itemID,
                        'modificatorID': modificatorID,
                        _csrf: csrfToken
                    },
                    success: function (json) {
                        if (json.error) {
                            swal("Error", "%(", "error");
                        }
                        else {
                            swal("Deleted!", "\n", "success");
                        }
                    },
                    dataType: 'json'
                });
            });

        return false;

    };
    $('.dell-modificator').click(dell_item);
});

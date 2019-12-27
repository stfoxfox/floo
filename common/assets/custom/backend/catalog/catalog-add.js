/**
 * Created by anatoliypopov on 08.11.15.
 */
swal({

        title: "Add catalog category",
        text: "Category title:",
        type: "input",   showCancelButton: true,
        closeOnConfirm: false,
        animation: "slide-from-top",
        showLoaderOnConfirm: true,
        confirmButtonText: "Add",
        cancelButtonText:"Cancel",

        inputPlaceholder: ""
    },
    function(inputValue){
        if (inputValue === false) return false;
        if (inputValue === "") {
            swal.showInputError("Title can not be blank");
            return false   }

        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            type: "post",
            url:"/catalog/add-category.html",
            data: {
                title:inputValue,
                _csrf : csrfToken

            },
            success: function(json){


                if(json.error){
                    swal("Error", "%(", "error");
                }
                else{
                    window.location.reload(true);
                }



            },
            dataType: 'json'
        });

        //  swal("Nice!", "You wrote: " + inputValue, "success");
    });

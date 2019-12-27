$(document).ready(function() {

    var $image = $("#crop_img");


    var $inputImage = $("#promoform-file_name");
    if (window.FileReader) {
        $inputImage.change(function() {
            var fileReader = new FileReader(),
                files = this.files,
                file;

            if (!files.length) {
                return;
            }

            file = files[0];

            if (/^image\/\w+$/.test(file.type)) {
                fileReader.readAsDataURL(file);
                fileReader.onload = function () {
                    $('#image-div').fadeIn(300);
                    //$inputImage.val("");
                    $image.cropper({
                        aspectRatio:2.27,
                        //  preview: ".img-preview",
                        minContainerHeight:300,

                        crop: function(data) {
                            // Output the result data for cropping image.
                            showCoords(data);
                        }
                    }).cropper("reset", true).cropper("replace", this.result);
                };
            } else {
                showMessage("Please choose an image file.");
            }
        });

    } else {
        $inputImage.addClass("hide");
    }




    $(".select2").select2(
        {


          //  placeholder: "Рестораны"
        }


    );



    function showCoords(c) {
        $('#promoform-x').val(c.x);
        $('#promoform-y').val(c.y);
        $('#promoform-h').val(c.height);
        $('#promoform-w').val(c.width);
    }



});
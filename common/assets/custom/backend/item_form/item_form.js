$(document).ready(function() {

    var $image = $("#crop_img");


    var $inputImage = $("#catalogitemform-file_name");
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
                        aspectRatio:1,
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




    $("#select-types").select2(
        {


            placeholder: "Модификаторы"
        }


    );

    $("#select-tags").select2(
        {


            placeholder: "Теги"
        }


    );



    function showCoords(c) {
        $('#catalogitemform-x').val(c.x);
        $('#catalogitemform-y').val(c.y);
        $('#catalogitemform-h').val(c.height);
        $('#catalogitemform-w').val(c.width);
    }



});
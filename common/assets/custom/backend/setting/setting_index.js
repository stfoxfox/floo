$(document).ready(function() {
    change_fields();

    var dell_catalog_item = function () {
        var item_name = $(this).data('item-name');
        var item_id = $(this).data('item-id');

        swal({

                title: "Удалить настройку?",
                text: "" + item_name,
                type: "warning",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                showLoaderOnConfirm: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Удалить",
                cancelButtonText: "Отмена"


            },
            function () {

                var csrfToken = $('meta[name="csrf-token"]').attr("content");
                $.ajax({
                    type: "post",
                    url: "/index.php/setting/item-dell.html",
                    data: {
                        'item_id': item_id,
                        _csrf: csrfToken
                    },
                    success: function (json) {


                        if (json.error) {
                            swal("Error", "%(", "error");
                        }
                        else {
                            $("#item_" + json.item_id).remove();

                            swal("Готово!", "\n", "success");
                        }


                    },
                    dataType: 'json'
                });

                //  swal("Nice!", "You wrote: " + inputValue, "success");
            });

        return false;

    };



    $('.dell-catalog-item').click(dell_catalog_item);
    // jQuery(function ($) {
    //     if (window.FileReader) {
    //         $('#settingform-value').change(function() {
    //             var fileReader = new FileReader(),
    //             files = this.files,
    //             file;
    //             if (!files.length) {
    //                 return;
    //             }
    //             file = files[0];

    //             if (/^image\/\w+$/.test(file.type)) {
    //                 fileReader.readAsDataURL(file);
    //                 fileReader.onload = function () {
    //                     $('#settingform-value_image-div').fadeIn(300);                     
    //                     $('#settingform-value_crop_img').cropper({
    //                         aspectRatio:3.76,
    //                         minContainerHeight:300,
    //                         crop: function(data) {
    //                             value_w0_showCoords(data);
    //                         }
    //                     }).cropper('reset', true).cropper('replace', this.result);
    //                 };
    //             } else {
    //                 showMessage('Please choose an image file.');
    //             }
    //         });

    //     } else {
    //         $('#settingform-value').addClass('hide');
    //     }

    //     function value_w0_showCoords(c) {
    //         $('#settingform-x').val(c.x);
    //         $('#settingform-y').val(c.y);
    //         $('#settingform-h').val(c.height);
    //         $('#settingfrom-w').val(c.width);
    //     }
    // });


    $('#settingform-type').on('change', function(e){
        change_fields();
        
    });  

    function change_fields(){
        var type = $('#settingform-type').val();
        var value = $('#settingform-value').val();
        $('.field-settingform-value').empty();
        if(type == 'string'){
            $('.crop-value').css('display', 'none');
            $('.field-settingform-value').append('\
                <label class="control-label" for="settingform-value">\
                    Значение\
                </label>\
                <input type="text" id="settingform-value" class="form-control" name="SettingForm[value]" value = '+ value +' aria-required="true">\
                <p class="help-block help-block-error"></p>\
            ');
        }else if(type == 'boolean'){
            if(value == ""){
                value = 0;
            }
            $('.crop-value').css('display', 'none');
            $('.field-settingform-value').append('\
                <div class="checkbox">\
                    <label for="settingform-value">\
                        <input type="hidden" name="SettingForm[value]" value = "'+ value +'" >\
                        <input type="checkbox" id="settingform-value" name="SettingForm[value]" aria-invalid="false">\
                        Значение\
                    </label>\
                    <p class="help-block help-block-error"></p>\
                </div>\
            ');
        }else if(type == 'text'){
            $('.crop-value').css('display', 'none');
            $('.field-settingform-value').append('\
                <label class="control-label" for="settingform-value">\
                    Значение\
                </label>\
                <textarea id="settingform-value" class="form-control" name="SettingForm[value]"  value = '+ value +' ></textarea>\
            ');
        }else if(type == 'image'){
            // $('.field-settingform-value').append('\
            //     <div class="col-md-12">\
            //         <div class="ibox float-e-margins">\
            //             <div class="ibox-title">\
            //                 <h5>Value</h5>\
            //                  <div class="pull-right">\
            //                 <label title="Изменить изображение" for="settingform-value" class="btn btn-outline btn-xs btn-success">\
            //                 <input type="hidden" name="SettingForm[value]" value="">\
            //                 <input type="file" id="settingform-value" class="hide input_file" name="SettingForm[value]" accept="image/*">\
            //                 Загрузить изображение\
            //             </label>\
            //             <input type="hidden" id="settingform-x" name="SettingForm[x]">\
            //             <input type="hidden" id="settingform-y" name="SettingForm[y]">\
            //             <input type="hidden" id="settingform-w" name="SettingForm[w]">\
            //             <input type="hidden" id="settingform-h" name="SettingForm[h]">\
            //         </div>\
            //     </div>\
            //     <div class="ibox-content">\
            //         <div class="m-t m-b" style="display: none;" id="settingform-value_image-div">\
            //         <img id="settingform-value_crop_img" height="300" width="300" src="" alt="Picture"></div>\
            //     </div>\
            // </div>\
            // </div>\
            // ');
            $('.crop-value').css('display', 'block');
        }
    }
});

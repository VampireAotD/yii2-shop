$(function () {
   $('.image-input').on('change',function () {
       previewImage($(this)[0], $('.preview-image'), $('.image-status'));
   });
});

function previewImage(input,img, error) {
    if(input && input.files[0]){
        error.removeClass('display-block').addClass('display-none');
        if(input.files[0].type.match('image/*')){
            error.removeClass('display-block').addClass('display-none');

            const reader = new FileReader();

            reader.onload = function (e) {
                img.attr('src',e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
        else{
            error.removeClass('display-none').addClass('alert-danger display-block').html('Файл должен быть изображением!');
        }
    }
}
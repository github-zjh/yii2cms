/**
 * Created by 赵金涵 on 2016/8/17.
 */

    //公共弹窗
    var dialog_open = function (message) {
        $('.modal-body').html(message);
        $('#message-modal').modal({'show': true});
    };
    var dialog_close = function () {
        $('#message-modal').modal({'show': false});
    };
    //上传单个图片
    var uploadSingleImage = function (file) {
        var $this = $(file);
        var form_data = new FormData();
        var name = $this.attr('name');
        var fileList = $this[0].files;
        if (!fileList[0]) {
            return false;
        }
        form_data.append(name, fileList[0]);
        var upload_url = $this.data('upload-url');
        var pre_image = $('img.pre-image');
        var hide_input = $('input[name="' + name + '"]:hidden');
        pre_image.removeClass('hidden');
        $.ajax({
            url: upload_url,
            type: 'POST',
            data: form_data,
            dataType: 'JSON',
            cache: false,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.status == 200 && data.data.path) {
                    var img_path = data.data.path;
                    hide_input.val(img_path);
                    pre_image.attr({'src': img_path});
                } else {
                    dialog_open(data.message);
                    if (!pre_image.hasClass('has-val')) {
                        pre_image.addClass('hidden');
                    }
                }
            }
        });
        //重置已选择的文件
        $this.val('');
        return true;
    };


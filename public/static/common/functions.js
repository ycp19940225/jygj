$(document).ready(function () {

    /***
     * 获取box里面所有的表单的值，返回一个对象
     */
    window.get_box_value = function (selecter) {
        var content = {};
        var key;
        $(selecter).find('input').each(function () {
            key = $(this).attr('data-field');
            if (!key) {
                key = this.id
            }
            content[ key ] = this.value;
            key = null;
        });
        $(selecter).find('select').each(function () {
            key = $(this).attr('data-field');
            if (!key) {
                key = this.id
            }
            content[ key ] = $(this).val();
            key = null;
        });
        $(selecter).find('textarea').each(function () {
            key = $(this).attr('data-field');
            if (!key) {
                key = this.id
            }
            if (!$(this).hasClass('no-change-to-br')) {
                content[ key ] = $(this).val().replace(/[\n\r]/g, '<br />');
            } else {
                content[ key ] = $(this).val();
            }
            key = null;
        });
        return content;
    }

    /***
     * 检测box内所有的input输入框是否合法
     */
    window.check_box_value = function (selecter, isAlert, tipHideTime) {
        var re = true;
        isAlert = typeof isAlert == 'undefined' ? true : isAlert;
        $(selecter).find('input').each(function () {
            if ($(this).val() === '' && $(this).attr('data-required') === 'true') {
                if (isAlert) {
                    re = false;
                    alert($(this).attr('data-tip'));
                    return false;
                }
                var $this = $(this);
                setTimeout(function () {
                    $this.focus();
                }, 500);
                $(this).css({'background': 'red'}).bind('keydown click', function () {
                    $(this).css({'background': '#fff'});
                });
                re = false;
                return false;
            }
        });
        if (re == false) {
            return false;
        }
        $(selecter).find('select').each(function () {
            if ($(this).val() === '' && $(this).attr('data-required') == 'true') {
                if (isAlert) {
                    re = false;
                    alert($(this).attr('data-tip'));
                    return false;
                }
                var $this = $(this);
                setTimeout(function () {
                    $this.focus();
                }, 500);
                $(this).css({'background': 'red'}).bind('keydown click', function () {
                    $(this).css({'background': '#fff'});
                });
                re = false;
                return false;
            }
        });

        if (re == false) {
            return false;
        }
        $(selecter).find('textarea').each(function () {
            if ($(this).val() === '' && $(this).attr('data-required') == 'true') {
                if (isAlert) {
                    re = false;
                    alert($(this).attr('data-tip'));
                    return false;
                }
                var $this = $(this);
                setTimeout(function () {
                    $this.focus();
                }, 500);
                $(this).css({'background': 'red'}).bind('keydown click', function () {
                    $(this).css({'background': '#fff'});
                });
                re = false;
                return false;
            }
        });
        if (re == false) {
            return false;
        }
        return true;
    }

    /***
     * js获取GET参数
     */
    window._GET = (function () {
        var arr = location.search.substr(1).split('&');
        var _get = [], valArr = [];
        for (var key in arr) {
            valArr = arr[key].split('=');
            _get[ valArr[0] ] = valArr[1];
        }
        return _get;
    })();

    /***
     * 创建文本输入框控件
     * param object {
     *     minWidth : '', 最小宽度
     *     maxWidth : '', 最大宽度
     *     height : '',   高度
     *     uploadJson : '', 上传接口
     * }
     *
     */
    window.create_editer = function (seleter, param) {
        if (typeof KindEditor == 'undefined') {
            return;
        }
        //var editor
        window.editor = KindEditor.create(seleter, {
            minWidth: (param && param.minWidth ? param.minWidth : 500),
            maxWidth: (param && param.maxWidth ? param.maxWidth : 600),
            height: (param && param.height ? param.height : 300),
            uploadJson: (param && param.uploadJson ? param.uploadJson : 300),
            items: (param && param.items ? param.items : ['source', '|', 'undo', 'redo', '|', 'preview', 'code', '|', 'justifyleft', 'justifycenter', 'justifyright',
                'justifyfull', 'subscript',
                'superscript', 'clearhtml', 'selectall',
                'formatblock', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
                'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 
                'table', 'hr', 'emoticons', 'baidumap', 'pagebreak',
                'anchor', 'link', 'unlink', '|', 'media', '|', 'fullscreen',
            ]),
            filterMode: false, //是否开启过滤模式
            extraFileUploadParams: (param && param.extraFileUploadParams ? param.extraFileUploadParams : {}),
        });
        //获取文本框内的内容
        window.getEditerContent = function () {
            return editor.html();
        }
        //设置文本框内的内容
        window.setEditerContent = function (s) {
            editor.html(s);
        }
    }
});
/**
 * 打印js对象
 * @param object obj 对象
 * @returns string
 */
function printarr(obj) {
    var description = "";
    for (var i in obj) {
        var property = obj[i];
        description += i + " = " + property + "\n";
    }
    alert(description);
} 


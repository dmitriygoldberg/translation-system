$(document).ready(function () {
    $("#langAdd").on('click', function () {
        $("#langModal").find('.modal-title').text('Добавление язык');
        $("input[name='lang_id']").val('');
        $("input[name='lang_name']").val('');
        $("input[name='lang_code']").val('');
    });

    $("#modalSuccess").on('click', function () {
        if (validate()) {
            saveLanguage();
        }
    });

    $("#modalDefault").on('click', function () {
        if ($("#defaultLang").val() != '') {
            var defaultLang = $.parseJSON($("#defaultLang").val());
            $("input[name='lang_name']").val(defaultLang.name);
            $("input[name='lang_code']").val(defaultLang.code);
        }
    });

    $(".lang-table").on('click', '.edit-lang-btn', function (ev) {
        var $tr = $(ev.target).closest('tr');
        var id = $tr.find('.lang_id').text().trim();
        var name = $tr.find('.lang_name').text().trim();
        var code = $tr.find('.lang_code').text().trim();
        editRow = $tr;

        $("#langModal").find('.modal-title').text('Редактирование языка - ' + name);
        $("input[name='lang_id']").val(id);
        $("input[name='lang_name']").val(name);
        $("input[name='lang_code']").val(code);

        $("#langModal").modal();
    });

    $(".lang-table").on('click', '.rm-lang-btn', function (ev) {
        var $tr = $(ev.target).closest('tr');
        var id = $tr.find('.lang_id').text().trim();
        var name = $tr.find('.lang_name').text().trim();
        editRow = $tr;

        var confMsg = 'Удалить язык ' + name + '?';
        confMsg += '\nВнимание! Это действие необратимо.';
        if (!confirm(confMsg)) return;

        deleteLanguage(id);
    });
});

var editRow = null;

function validate() {
    if ($("input[name='lang_name']").val().trim() === '') {
        alert('Введите название языка');
        return false;
    }

    if ($("input[name='lang_code']").val().trim() === '') {
        alert('Введите код языка');
        return false;
    }

    if ($("input[name='lang_code']").val().trim().length > 11) {
        alert('Код языка не може привышать 11 символов');
        return false;
    }

    var errorMsg = 'Код языка должен быть в одном из следующих форматов:\n"xxx", "xxx-xxxx", "xxx-xxxx-xx"';
    var code = $("input[name='lang_code']").val().trim().split('-');
    if (code.length > 3) {
        alert(errorMsg);
        return false;
    }

    if (typeof(code[2]) !== 'undefined') {
        if (code[2].length !== 2) {
            alert(errorMsg);
            return false;
        }
    }

    if (typeof(code[1]) !== 'undefined') {
        if (code[1].length !== 4) {
            alert(errorMsg);
            return false;
        }
    }

    if (code[0].length !== 3) {
        alert(errorMsg);
        return false;
    }

    return true;
}

function saveLanguage() {
    var id = $("input[name='lang_id']").val();
    if (id.length) {
        edit(id);
    } else {
        save();
    }
}

function save() {
    var name = $("input[name='lang_name']").val().trim();
    var code = $("input[name='lang_code']").val().trim();
    var data = {
        controller: 'Language',
        action: 'createLanguage',
        params: {
            name: name,
            code: code
        }
    };

    $.ajax({
        method: 'POST',
        url: '/index.php',
        data: data,
        success: function (answ) {
            var response = $.parseJSON(answ);
            if (response.success) {
                var id = response.data.id;
                var tr = $('<tr>');
                var row = {
                    lang_id: id,
                    lang_name: name,
                    lang_code: code
                };

                $.each(row, function (key, value) {
                    tr.append('<td class="' + key + '">' + value + '</td>');
                });

                tr.append('<td>' +
                    '<i class="edit-lang-btn fa fa-magic" aria-hidden="true"></i>' +
                    '<i class="rm-lang-btn fa fa-trash" aria-hidden="true"></i>' +
                    '</td>');

                $('.lang-table tr:last').after(tr);
                $("#langModal").modal('hide');
            } else {
                var errorMsg = '';
                $.each(response.errors, function (key, value) {
                    errorMsg += value + '\n';
                });
                errorMsg = errorMsg.trim();
                alert(errorMsg);
                console.log(errorMsg);
            }
        }
    });
}

function edit(id) {
    var name = $("input[name='lang_name']").val().trim();
    var code = $("input[name='lang_code']").val().trim();
    var data = {
        controller: 'Language',
        action: 'editLanguage',
        params: {
            id: id,
            name: name,
            code: code
        }
    };

    $.ajax({
        method: 'POST',
        url: '/index.php',
        data: data,
        success: function (answ) {
            var response = $.parseJSON(answ);
            if (response.success) {
                editRow.find('.lang_name').text(name);
                editRow.find('.lang_code').text(code);
                $("#langModal").modal('hide');
            } else {
                var errorMsg = '';
                $.each(response.errors, function (key, value) {
                    errorMsg += value + '\n';
                });
                errorMsg = errorMsg.trim();
                alert(errorMsg);
                console.log(errorMsg);
            }
        }
    });
}

function deleteLanguage(id) {
    var data = {
        controller: 'Language',
        action: 'deleteLanguage',
        params: {
            id: id
        }
    };

    $.ajax({
        method: 'POST',
        url: '/index.php',
        data: data,
        success: function (answ) {
            var response = $.parseJSON(answ);
            if (response.success) {
                editRow.remove();
            } else {
                var errorMsg = '';
                $.each(response.errors, function (key, value) {
                    errorMsg += value + '\n';
                });
                errorMsg = errorMsg.trim();
                alert(errorMsg);
                console.log(errorMsg);
            }
        }
    });
}
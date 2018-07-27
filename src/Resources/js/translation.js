$(document).ready(function () {
    $("#keyAdd").on('click', function () {
        $("#keyModal").find('.modal-title').text('Добавление ключа');
        $("#keyModal input[name='key_id']").val('');
        $("#keyModal input[name='key_name']").val('');
    });

    $("#keyModalSuccess").on('click', function () {
        if (Key.validate()) {
            Key.saveKey();
        }
    });

    $("#translateModalSuccess").on('click', function () {
        if (Translation.validate()) {
            Translation.saveTranslation();
        }
    });

    $("#translateModalDelete").on('click', function () {
        var confMsg = 'Удалить данный перевод?';
        confMsg += '\nВнимание! Это действие необратимо.';
        if (!confirm(confMsg)) return;
        var id = parseInt($("#translateModal input[name='id']").val());
        Translation.deleteTranslation(id);
    });

    $(".translation-table").on('click', '.edit-btn', function (ev) {
        var $tr = $(ev.target).closest('tr');
        var id = $tr.attr('id');
        var name = $tr.find('.key_name').text().trim();
        editRow = $tr;

        $("#keyModal").find('.modal-title').text('Редактирование ключа - ' + name);
        $("#keyModal input[name='key_id']").val(id);
        $("#keyModal input[name='key_name']").val(name);

        $("#keyModal").modal();
    });

    $(".translation-table").on('click', '.rm-btn', function (ev) {
        var $tr = $(ev.target).closest('tr');
        var id = $tr.attr('id');
        var name = $tr.find('.key_name').text().trim();
        editRow = $tr;

        var confMsg = 'Удалить ключ ' + name + '?';
        confMsg += '\nВнимание! Это действие необратимо.';
        if (!confirm(confMsg)) return;

        Key.deleteKey(id);
    });

    $(".translation-table").on('click', '.translation', function (ev) {
        var $td = $(ev.target);
        var $tr = $(ev.target).closest('tr');
        var $th = $td.closest('table').find('th').eq($td.index());

        var keyId = $tr.attr('id');
        var langId = $th.attr('id');
        var translateId = $td.attr('id');

        var keyName = $tr.find('.key_name').text().trim();
        var langCode = $th.text().trim();
        var content = $td.text().trim();

        editCell = $td;

        $("#translateModal").find('.modal-title').text('Введите перевод. Ключ - ' + keyName + '. Язык - ' + langCode);
        $("#translateModal input[name='id']").val(translateId);
        $("#translateModal input[name='key_id']").val(keyId);
        $("#translateModal input[name='lang_id']").val(langId);
        $("#translateModal textarea[name='content']").val(content);

        if (parseInt(translateId) === 0) {
            $("#translateModalDelete").hide();
        } else {
            $("#translateModalDelete").show();
        }

        $('#translateModal').modal();
    });
});

var editRow = null;
var editCell = null;

var Key = {
    validate: function () {
        if ($("#keyModal input[name='key_name']").val().trim() === '') {
            alert('Введите название ключа');
            return false;
        }
        return true;
    },

    saveKey: function () {
        var id = $("#keyModal input[name='key_id']").val();
        if (id.length) {
            this.edit(id);
        } else {
            this.save();
        }
    },

    save: function () {
        var name = $("#keyModal input[name='key_name']").val().trim();
        var data = {
            controller: 'Translation',
            action: 'createKey',
            params: {
                name: name
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
                    var tr = $('<tr id="' + id + '">');

                    tr.append('<td class="key_name">' + name + '</td>');

                    $('.language').each(function () {
                        tr.append('<td class="translation" id="0"></td>');
                    });

                    tr.append('<td>' +
                        '<i class="edit-btn fa fa-magic" aria-hidden="true"></i>' +
                        '<i class="rm-btn fa fa-times" aria-hidden="true"></i>' +
                        '</td>');

                    $('.translation-table tr:last').after(tr);
                    $("#keyModal").modal('hide');
                } else {
                    alert(JSON.stringify(response.errors));
                    console.log(response.errors);
                }
            }
        });
    },

    edit: function (id) {
        var name = $("#keyModal input[name='key_name']").val().trim();
        var data = {
            controller: 'Translation',
            action: 'editKey',
            params: {
                id: id,
                name: name
            }
        };

        $.ajax({
            method: 'POST',
            url: '/index.php',
            data: data,
            success: function (answ) {
                var response = $.parseJSON(answ);
                if (response.success) {
                    editRow.find('.key_name').text(name);
                    $("#keyModal").modal('hide');
                } else {
                    alert(JSON.stringify(response.errors));
                    console.log(response.errors);
                }
            }
        });
    },

    deleteKey: function (id) {
        var data = {
            controller: 'Translation',
            action: 'deleteKey',
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
                    alert(JSON.stringify(response.errors));
                    console.log(response.errors);
                }
            }
        });
    }
};

var Translation = {
    validate: function () {
        if ($("#translateModal textarea[name='content']").val().trim() === '') {
            alert('Введите перевод');
            return false;
        }
        return true;
    },

    saveTranslation: function () {
        var id = parseInt($("#translateModal input[name='id']").val());
        if (id === 0) {
            this.save();

        } else {
            this.edit(id);
        }
    },

    save: function () {
        var content = $("#translateModal textarea[name='content']").val().trim();
        var keyId = $("#translateModal input[name='key_id']").val();
        var langId = $("#translateModal input[name='lang_id']").val();

        var data = {
            controller: 'Translation',
            action: 'createTranslation',
            params: {
                keyId: keyId,
                langId: langId,
                content: content
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
                    editCell.attr('id', id);
                    editCell.text(content);
                    $("#translateModal").modal('hide');
                } else {
                    alert(JSON.stringify(response.errors));
                    console.log(response.errors);
                }
            }
        });
    },

    edit: function (id) {
        var content = $("#translateModal textarea[name='content']").val().trim();
        var keyId = $("#translateModal input[name='key_id']").val();
        var langId = $("#translateModal input[name='lang_id']").val();

        var data = {
            controller: 'Translation',
            action: 'editTranslation',
            params: {
                id: id,
                keyId: keyId,
                langId: langId,
                content: content
            }
        };

        $.ajax({
            method: 'POST',
            url: '/index.php',
            data: data,
            success: function (answ) {
                var response = $.parseJSON(answ);
                if (response.success) {
                    editCell.text(content);
                    $("#translateModal").modal('hide');
                } else {
                    alert(JSON.stringify(response.errors));
                    console.log(response.errors);
                }
            }
        });
    },

    deleteTranslation: function (id) {
        var data = {
            controller: 'Translation',
            action: 'deleteTranslation',
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
                    editCell.attr('id', 0);
                    editCell.text('');
                    $("#translateModal").modal('hide');
                } else {
                    alert(JSON.stringify(response.errors));
                    console.log(response.errors);
                }
            }
        });
    }
};
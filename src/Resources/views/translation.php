<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Система переводов</title>

    <link rel="stylesheet" type="text/css" href="/app/Resources/bootstrap-3.3.7-dist/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/src/Resources/css/translation.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="/app/Resources/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
    <script src="/app/Resources/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
</head>
<body>
<!-- Modal -->
<div id="keyModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content container">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <form class="key-form">
                <div class="modal-body">
                    <div class="doc-head">
                        <input name="key_id" type="text" value="" hidden>
                        <div class="form-group row">
                            <label class="col-sm-2">Ключ </label>
                            <input class="col-sm-10" name="key_name" type="text" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer row">
                    <button type="button" class="btn btn-success js-save-btn" id="keyModalSuccess">Сохранить</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END modal -->

<!-- Modal -->
<div id="translateModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content container">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <form class="translate-form">
                <div class="modal-body">
                    <div class="doc-head">
                        <input name="id" type="text" value="" hidden>
                        <input name="key_id" type="text" value="" hidden>
                        <input name="lang_id" type="text" value="" hidden>
                        <div class="form-group row">
                            <textarea class="col-sm-12" rows="10" name="content"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer row">
                    <button type="button" class="btn btn-success" id="translateModalSuccess">Сохранить</button>
                    <button type="button" class="btn btn-danger" id="translateModalDelete">Удалить</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END modal -->

<div class="container">
    <ul class="nav nav-pills nav-justified">
        <li><a href="/?controller=Language&action=showLanguagePage">Менеджер языков</a></li>
    </ul>
    <h1>Управление переводами</h1>
</div>
<div class="container">
    <button class="btn btn-primary" id="keyAdd" data-toggle="modal" data-target="#keyModal">
        <span class="glyphicon glyphicon-plus"></span>
        Добавить ключ
    </button>
    <table class="table table-hover translation-table">
        <thead>
        <tr>
            <th>Ключ</th>
            <?php foreach ($langList as $lang): ?>
                <th class="language" id="<?= $lang['id'] ?>"><?= $lang['code'] ?></th>
            <?php endforeach; ?>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($keyList as $key): ?>
            <tr id="<?= $key['id'] ?>">
                <td class="key_name"><?= $key['name'] ?></td>
                <?php foreach ($langList as $lang): ?>
                    <?php if (isset($translationList[$key['id']][$lang['id']])): ?>
                        <td class="translation" id="<?= $translationList[$key['id']][$lang['id']]['id'] ?>">
                            <?= $translationList[$key['id']][$lang['id']]['content'] ?></td>
                    <?php else: ?>
                        <td class="translation" id="0"></td>
                    <?php endif; ?>
                <?php endforeach; ?>
                <td>
                    <i class="edit-btn fa fa-magic" aria-hidden="true"></i>
                    <i class="rm-btn fa fa-trash" aria-hidden="true"></i>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script type="text/javascript" src="/src/Resources/js/translation.js"></script>
</body>
</html>
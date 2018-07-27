<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Языки</title>

    <link rel="stylesheet" type="text/css" href="/app/Resources/bootstrap-3.3.7-dist/css/bootstrap.css"/>
    <link rel="stylesheet" type="text/css" href="/src/Resources/css/language.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="/app/Resources/jQuery-3.3.1/jquery-3.3.1.min.js"></script>
    <script src="/app/Resources/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
</head>
<body>
<!-- Modal -->
<div id="langModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content container">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <form class="lang-form">
                <div class="modal-body">
                    <div class="doc-head">
                        <input name="lang_id" type="text" value="" hidden>
                        <div class="form-group row">
                            <label class="col-sm-4">Название </label>
                            <input class="col-sm-8" name="lang_name" type="text" value="">
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4">Kод ISO 693-3 </label>
                            <input class="col-sm-8" name="lang_code" type="text" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer row">
                    <button type="button" class="btn btn-success js-save-btn" id = "modalSuccess">Сохранить</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END modal -->

<div class="container">
    <ul class="nav nav-pills nav-justified">
        <li><a href="/">Страница переводов</a></li>
    </ul>
    <h1>Менеджер языков</h1>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-2">
            <button class="btn btn-primary" id="langAdd" data-toggle="modal" data-target="#langModal">
                <span class="glyphicon glyphicon-plus"></span>
                Добавить язык
            </button>
        </div>
        <div class="col-md-10">
            <table class="table table-hover lang-table">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Язык</th>
                    <th>ISO 693-3</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($langList as $key => $lang): ?>
                    <tr>
                        <td class = "lang_id"><?=$lang['id'] ?></td>
                        <td class = "lang_name"><?=$lang['name'] ?></td>
                        <td class = "lang_code"><?=$lang['code'] ?></td>
                        <td>
                            <i class="edit-lang-btn fa fa-magic" aria-hidden="true"></i>
                            <i class="rm-lang-btn fa fa-times" aria-hidden="true"></i>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript" src="/src/Resources/js/language.js"></script>
</body>
</html>
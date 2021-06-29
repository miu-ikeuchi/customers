<?php

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/config.php';

$company = '';
$name = '';
$email = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // フォームに入力されたデータを受け取る
    $company = filter_input(INPUT_POST, 'company');
    $name = filter_input(INPUT_POST, 'name');
    $email = filter_input(INPUT_POST, 'email');

    // バリデーション
    $errors = insertValidate($company, $name, $email);

    // エラーチェック
    if (empty($errors)) {
        // タスク登録処理の実行
        submitCustomersDate($company, $name, $email);
    }
}

?>
<!DOCTYPE html>
<html lang="ja">

<?php include_once __DIR__ . '/_head.html' ?>

<body>
    <div class="wrapper">
        <h1 class="title"><a href="index.php">顧客管理アプリ</a></h1>
        <div class="form-area">
            <h2 class="sub-title">編集</h2>

            <?php if ($errors) echo (createErrMsg($errors)) ?>

            <form action="" method="post">
                <label for="company">会社名</label>
                <input type="text" id="company" name="company" value="<?=$company ?>">
                <label for="name">氏名</label>
                <input type="text" id="name" name="name" value="<?= $name ?>">
                <label for="email">メールアドレス</label>
                <input type="email" id="email" name="email" value="<?= $email ?>">
                <input type="submit" class="btn submit-btn" value="更新">
            </form>
            <a href="index.php" class="btn return-btn">戻る</a>
        </div>
    </div>
</body>

</html>
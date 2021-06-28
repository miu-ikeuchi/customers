<?php

require_once __DIR__ . '/config.php';

function connectDb()
{
    try {
        return new PDO(
            DSN,
            USER,
            PASSWORD,
            [PDO::ATTR_ERRMODE =>
            PDO::ERRMODE_EXCEPTION]
        );
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
}

function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function insertValidate($company, $name, $email)
{
    $errors = [];

    if ($company == '') {
        $errors[] = MSG_COMPANY_REQUIRED;
    }
    if ($name == '') {
        $errors[] = MSG_NAME_REQUIRED;
    }
    if ($email == '') {
        $errors[] = MSG_EMAIL_REQUIRED;
    }
    return $errors;
}
function submitCustomersDate($company, $name, $email)
{
    try {
        $dbh = connectDb();
        $sql = <<<EOM
        INSERT INTO
            customers
            (company, name, email)
        VALUES
            (:company, :name, :email);
        EOM;
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':company', $company, PDO::PARAM_STR);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
function createErrMsg($errors)
{
    foreach ($errors as $error) {
        $err_msg = h($error) ;
    }
    return $err_msg;
}

function deleteCustomer($id)
{
    $dbh = connectDb();

    $sql = <<<EOM
    DELETE FROM
        customers
    WHERE
        id = :id
    EOM;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
}
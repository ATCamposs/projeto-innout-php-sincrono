<?php

function addSuccessMsg(string $msg): void
{
    $_SESSION['message'] = [
        'type' => 'success',
        'message' => $msg
    ];
}

function addErrorMsg(string $msg): void
{
    $_SESSION['message'] = [
        'type' => 'error',
        'message' => $msg
    ];
}

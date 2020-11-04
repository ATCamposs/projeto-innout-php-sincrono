<?php

namespace Src\View\Template;

use Symfony\Component\Config\Definition\Exception\Exception;

class Messages
{
    public function errorMessage(Exception $exception): void
    {
        if (!empty($exception)) {
            $message = [
                'type' => 'error',
                'message' => $exception->getMessage()
            ];
            //$message_type = $message['type'] === 'error' ? 'danger' : 'success';
            $message_type = 'danger';
            echo '<div class="mx-3 alert alert-' . $message_type  . '" role="alert">' . $message['message'] . '</div>';
        }
    }
}

<?php

namespace Src\View\Template;

use Symfony\Component\Config\Definition\Exception\Exception;

class Messages
{
    /** @param mixed $exception */
    public function errorMessage($exception): void
    {
        if (isset($_SESSION['message'])) {
            $message['type'] = $_SESSION['message']['type'];
            $message['message'] = $_SESSION['message']['message'];
            unset($_SESSION['message']);
        }

        if (!empty($exception)) {
            $message = [
                'type' => 'error',
                'message' => $exception->getMessage()
            ];
        }
        if (isset($message)) {
            $message_type = $message['type'] == 'error' ? 'danger' : 'success';
            echo '<div class="mx-3 alert alert-' . $message_type  . '" role="alert">' . $message['message'] . '</div>';
        }
    }
}

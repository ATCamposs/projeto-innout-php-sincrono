<?php

namespace Src\View\Template;

class Messages
{
    public function errorMessage(string $exception): void
    {
        if (!empty($exception)) {
            $message = [
                'type' => 'error',
                'message' => $exception
            ];

            echo '<div class="mx-3 alert alert-danger" role="alert">' . $message['message'] . '</div>';
        }
    }

}

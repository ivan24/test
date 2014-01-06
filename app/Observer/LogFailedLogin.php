<?php
/**
 * @author Ivan Oreshkov ivan.oreshkov@gmail.com
 */

namespace Observer;


class LogFailedLogin extends LoginObserver
{
    public function doUpdate(Login $login)
    {
        $status = $login->getStatus();
        if ($status['status'] === Login::LOGIN_FAILED) {
            echo "Login Failed. Add to logs";
        }
    }
} 
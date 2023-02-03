<?php
                
    function deleteSessionandCookie(){   

            session_destroy();

            foreach ($_COOKIE as $key => $value) {
                var_dump($key);
                setcookie($key, '', time() - 3600);
            }

            return true;

}
<?php
class TokenPW
{
    function generateToken()
    {
        $token = bin2hex(random_bytes(32));
        $expiration = time() + 3600; // 1 hour
        return array('token' => $token, 'expiration' => $expiration);
    }
    
}
?>
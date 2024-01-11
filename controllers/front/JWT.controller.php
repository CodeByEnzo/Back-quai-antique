<?php
class JWT
{
    /**
     * generate JWT
     * @param array $header Header's token
     * @param array $payload Payload's token'
     * @param string $secret Secret key
     * @param int $validity Validity's token (seconds)
     * @return string Token
     */
    public function generate(array $header, array $payload, string $secret, int $validity = 43200): string
    {
        if ($validity > 0) {
            $now = new DateTime();
            $expiration = $now->getTimestamp() + $validity;
            $payload['iat'] = $now->getTimestamp();
            $payload['exp'] = $expiration;
        }

        // Encode base64
        $base64Header = base64_encode(json_encode($header));
        $base64Payload = base64_encode(json_encode($payload));

        // Clean up values by replacing +, / and =
        $base64Header = str_replace(['+', '/', '='], ['-', '_', ''], $base64Header);
        $base64Payload = str_replace(['+', '/', '='], ['-', '_', ''], $base64Payload);

        // Generate signature
        $secret = base64_encode($secret);
        $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, $secret, true);

        $base64Signature = base64_encode($signature);

        $signature = str_replace(['+', '/', '='], ['-', '_', ''], $base64Signature);

        // Create token
        $jwt = $base64Header . '.' . $base64Payload . '.' . $signature;

        return $jwt;
    }

    /**
     * Verify Token
     * @param string $token Token to verify
     * @param string $secret Secret key
     * @return bool Verify or not
     */
    public function check(string $token, string $secret): bool
    {
        // get header and payload
        $header = $this->getHeader($token);
        $payload = $this->getPayload($token);

        // Generate verify token
        $verifToken = $this->generate($header, $payload, $secret, 0);

        return $token === $verifToken;
    }

    /**
     * Rget header
     * @param string $token Token
     * @return array Header
     */
    public function getHeader(string $token)
    {
        // Unmount token
        $array = explode('.', $token);

        // decode header
        $header = json_decode(base64_decode($array[0]), true);

        return $header;
    }

    /**
     * Return payload
     * @param string $token Token
     * @return array Payload
     */
    public function getPayload(string $token)
    {
        // Unmount token
        $array = explode('.', $token);

        // Decode payload
        $payload = json_decode(base64_decode($array[1]), true);

        return $payload;
    }

    /**
     * Verify if expired
     * @param string $token Token to verify
     * @return bool Verify or not
     */
    public function isExpired(string $token): bool
    {
        $payload = $this->getPayload($token);

        $now = new DateTime();

        return $payload['exp'] < $now->getTimestamp();
    }

    /**
     * Verify validity of token
     * @param string $token Token to verify
     * @return bool Verify or not
     */
    public function isValid(string $token): bool
    {
        return preg_match(
            '/^[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+\.[a-zA-Z0-9\-\_\=]+$/',
            $token
        ) === 1;
    }
}

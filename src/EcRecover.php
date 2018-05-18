<?php

namespace Ethereum;

use Elliptic\EC;
use kornrunner\Keccak;


class EcRecover
{

    /**
     * @param string $message
     * @param string $signature
     * @return string
     * @throws \Exception
     */
    public static function personalEcRecover(string $message, string $signature)
    {
        $message_hash =  '0x' . Keccak::hash(self::personalSignAddHeader($message), 256);
        $address = self::phpEcRecover($message_hash, $signature);
        return $address;
    }

    /**
     * @param string $message
     * @param string $signature
     * @param string $address
     * @return bool
     * @throws \Exception
     */
    public static function personalVerifyEcRecover(string $message, string $signature, string $address)
    {
        $recovered_address = self::personalEcRecover($message, $signature);
        return ($address === $recovered_address);
    }

    /**
     * EcRecover - Elliptic Curve Signature Verification.
     *
     * This function ecRecover is a wrapper to a solidity function (ececover).
     * See:
     * http://solidity.readthedocs.io/en/latest/miscellaneous.html?highlight=ecrecover
     *
     * Using this ecRecover-wrapper it is the recommended to use ecrecover in
     * order to  provide future performance improvements.
     *
     * EC recovery doses not require any blockchain interaction, it's just
     * freaky math. Considering libraries, PHP extensions or command
     * line C or node implementations.
     *
     * @param string $message_hash .
     *   Keccak-256 of message in hex
     *
     * @param string $signature .
     *   Keccak-256 of message in hex
     *
     * @return string
     *   Keccak256 of the provided string.
     *
     * @throws \Exception
     *   If keccak hash does not match formal conditions.
     */
    public static function phpEcRecover(string $message_hash, string $signature)
    {
        $return = NULL;

        $ec = new EC('secp256k1');
        $sign   = ["r" => substr($signature, 2, 64), "s" => substr($signature, 66, 64)];
        $recid  = ord(hex2bin(substr($signature, 130, 2))) - 27;

        $pubKey = $ec->recoverPubKey($message_hash, $sign, $recid);

        $recoveredAddress = "0x" . substr(Keccak::hash(substr(hex2bin($pubKey->encode("hex")), 1), 256), 24);
        return $recoveredAddress;
    }

    /**
     * Ethereum personal_sign message header.
     *
     * @param string $message
     *   Message to be prefixed.
     *
     * @return string
     *   prefixed message.
     */
    public static function personalSignAddHeader($message)
    {
        // MUST be double quotes.
        return "\x19Ethereum Signed Message:\n" . strlen($message) . $message;
    }

}

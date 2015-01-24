<?php
/**
 * Created by PhpStorm.
 * User: Jayvic
 * Date: 14/12/14
 * Time: 下午8:30
 */

namespace Extensions\Hashing;

use Illuminate\Hashing\HasherInterface;

class Sha256Hasher implements HasherInterface {

    /**
     * Hash the given value.
     *
     * @param  string  $value
     * @param  array   $options
     * @return string
     *
     * @throws \RuntimeException
     */
    public function make($value, array $options = array())
    {
        $hash = hash('sha256', $value);

        return $hash;
    }

    /**
     * Check the given plain value against a hash.
     *
     * @param  string  $value
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function check($value, $hashedValue, array $options = array())
    {
        return $this->make($value) === $hashedValue;
    }

    /**
     * Check if the given hash has been hashed using the given options.
     *
     * @param  string  $hashedValue
     * @param  array   $options
     * @return bool
     */
    public function needsRehash($hashedValue, array $options = array())
    {
        return false;
    }

}

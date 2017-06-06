<?php
namespace Core\Bundle;

/**
 * Class Bundler
 *
 * @author Adrien PAYEN <adrien.payen2@gmail.com>
 * @package Core\Bundle
 */
interface BundlerInterface
{
    /**
     * @return array
     */
    public function call();
}
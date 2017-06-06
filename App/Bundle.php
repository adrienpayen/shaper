<?php
namespace App;

use Core\Bundle\BundlerInterface;

/**
 * Class Bundle
 *
 * @author Adrien PAYEN <adrien.payen2@gmail.com>
 * @package App
 */
class Bundle implements BundlerInterface
{
    public function call()
    {
        return $bundle = [
            'BackOffice' => [
                'route_prefix' => 'admin'
            ],
            'FrontOffice'
        ];
    }
}
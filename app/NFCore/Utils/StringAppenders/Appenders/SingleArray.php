<?php
/**
 * Created by PhpStorm.
 * User: Olusegun
 * Date: 4/15/2018
 * Time: 12:53 AM
 */

namespace App\NFCore\Utils\StringAppenders\Appenders;

use App\NFCore\Utils\StringAppenders\IAppender;

class SingleArray implements IAppender
{
    protected $arrayToBuild;

    public function __construct(array $arrayToBuild = null)
    {
        $this->arrayToBuild = $arrayToBuild;
    }


    public function build()
    {
        $builtString = '';

        for($i = 0; $i < count($this->arrayToBuild); $i++) {

            if($i > 0) {
                $builtString .= ','.$this->arrayToBuild[$i];
            }
            else {
                $builtString .= $this->arrayToBuild[$i];
            }
        }
        return $builtString;
    }
}
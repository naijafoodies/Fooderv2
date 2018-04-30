<?php
/**
 * Created by PhpStorm.
 * User: Olusegun
 * Date: 4/14/2018
 * Time: 4:24 PM
 */

namespace App\NFCore\Utils\StringAppenders\Appenders;


use App\NFCore\Utils\StringAppenders\IAppender;

class GroupedArray implements IAppender
{
    protected $arrayToBuild;

    protected $isMapperString = false;

    /**
     * GroupedArray constructor.
     * @param array $arrayToBuild
     * @internal param array $stringToBuild
     */
    public function __construct(array $arrayToBuild)
    {
        $this->arrayToBuild = $arrayToBuild;
    }

    /**
     * @return string
     * Function analyzes the arrays inside a mother array, breaking the content into strings delimited by
     */
    public function build()
    {
        $builtString = '';

        for ($i = 0; $i < count($this->arrayToBuild); $i++) {
            for ($j = 0; $j < count($this->arrayToBuild[$i]); $j++) {

                if ($j > 0) {
                    $builtString .= ',' . $this->arrayToBuild[$i][$j];
                } else {
                    $builtString .= $this->arrayToBuild[$i][$j];
                }
            }
            $builtString .= '|';
        }

        return $builtString;
    }
}
         
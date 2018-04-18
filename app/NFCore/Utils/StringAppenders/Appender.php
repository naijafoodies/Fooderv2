<?php
/**
 * Created by PhpStorm.
 * User: Olusegun
 * Date: 4/14/2018
 * Time: 4:17 PM
 */

namespace App\NFCore\Utils\StringAppenders;


class Appender
{
    private $initialString = '';

    public function __construct($initialString = null)
    {
        if(is_string($initialString)) {
            $this->initialString = $this->initialString = $initialString;
        }
    }


    public function append(IAppender $appender) {

        if($appender instanceof IAppender) {

           $this->initialString .= $appender->build();
        }
        else {
            throw new \InvalidArgumentException("Appender must implement the IAppender Interface");
        }
    }

    public function build()
    {
        return $this->initialString;
    }
}
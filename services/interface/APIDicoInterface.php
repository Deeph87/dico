<?php
/**
 * Created by PhpStorm.
 * User: jhaudry
 * Date: 21/03/2018
 * Time: 13:23
 */

namespace Dico\Services;


interface APIDicoInterface
{
    public function get();
    public function post();
    public function put();
    public function delete();
}
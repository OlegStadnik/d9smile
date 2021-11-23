<?php

/**
 * @file
 * The PHP page that serves all page requests on a Drupal installation.
 *
 * All Drupal code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt files in the "core" directory.
 */

use Drupal\Core\DrupalKernel;
use Symfony\Component\HttpFoundation\Request;
$a = []; // наш основной массив
$a[] = [1, 'Lorem' ,2,3, 'Ipsum', 4,5]; // первый подмассив
$a[] = [7,8,9, 'is', 10,11, 'simply', 12]; //второй
$a[] = [13,14, 'dummy',15,16,17]; // третий.
$a[] = 18;
$a[] = 'text';
$str = '';
$num = 0;
$counter = 0;
foreach ($a as $value){
  if (is_array($value)){
    foreach ($value as $val){
      if (is_int($val)) {
        $num += $val;
        $counter++;

      }
      elseif (is_string($val)) {
        $str .= $val . ' ';
      }
    }
  }
  elseif (is_int($value)) {
    $num += $value;
    $counter++;

  }
  elseif (is_string($value)) {
    $str .= $value . ' ';
  }

}
echo  $str;
echo $num / $counter;

$autoloader = require_once 'autoload.php';

$kernel = new DrupalKernel('prod', $autoloader);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();

$kernel->terminate($request, $response);

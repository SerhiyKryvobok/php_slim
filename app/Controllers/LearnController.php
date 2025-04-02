<?php

namespace App\Controllers;

class LearnController extends BaseController
{
    public function task($request, $response, $args)
    {
        $task = $args['task'];

        $scope = $this->task_scope($task);
        $scope || exit;

        $res = '';

        foreach ($scope as $S) {
            $res .= $this->exec_monitor($this->task_process($S, $task), $S);
        }

        $response->getBody()->write($res);
    }

    function task_process($S, $task)
    {
        switch ($task) {
            case 1:
                return $this->task1_process($S);
                break;
            case 2:
                return $this->task2_process($S);
                break;
            default:
                return false;
        }

    }

    function task_scope($task)
    {
        switch ($task) {
            case 1:
                return [
                    '100101100101',
                    '100011',
                    '1001',
                    '1100100101'
                ];
                break;
            case 2:
                return [
                    'aaabb',
                    'abbaa',
                    'bb',
                    'aaaa'
                ];
                break;
            default:
                return false;
        }
    }

    function task1_process($S)
    {
        /**
         *  There is string contains binary representation of number
         *  There are to ways to operate with this number:
         *  if it is even num should be divided by 2, if odd num should be substract by 1
         *  Need to count number of iteration for num become 0
         * */
        $num = bindec($S);
        $count = 0;

        while ($num > 0) {
            $num = ($num % 2 == 0) ? $num / 2 : $num - 1;

            $this->console_log($num);
            $count++;
        }

        return $count;
    }

    function task2_process($S)
    {
        /**
         *  Check positions of a letters in string.
         *  if all a before b - true
         *  if at least on a after b  - false
         *  if there are on a - false
         *  if there are on b - true
         * */
        $str = $S;
        $bool = false;

        $a = [];
        $b = [];

        for ($i = 0; $i < strlen($str); $i++) {
            $posa = strpos($str, 'a');
            $posb = strpos($str, 'b');

            $this->console_log($posa);
            $this->console_log($posb);

            if ($posa == 'false') {$bool = false; break;}
            elseif ($posb == 'false') {$bool = true; break;}
            else {
                $a[] = $posa;
                $b[] = $posb;
    
                $this->console_log($a);
                $this->console_log($b);
    
                $str = substr($str, 0, $posa) . substr($str, $posa + 1, strlen($str) - 1);
                $str = substr($str, 0, $posb) . substr($str, $posb + 1, strlen($str) - 1);
            }

        }

        $this->console_log($a);
        $this->console_log($b);

        return json_encode($bool);
    }

    function exec_monitor($fn, $S)
    {
        $fn || exit;
        $res = '<pre>';
        $res .= $S . "\t";
        $starttime = hrtime(true);
        $res .= $fn;
        $endtime = hrtime(true);
        $time = ($endtime - $starttime) / 1000;
        $res .= "\t{$time}s\n";
        $res .= "</pre>";

        return $res;
    }

    
}
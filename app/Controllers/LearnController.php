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
            case 3:
                return $this->task3_process($S);
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
            case 3:
                return [
                    [100, 100, 100, -10], 
                    ['2020-12-31', '2020-12-22', '2020-12-03', '2020-12-29']
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
        $posa = strpos($S, 'a');
        $posb = strpos($S, 'b');

        if ($posa === false) {
            return json_encode(false);
        }
        if ($posb === false) {
            return json_encode(true);
        }

        $lasta = strrpos($S, 'a');
        $firstb = strrpos($S, 'b');

        return json_encode($lasta > $firstb);
    }

    function task3_process($S)
    {
        /**
         *  Given list of transactions. Each transaction specifies the amount and the date it was executed.
         *  If amount negative - then it was a card payment. Otherwise it was an incomming transfer. (amount at least 0)
         *  The date of each transaction is in YYYY-MM-DD format.
         *  Additionally there is a fee for having a card (ommited in the given transaction list), which is 5 per month.
         *  This fee is deducted from the account balance at the end of each month unless there were at least three payments made by card for a total cost of at least 100 within tha month.
         *  Task is to compute the final balance of th account at the end of the year 2020.
         *  Write a function, that given an array A of N integers representing transaction amounts and an attay D of N strings representing transaction dates, returns the final balance of the account at the end of the year 2020.
         * */
        
        return false;
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
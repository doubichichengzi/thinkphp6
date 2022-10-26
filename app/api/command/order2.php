<?php

declare(strict_types=1);

namespace app\api\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\console\output\descriptor\Console;
use think\facade\Cache;

class Order2 extends Command
{
    protected function configure()
    {
        // 指令配置
        $this->setName('hello')
            ->setDescription('the hello command');
    }

    protected function execute(Input $input, Output $output)
    {
        // 指令输出
        while (true) {
            $res = Cache::zRangeByScore("order_status", 0, time(), ["limit" => [0, 1]]);
            if (empty($res)) {
                //return false;
            }
            $output->writeln($res[0]);
            Cache::zRem("order_status", $res[0]);
            sleep(1);
        }
    }
}
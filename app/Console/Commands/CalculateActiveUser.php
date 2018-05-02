<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CalculateActiveUser extends Command
{
    protected $signature = 'larabbs:calculate-active-user';
    protected $description = '生成活跃用户';

    public function handle(User $user)
    {
        // 在命令行打印一行信息
        $this->info("开始计算。。");
        $user->calculateAndCacheActiveUsers();
        $this->info("成功生成");
    }
}

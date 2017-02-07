<?php
/**
 * Created by PhpStorm.
 * User: nikitag
 * Date: 10.11.16
 * Time: 11:42
 */
namespace App\Console\Commands;

use Illuminate\Console\Command;

class Demonize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demonize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Demonize process to listen tcp/udp directly';

    /**
     * Server service.
     *
     * @var MulticastServer
     */
    protected $drip;

    /**
     * Create a new command instance.
     *
     * @param  MulticastServer  $drip
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        var_dump('Console app initted');

        $this->server = new \stdClass();

//        die();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        var_dump('hadnling initted');
        die();
        $this->drip->send(User::find($this->argument('user')));
    }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class EventTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'evt:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
    Event::where('status', 'Publish')
        ->where('tgl_mulai', '<=', Carbon::now()->toDateString())
        ->where('tgl_berakhir', '>=', Carbon::now()->toDateString())
        ->update(['status' => 'Berlangsung']);

    Event::where('status', 'Publish')
        ->where('tgl_berakhir', '<=', Carbon::now()->toDateString())
        ->update(['status' => 'Selesai']);

    Log::info('Status updated successfully.');
    }
}

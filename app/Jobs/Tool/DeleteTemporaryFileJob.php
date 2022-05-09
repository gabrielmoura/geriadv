<?php

namespace App\Jobs\Tool;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;

class DeleteTemporaryFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    protected $path;

    /**
     *
     */
    public function __construct()
    {
        $this->path = storage_path('app/tmp/');
    }

    /**
     * Deleta arquivos cujo o tempo tenha passado mais que 1h
     * @return void
     */
    public function handle()
    {
        foreach (File::files($this->path) as $file) {
            if ($file->isFile()) {
                if (now()->gt(Carbon::parse($file->getATime())->addHour())) {
                    File::delete([$file->getPathname()]);
                }
            }
        }
    }
}

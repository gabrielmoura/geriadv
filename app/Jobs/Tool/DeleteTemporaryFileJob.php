<?php

namespace App\Jobs\Tool;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\Exception\DirectoryNotFoundException;

class DeleteTemporaryFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    public $path;

    public function __construct($path = null)
    {
        $this->path = $path ?? storage_path('app/tmp/');
    }

    /**
     * Deleta arquivos cujo o tempo tenha passado mais que 1h
     */
    public function handle()
    {
        try {
            if (File::isDirectory($this->path)) {
                foreach (File::files($this->path) as $file) {
                    if ($file->isFile()) {
                        if (now()->gt(Carbon::parse($file->getATime())->addHour())) {
                            File::delete([$file->getPathname()]);
                        }
                    }
                }
            } else {
                File::makeDirectory($this->path);
            }
        } catch (\Throwable $throwable) {
            report($throwable);
        }

    }
}

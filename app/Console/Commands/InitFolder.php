<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InitFolder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init_folders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inisiasi Membuat Folder di Storage';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $folderPaths = [
            public_path('storage/docs'),
            public_path('storage/temp_file'),
        ];

        foreach ($folderPaths as $folderPath) {
            self::makeDirectoryStorage($folderPath);
        }
    }

    public static function makeDirectoryStorage(string $path)
    {
        $result = [];

        if (!\File::exists($path)) {
            $result = \File::makeDirectory($path);
        }

        return $result;
    }

}

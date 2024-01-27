<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InitFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init_files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inisiasi Membuat File di Storage';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
	{
		// Menyalin file yang sudah ada
		$this->copyingExistingFiles();

		// Membuat file
		$this->createNonExistingFiles();
	}


	private function copyingExistingFiles()
	{
		foreach($this->existingFiles() as $file)
		{
			if( !\File::exists($file['destination']) ) {
				\File::copy( $file['source'], $file['destination'] );
			}
		}
	}


	private function existingFiles()
	{
		return [
			[
				'source'		=> storage_path('files/import_campaign.xlsx'),
				'destination'	=> storage_path('app/public/docs/import_campaign.xlsx')
			],
		];
	}


	private function createNonExistingFiles()
	{
		foreach($this->nonExistingFiles() as $file)
		{
			if( !\File::exists($file) ) {
				\File::put($file, '');
			}
		}
	}


	private function nonExistingFiles()
	{
		return [
			//
		];
	}
}

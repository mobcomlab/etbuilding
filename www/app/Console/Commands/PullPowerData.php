<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PullPowerData extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'pull:power';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Download power data from Dropbox and populate database with new data.';

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
	 * @return mixed
	 */
	public function fire()
	{
		$directory = 'Naresuan Univ';
		
		if (!Storage::disk('dropbox')->exists($directory)) {
			$this->error('Dropbox directory not found');
			return;
		}
		
		$powerMinDate = strtotime(DB::table('power')->max('recorded_at'));
		
		$this->info('Found Dropbox directory');
		$files = Storage::disk('dropbox')->allFiles($directory); // All files (slower)
		//$files = Storage::disk('dropbox')->files($directory.'/201502/19'); // For individual day
		
		$new_records_count = 0;
		
		foreach($files as $file) {
			
			// Only process *_0001.csv files
			if (preg_match('/(\d{4})(\d{2})(\d{2})\_0001\.csv$/',$file,$match)) {
				
				$file_name = $match[0];
				$file_date = mktime(23, 59, 59, $match[2], $match[3], $match[1]);
				
				// And then only process current or new files
				if (!$powerMinDate || $powerMinDate < $file_date) {
					$this->info('Downloading '.$file);

					// Download file and save it locally
					$contents = Storage::disk('dropbox')->get($file);
					Storage::put($file_name, $contents);

					// Read contents
					$this->info('Processing '.$file);
					Excel::load(storage_path().'/app/'.$file_name, function($reader) use($match, $powerMinDate,&$new_records_count) {
						$results = $reader->toArray();
						
						$cols = array_keys($results[0]);
						unset($cols[0]);
						
						foreach ($results as $row) {
							$time_str = $row[0];
							$date_time_str = $match[1].'-'.$match[2].'-'.$match[3].' '.$time_str;
							$date_time = strtotime($date_time_str);
							if (!$powerMinDate || $powerMinDate < $date_time) {
								foreach ($cols as $col) {
									$val = $row[$col];
									if ($val !== null) {
										DB::table('power')->insert(
								    		['recorded_at' => $date_time_str, 'sensor' => $col, 'value' => $val]);
									}
								}
								$new_records_count++;
							}
						}
					});
				}
			}
		}
		
		$this->info('Inserted '.$new_records_count.' new power records');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [];
	}

}

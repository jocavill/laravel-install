<?php namespace Paddons\Install\Commands;

use Illuminate\Console\Command;
use Artisan;

class InstallCommand extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh database schema and data.';

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
        $this->info('Starting installation...');

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        $tables = DB::select('show tables');

        $property = 'Tables_in_' . DB::getDatabaseName();

        foreach($tables as $table) {
            Schema::drop($table->$property);
        }

        $this->info('Tables dropped');

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        Artisan::call('migrate');

        $this->info('Tables migrated');

        Artisan::call('db:seed');

        $this->info('Seeding done');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }

}

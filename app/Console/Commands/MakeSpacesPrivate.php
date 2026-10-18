<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MakeSpacesPrivate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spaces:make-private {--dry-run : Only list and count files, change nothing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the ACL of every file on the do_spaces disk to private';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $disk = Storage::disk('do_spaces');
        $files = $disk->allFiles('');
        $total = count($files);

        if ($this->option('dry-run')) {
            foreach ($files as $file) {
                $this->line($file);
            }
            $this->info("Dry run: {$total} file(s) would be set to private.");

            return self::SUCCESS;
        }

        if ($total === 0) {
            $this->info('No files found.');

            return self::SUCCESS;
        }

        $failed = [];
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        foreach ($files as $file) {
            try {
                if (!$disk->setVisibility($file, 'private')) {
                    $failed[$file] = 'setVisibility returned false';
                }
            } catch (\Throwable $e) {
                $failed[$file] = $e->getMessage();
            }
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        if ($failed) {
            $this->error(count($failed) . " of {$total} file(s) failed:");
            foreach ($failed as $file => $error) {
                $this->line("  {$file}: {$error}");
            }

            return self::FAILURE;
        }

        $this->info("{$total} file(s) set to private.");

        return self::SUCCESS;
    }
}

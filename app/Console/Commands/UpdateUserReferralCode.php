<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UpdateUserReferralCode extends Command implements ToCollection, WithHeadingRow
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update-referral {file? : Path to the excel file, defaults to Template Member Excel.xlsx}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user referral_code from an Excel file based on email and code_referral column';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->argument('file');

        if (!$filePath) {
            $filePath = database_path('factories/Template Member Excel.xlsx');
        }

        if (!file_exists($filePath)) {
            $this->error("File not found at: {$filePath}");
            return Command::FAILURE;
        }

        $this->info("Reading data from {$filePath}...");

        try {
            Excel::import($this, $filePath);
            $this->info('Process completed successfully.');
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Error processing Excel file: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        $updatedCount = 0;
        $notFoundCount = 0;
        $doesntHaveRefferal = 0;

        $this->withProgressBar($rows, function ($row) use (&$updatedCount, &$notFoundCount, &$doesntHaveRefferal) {
            // Skip empty rows
            if (!isset($row['email']) || empty($row['email'])) {
                return;
            }

            $email = trim($row['email']);
            // The column in excel is 'code_referral' as per user instruction
            $codeReferral = isset($row['code_referral']) ? trim($row['code_referral']) : null;

            if (empty($codeReferral)) {
                $codeReferral = Str::upper(Str::random(4) . now()->format('s') . Str::random(2));
            }

            $user = User::where('email', $email)->withTrashed()->first();

            if ($user) {
                if ($user->referral_code !== $codeReferral) {
                    $user->update(['referral_code' => $codeReferral]);
                    $updatedCount++;
                }
            } else {
                $notFoundCount++;
            }
        });

        $this->newLine();
        $this->info("Updated {$updatedCount} users.");
        if ($notFoundCount > 0) {
            $this->warn("{$notFoundCount} emails from excel not found in database.");
        }
    }
}

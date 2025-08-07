<?php
namespace App\Commands;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\AccountModel;
class CleanupAccounts extends BaseCommand{
    protected $group       = 'cleanup';
    protected $name        = 'cleanup:accounts';
    protected $description = 'Deletes inactive accounts with expired activation tokens.';
    public function run(array $params){
        CLI::write('Starting account cleanup...', 'yellow');
        $accountModel = new AccountModel();
        $currentTime = time();
        $threeHoursAgo = date('Y-m-d H:i:s', $currentTime - (3 * 60 * 60));
        $expiredAccounts = $accountModel
            ->where('is_active', 0)
            ->where('token_created_at <', $threeHoursAgo)
            ->findAll();
        if (empty($expiredAccounts)) {
            CLI::write('No expired inactive accounts found.', 'green');
            return;
        }
        CLI::write('Found ' . count($expiredAccounts) . ' accounts to delete.', 'yellow');
        $deletedCount = 0;
        foreach ($expiredAccounts as $account) {
            if ($accountModel->delete($account['AccountId'])) {
                CLI::write("Deleted account ID: {$account['AccountId']} ({$account['email']})", 'green');
                $deletedCount++;
            } else {
                CLI::write("Failed to delete account ID: {$account['AccountId']} ({$account['email']})", 'red');
            }
        }
        CLI::write("Finished account cleanup. Deleted $deletedCount accounts.", 'yellow');
    }
}
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invoice;
use Carbon\Carbon;

class UpdateInvoiceStatuses extends Command
{
    protected $signature = 'invoices:update-statuses';
    protected $description = 'Update invoice statuses to Due if the due date has been reached';

    public function handle()
    {
        Invoice::where('status', '!=', 'Due')
            ->where('due_date', '<=', Carbon::now())
            ->update(['status' => 'Due']);

        $this->info('Invoice statuses updated successfully.');
    }
}

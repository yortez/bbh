<?php

namespace App\Console\Commands;

use App\Models\Boarder;
use App\Models\Boarders;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateMonthlyInvoices extends Command
{
    protected $signature = 'invoices:generate';
    protected $description = 'Generate monthly invoices for boarders and update their balance';

    public function handle()
    {
        $boarders = Boarders::where('staus', 1)->with('room')->get();
        $now = Carbon::now();

        DB::beginTransaction();

        try {
            foreach ($boarders as $boarder) {
                // Check if an invoice for this month already exists
                $existingInvoice = Invoice::where('boarder_id', $boarder->id)
                    ->whereYear('invoice_date', $now->year)
                    ->whereMonth('invoice_date', $now->month)
                    ->first();

                if (!$existingInvoice) {
                    $roomRate = $boarder->room->rate;

                    $invoice = Invoice::create([
                        'boarders_id' => $boarder->id,
                        'amount' => $roomRate,
                        'invoice_date' => $now->format('Y-m-d'),
                        'due_date' => $now->copy()->addDays(7)->format('Y-m-d'),
                        'status' => 'New',
                    ]);

                    // Update boarder's balance
                    $boarder->balance += $roomRate;
                    $boarder->save();

                    $this->info("Invoice created for boarder {$boarder->name} - Amount: {$roomRate}");
                    $this->info("Boarder {$boarder->name}'s balance updated to: {$boarder->balance}");
                } else {
                    $this->info("Invoice already exists for boarder {$boarder->name} this month.");
                }
            }

            DB::commit();
            $this->info('Monthly invoices generation process completed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('An error occurred: ' . $e->getMessage());
        }
    }
}

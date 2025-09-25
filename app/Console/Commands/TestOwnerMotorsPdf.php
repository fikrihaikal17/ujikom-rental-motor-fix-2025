<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Motor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class TestOwnerMotorsPdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:owner-motors-pdf {owner_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test generating PDF for owner motors';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $ownerId = $this->argument('owner_id');

        if ($ownerId) {
            $owner = User::find($ownerId);
        } else {
            $owner = User::where('role', 'pemilik')->first();
        }

        if (!$owner) {
            $this->error('Owner not found!');
            return;
        }

        $this->info("Testing PDF generation for owner: {$owner->name}");

        $motors = Motor::where('pemilik_id', $owner->id)
            ->with(['tarifRental'])
            ->withCount(['penyewaans as total_rentals'])
            ->withSum(['penyewaans as total_revenue' => function ($q) {
                $q->join('bagi_hasils', 'penyewaans.id', '=', 'bagi_hasils.penyewaan_id');
            }], 'bagi_hasils.bagi_hasil_pemilik')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_motors' => $motors->count(),
            'available_motors' => $motors->where('status', \App\Enums\MotorStatus::AVAILABLE)->count(),
            'rented_motors' => $motors->where('status', \App\Enums\MotorStatus::RENTED)->count(),
            'pending_motors' => $motors->where('status', \App\Enums\MotorStatus::PENDING)->count(),
            'total_revenue' => $motors->sum('total_revenue') ?? 0,
        ];

        $this->info("Found {$stats['total_motors']} motors for this owner");

        try {
            $pdf = PDF::loadView('owner.motors.pdf', compact('motors', 'stats', 'owner'));
            $filename = 'test-motor-list-' . $owner->id . '.pdf';
            $pdf->save(storage_path('app/public/' . $filename));

            $this->info("PDF generated successfully: storage/app/public/{$filename}");
            $this->info("You can view it at: " . asset('storage/' . $filename));
        } catch (\Exception $e) {
            $this->error("Error generating PDF: " . $e->getMessage());
        }
    }
}

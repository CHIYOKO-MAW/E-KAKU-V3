<?php

namespace App\Console\Commands;

use App\Mail\ReminderMail;
use App\Models\KartuKuning;
use App\Models\NotificationE;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendSmartReminder extends Command
{
    protected $signature = 'reminder:smart';
    protected $description = 'Kirim smart reminder untuk status pekerjaan dan masa berlaku kartu kuning';

    public function handle(): int
    {
        $now = Carbon::now();

        $this->remindStatusPekerjaan($now);
        $this->remindKartuMasaBerlaku($now);

        $this->info('Smart reminders processed.');
        return self::SUCCESS;
    }

    private function remindStatusPekerjaan(Carbon $now): void
    {
        $cutoff = $now->copy()->subDays(90)->toDateString();
        $usersToRemind = DB::table('status_pekerjaan')
            ->whereNull('deleted_at')
            ->where(function ($q) use ($cutoff) {
                $q->where('tanggal_update', '<=', $cutoff)
                    ->orWhereNull('tanggal_update');
            })
            ->pluck('user_id');

        foreach ($usersToRemind as $userId) {
            $user = User::find($userId);
            if (! $user) {
                continue;
            }

            $alreadyReminded = NotificationE::where('user_id', $user->id)
                ->where('tipe', 'status_update')
                ->whereDate('created_at', '>=', $now->copy()->subDays(7)->toDateString())
                ->exists();
            if ($alreadyReminded) {
                continue;
            }

            NotificationE::create([
                'user_id' => $user->id,
                'judul' => 'Pengingat: Perbarui Status Pekerjaan',
                'pesan' => 'Silakan perbarui status pekerjaan Anda. Data terakhir sudah lebih dari 90 hari.',
                'status_baca' => false,
                'tipe' => 'status_update',
            ]);

            try {
                Mail::to($user->email)->send(new ReminderMail('status_update', $user));
            } catch (\Throwable $e) {
                Log::warning('Gagal kirim email reminder status.', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    private function remindKartuMasaBerlaku(Carbon $now): void
    {
        $kartuList = KartuKuning::with('user')
            ->whereNotNull('tanggal_cetak')
            ->whereNull('deleted_at')
            ->get();

        foreach ($kartuList as $kartu) {
            if (! $kartu->user) {
                continue;
            }

            $expiredAt = Carbon::parse($kartu->tanggal_cetak)->addYears(2);
            $isNearExpiry = $expiredAt->lessThanOrEqualTo($now->copy()->addDays(30));

            if (! $isNearExpiry) {
                continue;
            }

            $isExpired = $expiredAt->isPast();
            $pesan = $isExpired
                ? 'Kartu Kuning Anda telah melewati masa berlaku 2 tahun. Segera lakukan pembaruan.'
                : 'Kartu Kuning Anda akan segera habis masa berlaku dalam 30 hari. Silakan lakukan pembaruan.';

            $alreadyReminded = NotificationE::where('user_id', $kartu->user->id)
                ->where('tipe', 'kartu_expired')
                ->whereDate('created_at', '>=', $now->copy()->subDays($isExpired ? 30 : 7)->toDateString())
                ->exists();
            if ($alreadyReminded) {
                continue;
            }

            NotificationE::create([
                'user_id' => $kartu->user->id,
                'judul' => 'Pengingat: Masa Berlaku Kartu AK/1',
                'pesan' => $pesan,
                'status_baca' => false,
                'tipe' => 'kartu_expired',
            ]);

            try {
                Mail::to($kartu->user->email)->send(new ReminderMail('kartu_expired', $kartu->user, $kartu));
            } catch (\Throwable $e) {
                Log::warning('Gagal kirim email reminder kartu.', [
                    'user_id' => $kartu->user->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }
}

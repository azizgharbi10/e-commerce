<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class PromoteToAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:promote {email : L\'email de l\'utilisateur à promouvoir}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promouvoir un utilisateur existant en administrateur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        try {
            $user = User::where('email', $email)->firstOrFail();

            if ($user->role === 'admin') {
                $this->warn("⚠ Cet utilisateur est déjà administrateur.");
                return 1;
            }

            $user->update(['role' => 'admin']);

            $this->info("✓ Utilisateur promu en administrateur !");
            $this->line("👤 Nom: {$user->name}");
            $this->line("📧 Email: {$user->email}");
            $this->line("🔑 Nouveau rôle: {$user->role}");

            return 0;

        } catch (\Exception $e) {
            $this->error("❌ Utilisateur non trouvé avec l'email : {$email}");
            return 1;
        }
    }
}

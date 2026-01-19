<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {--email= : L\'email de l\'admin} {--name= : Le nom de l\'admin} {--password= : Le mot de passe}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Créer un nouvel utilisateur administrateur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Récupérer ou demander les informations
        $name = $this->option('name') ?: $this->ask('Quel est le nom de l\'admin ?');
        $email = $this->option('email') ?: $this->ask('Quel est l\'email de l\'admin ?');
        $password = $this->option('password') ?: $this->secret('Quel est le mot de passe ? (minimum 8 caractères)');

        // Valider les données
        $validator = Validator::make([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ], [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        // Créer l'utilisateur admin
        try {
            $admin = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
            ]);

            $this->info("✓ Administrateur créé avec succès !");
            $this->line("📧 Email: {$admin->email}");
            $this->line("👤 Nom: {$admin->name}");
            $this->line("🔑 Rôle: {$admin->role}");

            return 0;

        } catch (\Exception $e) {
            $this->error('Erreur lors de la création de l\'admin : ' . $e->getMessage());
            return 1;
        }
    }
}


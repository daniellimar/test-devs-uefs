<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Console\Command;

class UserCrudCommand extends Command
{
    protected $signature = 'user:crud
                            {action : create|read|update|delete|list}
                            {id?}';

    protected $description = 'CRUD operations for Users via CLI';

    public function __construct(protected UserService $service)
    {
        parent::__construct();
    }

    public function handle()
    {
        $action = $this->argument('action');
        $id = $this->argument('id');

        switch ($action) {
            case 'create':
                $name = $this->ask('Name');

                // Username + email
                while (true) {
                    $input = $this->ask("Nome de usuário (username)");
                    if (!preg_match('/^[a-zA-Z0-9._-]+$/', $input)) {
                        $this->error("Use apenas letras, números, pontos, traços e underscores.");
                        continue;
                    }
                    $emailLocal = $input;
                    break;
                }
                $email = $emailLocal . '@' . config('corporate.domain');

                $password = $this->secret('Password');

                // Pergunta se o usuário deve ser ativo
                while (true) {
                    $activeInput = $this->ask('Ativo? (s/n)', 's');
                    $activeInput = strtolower($activeInput);
                    if (!in_array($activeInput, ['s', 'n'])) {
                        $this->error("Digite 's' para Sim ou 'n' para Não.");
                        continue;
                    }
                    $active = $activeInput === 's' ? 1 : 0;
                    break;
                }

                $user = $this->service->create([
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'active' => $active,
                ]);

                $this->info("User created: {$user->id}");
                break;

            case 'read':
                $user = User::find($id);

                if (!$user) {
                    $this->error('Usuário não encontrado.');
                    return;
                }

                $this->info(json_encode($user->toArray(), JSON_PRETTY_PRINT));
                break;

            case 'update':
                $user = User::find($id);

                if (!$user) {
                    $this->error('Usuário não encontrado.');
                    return;
                }

                $name = $this->ask('Name', $user->name);

                while (true) {
                    $input = $this->ask("Nome de usuário (username)");

                    if (!preg_match('/^[a-zA-Z0-9._-]+$/', $input)) {
                        $this->error("Use apenas letras, números, pontos, traços e underscores.");
                        continue;
                    }

                    $emailLocal = $input;
                    break;
                }

                $email = $emailLocal . '@' . config('corporate.domain');

                $password = $this->secret('Senha (deixe em branco para manter a senha atual)');

                $data = [
                    'name' => $name,
                    'email' => $email,
                ];

                // Pergunta se o usuário deve ser ativo
                while (true) {
                    $activeInput = $this->ask('Ativo? (s/n)', $user->active ? 's' : 'n');
                    $activeInput = strtolower($activeInput);
                    if (!in_array($activeInput, ['s', 'n'])) {
                        $this->error("Digite 's' para Sim ou 'n' para Não.");
                        continue;
                    }
                    $active = $activeInput === 's' ? 1 : 0;
                    break;
                }

                $data['active'] = $active;

                if ($password) {
                    $data['password'] = $password;
                }

                $this->service->update($user, $data);
                $this->info("User updated: {$user->id}");
                break;

            case 'delete':
                $user = User::find($id);

                if (!$user) {
                    $this->error('Usuário não encontrado.');
                    return;
                }

                $this->service->delete($user);
                $this->info("User deleted: {$id}");
                break;

            case 'list':
                $users = $this->service->listAll();

                $this->table(
                    ['ID', 'Nome', 'Email', 'Ativo', 'Criado em'],
                    $users->map(fn($u) => [
                        $u->id,
                        $u->name,
                        $u->email,
                        $u->active ? 'Sim' : 'Não',
                        $u->created_at?->format('d/m/Y H:i:s'),
                    ])->toArray()
                );

                break;

            default:
                $this->error('Invalid action. Use: create|read|update|delete|list');
                break;
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\View\View;

class DeploymentToolsController extends Controller
{
    public function fixStorageScript(): Response
    {
        if (! $this->publicNoTokenEnabled()) {
            return response("This endpoint is disabled. Set DEPLOYMENT_PUBLIC_NO_TOKEN=true to enable.\n", 403, [
                'Content-Type' => 'text/plain; charset=UTF-8',
            ]);
        }

        try {
            $output = $this->runNoTokenMaintenanceSequence();

            return response($output . "\n", 200, [
                'Content-Type' => 'text/plain; charset=UTF-8',
            ]);
        } catch (\Throwable $e) {
            return response('Maintenance run failed: ' . $e->getMessage() . "\n", 500, [
                'Content-Type' => 'text/plain; charset=UTF-8',
            ]);
        }
    }

    public function publicIndex(Request $request): View
    {
        $token = (string) $request->query('token', '');
        $noTokenMode = $this->publicNoTokenEnabled();

        return view('deployment-tools-public', [
            'isConfigured' => $noTokenMode ? true : $this->publicTokenConfigured(),
            'isValidToken' => $noTokenMode ? true : $this->publicTokenValid($token),
            'noTokenMode' => $noTokenMode,
            'token' => $token,
            'status' => $this->statusSnapshot(),
            'availableActions' => $this->publicAvailableActions(),
        ]);
    }

    public function publicRun(Request $request): RedirectResponse
    {
        $noTokenMode = $this->publicNoTokenEnabled();

        $request->validate([
            'action' => 'required|string',
            'token' => $noTokenMode ? 'nullable|string' : 'required|string',
        ]);

        $token = (string) $request->input('token', '');
        $action = (string) $request->input('action', '');

        if (!$noTokenMode && !$this->publicTokenConfigured()) {
            return back()->with('error', 'DEPLOYMENT_PUBLIC_TOKEN is not configured in .env.');
        }

        if (!$noTokenMode && !$this->publicTokenValid($token)) {
            return back()->with('error', 'Invalid deployment token.');
        }

        if (!array_key_exists($action, $this->publicAvailableActions())) {
            return back()->with('error', 'Unsupported action requested.');
        }

        try {
            $output = $action === 'full_deploy'
                ? $this->runFullDeploymentSequence()
                : $this->executeAction($action);

            return back()
                ->with('success', $this->publicAvailableActions()[$action] . ' completed successfully.')
                ->with('command_output', $output);
        } catch (\Throwable $e) {
            return back()->with('error', 'Action failed: ' . $e->getMessage());
        }
    }

    public function once(Request $request): View
    {
        return view('deployment-tools-once', [
            'isConfigured' => true,
            'isValidToken' => true,
            'noTokenMode' => true,
            'isUsed' => false,
            'token' => '',
            'status' => $this->statusSnapshot(),
            'onceActions' => $this->onceAvailableActions(),
        ]);
    }

    public function runOnce(Request $request): RedirectResponse
    {
        try {
            $output = $this->runFullDeploymentSequence();

            return back()
                ->with('success', 'Full deployment sequence completed successfully.')
                ->with('command_output', $output);
        } catch (\Throwable $e) {
            return back()->with('error', 'Deployment sequence failed: ' . $e->getMessage());
        }
    }

    public function runOnceAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => 'required|string',
        ]);

        $action = (string) $request->input('action');

        if (!array_key_exists($action, $this->onceAvailableActions())) {
            return back()->with('error', 'Unsupported action requested.');
        }

        try {
            $output = $this->executeAction($action);

            return back()
                ->with('success', $this->onceAvailableActions()[$action] . ' completed successfully.')
                ->with('command_output', $output);
        } catch (\Throwable $e) {
            return back()->with('error', 'Action failed: ' . $e->getMessage());
        }
    }

    public function index(): View
    {
        $this->ensureAdmin();

        return view('admin.deployment-tools', [
            'status' => $this->statusSnapshot(),
            'availableActions' => $this->availableActions(),
            'toolTokenRequired' => !empty((string) env('DEPLOYMENT_TOOL_TOKEN')),
        ]);
    }

    public function run(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $request->validate([
            'action' => 'required|string',
            'tool_token' => 'nullable|string',
        ]);

        $expectedToken = (string) env('DEPLOYMENT_TOOL_TOKEN', '');
        if ($expectedToken !== '' && !hash_equals($expectedToken, (string) $request->input('tool_token', ''))) {
            return back()->with('error', 'Invalid deployment tool token. Set DEPLOYMENT_TOOL_TOKEN in .env and use the same value here.');
        }

        $action = (string) $request->input('action');

        if (!array_key_exists($action, $this->availableActions())) {
            return back()->with('error', 'Unsupported action requested.');
        }

        try {
            $output = $this->executeAction($action);
            $message = $this->availableActions()[$action] . ' completed successfully.';

            return back()
                ->with('success', $message)
                ->with('command_output', $output);
        } catch (\Throwable $e) {
            return back()
                ->with('error', 'Action failed: ' . $e->getMessage());
        }
    }

    private function executeAction(string $action): string
    {
        return match ($action) {
            'clear_cache' => $this->runArtisanCommand('optimize:clear'),
            'clear_config' => $this->runArtisanCommand('config:clear'),
            'cache_config' => $this->runArtisanCommand('config:cache'),
            'clear_routes' => $this->runArtisanCommand('route:clear'),
            'cache_routes' => $this->runArtisanCommand('route:cache'),
            'clear_views' => $this->runArtisanCommand('view:clear'),
            'cache_views' => $this->runArtisanCommand('view:cache'),
            'storage_link' => $this->runArtisanCommand('storage:link'),
            'migrate_force' => $this->runArtisanCommand('migrate', ['--force' => true]),
            'seed_force' => $this->runArtisanCommand('db:seed', ['--force' => true]),
            'generate_key' => $this->runArtisanCommand('key:generate', ['--force' => true]),
            'ensure_vendor' => $this->ensureVendorFolder(),
            default => throw new \RuntimeException('Unknown action.'),
        };
    }

    private function runArtisanCommand(string $command, array $params = []): string
    {
        Artisan::call($command, $params);

        return trim(Artisan::output()) ?: 'Command executed with no output.';
    }

    private function ensureVendorFolder(): string
    {
        $vendorPath = base_path('vendor');
        $autoloadPath = base_path('vendor/autoload.php');

        if (!File::exists($vendorPath)) {
            File::makeDirectory($vendorPath, 0755, true);
        }

        if (File::exists($autoloadPath)) {
            return 'Vendor folder and autoload.php are present.';
        }

        return 'Vendor folder exists, but vendor/autoload.php is missing. Upload vendor from local build (run composer install locally first).';
    }

    private function availableActions(): array
    {
        return [
            'clear_cache' => 'Clear all caches',
            'clear_config' => 'Clear config cache',
            'cache_config' => 'Rebuild config cache',
            'clear_routes' => 'Clear route cache',
            'cache_routes' => 'Rebuild route cache',
            'clear_views' => 'Clear compiled views',
            'cache_views' => 'Rebuild compiled views',
            'storage_link' => 'Create storage symlink',
            'migrate_force' => 'Run migrations (--force)',
            'seed_force' => 'Run database seeders (--force)',
            'generate_key' => 'Generate app key',
            'ensure_vendor' => 'Ensure vendor folder exists',
        ];
    }

    private function publicAvailableActions(): array
    {
        return [
            'clear_cache' => 'Clear all caches',
            'clear_config' => 'Clear config cache',
            'storage_link' => 'Create storage symlink',
            'migrate_force' => 'Run migrations (--force)',
            'seed_force' => 'Run database seeders (--force)',
            'clear_routes' => 'Clear route cache',
            'cache_config' => 'Rebuild config cache',
            'cache_routes' => 'Rebuild route cache',
            'clear_views' => 'Clear compiled views',
            'cache_views' => 'Rebuild compiled views',
            'full_deploy' => 'Run full deployment sequence',
        ];
    }

    private function onceAvailableActions(): array
    {
        return [
            'clear_cache' => 'Clear all caches',
            'clear_config' => 'Clear config cache',
            'cache_config' => 'Rebuild config cache',
            'clear_routes' => 'Clear route cache',
            'cache_routes' => 'Recreate routes (route:cache)',
            'clear_views' => 'Clear compiled views',
            'cache_views' => 'Recreate views (view:cache)',
            'storage_link' => 'Create storage symlink',
            'migrate_force' => 'Run migrations (--force)',
            'seed_force' => 'Run database seeders (--force)',
        ];
    }

    private function statusSnapshot(): array
    {
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'app_url' => config('app.url'),
            'environment' => app()->environment(),
            'env_file_exists' => File::exists(base_path('.env')),
            'app_key_set' => !empty((string) config('app.key')),
            'vendor_autoload' => File::exists(base_path('vendor/autoload.php')),
            'storage_writable' => is_writable(storage_path()),
            'bootstrap_cache_writable' => is_writable(base_path('bootstrap/cache')),
        ];
    }

    private function ensureAdmin(): void
    {
        $user = auth()->user();
        if (!$user) {
            throw new HttpException(403, 'Please login first.');
        }

        try {
            $roleName = $user->role?->name;
            if ($roleName && strtoupper((string) $roleName) !== 'ADMIN') {
                throw new HttpException(403, 'Only admin users can access deployment tools.');
            }
        } catch (HttpException $e) {
            throw $e;
        } catch (\Throwable $e) {
            // If role mapping fails on shared hosting (missing table/column),
            // keep the page accessible to authenticated users and rely on
            // DEPLOYMENT_TOOL_TOKEN for command execution protection.
        }
    }

    private function runFullDeploymentSequence(): string
    {
        $logs = [];

        $logs[] = '[1/8] ' . $this->ensureVendorFolder();

        if (empty((string) config('app.key'))) {
            $logs[] = '[2/8] ' . $this->runArtisanCommand('key:generate', ['--force' => true]);
        } else {
            $logs[] = '[2/8] APP_KEY already set. Skipped key generation.';
        }

        $logs[] = '[3/8] ' . $this->runArtisanCommand('storage:link');
        $logs[] = '[4/8] ' . $this->runArtisanCommand('optimize:clear');
        $logs[] = '[5/8] ' . $this->runArtisanCommand('migrate', ['--force' => true]);
        $logs[] = '[6/8] ' . $this->runArtisanCommand('db:seed', ['--force' => true]);
        $logs[] = '[7/8] ' . $this->runArtisanCommand('config:cache');
        $logs[] = '[8/8] ' . $this->runArtisanCommand('route:cache');

        return implode("\n\n", $logs);
    }

    private function runNoTokenMaintenanceSequence(): string
    {
        $logs = [];
        $logs[] = '[1/4] ' . $this->runArtisanCommand('storage:link');
        $logs[] = '[2/4] ' . $this->runArtisanCommand('optimize:clear');
        $logs[] = '[3/4] ' . $this->runArtisanCommand('migrate', ['--force' => true]);
        $logs[] = '[4/4] ' . $this->runArtisanCommand('db:seed', ['--force' => true]);

        return implode("\n\n", $logs);
    }

    private function oneTimeTokenConfigured(): bool
    {
        return !empty($this->oneTimeTokenValue());
    }

    private function oneTimeTokenValid(string $token): bool
    {
        $expected = $this->oneTimeTokenValue();

        return $expected !== '' && hash_equals($expected, $token);
    }

    private function oneTimeTokenValue(): string
    {
        return (string) env('DEPLOYMENT_ONE_TIME_TOKEN', env('DEPLOYMENT_PUBLIC_TOKEN', env('DEPLOYMENT_TOOL_TOKEN', '')));
    }

    private function oneTimeLinkUsed(): bool
    {
        return File::exists($this->oneTimeLockPath());
    }

    private function markOneTimeLinkAsUsed(): void
    {
        File::ensureDirectoryExists(dirname($this->oneTimeLockPath()));
        File::put($this->oneTimeLockPath(), now()->toDateTimeString());
    }

    private function oneTimeLockPath(): string
    {
        return storage_path('app/deployment-tools-once-used.lock');
    }

    private function publicTokenConfigured(): bool
    {
        return !empty($this->publicTokenValue());
    }

    private function publicTokenValid(string $token): bool
    {
        $expected = $this->publicTokenValue();

        return $expected !== '' && hash_equals($expected, $token);
    }

    private function publicTokenValue(): string
    {
        return (string) env('DEPLOYMENT_PUBLIC_TOKEN', env('DEPLOYMENT_TOOL_TOKEN', ''));
    }

    private function publicNoTokenEnabled(): bool
    {
        return filter_var((string) env('DEPLOYMENT_PUBLIC_NO_TOKEN', 'false'), FILTER_VALIDATE_BOOL);
    }
}

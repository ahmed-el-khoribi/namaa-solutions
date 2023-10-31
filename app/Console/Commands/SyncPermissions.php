<?php

namespace App\Console\Commands;

use Spatie\Permission\Models\Permission;
use Illuminate\Console\Command;
use Route;

class SyncPermissions extends Command
{
    /**
     * Prefix to be used for route name for admin portal
     */
    protected $adminRoutePrefix = '/portal';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-permissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates & sync the newly created routes to have granted permissions upon users and roles';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Starting synchronizing...");

        $collection = Route::getRoutes();

        $routes = [];

        $permissions = [];

        $bar = $this->output->createProgressBar(count($collection));

        $bar->start();

        $this->info('');
        foreach($collection as $route) {
            if ( $route->getPrefix() == $this->adminRoutePrefix ) {

                $routeName = $route->getName();

                $this->info('Synchronizing route ' . $routeName. '...');

                $this->info('');

                $bar->advance();

                if ($routeName) {
                    $routePartials = explode('.', $routeName);

                    $module = $routePartials[1];

                    $action = $routePartials[2];

                    switch (true) {
                        case in_array($action, ['index', 'show']):
                            $permissions[$module .'_view'] = [
                                'name' => $module .'_view'
                            ];
                            break;

                        case in_array($action, ['create', 'store']):
                            $permissions[$module .'_create'] = [
                                'name' => $module .'_create'
                            ];
                            break;

                        case in_array($action, ['edit', 'update']):
                            $permissions[$module .'_edit'] = [
                                'name' => $module .'_edit'
                            ];
                            break;

                        case in_array($action, ['destroy']):
                            $permissions[$module .'_delete'] = [
                                'name' => $module .'_delete'
                            ];
                            break;

                        default:
                            $permissions[$module .'_'. $action] = [
                                'name' => $module .'_'. $action
                            ];
                            break;
                    }
                    $routes[] = $routeName;
                }
            }
        }

        $bar->finish();

        foreach ($permissions as $permission) {
            Permission::firstOrCreate($permission);
        }
        $this->info('');

        $this->info('Synchronizing routes of admin portal finished successfully');
    }
}

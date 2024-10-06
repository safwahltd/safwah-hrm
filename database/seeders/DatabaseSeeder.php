<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserInfos;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Route;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $email = 'admin@gmail.com';
        $user = User::where('email',$email)->first();
        if (!$user){
            \App\Models\User::create([
                'id' => 1,
                'name' => 'Super Admin',
                'email' => $email,
                'password' => bcrypt('admin@gmail.com'),
                'role' => 'admin',
            ]);
        }
        $userInfo = UserInfos::where('user_id',1)->first();
        if (!$userInfo) {
            \App\Models\UserInfos::create([
                'user_id' => 1,
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
            ]);
        }
        /* Permission Create */
        $routeCollection = Route::getRoutes();
        $middlewareGroup = 'admin.auth';
        $routeNames = [];
        foreach ($routeCollection as $route){
            $middleWares = $route->gatherMiddleware();
            if (in_array($middlewareGroup,$middleWares)){
                $routeName = $route->getName();
                if ($routeName !== 'admin.dashboard' && $routeName !== 'logout'){
                    array_push($routeNames,$routeName);
                }
            }
        }
        foreach ($routeNames as $name) {
            if(!empty($name)) {
                $permission = $name;
                $permission = trim(strtolower($permission));
                $permission = preg_replace('/[\s.,-]+/', ' ', $permission);
                Permission::create([
                    'name' => $permission
                ]);
            }
        }

    }
}

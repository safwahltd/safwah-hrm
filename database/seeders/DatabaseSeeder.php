<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
use App\Models\Setting;
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

        $email = 'admin@safwahltd.com';
        $user = User::where('email',$email)->first();
        if (!$user){
            \App\Models\User::create([
                'id' => 1,
                'name' => 'Super Admin',
                'email' => $email,
                'password' => bcrypt('admin@safwahltd.com'),
                'role' => 'super_admin',
            ]);
        }
        $userInfo = UserInfos::where('user_id',1)->first();
        if (!$userInfo) {
            \App\Models\UserInfos::create([
                'user_id' => 1,
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'employee_id' => 000000,
            ]);
        }
        /* Role Permission */
        $routeCollection = Route::getRoutes();
        $middlewareGroup = 'admin.auth';
        $routeNames = [];
        foreach ($routeCollection as $route){
            $middleWares = $route->gatherMiddleware();
            if (in_array($middlewareGroup,$middleWares)){
                $routeName = $route->getName();
                if ($routeName !== 'admin.dashboard' && $routeName !== 'admin.logout'){
                    array_push($routeNames,$routeName);
                }
            }
        }
        foreach ($routeNames as $name) {
            if(!empty($name)) {
                $permission = $name;
                $permission = trim(strtolower($permission));
                $permission = preg_replace('/[\s.,-]+/', ' ', $permission);
                $per = Permission::where('name',$permission)->first();
                if (!$per){
                    Permission::create([
                        'name' => $permission
                    ]);
                }
            }
        }

        /* Setting */
        $sitting = Setting::find(1);
        if (!$sitting){
            \App\Models\Setting::create([
                'id' => 1,
                'company_name' => 'SAFWAH LIMITED',
                'company_title' => 'A Path For Prosperity',
                'phone' => '+880 9611-656104',
                'hotLine' => '+880 9611-656104',
                'email' => 'safwahmart@gmail.com',
                'address' => 'Kha-9, Confidence Center, Level-10/B, Shahajadpur, Gulshan-2, Dhaka-1212, Bangladesh',
            ]);
        }
    }
}

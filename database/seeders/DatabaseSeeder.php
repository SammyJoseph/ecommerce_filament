<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $diskName = config('media-library.disk_name');
        $prefix = config('media-library.prefix');
        $this->command->warn("Clearing Spatie media directories from disk: '{$diskName}' in '{$prefix}'");

        try {
            $disk = Storage::disk($diskName);
            $path = $prefix ? $prefix : ''; // Obtiene los directorios dentro del prefijo configurado
            $directories = $disk->directories($path);

            $deletedCount = 0;
            foreach ($directories as $directory) {
                $dirname = basename($directory);
                if (is_numeric($dirname)) { // Solo borra los directorios que estén dentro del prefijo y sean numéricos (id de los modelos)
                    $disk->deleteDirectory($directory);
                    $deletedCount++;
                }
            }
            $this->command->info("Deleted {$deletedCount} media directories from {$prefix}.");

        } catch (\InvalidArgumentException $e) {
            $this->command->error("Error accessing disk '{$diskName}'. Check config/filesystems.php and config/media-library.php. Error: " . $e->getMessage());
        } catch (\Exception $e) {
            $this->command->error("An unexpected error occurred while deleting media directories: " . $e->getMessage());
        }

        $this->call(RolesPermissionsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        // $this->call(ProductSeeder::class); // ahora los productos se crean en CategorySeeder
        $this->call(CouponSeeder::class);
        $this->call(OrderSeeder::class);
    }
}

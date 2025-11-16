<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CulturalGeoSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/cultural_map.geojson');

        if (!File::exists($path)) {
            $this->command->error("❌ File GeoJSON tidak ditemukan di: {$path}");
            return;
        }

        $json = File::get($path);
        $data = json_decode($json, true);

        if (!isset($data['features'])) {
            $this->command->error("❌ Format GeoJSON tidak valid (tidak ada 'features').");
            return;
        }

        $inserted = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($data['features'] as $feature) {
            $props = $feature['properties'];
            $coords = $feature['geometry']['coordinates'];

            // Pastikan data memiliki koordinat & nama
            if (empty($props['name']) || count($coords) < 2) {
                $skipped++;
                continue;
            }

            // Cari cultural berdasarkan nama
            $cultural = DB::table('culturals')->where('name', $props['name'])->first();

            if (!$cultural) {
                // Jika belum ada di DB, lewati (tidak buat duplikat)
                $skipped++;
                continue;
            }

            // Cek apakah data maps sudah ada untuk cultural_id ini
            $existingMap = DB::table('cultural_mapsdata')->where('cultural_id', $cultural->id)->first();

            if ($existingMap) {
                // Update koordinat jika ada perubahan
                DB::table('cultural_mapsdata')->where('cultural_id', $cultural->id)->update([
                    'latitude' => $coords[1],
                    'longitude' => $coords[0],
                    'updated_at' => now(),
                ]);
                $updated++;
            } else {
                // Tambahkan data baru ke tabel mapsdata
                DB::table('cultural_mapsdata')->insert([
                    'cultural_id' => $cultural->id,
                    'latitude' => $coords[1],
                    'longitude' => $coords[0],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $inserted++;
            }

            // Sinkronkan kolom has_map agar tetap sesuai
            DB::table('culturals')
                ->where('id', $cultural->id)
                ->update(['has_map' => true, 'updated_at' => now()]);
        }

        $this->command->info("✅ Seeder selesai: {$inserted} data baru, {$updated} diperbarui, {$skipped} dilewati.");
    }
}

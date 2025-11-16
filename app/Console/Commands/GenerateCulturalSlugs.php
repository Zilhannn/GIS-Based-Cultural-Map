<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Cultural;
use Illuminate\Support\Str;

class GenerateCulturalSlugs extends Command
{
    protected $signature = 'cultural:generate-slugs';
    protected $description = 'Generate slugs for Cultural models that dont have them';

    public function handle()
    {
        $this->info('Starting to generate slugs for Cultural models...');

        $culturals = Cultural::whereNull('slug')->orWhere('slug', '')->get();
        $count = 0;

        foreach ($culturals as $cultural) {
            $slug = Str::slug($cultural->name);
            $originalSlug = $slug;
            $counter = 1;

            // Check if slug exists
            while (Cultural::where('slug', $slug)->where('id', '!=', $cultural->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $cultural->slug = $slug;
            $cultural->save();
            $count++;
        }

        $this->info("Generated slugs for {$count} cultural records.");
    }
}
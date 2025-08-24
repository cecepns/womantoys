<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CarouselSlide;
use Illuminate\Support\Facades\Storage;

class CleanBrokenCarouselImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carousel:clean-broken-images {--dry-run : Show what would be cleaned without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean carousel slides with broken image references';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        
        if ($isDryRun) {
            $this->info('🔍 DRY RUN MODE - No changes will be made');
        }

        $slides = CarouselSlide::whereNotNull('image_path')->get();
        $brokenSlides = [];
        $fixedCount = 0;

        $this->info("Checking {$slides->count()} carousel slides...");

        foreach ($slides as $slide) {
            if (!$slide->hasValidImage()) {
                $brokenSlides[] = $slide;
                
                $this->warn("❌ Broken image found: Slide ID {$slide->id}");
                $this->line("   Path: {$slide->image_path}");
                $this->line("   Title: {$slide->title}");
                
                if (!$isDryRun) {
                    // Clear the broken image path
                    $slide->update(['image_path' => null]);
                    $fixedCount++;
                    $this->info("   ✅ Fixed: Cleared broken image path");
                } else {
                    $this->line("   🔧 Would fix: Clear broken image path");
                }
            }
        }

        if (empty($brokenSlides)) {
            $this->info('✅ No broken images found!');
            return 0;
        }

        $this->newLine();
        $this->info("📊 Summary:");
        $this->line("   Total slides checked: {$slides->count()}");
        $this->line("   Broken images found: " . count($brokenSlides));
        
        if (!$isDryRun) {
            $this->line("   Fixed: {$fixedCount}");
            $this->info("✅ Cleanup completed successfully!");
        } else {
            $this->line("   Would fix: " . count($brokenSlides));
            $this->info("💡 Run without --dry-run to apply changes");
        }

        return 0;
    }
}

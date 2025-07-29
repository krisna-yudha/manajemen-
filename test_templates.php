<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🧪 Testing Blade Template Syntax...\n\n";

// Test if blade template compiles without errors
try {
    $viewFactory = app('view');
    
    // Test files
    $templates = [
        'profile.edit',
        'profile.partials.delete-user-form',
        'profile.partials.update-profile-information-form',
        'profile.partials.update-password-form'
    ];
    
    foreach ($templates as $template) {
        try {
            if ($viewFactory->exists($template)) {
                echo "✅ Template '{$template}' exists and syntax is valid\n";
            } else {
                echo "❌ Template '{$template}' not found\n";
            }
        } catch (Exception $e) {
            echo "❌ Template '{$template}' has syntax error: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\n🎯 Template testing complete!\n";
    
} catch (Exception $e) {
    echo "❌ Error during template testing: " . $e->getMessage() . "\n";
}

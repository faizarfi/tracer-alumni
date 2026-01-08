<?php
require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Alumni;

$testimonials = Alumni::whereNotNull('testimonial_quote')->where('testimonial_status', 'approved')->get(['id', 'nama', 'testimonial_status']);
echo "Total testimoni yang disetujui: " . $testimonials->count() . "\n";
foreach ($testimonials as $t) {
    echo "- ID: {$t->id} | Nama: {$t->nama} | Status: {$t->testimonial_status}\n";
}
?>

<?php
$file = 'resources/views/layouts/dashboard.blade.php';
$content = file_get_contents($file);

$strings = [
    'Home' => 'Nyumbani',
    'Manage Listings' => 'Dhibiti Nyumba',
    'My Listings' => 'Nyumba Zangu',
    'Add New Listing' => 'Weka Nyumba Mpya',
    'Bookings' => 'Orodha za Kuhifadhi',
    'Appointments' => 'Miadi',
    'Profile' => 'Wasifu',
    'Manage Profile' => 'Dhibiti Wasifu',
    'Main' => 'Kuu',
    'Dashboard' => 'Dashibodi',
    'Browse Listings' => 'Vinjari Nyumba',
    'My Activity' => 'Shughuli Zangu',
    'My Bookings' => 'Uhifadhi Wangu',
    'Career' => 'Kazi',
    'Become an Agent' => 'Kuwa Wakala',
    'Pending' => 'Inasubiri',
    'Admin Panel' => 'Jopo la Usimamizi',
    'Manage Users' => 'Dhibiti Watumiaji',
    'User Management' => 'Usimamizi wa Watumiaji',
    'Properties' => 'Mali',
    'All Listings' => 'Nyumba Zote',
    'Platform' => 'Jukwaa',
    'Agent Applications' => 'Maombi ya Wakala',
    'Themes' => 'Mionekano',
    'Change Theme' => 'Badili Muonekano',
    'Sign Out' => 'Toka',
];

$translations = [];

// Since there is HTML, let's carefully replace
foreach ($strings as $en => $sw) {
    // Only replace outside of HTML tags and blade directives if possible. 
    // It's safer to just str_replace with exact matching for specific strings we know
    // Example: <i class="..."></i> Add New Listing
    
    // Instead of regex, let's just do exact string replacements for the known HTML patterns:
    $patterns = [
        "> $en" => "> {{ __('$en') }}",
        ">$en<" => ">{{ __('$en') }}<",
        "'$en'" => "'{{ __('$en') }}'",
    ];
    
    foreach($patterns as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }
    
    $translations[$en] = $sw;
}

file_put_contents($file, $content);
file_put_contents('lang/sw.json', json_encode($translations, JSON_PRETTY_PRINT));
echo "Patched dashboard.blade.php\n";

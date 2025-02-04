<?php
require_once 'includes/header.php';

// Historical milestones
$milestones = [
    [
        'year' => '2020',
        'title' => 'Foundation',
        'description' => 'Establishment of Jamia Shere Rabbani Mananwala distt Sheikhupura, Punjab, Pakistan'
    ],
    [
        'year' => '2021',
        'title' => 'First Examination',
        'description' => 'Conducted first standardized examination system'
    ],
    [
        'year' => '2021',
        'title' => 'Government Recognition',
        'description' => 'Official recognition of degrees by the Government of Pakistan'
    ],
    [
        'year' => '2021',
        'title' => 'Curriculum Modernization',
        'description' => 'Major revision of curriculum incorporating modern educational needs'
    ],
    [
        'year' => '2024',
        'title' => 'Digital Transformation',
        'description' => 'Introduction of online services and digital record management'
    ],
    [
        'year' => '2025',
        'title' => 'Global Expansion',
        'description' => 'Extended services to international students and institutions'
    ]
];

// Core values
$values = [
    [
        'icon' => 'book-open',
        'title' => 'Islamic Knowledge',
        'description' => 'Promoting authentic Islamic education based on Quran and Sunnah'
    ],
    [
        'icon' => 'users',
        'title' => 'Community Service',
        'description' => 'Preparing scholars who serve the Muslim community worldwide'
    ],
    [
        'icon' => 'award',
        'title' => 'Academic Excellence',
        'description' => 'Maintaining high standards in Islamic education and research'
    ],
    [
        'icon' => 'globe',
        'title' => 'Global Perspective',
        'description' => 'Connecting Islamic education with contemporary global challenges'
    ]
];

// Statistics
$statistics = [
    [
        'number' => '5+',
        'label' => 'Affiliated Institutions'
    ],
    [
        'number' => '1000+',
        'label' => 'Students Enrolled'
    ],
    [
        'number' => '200+',
        'label' => 'Graduates'
    ],
    [
        'number' => '4+',
        'label' => 'Years of Excellence'
    ]
];
?>

<div class="min-h-screen bg-[#F8F9FA]">
    <!-- Hero Section with Parallax Effect -->
    <div class="relative h-[80vh] overflow-hidden">
        <div class="absolute inset-0">
            <img
                src="https://images.unsplash.com/photo-1542816417-0983c9c9ad53?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80"
                alt="Islamic Architecture"
                class="w-full h-full object-cover"
            >
            <div class="absolute inset-0 bg-gradient-to-r from-green-900/90 to-green-800/80"></div>
        </div>
        <div class="relative h-full flex items-center">
            <div class="container mx-auto px-4">
                <div class="max-w-3xl">
                    <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 leading-tight">
                        Jamia Shere Rabbani <br>Mananala
                    </h1>
                    <p class="text-xl text-green-50 leading-relaxed">
                        Since 2020, Jamia Shere Rabbani Mananala Pakistan has been at the forefront of Islamic education,
                        fostering knowledge, wisdom, and spiritual growth.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mission & Vision Cards -->
    <div class="container mx-auto px-4 -mt-20 relative z-10">
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                <h2 class="text-3xl font-bold text-green-800 mb-4">Our Mission</h2>
                <p class="text-gray-600 leading-relaxed">
                    To provide quality Islamic education through a standardized system that combines traditional
                    Islamic knowledge with modern educational methodologies, preparing scholars who can effectively
                    serve the Muslim community in the contemporary world.
                </p>
            </div>
            <div class="bg-white rounded-2xl p-8 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                <h2 class="text-3xl font-bold text-green-800 mb-4">Our Vision</h2>
                <p class="text-gray-600 leading-relaxed">
                    To be the leading institution in Islamic education, recognized globally for excellence in
                    Islamic studies, research, and the development of scholars who can address contemporary
                    challenges while maintaining Islamic principles.
                </p>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="container mx-auto px-4 py-24">
        <div class="bg-green-800 rounded-3xl p-12">
            <div class="grid md:grid-cols-4 gap-12">
                <?php foreach ($statistics as $stat): ?>
                    <div class="text-center">
                        <div class="text-5xl font-bold text-white mb-2"><?php echo htmlspecialchars($stat['number']); ?></div>
                        <div class="text-green-100"><?php echo htmlspecialchars($stat['label']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Core Values Section -->
    <div class="container mx-auto px-4 py-16">
        <h2 class="text-4xl font-bold text-center text-gray-900 mb-16">Our Core Values</h2>
        <div class="grid md:grid-cols-4 gap-8">
            <?php foreach ($values as $value): ?>
                <div class="group bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                    <div class="inline-block p-4 bg-green-100 rounded-2xl mb-6 group-hover:bg-green-800 transition-colors duration-300">
                        <div class="text-green-800 group-hover:text-white transition-colors duration-300">
                            <i data-lucide="<?php echo $value['icon']; ?>" class="w-8 h-8"></i>
                        </div>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3"><?php echo htmlspecialchars($value['title']); ?></h3>
                    <p class="text-gray-600"><?php echo htmlspecialchars($value['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Timeline Section -->
    <div class="bg-white py-24">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center text-gray-900 mb-16">Our Journey</h2>
            <div class="space-y-12">
                <?php foreach ($milestones as $milestone): ?>
                    <div class="flex group">
                        <div class="w-32 pt-2 flex-shrink-0 text-right">
                            <span class="text-2xl font-bold text-green-800"><?php echo htmlspecialchars($milestone['year']); ?></span>
                        </div>
                        <div class="mx-8 relative">
                            <div class="w-4 h-4 rounded-full bg-green-800 group-hover:ring-4 ring-green-200 transition-all duration-300"></div>
                            <div class="w-px h-full bg-green-200 absolute top-4 left-2"></div>
                        </div>
                        <div class="flex-grow bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 -mt-2">
                            <h3 class="text-xl font-bold text-gray-900 mb-2 flex items-center">
                                <?php echo htmlspecialchars($milestone['title']); ?>
                                <i data-lucide="chevron-right" class="w-5 h-5 ml-2 text-green-800 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                            </h3>
                            <p class="text-gray-600"><?php echo htmlspecialchars($milestone['description']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
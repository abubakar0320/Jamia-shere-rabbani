<?php
require_once 'includes/header.php';

// Examination schedule data
$examSchedule = [
    'annual' => [
        'title' => 'Annual Examinations 2024',
        'registration_start' => '2024-04-01',
        'registration_end' => '2024-04-30',
        'exam_start' => '2024-06-01',
        'exam_end' => '2024-06-30',
        'programs' => [
            'Hafiz Course',
            'Tajveed-o-qirat Course',
            'Matwasita Course',
            'Amma Course',
            'Khasa Course',
            'Alia Course',
            'Almia Course',
            'Takhassus Course'
        ]
    ],
    'supplementary' => [
        'title' => 'Supplementary Examinations 2024',
        'registration_start' => '2024-09-01',
        'registration_end' => '2024-09-30',
        'exam_start' => '2024-11-01',
        'exam_end' => '2024-11-30',
        'programs' => [
            'Hafiz Course',
            'Tajveed-o-qirat Course',
            'Matwasita Course',
            'Amma Course',
            'Khasa Course',
            'Alia Course',
            'Almia Course',
            'Takhassus Course'
        ]
    ]
];

// Important guidelines
$guidelines = [
    'Examination registration must be completed before the deadline',
    'Original CNIC and registration card are mandatory during examinations',
    'Students must arrive at least 30 minutes before the examination',
    'Mobile phones and electronic devices are strictly prohibited',
    'Answer sheets must be written in blue or black ink only',
    'Examination center cannot be changed once allocated'
];

// Required documents
$documents = [
    'Original CNIC/B-Form',
    'Registration Card',
    'Previous Examination DMC (for continuing students)',
    'Passport Size Photographs',
    'Character Certificate from Institution',
    'Migration Certificate (if applicable)'
];
?>

<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900">Examinations</h1>
            <p class="mt-4 text-gray-600">Complete information about examinations and schedules</p>
        </div>

        <!-- Examination Schedule Section -->
        <div class="grid gap-8 mb-12">
            <?php foreach ($examSchedule as $exam): ?>
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <div class="px-6 py-4 bg-green-800 text-white">
                        <h2 class="text-xl font-bold"><?php echo htmlspecialchars($exam['title']); ?></h2>
                    </div>
                    <div class="p-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-3">Registration Period</h3>
                                <p class="text-gray-600">
                                    Start: <?php echo date('d M Y', strtotime($exam['registration_start'])); ?><br>
                                    End: <?php echo date('d M Y', strtotime($exam['registration_end'])); ?>
                                </p>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-3">Examination Period</h3>
                                <p class="text-gray-600">
                                    Start: <?php echo date('d M Y', strtotime($exam['exam_start'])); ?><br>
                                    End: <?php echo date('d M Y', strtotime($exam['exam_end'])); ?>
                                </p>
                            </div>
                        </div>
                        <div class="mt-6">
                            <h3 class="font-semibold text-gray-900 mb-3">Programs</h3>
                            <div class="grid md:grid-cols-2 gap-2">
                                <?php foreach ($exam['programs'] as $program): ?>
                                    <div class="flex items-center">
                                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-2"></i>
                                        <span class="text-gray-600"><?php echo htmlspecialchars($program); ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Guidelines and Documents Section -->
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Guidelines -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-green-800 text-white">
                    <h2 class="text-xl font-bold">Important Guidelines</h2>
                </div>
                <div class="p-6">
                    <ul class="space-y-4">
                        <?php foreach ($guidelines as $guideline): ?>
                            <li class="flex items-start">
                                <i data-lucide="alert-circle" class="w-5 h-5 text-green-600 mr-2 flex-shrink-0"></i>
                                <span class="text-gray-600"><?php echo htmlspecialchars($guideline); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <!-- Required Documents -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="px-6 py-4 bg-green-800 text-white">
                    <h2 class="text-xl font-bold">Required Documents</h2>
                </div>
                <div class="p-6">
                    <ul class="space-y-4">
                        <?php foreach ($documents as $document): ?>
                            <li class="flex items-start">
                                <i data-lucide="file-text" class="w-5 h-5 text-green-600 mr-2 flex-shrink-0"></i>
                                <span class="text-gray-600"><?php echo htmlspecialchars($document); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="mt-12 text-center">
            <a href="/rollno.php" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-green-800 hover:bg-green-700">
                Check Examination Results
                <i data-lucide="arrow-right" class="ml-2 w-5 h-5"></i>
            </a>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
<?php
require_once 'includes/header.php';
$auth = Auth::getInstance();

// Categories and their documents
$downloadCategories = [
    'Admission Forms' => [
        [
            'title' => 'New Student Registration Form',
            'description' => 'Form for new student registration and admission',
            'file_url' => '/documents/admission/registration_form.pdf',
            'size' => '245 KB',
            'updated_at' => '2024-03-15'
        ],
        [
            'title' => 'Transfer Application Form',
            'description' => 'Form for students requesting transfer between institutions',
            'file_url' => '/documents/admission/transfer_form.pdf',
            'size' => '180 KB',
            'updated_at' => '2024-03-10'
        ]
    ],
    'Examination Forms' => [
        [
            'title' => 'Annual Examination Form',
            'description' => 'Examination registration form for regular students',
            'file_url' => '/documents/examination/annual_exam_form.pdf',
            'size' => '220 KB',
            'updated_at' => '2024-03-20'
        ],
        [
            'title' => 'Supplementary Examination Form',
            'description' => 'Form for supplementary examinations',
            'file_url' => '/documents/examination/supply_exam_form.pdf',
            'size' => '215 KB',
            'updated_at' => '2024-03-18'
        ],
        [
            'title' => 'Result Rechecking Form',
            'description' => 'Application form for result rechecking',
            'file_url' => '/documents/examination/recheck_form.pdf',
            'size' => '190 KB',
            'updated_at' => '2024-03-12'
        ]
    ],
    'Academic Documents' => [
        [
            'title' => 'Course Syllabus - Hafiz Course',
            'description' => 'Detailed syllabus for Hafiz Course',
            'file_url' => '/documents/academic/hafiz_syllabus.pdf',
            'size' => '1.2 MB',
            'updated_at' => '2024-02-28'
        ],
        [
            'title' => 'Course Syllabus - Aalim Course',
            'description' => 'Detailed syllabus for Aalim Course',
            'file_url' => '/documents/academic/aalim_syllabus.pdf',
            'size' => '1.5 MB',
            'updated_at' => '2024-02-28'
        ],
        [
            'title' => 'Academic Calendar 2024',
            'description' => 'Academic calendar for the year 2024',
            'file_url' => '/documents/academic/calendar_2024.pdf',
            'size' => '350 KB',
            'updated_at' => '2024-01-15'
        ]
    ],
    'Guidelines & Policies' => [
        [
            'title' => 'Student Handbook',
            'description' => 'Complete guide for students including rules and regulations',
            'file_url' => '/documents/guidelines/student_handbook.pdf',
            'size' => '2.8 MB',
            'updated_at' => '2024-01-20'
        ],
        [
            'title' => 'Examination Rules',
            'description' => 'Comprehensive examination rules and regulations',
            'file_url' => '/documents/guidelines/exam_rules.pdf',
            'size' => '420 KB',
            'updated_at' => '2024-02-15'
        ]
    ]
];

// Search functionality
$searchQuery = $_GET['search'] ?? '';
$searchResults = [];

if ($searchQuery) {
    foreach ($downloadCategories as $category => $documents) {
        foreach ($documents as $document) {
            if (stripos($document['title'], $searchQuery) !== false || 
                stripos($document['description'], $searchQuery) !== false) {
                $document['category'] = $category;
                $searchResults[] = $document;
            }
        }
    }
}
?>

<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900">Downloads</h1>
            <p class="mt-4 text-gray-600">Access and download important documents and forms</p>
        </div>

        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto mb-12">
            <form method="GET" class="flex gap-4">
                <div class="flex-1">
                    <input
                        type="text"
                        name="search"
                        value="<?php echo htmlspecialchars($searchQuery); ?>"
                        placeholder="Search documents..."
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                    >
                </div>
                <button
                    type="submit"
                    class="px-4 py-2 bg-green-800 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                >
                    <i data-lucide="search" class="w-5 h-5"></i>
                </button>
            </form>
        </div>

        <?php if ($searchQuery): ?>
            <!-- Search Results -->
            <div class="mb-12">
                <h2 class="text-xl font-semibold text-gray-900 mb-6">
                    Search Results for "<?php echo htmlspecialchars($searchQuery); ?>"
                </h2>
                <?php if (empty($searchResults)): ?>
                    <p class="text-gray-600 text-center py-8">No documents found matching your search.</p>
                <?php else: ?>
                    <div class="grid gap-6">
                        <?php foreach ($searchResults as $document): ?>
                            <div class="bg-white rounded-lg shadow-md p-6">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <span class="text-sm font-medium text-green-800">
                                            <?php echo htmlspecialchars($document['category']); ?>
                                        </span>
                                        <h3 class="text-lg font-semibold text-gray-900 mt-1">
                                            <?php echo htmlspecialchars($document['title']); ?>
                                        </h3>
                                        <p class="text-gray-600 mt-1">
                                            <?php echo htmlspecialchars($document['description']); ?>
                                        </p>
                                        <div class="flex items-center mt-2 text-sm text-gray-500">
                                            <span class="flex items-center">
                                                <i data-lucide="hard-drive" class="w-4 h-4 mr-1"></i>
                                                <?php echo htmlspecialchars($document['size']); ?>
                                            </span>
                                            <span class="flex items-center ml-4">
                                                <i data-lucide="calendar" class="w-4 h-4 mr-1"></i>
                                                Updated: <?php echo date('M d, Y', strtotime($document['updated_at'])); ?>
                                            </span>
                                        </div>
                                    </div>
                                    <a
                                        href="<?php echo htmlspecialchars($document['file_url']); ?>"
                                        download
                                        class="flex items-center text-green-800 hover:text-green-700"
                                    >
                                        <i data-lucide="download" class="w-5 h-5 mr-1"></i>
                                        Download
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <!-- Categories and Documents -->
            <div class="grid gap-8">
                <?php foreach ($downloadCategories as $category => $documents): ?>
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="px-6 py-4 bg-green-800 text-white">
                            <h2 class="text-xl font-bold"><?php echo htmlspecialchars($category); ?></h2>
                        </div>
                        <div class="divide-y divide-gray-200">
                            <?php foreach ($documents as $document): ?>
                                <div class="p-6 hover:bg-gray-50">
                                    <div class="flex items-start justify-between">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                <?php echo htmlspecialchars($document['title']); ?>
                                            </h3>
                                            <p class="text-gray-600 mt-1">
                                                <?php echo htmlspecialchars($document['description']); ?>
                                            </p>
                                            <div class="flex items-center mt-2 text-sm text-gray-500">
                                                <span class="flex items-center">
                                                    <i data-lucide="hard-drive" class="w-4 h-4 mr-1"></i>
                                                    <?php echo htmlspecialchars($document['size']); ?>
                                                </span>
                                                <span class="flex items-center ml-4">
                                                    <i data-lucide="calendar" class="w-4 h-4 mr-1"></i>
                                                    Updated: <?php echo date('M d, Y', strtotime($document['updated_at'])); ?>
                                                </span>
                                            </div>
                                        </div>
                                        <a
                                            href="<?php echo htmlspecialchars($document['file_url']); ?>"
                                            download
                                            class="flex items-center text-green-800 hover:text-green-700"
                                        >
                                            <i data-lucide="download" class="w-5 h-5 mr-1"></i>
                                            Download
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
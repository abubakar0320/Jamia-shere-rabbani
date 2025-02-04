<?php
require_once 'includes/header.php';
$auth = Auth::getInstance();

$searchError = '';
$results = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $registrationNumber = $_POST['registration_number'] ?? '';
    $rollNumber = $_POST['roll_number'] ?? '';
    
    try {
        $supabase = Database::getClient();
        $query = $supabase
            ->from('results')
            ->select('
                results.id,
                results.marks,
                results.grade,
                results.examination_date,
                courses(title)
            ')
            ->eq('verification_code', $registrationNumber)
            ->execute();
        
        if ($query && !empty($query->data)) {
            $results = $query->data;
        } else {
            $searchError = 'No results found for the provided information.';
        }
    } catch (Exception $e) {
        $searchError = 'An error occurred while fetching results.';
        error_log($e->getMessage());
    }
}
?>

<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900">Examination Results</h1>
            <p class="mt-4 text-gray-600">Enter your CNIC or Roll No to view results</p>
        </div>
        
        <div class="max-w-xl mx-auto">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form method="POST" class="space-y-6">
                    <div>
                        <label for="registration_number" class="block text-sm font-medium text-gray-700">
                            CNIC
                        </label>
                 <boltAction type="file" filePath="results.php">                        <input
                            type="text"
                            id="registration_number"
                            name="registration_number"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                        >
                    </div>
                    
                    <div>
                        <label for="roll_number" class="block text-sm font-medium text-gray-700">
                            Roll Number
                        </label>
                        <input
                            type="text"
                            id="roll_number"
                            name="roll_number"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                        >
                    </div>
                    
                    <div>
                        <button
                            type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-800 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                        >
                            Search Results
                        </button>
                    </div>
                </form>
                
                <?php if ($searchError): ?>
                    <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <?php echo htmlspecialchars($searchError); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($results): ?>
                    <div class="mt-8">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Results Found</h2>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Course
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Marks
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Grade
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Date
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($results as $result): ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php echo htmlspecialchars($result->courses->title); ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php echo htmlspecialchars($result->marks); ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php echo htmlspecialchars($result->grade); ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php echo date('d M Y', strtotime($result->examination_date)); ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
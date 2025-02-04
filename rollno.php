<?php
require_once 'includes/header.php';
$auth = Auth::getInstance();

$error = '';
$success = '';
$result = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rollNumber = $_POST['roll_number'] ?? '';
    
    try {
        $db = Database::getInstance()->getConnection();
        
        $stmt = $db->prepare("
            SELECT 
                s.registration_number,
                s.enrollment_date,
                p.full_name,
                r.marks,
                r.grade,
                r.examination_date,
                c.title as course_title,
                c.code as course_code
            FROM students s
            JOIN profiles p ON p.user_id = s.user_id
            JOIN results r ON r.student_id = s.id
            JOIN courses c ON c.id = r.course_id
            WHERE s.registration_number = :roll_number
        ");
        
        $stmt->execute(['roll_number' => $rollNumber]);
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        if (empty($result)) {
            $error = 'No records found for the provided roll number.';
        }
    } catch (PDOException $e) {
        $error = 'An error occurred while fetching the results.';
        error_log($e->getMessage());
    }
}
?>

<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900">Roll Number Slip Verification</h1>
            <p class="mt-4 text-gray-600">Check your Roll No Slip</p>
        </div>
        
        <div class="max-w-xl mx-auto">
            <div class="bg-white shadow-md rounded-lg p-6">
                <form method="POST" class="space-y-6">
                    <div>
                        <label for="roll_number" class="block text-sm font-medium text-gray-700">
                            Enter Roll Number
                        </label>
                        <input
                            type="text"
                            id="roll_number"
                            name="roll_number"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                            placeholder="Enter your CNIC OR B-Form "
                        >
                    </div>
                    
                    <div>
                        <button
                            type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-800 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                        >
                            Check Roll No Slip
                        </button>
                    </div>
                </form>
                
                <?php if ($error): ?>
                    <div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($result): ?>
                    <div id="printable-area" class="mt-8">
                        <div class="mb-6 text-center">
                            <img
                                src="https://wafaq.edu.pk/assets/images/logo.png"
                                alt="Wafaq Logo"
                                class="h-20 mx-auto mb-4"
                            >
                            <h2 class="text-2xl font-bold text-gray-900">Result Card</h2>
                            <p class="text-gray-600">Wafaqul Madaris Al Arabia Pakistan</p>
                        </div>
                        
                        <div class="mb-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600">Student Name</p>
                                    <p class="font-medium"><?php echo htmlspecialchars($result[0]->full_name); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Roll Number</p>
                                    <p class="font-medium"><?php echo htmlspecialchars($result[0]->registration_number); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600">Enrollment Date</p>
                                    <p class="font-medium"><?php echo date('d M Y', strtotime($result[0]->enrollment_date)); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Course</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Marks</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grade</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php foreach ($result as $row): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <?php echo htmlspecialchars($row->course_title); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <?php echo htmlspecialchars($row->course_code); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <?php echo htmlspecialchars($row->marks); ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <?php echo htmlspecialchars($row->grade); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                        <div class="mt-6 text-right">
                            <button
                                onclick="window.print()"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-800 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                            >
                                <i data-lucide="printer" class="w-4 h-4 mr-2"></i>
                                Print Result Card
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style media="print">
    @page {
        size: A4;
        margin: 2cm;
    }
    
    body * {
        visibility: hidden;
    }
    
    #printable-area, #printable-area * {
        visibility: visible;
    }
    
    #printable-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        padding: 20px;
    }
    
    button {
        display: none !important;
    }
</style>

<?php require_once 'includes/footer.php'; ?>
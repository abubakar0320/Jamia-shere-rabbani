<?php
session_start();
require_once 'includes/header.php';
require_once 'config/database.php';

// Security headers
// header("X-XSS-Protection: 1; mode=block");
// header("X-Content-Type-Options: nosniff");
// header("X-Frame-Options: DENY");
// header("Referrer-Policy: strict-origin-when-cross-origin");

// Initialize variables
$error = '';
$success = '';
$formData = [];

// Function to send SMS using cURL
function sendSMS($phone, $message) {
    // Replace these with your preferred SMS gateway credentials
    $apiKey = "YOUR_API_KEY";
    $sender = "ADMISSIONS";
    
    // Format phone number (assuming Pakistani format)
    if (substr($phone, 0, 1) === '0') {
        $phone = '92' . substr($phone, 1);
    }
    
    // Example using a generic SMS API (replace with your preferred service)
    $url = "https://api.yoursmsgateway.com/send?" . http_build_query([
        'apikey' => $apiKey,
        'sender' => $sender,
        'numbers' => $phone,
        'message' => $message
    ]);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    
    return !$err;
}

// Program details with descriptions
$programs = [
    ['value' => 'Hafiz', 'label' => 'Hafiz Course', 'description' => 'Comprehensive Quran memorization program'],
    ['value' => 'Tajveed-o-qirat', 'label' => 'Tajveed-o-qirat Course', 'description' => 'Master the art of Quranic recitation'],
    ['value' => 'Matwasita', 'label' => 'Matwasita (middle) Course', 'description' => 'Foundation Islamic studies'],
    ['value' => 'Amma-Part-1', 'label' => 'Amma Part 1 Course (Matric)', 'description' => 'Basic Islamic education - Part 1'],
    ['value' => 'Amma-Part-2', 'label' => 'Amma Part 2 Course (Matric)', 'description' => 'Advanced Islamic education - Part 2'],
    ['value' => 'Amma-KHASOOSI', 'label' => 'Amma Khasosi Course (Matric)', 'description' => 'Specialized Islamic studies'],
    ['value' => 'Khasa-Part-1', 'label' => 'Khasa Part 1 Course', 'description' => 'Intermediate Islamic studies - Part 1'],
    ['value' => 'Khasa-Part-2', 'label' => 'Khasa Part 2 Course (F.A)', 'description' => 'Advanced Islamic studies - Part 2'],
    ['value' => 'Khasa-Khasosi', 'label' => 'Khasa Khasosi Course (F.A)', 'description' => 'Specialized advanced studies'],
    ['value' => 'Alia-Part-1', 'label' => 'Alia Part 1 Course', 'description' => 'Higher Islamic education - Part 1'],
    ['value' => 'Alia-Part-2', 'label' => 'Alia Part 2 Course (B.A)', 'description' => 'Bachelor level Islamic studies'],
    ['value' => 'Almia-Part-1', 'label' => 'Almia Part 1 Course', 'description' => 'Advanced scholarly program - Part 1'],
    ['value' => 'Almia-Part-2', 'label' => 'Almia Part 2 Course (M.A)', 'description' => 'Masters in Arabic & Islamic Studies'],
    ['value' => 'Almia-Khasosi-1', 'label' => 'Almia Khasosi Part 1', 'description' => 'Specialized scholarly program - Part 1'],
    ['value' => 'Almia-Khasosi-2', 'label' => 'Almia Khasosi Part 2', 'description' => 'Advanced Masters program'],
    ['value' => 'Takhassus-1', 'label' => 'Takhassus Part 1', 'description' => 'Specialization program - Part 1'],
    ['value' => 'Takhassus-2', 'label' => 'Takhassus Part 2', 'description' => 'Final specialization program']
];

// Requirements with icons
$requirements = [
    ['id' => 1, 'text' => 'Completed Admission Form', 'icon' => 'file-text'],
    ['id' => 2, 'text' => 'Previous Educational Certificates', 'icon' => 'graduation-cap'],
    ['id' => 3, 'text' => 'Valid Student ID Card Copy and Father\'s CNIC Copy', 'icon' => 'id-card'],
    ['id' => 4, 'text' => 'Recent Passport-size Photographs', 'icon' => 'image']
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // CSRF protection
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            throw new Exception('Invalid form submission.');
        }

        // Validate personal information
        $formData['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $formData['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $formData['phone'] = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $formData['program'] = filter_input(INPUT_POST, 'program', FILTER_SANITIZE_STRING);

        if (!$formData['name'] || !$formData['email'] || !$formData['phone'] || !$formData['program']) {
            throw new Exception('Please fill in all required fields.');
        }

        // Validate and handle file uploads
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        $maxFileSize = 5 * 1024 * 1024; // 5MB
        $uploadedFiles = [];
        $uploadDir = 'uploads/' . date('Y/m/');

        // Create upload directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($_FILES['documents']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['documents']['error'][$key] === UPLOAD_ERR_OK) {
                $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($fileInfo, $tmp_name);
                finfo_close($fileInfo);

                if (!in_array($mimeType, $allowedTypes)) {
                    throw new Exception('Invalid file type. Only JPG, PNG, and PDF files are allowed.');
                }

                if ($_FILES['documents']['size'][$key] > $maxFileSize) {
                    throw new Exception('File size exceeds limit. Maximum size is 5MB.');
                }

                $fileName = uniqid() . '-' . basename($_FILES['documents']['name'][$key]);
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($tmp_name, $targetPath)) {
                    $uploadedFiles[] = $targetPath;
                } else {
                    throw new Exception('Failed to upload file: ' . $_FILES['documents']['name'][$key]);
                }
            }
        }

        // Generate application reference number
        $referenceNumber = 'ADM-' . date('Y') . '-' . sprintf('%05d', rand(1, 99999));

        // Save to database (example query)
        /*
        $stmt = $pdo->prepare("INSERT INTO applications (reference_number, name, email, phone, program, documents, status, created_at) 
                              VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())");
        $stmt->execute([$referenceNumber, $formData['name'], $formData['email'], $formData['phone'], 
                       $formData['program'], json_encode($uploadedFiles)]);
        */

        // Send confirmation email
        // $to = $formData['email'];
        // $subject = "Application Received - Reference #" . $referenceNumber;
        // $message = "Dear " . htmlspecialchars($formData['name']) . ",\n\n";
        // $message .= "Your application has been received successfully.\n";
        // $message .= "Reference Number: " . $referenceNumber . "\n";
        // $message .= "Program: " . $formData['program'] . "\n\n";
        // $message .= "We will review your application and contact you soon.\n\n";
        // $message .= "Best regards,\nAdmissions Team";
        
        // $headers = "From: admissions@example.com";
        // mail($to, $subject, $message, $headers);

        // Send SMS notification
        $smsMessage = "Thank you for applying! Your reference number is: " . $referenceNumber . 
                     ". We will contact you soon. - Admissions Team";
        
        $smsSent = sendSMS($formData['phone'], $smsMessage);

        // Set success message
        $success = "Your application has been submitted successfully! Reference Number: " . $referenceNumber;
        if (!$smsSent) {
            $success .= " (SMS notification could not be sent)";
        }
        
        // Clear form data
        $formData = [];
        
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Generate new CSRF token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// [Rest of the HTML code remains exactly the same as in the previous version]
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Admissions</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gradient-to-b from-green-50 to-white min-h-screen">
    <div class="py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <i data-lucide="book-open" class="w-16 h-16 mx-auto text-green-600 mb-4"></i>
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Online Admissions</h1>
                <p class="text-xl text-gray-600">Begin your journey of Islamic education</p>
            </div>

            <div class="max-w-3xl mx-auto">
                <?php if ($success): ?>
                    <div class="bg-white shadow-xl rounded-2xl p-8 text-center mb-8">
                        <i data-lucide="check-circle" class="w-16 h-16 mx-auto text-green-500 mb-4"></i>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Application Submitted Successfully!</h2>
                        <p class="text-gray-600"><?php echo htmlspecialchars($success); ?></p>
                    </div>
                <?php else: ?>
                    <form method="POST" enctype="multipart/form-data" class="bg-white shadow-xl rounded-2xl p-8 mb-8">
                        <?php if ($error): ?>
                            <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i data-lucide="alert-circle" class="w-5 h-5 text-red-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-red-700"><?php echo htmlspecialchars($error); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                        <div class="space-y-6">
                            <!-- Personal Information -->
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                    <input type="text" id="name" name="name" required
                                           value="<?php echo htmlspecialchars($formData['name'] ?? ''); ?>"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                    <input type="email" id="email" name="email" required
                                           value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                </div>
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" required
                                           value="<?php echo htmlspecialchars($formData['phone'] ?? ''); ?>"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                </div>
                            </div>

                            <!-- Program Selection -->
                            <div>
                                <label for="program" class="block text-sm font-medium text-gray-700">Select Your Program</label>
                                <select id="program" name="program" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                    <option value="">Select a program</option>
                                    <?php foreach ($programs as $program): ?>
                                        <option value="<?php echo htmlspecialchars($program['value']); ?>"
                                                <?php echo (isset($formData['program']) && $formData['program'] === $program['value']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($program['label']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <p class="mt-2 text-sm text-gray-500" id="program-description"></p>
                            </div>

                            <!-- Document Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Upload Required Documents</label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-green-400 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <i data-lucide="upload" class="mx-auto h-12 w-12 text-gray-400"></i>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="documents" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                                <span>Upload files</span>
                                                <input id="documents" name="documents[]" type="file" multiple required class="sr-only"
                                                       accept=".jpg,.jpeg,.png,.pdf">
                                            </label>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PDF, JPG, PNG up to 5MB each</p>
                                    </div>
                                </div>
                            </div>

                            <button type="submit"
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                Submit Application
                            </button>
                        </div>
                    </form>

                    <!-- Requirements Section -->
                    <div class="bg-white shadow-xl rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Admission Requirements</h2>
                        <div class="grid gap-6">
                            <?php foreach ($requirements as $req): ?>
                                <div class="flex items-start space-x-3">
                                    <i data-lucide="<?php echo $req['icon']; ?>" class="w-6 h-6 text-green-500 flex-shrink-0"></i>
                                    <span class="text-gray-600"><?php echo htmlspecialchars($req['text']); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Program description update
        const programs = <?php echo json_encode($programs); ?>;
        const programSelect = document.getElementById('program');
        const programDescription = document.getElementById('program-description');

        programSelect.addEventListener('change', function() {
            const selected = programs.find(p => p.value === this.value);
            programDescription.textContent = selected ? selected.description : '';
        });

        // File upload validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const files = document.getElementById('documents').files;
            const maxSize = 5 * 1024 * 1024; // 5MB

            for (let file of files) {
                if (file.size > maxSize) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'File Too Large',
                        text: `${file.name} exceeds the 5MB size limit`
                    });
                    return;
                }
            }
        });

        // Drag and drop functionality
        const dropZone = document.querySelector('.border-dashed');
        const fileInput = document.getElementById('documents');

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        function highlight(e) {
            dropZone.classList.add('border-green-400', 'bg-green-50');
        }

        function unhighlight(e) {
            dropZone.classList.remove('border-green-400', 'bg-green-50');
        }

        dropZone.addEventListener('drop', handleDrop, false);

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
        }
    </script>
</body>
</html>
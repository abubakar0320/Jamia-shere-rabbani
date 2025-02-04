<?php
require_once 'includes/header.php';

$error = '';
$success = '';
$challan = null;

// Updated Program fee structure with all courses
$programFees = [
    'hafiz' => [
        'name' => 'Hafiz Course',
        'admission_fee' => 3000,
        'tuition_fee' => 12000,
        'exam_fee' => 2500,
        'library_fee' => 1500
    ],
    'tajveed-o-qirat' => [
        'name' => 'Tajveed-o-qirat Course',
        'admission_fee' => 3500,
        'tuition_fee' => 13000,
        'exam_fee' => 2500,
        'library_fee' => 1500
    ],
    'matwasita' => [
        'name' => 'Matwasita (middle) Course',
        'admission_fee' => 4000,
        'tuition_fee' => 14000,
        'exam_fee' => 2800,
        'library_fee' => 1800
    ],
    'amma-part-1' => [
        'name' => 'Amma Part 1 Course (Matric)',
        'admission_fee' => 4500,
        'tuition_fee' => 15000,
        'exam_fee' => 3000,
        'library_fee' => 2000
    ],
    'amma-part-2' => [
        'name' => 'Amma Part 2 Course (Matric)',
        'admission_fee' => 4500,
        'tuition_fee' => 15000,
        'exam_fee' => 3000,
        'library_fee' => 2000
    ],
    'amma-khasoosi' => [
        'name' => 'Amma Khasosi Course (Matric)',
        'admission_fee' => 5000,
        'tuition_fee' => 16000,
        'exam_fee' => 3200,
        'library_fee' => 2200
    ],
    'khasa-part-1' => [
        'name' => 'Khasa Part 1 Course',
        'admission_fee' => 5500,
        'tuition_fee' => 17000,
        'exam_fee' => 3500,
        'library_fee' => 2500
    ],
    'khasa-part-2' => [
        'name' => 'Khasa Part 2 Course (F.A)',
        'admission_fee' => 5500,
        'tuition_fee' => 17000,
        'exam_fee' => 3500,
        'library_fee' => 2500
    ],
    'khasa-khasosi' => [
        'name' => 'Khasa Khasosi Course (F.A)',
        'admission_fee' => 1500,
        'tuition_fee' => 2500,
        'exam_fee' => 1000,
        'library_fee' => 500
    ],
    'alia-part-1' => [
        'name' => 'Alia Part 1 Course',
        'admission_fee' => 6500,
        'tuition_fee' => 20000,
        'exam_fee' => 4000,
        'library_fee' => 3000
    ],
    'alia-part-2' => [
        'name' => 'Alia Part 2 Course (B.A)',
        'admission_fee' => 6500,
        'tuition_fee' => 20000,
        'exam_fee' => 4000,
        'library_fee' => 3000
    ],
    'almia-part-1' => [
        'name' => 'Almia Part 1 Course',
        'admission_fee' => 7000,
        'tuition_fee' => 22000,
        'exam_fee' => 4500,
        'library_fee' => 3500
    ],
    'almia-part-2' => [
        'name' => 'Almia Part 2 Course (M.A Arabic & Islamyat)',
        'admission_fee' => 7000,
        'tuition_fee' => 22000,
        'exam_fee' => 4500,
        'library_fee' => 3500
    ],
    'almia-khasosi-part-1' => [
        'name' => 'Almia Khasosi Part 1 Course',
        'admission_fee' => 7500,
        'tuition_fee' => 24000,
        'exam_fee' => 5000,
        'library_fee' => 4000
    ],
    'almia-khasosi-part-2' => [
        'name' => 'Almia Khasosi Part 2 Course (M.A Arabic & Islamyat)',
        'admission_fee' => 7500,
        'tuition_fee' => 24000,
        'exam_fee' => 5000,
        'library_fee' => 4000
    ],
    'takhassus-part-1' => [
        'name' => 'Takhassus Part 1 Course',
        'admission_fee' => 8000,
        'tuition_fee' => 25000,
        'exam_fee' => 5500,
        'library_fee' => 4500
    ],
    'takhassus-part-2' => [
        'name' => 'Takhassus Part 2 Course',
        'admission_fee' => 8000,
        'tuition_fee' => 25000,
        'exam_fee' => 5500,
        'library_fee' => 4500
    ]
];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $program = $_POST['program'] ?? '';
    $accountno = $_POST['account_no'] ?? '          Jazz cash : 03284381312' ;
    $studentName = $_POST['student_name'] ?? '';
    $fatherName = $_POST['father_name'] ?? '';
    $cnic = $_POST['cnic'] ?? '';
    $contact = $_POST['contact'] ?? '';
    $address = $_POST['address'] ?? '';
    
    if (isset($programFees[$program])) {
        $challan = [
            'challan_no' => 'CH-' . date('Y') . '-' . rand(1000, 9999),
            'issue_date' => date('Y-m-d'),
            'due_date' => date('Y-m-d', strtotime('+15 days')),
            'program' => $program,
            'account_no' => $accountno,
            'student_name' => $studentName,
            'father_name' => $fatherName,
            'cnic' => $cnic,
            'contact' => $contact,
            'address' => $address,
            'fees' => $programFees[$program]
        ];
        
        try {
            $db = Database::getInstance()->getConnection();
            
            $stmt = $db->prepare("
                INSERT INTO challans (
                    challan_no, program, student_name, father_name, 
                    cnic, contact, address, total_amount, due_date, 
                    status, created_at
                ) VALUES (
                    :challan_no, :program, :account_no :student_name, :father_name,
                    :cnic, :contact, :address, :total_amount, :due_date,
                    'pending', NOW()
                )
            ");
            
            $totalAmount = array_sum(array_diff_key($programFees[$program], ['name' => '']));
            
            $stmt->execute([
                'challan_no' => $challan['challan_no'],
                'program' => $program,
                'account_no' => $accountno,
                'student_name' => $studentName,
                'father_name' => $fatherName,
                'cnic' => $cnic,
                'contact' => $contact,
                'address' => $address,
                'total_amount' => $totalAmount,
                'due_date' => $challan['due_date']
            ]);
            
            $success = 'Challan has been generated successfully.';
        } catch (PDOException $e) {
            $error = 'An error occurred while generating the challan.';
            error_log($e->getMessage());
        }
    } else {
        $error = 'Invalid program selected.';
    }
}
?>

<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900">Fee Challan Generation</h1>
            <p class="mt-4 text-gray-600">Generate your fee challan by providing the required information</p>
        </div>
        
        <div class="max-w-2xl mx-auto">
            <div class="bg-white shadow-md rounded-lg p-6">
                <?php if ($error): ?>
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        <?php echo htmlspecialchars($success); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!$challan): ?>
                    <form method="POST" class="space-y-6">
                        <div>
                            <label for="program" class="block text-sm font-medium text-gray-700">Program</label>
                            <select
                                id="program"
                                name="program"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                            >
                                <option value="">Select Program</option>
                                <?php foreach ($programFees as $key => $program): ?>
                                    <option value="<?php echo $key; ?>">
                                        <?php echo $program['name']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label for="student_name" class="block text-sm font-medium text-gray-700">Student Name</label>
                            <input
                                type="text"
                                id="student_name"
                                name="student_name"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                            >
                        </div>
                        
                        <div>
                            <label for="father_name" class="block text-sm font-medium text-gray-700">Father's Name</label>
                            <input
                                type="text"
                                id="father_name"
                                name="father_name"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                            >
                        </div>
                        
                        <div>
                            <label for="cnic" class="block text-sm font-medium text-gray-700">CNIC</label>
                            <input
                                type="text"
                                id="cnic"
                                name="cnic"
                                required
                                placeholder="00000-0000000-0"
                                pattern="[0-9]{5}-[0-9]{7}-[0-9]"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                            >
                        </div>
                        
                        <div>
                            <label for="contact" class="block text-sm font-medium text-gray-700">Contact Number</label>
                            <input
                                type="tel"
                                id="contact"
                                name="contact"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                            >
                        </div>
                        
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <textarea
                                id="address"
                                name="address"
                                rows="3"
                                required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                            ></textarea>
                        </div>
                        
                        <div>
                            <button
                                type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-800 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                            >
                                Generate Challan
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
                
                <?php if ($challan): ?>
                    <div id="printable-challan" class="border-2 border-gray-200 p-6">
                        <div class="grid grid-cols-2 gap-8 mb-6">
                            <!-- Bank Copy -->
                            <div class="border-r border-gray-200 pr-8">
                                <div class="text-center mb-4">
                                    <img
                                        src="https://wafaq.edu.pk/assets/images/logo.png"
                                        alt="Wafaq Logo"
                                        class="h-16 mx-auto mb-2"
                                    >
                                    <h3 class="font-bold">Bank Copy</h3>
                                </div>
                                
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="font-medium">Challan No:</span>
                                        <span><?php echo $challan['challan_no']; ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium">Issue Date:</span>
                                        <span><?php echo date('d-m-Y', strtotime($challan['issue_date'])); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium">Due Date:</span>
                                        <span><?php echo date('d-m-Y', strtotime($challan['due_date'])); ?></span>
                                    </div>
                                </div>
                                
                                <div class="mt-4 space-y-2 text-sm">
                                <p><span class="font-medium">Account No:</span> <?php echo htmlspecialchars($challan['account_no']); ?></p>
                                    <p><span class="font-medium">Student Name:</span> <?php echo htmlspecialchars($challan['student_name']); ?></p>
                                    <p><span class="font-medium">Father's Name:</span> <?php echo htmlspecialchars($challan['father_name']); ?></p>
                                    <p><span class="font-medium">Program:</span> <?php echo htmlspecialchars($challan['fees']['name']); ?></p>
                                </div>
                                
                                <table class="mt-4 w-full text-sm">
                                    <thead>
                                        <tr class="border-t border-b">
                                            <th class="py-2 text-left">Description</th>
                                            <th class="py-2 text-right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $total = 0;
                                        foreach ($challan['fees'] as $key => $amount):
                                            if ($key !== 'name'):
                                                $total += $amount;
                                        ?>
                                            <tr>
                                                <td class="py-1"><?php echo ucwords(str_replace('_', ' ', $key)); ?></td>
                                                <td class="py-1 text-right">Rs. <?php echo number_format($amount); ?></td>
                                            </tr>
                                        <?php endif; endforeach; ?>
                                        <tr class="border-t font-bold">
                                            <td class="py-2">Total Amount</td>
                                            <td class="py-2 text-right">Rs. <?php echo number_format($total); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Student Copy -->
                            <div>
                                <div class="text-center mb-4">
                                    <img
                                        src="https://wafaq.edu.pk/assets/images/logo.png"
                                        alt="Wafaq Logo"
                                        class="h-16 mx-auto mb-2"
                                    >
                                    <h3 class="font-bold">Student Copy</h3>
                                </div>
                                
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="font-medium">Challan No:</span>
                                        <span><?php echo $challan['challan_no']; ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium">Issue Date:</span>
                                        <span><?php echo date('d-m-Y', strtotime($challan['issue_date'])); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium">Due Date:</span>
                                        <span><?php echo date('d-m-Y', strtotime($challan['due_date'])); ?></span>
                                    </div>
                                </div>
                                
                                <div class="mt-4 space-y-2 text-sm">
                                <p><span class="font-medium">Account No:</span> <?php echo htmlspecialchars($challan['account_no']); ?></p>
                                    <p><span class="font-medium">Student Name:</span> <?php echo htmlspecialchars($challan['student_name']); ?></p>
                                    <p><span class="font-medium">Father's Name:</span> <?php echo htmlspecialchars($challan['father_name']); ?></p>
                                    <p><span class="font-medium">Program:</span> <?php echo htmlspecialchars($challan['fees']['name']); ?></p>
                                </div>
                                
                                <table class="mt-4 w-full text-sm">
                                    <thead>
                                        <tr class="border-t border-b">
                                            <th class="py-2 text-left">Description</th>
                                            <th class="py-2 text-right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($challan['fees'] as $key => $amount): if ($key !== 'name'): ?>
                                            <tr>
                                                <td class="py-1"><?php echo ucwords(str_replace('_', ' ', $key)); ?></td>
                                                <td class="py-1 text-right">Rs. <?php echo number_format($amount); ?></td>
                                            </tr>
                                        <?php endif; endforeach; ?>
                                        <tr class="border-t font-bold">
                                            <td class="py-2">Total Amount</td>
                                            <td class="py-2 text-right">Rs. <?php echo number_format($total); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Jamia Copy -->

                        <div>
                                <div class="text-center mb-4">
                                    <img
                                        src="https://wafaq.edu.pk/assets/images/logo.png"
                                        alt="Wafaq Logo"
                                        class="h-16 mx-auto mb-2"
                                    >
                                    <h3 class="font-bold">Jamia Copy</h3>
                                </div>
                                
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="font-medium">Challan No:</span>
                                        <span><?php echo $challan['challan_no']; ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium">Issue Date:</span>
                                        <span><?php echo date('d-m-Y', strtotime($challan['issue_date'])); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="font-medium">Due Date:</span>
                                        <span><?php echo date('d-m-Y', strtotime($challan['due_date'])); ?></span>
                                    </div>
                                </div>
                                
                                <div class="mt-4 space-y-2 text-sm">
                                <p><span class="font-medium">Account No:</span> <?php echo htmlspecialchars($challan['account_no']); ?></p>
                                    <p><span class="font-medium">Student Name:</span> <?php echo htmlspecialchars($challan['student_name']); ?></p>
                                    <p><span class="font-medium">Father's Name:</span> <?php echo htmlspecialchars($challan['father_name']); ?></p>
                                    <p><span class="font-medium">Program:</span> <?php echo htmlspecialchars($challan['fees']['name']); ?></p>
                                </div>
                                
                                <table class="mt-4 w-full text-sm">
                                    <thead>
                                        <tr class="border-t border-b">
                                            <th class="py-2 text-left">Description</th>
                                            <th class="py-2 text-right">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($challan['fees'] as $key => $amount): if ($key !== 'name'): ?>
                                            <tr>
                                                <td class="py-1"><?php echo ucwords(str_replace('_', ' ', $key)); ?></td>
                                                <td class="py-1 text-right">Rs. <?php echo number_format($amount); ?></td>
                                            </tr>
                                        <?php endif; endforeach; ?>
                                        <tr class="border-t font-bold">
                                            <td class="py-2">Total Amount</td>
                                            <td class="py-2 text-right">Rs. <?php echo number_format($total); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        
                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-600 mb-4">
                                Please deposit this challan at any branch of Meezan Bank before the due date.
                                Late payment will incur additional charges.
                            </p>
                            <button
                                onclick="window.print()"
                                class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-800 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                            >
                                <i data-lucide="printer" class="w-4 h-4 mr-2"></i>
                                Print Challan
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
        margin: 1cm;
    }
    
    body * {
        visibility: hidden;
    }
    
    #printable-challan, #printable-challan * {
        visibility: visible;
    }
    
    #printable-challan {
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
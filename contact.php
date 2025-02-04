<?php
require_once 'includes/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $message = $_POST['message'] ?? '';
    
    try {
      
        $result = $supabase
            ->from('contact_messages')
            ->insert([
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $message
            ])
            ->execute();
        
        if ($result) {
            $success = 'Your message has been sent successfully!';
        } else {
            $error = 'Failed to send message. Please try again.';
        }
    } catch (Exception $e) {
        $error = 'An error occurred while sending your message.';
        error_log($e->getMessage());
    }
}
?>

<div class="min-h-screen bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-3xl font-bold text-gray-900">Contact Us</h1>
            <p class="mt-4 text-gray-600">Get in touch with us for any inquiries</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
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
                
                <form method="POST" class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Name
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                        >
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Email
                        </label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                        >
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700">
                            Subject
                        </label>
                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                        >
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700">
                            Message
                        </label>
                        <textarea
                            id="message"
                            name="message"
                            rows="4"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                        ></textarea>
                    </div>
                    
                    <div>
                        <button
                            type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-800 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                        >
                            Send Message
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Contact Information</h2>
                
                <div class="space-y-6">
                    <div class="flex items-start">
                        <i data-lucide="map-pin" class="w-5 h-5 text-green-800 mr-3"></i>
                        <div>
                            <h3 class="font-medium text-gray-900">Address</h3>
                            <p class="mt-1 text-gray-600">
                                Jamia Shere Rabani Mananwala District Sheikhupura<br>
                                Punjab, Pakistan
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <i data-lucide="phone" class="w-5 h-5 text-green-800 mr-3"></i>
                        <div>
                            <h3 class="font-medium text-gray-900">Phone</h3>
                            <p class="mt-1 text-gray-600">Dr. Farooq Ali<br>+92-314-4081516<br>Dr. Hafiz Muhammad Ahmad<br>+92-328-4381312<br>+92-332-8364368<br>Abu Bakar <br>+92-309-7354874</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <i data-lucide="mail" class="w-5 h-5 text-green-800 mr-3"></i>
                        <div>
                            <h3 class="font-medium text-gray-900">Email</h3>
                            <p class="mt-1 text-gray-600">jamiashererabbani@gmail.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <i data-lucide="clock" class="w-5 h-5 text-green-800 mr-3"></i>
                        <div>
                            <h3 class="font-medium text-gray-900">Office Hours</h3>
                            <p class="mt-1 text-gray-600">
                                Monday - Saturday: 9:00 AM - 4:00 PM<br>
                                Friday : 09:00 AM - 1:00 PM <br>
                                Sunday: Closed
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-8">
                    <h3 class="font-medium text-gray-900 mb-4">Follow Us</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-green-800 hover:text-green-700">
                            <i data-lucide="facebook" class="w-6 h-6"></i>
                        </a>
                        <a href="#" class="text-green-800 hover:text-green-700">
                            <i data-lucide="twitter" class="w-6 h-6"></i>
                        </a>
                        <a href="#" class="text-green-800 hover:text-green-700">
                            <i data-lucide="youtube" class="w-6 h-6"></i>
                        </a>
                        <a href="#" class="text-green-800 hover:text-green-700">
                            <i data-lucide="instagram" class="w-6 h-6"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
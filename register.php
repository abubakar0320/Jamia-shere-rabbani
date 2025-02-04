<?php
require_once 'includes/header.php';
require_once 'config/database.php'; // Ensure database connection is included

$auth = Auth::getInstance();
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';
    $fullName = htmlspecialchars($_POST['full_name'] ?? '', ENT_QUOTES, 'UTF-8');

    // Validate input
    if (empty($email) || empty($password) || empty($fullName)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Register the user
        if ($auth->signUp($email, $hashedPassword, ['full_name' => $fullName])) {
            $success = 'Registration successful! Please check your email to verify your account.';
        } else {
            $error = 'Registration failed. This email may already be in use.';
        }
    }
}
?>

<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Create your account
            </h2>
        </div>
        
        <?php if ($error): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <form class="mt-8 space-y-6" method="POST">
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="full_name" class="sr-only">Full Name</label>
                    <input
                        id="full_name"
                        name="full_name"
                        type="text"
                        required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm"
                        placeholder="Full Name"
                        value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>"
                    >
                </div><br>
                <div>
                    <label for="email" class="sr-only">Email address</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm"
                        placeholder="Email address"
                        value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                    >
                </div><br>
                <div>
                    <label for="password" class="sr-only">Password</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-green-500 focus:border-green-500 focus:z-10 sm:text-sm"
                        placeholder="Password"
                    >
                </div>
            </div>
             
            <div>
                <button
                    type="submit"
                    class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-800 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                >
                    Register
                </button>
            </div>
            
            <div class="text-center">
                <a href="login.php" class="text-green-800 hover:text-green-700">
                    Already have an account? Sign in here
                </a>
            </div>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

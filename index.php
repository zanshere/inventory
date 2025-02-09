<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="shortcut icon" href="/assets/Images/box_icon_126533.ico" type="image/x-icon">
    <link rel="stylesheet" href="/assets/CSS/font.css">
</head>
<body>
<!-- Konten utama -->
    <!-- Header -->
    <?php include 'includes/header.php';?>

    <!-- Hero Section -->
    <section id="home" class="w-full h-screen flex items-center justify-center">
        <div class="text-center text-white px-8 py-12 mb-45">
            <!-- Logo Web -->
            <img src="assets/Images/box_icon_126533.ico" alt="Website Logo" class="mx-auto w-30 h-auto mb-6">
            
            <!-- Main Heading and Text -->
            <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">Simplify Your Business Inventory</h1>
            <p class="text-lg mb-6 max-w-2xl mx-auto">Streamline your product management, supplier tracking, and transaction recording with ease.</p>
            <a href="#signup" class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold">Get Started</a>
        </div>
    </section>


    <!-- Features Section -->
    <section id="features" class="py-85 bg-gray-800">
        <div class="max-w-9xl py-auto mx-20 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-12">Key Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 px-12">
                <div class="bg-gray-700 p-8 rounded-lg shadow-lg hover:bg-gray-600">
                    <i class="fas fa-box text-4xl text-blue-400 mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Product Management</h3>
                    <p class="text-gray-300">Easily manage your inventory, track stock levels, and update product details.</p>
                </div>
                <div class="bg-gray-700 p-8 rounded-lg shadow-lg hover:bg-gray-600">
                    <i class="fas fa-truck text-4xl text-green-400 mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Supplier & Transactions</h3>
                    <p class="text-gray-300">Keep an eye on supplier activity and record all transactions seamlessly.</p>
                </div>
                <div class="bg-gray-700 p-8 rounded-lg shadow-lg hover:bg-gray-600">
                    <i class="fas fa-chart-line text-4xl text-yellow-400 mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Reports & Analytics</h3>
                    <p class="text-gray-300">Get detailed insights into your business performance with real-time reports.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gray-900">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Contact Us</h2>
            <p class="text-lg text-gray-300 mb-8">Have any questions or need support? Reach out to us and we'll be happy to help!</p>
            <a href="mailto:support@inventorysystem.com" class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold">Email Us</a>
        </div>
    </section>

    <!-- Sign-Up Section -->
    <section id="signup" class="py-20 bg-gray-800">
        <div class="max-w-7xl mx-auto text-center">
            <h2 class="text-3xl font-bold text-white mb-6">Sign Up Now</h2>
            <p class="text-lg text-gray-300 mb-8">Start managing your inventory efficiently today. Join our platform now!</p>
            <a href="auth/login.php" class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold">Sign In</a>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php';?>
</body>
</html>
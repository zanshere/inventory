<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="shortcut icon" href="assets/images/box_icon_126533.ico" type="image/x-icon">
    <link rel="stylesheet" href="assets/CSS/font.css">
</head>

<style>
/* Hero Section */
#home {
    position: relative;
    /* Tambahkan posisi relative agar anak elemen bisa menggunakan position absolute */
    overflow: hidden;
    /* Untuk memastikan tidak ada bagian dari wave yang keluar dari section */
}

/* Ocean Wave Background */
.ocean {
    position: absolute;
    /* Menggunakan absolute agar terikat di dalam #home */
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 999;
    /* Pastikan berada di atas konten */
    overflow: hidden;
    pointer-events: none;
}

.wave {
    background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/85486/wave.svg') repeat-x;
    filter: drop-shadow(0 0 5px #01939c);
    position: absolute;
    bottom: 0;
    width: 6400px;
    height: 155px;
    animation: wave 12s cubic-bezier(0.26, 0.45, 0.43, 0.33) infinite;
    transform: translate3d(0, 0, 0);
}

.wave:nth-of-type(2) {
    bottom: 0;
    animation: wave 12s cubic-bezier(0.26, 0.45, 0.43, 0.33) -.125s infinite, swell 7s ease -1.25s infinite;
    opacity: 0.7;
}

@keyframes wave {
    0% {
        margin-left: 0;
    }

    100% {
        margin-left: -1600px;
    }
}

@keyframes swell {

    0%,
    100% {
        transform: translateY(0);
    }

    50% {
        transform: translateY(-20px);
    }
}
</style>

<body>
    <!-- Konten utama -->

    <!-- Header -->
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section id="home" class="w-full h-screen flex items-center justify-center bg-gray-900">

        <!-- Ocean Wave Background -->
        <div class="ocean">
            <div class="wave"></div>
            <div class="wave"></div>
        </div>

        <div class="text-center text-white px-8 py-12">
            <!-- Logo Web -->
            <img src="assets/images/logo-removebg-white-edition.png" alt="Website Logo" class="mx-auto w-100 h-auto">
            <!-- Main Heading and Text -->
            <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-4">Simplify Your Business Inventory</h1>
            <p class="text-lg mb-6 max-w-2xl mx-auto">
                Streamline your product management, supplier tracking, and transaction recording with ease.
            </p>
            <a href="auth/login.php"
                class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-lg text-lg font-semibold transition-colors">
                Get Started
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-800">
        <div class="max-w-7xl mx-auto text-center px-6">
            <h2 class="text-4xl text-white font-bold mb-4">Key Features</h2>
            <p class="text-lg text-gray-300 mb-12">
                Our platform is packed with powerful features to help you manage your inventory effortlessly. Discover
                what makes our solution stand out.
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature Card 1 -->
                <div class="bg-gray-700 p-8 rounded-lg shadow-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-box text-4xl text-blue-400 mb-4"></i>
                    <h3 class="text-xl text-white font-semibold mb-2">Product Management</h3>
                    <p class="text-gray-300">
                        Easily manage your inventory, track stock levels, and update product details with an intuitive
                        interface.
                    </p>
                </div>
                <!-- Feature Card 2 -->
                <div class="bg-gray-700 p-8 rounded-lg shadow-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-truck text-4xl text-green-400 mb-4"></i>
                    <h3 class="text-xl text-white font-semibold mb-2">Supplier Integration</h3>
                    <p class="text-gray-300">
                        Connect with your suppliers seamlessly and keep track of deliveries and orders in real-time.
                    </p>
                </div>
                <!-- Feature Card 3 -->
                <div class="bg-gray-700 p-8 rounded-lg shadow-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-chart-line text-4xl text-yellow-400 mb-4"></i>
                    <h3 class="text-xl text-white font-semibold mb-2">Advanced Analytics</h3>
                    <p class="text-gray-300">
                        Gain insights into your business performance with comprehensive reports and data visualizations.
                    </p>
                </div>
                <!-- Feature Card 4 -->
                <div class="bg-gray-700 p-8 rounded-lg shadow-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-bell text-4xl text-red-400 mb-4"></i>
                    <h3 class="text-xl text-white font-semibold mb-2">Real-Time Alerts</h3>
                    <p class="text-gray-300">
                        Receive instant notifications for low stock, order updates, and critical business events.
                    </p>
                </div>
                <!-- Feature Card 5 -->
                <div class="bg-gray-700 p-8 rounded-lg shadow-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-user-cog text-4xl text-purple-400 mb-4"></i>
                    <h3 class="text-xl text-white font-semibold mb-2">User Management</h3>
                    <p class="text-gray-300">
                        Manage team access and permissions to ensure data security and efficient collaboration.
                    </p>
                </div>
                <!-- Feature Card 6 -->
                <div class="bg-gray-700 p-8 rounded-lg shadow-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-cloud-upload-alt text-4xl text-indigo-400 mb-4"></i>
                    <h3 class="text-xl text-white font-semibold mb-2">Cloud Backup</h3>
                    <p class="text-gray-300">
                        Securely backup your data in the cloud with our automated and reliable backup solutions.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sign-Up Section -->
    <section id="signup" class="py-20 bg-gray-900">
        <div class="max-w-4xl mx-auto text-center px-6">
            <h2 class="text-4xl font-bold text-white mb-4">Join the Future of Inventory Management</h2>
            <p class="text-lg text-gray-300 mb-8">
                Experience a seamless, efficient, and secure way to manage your business inventory. Unlock a suite of
                powerful features designed to streamline your operations and drive growth.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-8">
                <a href="auth/register.php"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg text-lg font-semibold transition-colors">
                    Sign Up
                </a>
                <a href="auth/login.php"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-3 rounded-lg text-lg font-semibold transition-colors">
                    Sign In
                </a>
            </div>
            <div class="flex justify-center">
                <ul class="text-left text-gray-300 space-y-2">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Streamlined Processes for Quick Onboarding
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Real-Time Updates and Analytics
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Secure Cloud Backup and Data Protection
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gray-800 dark:bg-gray-800">
        <div class="container mx-auto px-4 max-w-6xl">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-white-800 dark:text-white mb-4">Get in Touch</h2>
                <p class="text-gray-400 dark:text-gray-300 max-w-2xl mx-auto">Have a project in mind or want to
                    collaborate?
                    Let's connect! Drop me a message and I'll get back to you within 24 hours.</p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 bg-dark dark:bg-gray-900 rounded-2xl p-8 shadow-lg">
                <!-- Contact Info -->
                <div class="space-y-8">
                    <div>
                        <h3 class="text-xl font-semibold text-white-800 dark:text-white mb-4">Contact Information</h3>
                        <div class="flex items-start space-x-4 mb-6">
                            <div class="bg-gray-700 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-white-600 dark:text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-white-600 dark:text-gray-300">Email</p>
                                <a href="mailto:reventory@gmail.com"
                                    class="text-blue-600 dark:text-blue-400 hover:underline">
                                    reventory@official.com
                                </a>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-gray-700 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-white-600 dark:text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-white-600 dark:text-gray-300">Location</p>
                                <p class="text-white-800 dark:text-gray-200">Cileungsi, Indonesia</p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-gray-200 dark:border-gray-700">
                        <h3 class="text-xl font-semibold text-white-800 dark:text-white mb-6">Follow Retail Inventory
                        </h3>
                        <div class="flex space-x-2">
                            <!-- LinkedIn -->
                            <a href="#"
                                class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 transition-colors">
                                <span class="sr-only">LinkedIn</span>
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                                </svg>
                            </a>
                            <!-- GitHub -->
                            <a href="#"
                                class="text-gray-600 hover:text-white dark:text-gray-300 dark:hover:text-white transition-colors">
                                <span class="sr-only">GitHub</span>
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <!-- Twitter (X) -->
                            <a href="#"
                                class="text-gray-600 hover:text-white dark:text-gray-300 dark:hover:text-white transition-colors">
                                <span class="sr-only">Twitter</span>
                                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <form action="https://api.web3forms.com/submit" method="POST" class="space-y-6">
                    <!-- Replace with your Access Key -->
                    <input type="hidden" name="access_key" value="2389732c-43b6-42d6-addf-e37f33f23504">
                    <div>
                        <label for="name" class="block text-sm font-medium text-white-700 dark:text-gray-300 mb-2">Full
                            Name</label>
                        <input type="text" id="name" name="name" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-gray-100 transition-all"
                            placeholder="John Doe">
                    </div>

                    <div>
                        <label for="email"
                            class="block text-sm font-medium text-white-700 dark:text-gray-300 mb-2">Email
                            Address</label>
                        <input type="email" id="email" name="email" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-gray-100 transition-all"
                            placeholder="you@example.com">
                    </div>

                    <div>
                        <label for="message"
                            class="block text-sm font-medium text-white-700 dark:text-gray-300 mb-2">Your
                            Message</label>
                        <textarea id="message" name="message" rows="5" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-800 dark:text-gray-100 transition-all"
                            placeholder="How can I help you?"></textarea>
                    </div>

                    <!-- Honeypot Spam Protection -->
                    <input type="checkbox" name="botcheck" class="hidden" style="display: none;">

                    <button type="submit" name="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'includes/footer.php';?>

</body>

</html>
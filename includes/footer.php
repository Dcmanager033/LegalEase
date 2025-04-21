<footer class="bg-gray-800 text-white py-12 mt-12">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Logo Column -->
            <div>
                <h3 class="text-xl font-bold mb-4">LegalEase</h3>
                <p class="text-gray-400">
                    Making laws understandable for everyone.
                </p>
            </div>
            
            <!-- Quick Links -->
            <div>
                <h4 class="font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="index.php" class="text-gray-400 hover:text-white transition">Home</a></li>
                    <li><a href="explore.php" class="text-gray-400 hover:text-white transition">Browse Laws</a></li>
                    <li><a href="about.php" class="text-gray-400 hover:text-white transition">About Us</a></li>
                </ul>
            </div>
            
            <!-- Legal -->
            <div>
                <h4 class="font-semibold mb-4">Legal</h4>
                <ul class="space-y-2">
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Terms of Use</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Privacy Policy</a></li>
                    <li><a href="#" class="text-gray-400 hover:text-white transition">Disclaimer</a></li>
                </ul>
            </div>
            
            <!-- Contact -->
            <div>
                <h4 class="font-semibold mb-4">Contact</h4>
                <address class="not-italic text-gray-400 space-y-2">
                    <p>123 Legal Street</p>
                    <p>Mumbai, India 400001</p>
                    <p>Email: info@legalease.example</p>
                    <p>Phone: +91 9876543210</p>
                </address>
            </div>
        </div>
        
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; <?= date('Y') ?> LegalEase. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
    // Mobile menu toggle
    document.getElementById('mobileMenuBtn').addEventListener('click', function() {
        const menu = document.getElementById('mobileMenu');
        menu.classList.toggle('hidden');
    });
</script>
</body>
</html>
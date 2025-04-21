<?php require_once 'includes/header.php'; ?>

<main class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-blue-800 mb-4">About LegalEase</h1>
            <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
        </div>

        <!-- Mission Section -->
        <section class="bg-white p-8 rounded-lg shadow-sm mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Our Mission</h2>
            <div class="prose max-w-none">
                <p class="text-gray-700 mb-4">
                    LegalEase was founded to bridge the gap between complex legal jargon and everyday understanding. 
                    We believe everyone deserves access to clear, accurate legal information without needing a law degree.
                </p>
                <p class="text-gray-700">
                    Our platform simplifies laws using:
                </p>
                <ul class="list-disc pl-5 mt-2 space-y-1 text-gray-700">
                    <li>Plain-language explanations</li>
                    <li>Real-world scenarios</li>
                    <li>Visual aids and examples</li>
                    <li>Direct links to official sources</li>
                </ul>
            </div>
        </section>

        <!-- Team Section -->
        <section class="bg-white p-8 rounded-lg shadow-sm mb-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Who We Are</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Legal Experts</h3>
                    <p class="text-gray-600">
                        Our team includes practicing attorneys and legal scholars who verify all content for accuracy.
                    </p>
                </div>
                <div>
                    <h3 class="text-lg font-medium text-gray-800 mb-3">Tech Team</h3>
                    <p class="text-gray-600">
                        Developers and designers who make legal information accessible through intuitive interfaces.
                    </p>
                </div>
            </div>
        </section>

        <!-- Disclaimer -->
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
            <h3 class="font-medium text-yellow-800 mb-2">Important Disclaimer</h3>
            <p class="text-yellow-700">
                LegalEase provides general information, not legal advice. Consult a qualified professional for specific situations.
            </p>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
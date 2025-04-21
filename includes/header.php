<?php
session_start();
require_once 'db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LegalEase - Simple Law Explorer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .law-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .mobile-menu {
                display: none;
            }

            .mobile-menu.active {
                display: block;
            }
        }
    </style>
</head>

<body class="bg-gray-50">
    <header class="bg-white shadow-sm sticky top-0 z-10">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="index.php" class="text-2xl font-bold text-blue-800">LegalEase</a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-8">
                <a href="index.php" class="text-gray-700 hover:text-blue-600">Home</a>
                <a href="explore.php" class="text-gray-700 hover:text-blue-600">Explore Laws</a>
                <a href="about.php" class="text-gray-700 hover:text-blue-600">About</a>
            </nav>

            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn" class="md:hidden text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="mobile-menu md:hidden bg-white border-t">
            <div class="container mx-auto px-4 py-2 flex flex-col">
                <a href="index.php" class="py-2 px-4 text-gray-700 hover:bg-gray-100">Home</a>
                <a href="explore.php" class="py-2 px-4 text-gray-700 hover:bg-gray-100">Browse Laws</a>
                <a href="about.php" class="py-2 px-4 text-gray-700 hover:bg-gray-100">About</a>
            </div>
        </div>

    </header>

    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('active');
        });
    </script>
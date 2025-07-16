<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to IRIS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Custom styles for the Inter font and overall body */
        body {
            font-family: "Inter", sans-serif;
            background-color: #f0f4f8;
            /* Light gray background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
            /* Add some padding for smaller screens */
            box-sizing: border-box;
        }

        /* Ensure the main container is centered and responsive */
        .container {
            max-width: 800px;
            width: 100%;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="text-5xl font-extrabold text-gray-900 mb-4">
            Welcome to <span class="text-indigo-600">IRIS</span>
        </h1>
        <p class="text-2xl font-semibold text-gray-700 mb-8">
            Interactive Recruitment Information System
        </p>

        <p class="text-lg text-gray-600 mb-8 leading-relaxed">
            IRIS is your comprehensive solution for streamlining the recruitment process.
            From managing applicant profiles and educational attainments to tracking work experiences
            and references, IRIS provides a centralized and efficient platform for all your hiring needs.
            Gain insights into your applicants with detailed reports and ensure a smooth recruitment workflow.
        </p>

        <div class="mt-8">
            <a href="{{ route('login') }}" {{-- Replace # with your actual login or dashboard route --}}
                class="inline-flex items-center px-8 py-4 bg-indigo-600 border border-transparent rounded-lg font-bold text-lg text-white uppercase tracking-wider hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-105">
                Get Started
                <svg class="w-5 h-5 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3">
                    </path>
                </svg>
            </a>
        </div>

        <p class="text-sm text-gray-500 mt-12">
            &copy; {{ date('Y') }} IRIS. All rights reserved.
        </p>
    </div>
</body>

</html>

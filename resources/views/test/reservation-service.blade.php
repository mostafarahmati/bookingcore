<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تست زنده سرویس رزرو</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Vazir:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Vazir', Tahoma, sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-8 max-w-4xl">
        <h1 class="text-4xl font-bold text-center mb-8 text-blue-800">تست زنده ReservationService</h1>
        <p class="text-center text-gray-600 mb-10">بررسی رفتار سیستم در سناریوهای مختلف رزرو</p>

        <div class="grid gap-6">
            @foreach($results as $result)
                <div class="bg-white rounded-lg shadow-lg p-6 border-r-8 {{ $result['status'] === 'success' ? 'border-green-500' : 'border-red-500' }}">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold {{ $result['status'] === 'success' ? 'text-green-700' : 'text-red-700' }}">
                            {{ $result['title'] }}
                        </h2>
                        <span class="text-3xl">
                            {{ $result['status'] === 'success' ? '✅' : '❌' }}
                        </span>
                    </div>
                    <p class="text-lg text-gray-800 mb-2">{{ $result['message'] }}</p>
                    @if(isset($result['details']))
                        <p class="text-sm text-gray-600 bg-gray-50 p-3 rounded mt-3">{{ $result['details'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        <div class="text-center mt-10">
            <a href="{{ url('/test/reservation-service') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-lg">
                اجرای مجدد تست‌ها
            </a>
        </div>

        <footer class="text-center mt-12 text-gray-500">
            <p>سیستم رزرو رویداد - تست زنده سرویس رزرو</p>
            <p class="mt-2">هر بار که صفحه رفرش می‌شود، تست‌ها با داده‌های جدید اجرا می‌شوند</p>
        </footer>
    </div>
</body>
</html>

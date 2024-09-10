<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email hỗ trợ</title>
    <style>
        /* Tailwind CSS */
        @import url('https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css');
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg overflow-hidden mt-8">
        <div class="px-6 py-4">
            <div class="mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Yêu cầu hỗ trợ</h1>
                <p class="text-gray-600">Xin chào: [{{$content->name}}],</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700">
                    Cảm ơn bạn đã liên hệ với chúng tôi về vấn đề gần đây của bạn . Chúng tôi đã xem xét kỹ lưỡng yêu cầu của bạn và xác định được nguyên nhân của vấn đề.
                </p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700">
                    Sau đây là giải pháp chúng tôi đề xuất: <br><br>
                    {{$content->repMessage}}
                </p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700">
                    Nếu bạn vẫn gặp sự cố hoặc nếu giải pháp được cung cấp không giải quyết được vấn đề, vui lòng trả lời email này. Chúng tôi ở đây để hỗ trợ bạn thêm.
                </p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700">
                    Cảm ơn bạn đã đồng hành cùng chúng tôi!
                </p>
            </div>

            </div>
        </div>
        <div class="mb-4">
            <p class="text-gray-700">
                Trân trọng,<br>
            </p>
        </div>
    </div>
</body>
</html>
{{-- {{ config('app.name') }} --}}

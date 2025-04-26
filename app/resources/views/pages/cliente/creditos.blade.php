<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    @vite('resources/css/app.css')
    <style>
        .style-card {
            transition: all 0.3s ease;
        }

        .style-card.selected {
            border-color: #2563eb;
            background-color: #ebf8ff;
        }
    </style>
</head>

<body class="bg-gray-100">
    @include('components.header')
    <div class="flex flex-col items-center px-4 sm:px-6 lg:px-8">
        <!-- Main Content -->
        <main class="w-full max-w-7xl bg-white shadow-md rounded-lg mt-8 p-6">

        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const styleCards = document.querySelectorAll('.style-card');
            const selectedStylesInput = document.getElementById('selectedStyles');

            styleCards.forEach(card => {
                card.addEventListener('click', () => {
                    card.classList.toggle('selected');
                    updateSelectedStyles();
                });
            });

            function updateSelectedStyles() {
                const selectedStyles = Array.from(styleCards)
                    .filter(card => card.classList.contains('selected'))
                    .map(card => card.getAttribute('data-style'));
                selectedStylesInput.value = selectedStyles.join(',');
            }
        });
    </script>
</body>

</html>

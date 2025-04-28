<!doctype html>
<html>

@include('components.head')

<body class="bg-gray-100">
    @include('components.header')
    <div class="flex flex-col items-center px-4 sm:px-6 lg:px-8">
        <main class="w-full max-w-7xl bg-white shadow-md rounded-lg mt-8 p-6">
            @if ($errors->any())
                <div class="mb-4 text-sm text-red-600">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <h1 class="text-2xl font-bold mb-4">Seus Créditos</h1>
            <div class="mb-6">
                <p class="text-lg">Créditos atuais: <span id="currentCredits" class="font-semibold text-green-600">0</span></p>
            </div>
            <div class="mb-6">
                <a href="{{ route('api.stripe.checkout') }}"
                    class="text-white bg-purple-600 hover:bg-purple-700 focus:ring-4 focus:ring-purple-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:text-white dark:focus:ring-purple-900">
                    Comprar 10 Créditos
                </a>
            </div>
            <h2 class="text-xl font-semibold mb-4">Histórico de Compras</h2>
            <div class="overflow-x-auto">
                <table class="table-auto w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="px-4 py-2">Data</th>
                            <th class="px-4 py-2">Descrição</th>
                            <th class="px-4 py-2">Quantidade</th>
                        </tr>
                    </thead>
                    <tbody id="purchaseHistory">
                        <!-- Histórico será preenchido dinamicamente -->
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const currentCreditsElement = document.getElementById('currentCredits');
            const purchaseHistoryElement = document.getElementById('purchaseHistory');

            try {
                const response = await fetch('/api/creditos');
                const data = await response.json();

                currentCreditsElement.textContent = data.currentCredits;

                data.history.forEach(item => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="border px-4 py-2">${item.date}</td>
                        <td class="border px-4 py-2">${item.description}</td>
                        <td class="border px-4 py-2">${item.amount}</td>
                    `;
                    purchaseHistoryElement.appendChild(row);
                });
            } catch (error) {
                console.error('Erro ao carregar os dados:', error);
            }
        });
    </script>
</body>

</html>

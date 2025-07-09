<!doctype html>
<html>

@include('components.head')

<body class="bg-gray-100">
    @include('components.header')
    <div class="flex flex-col items-center px-4 sm:px-6 lg:px-8">
        <main class="w-full max-w-7xl bg-white shadow-md rounded-lg mt-8 p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Créditos -->
                <div
                    class="bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg p-6 shadow text-white flex flex-col justify-between">
                    <div>
                        <div class="text-lg font-semibold mb-2">Seus Créditos</div>
                        <div class="text-4xl font-bold mb-2">{{ $currentCredits }}</div>
                    </div>
                    <a href="{{ route('dashboard.creditos') }}"
                        class="mt-4 inline-block bg-white text-purple-700 font-semibold px-4 py-2 rounded shadow hover:bg-purple-100 transition">Comprar
                        Créditos</a>
                </div>
                <!-- Histórico de Transações -->
                <div class="bg-white rounded-lg p-6 shadow border col-span-2">
                    <div class="flex justify-between items-center mb-4">
                        <div class="text-lg font-semibold text-gray-700">Histórico de Transações</div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="table-auto w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2">Data</th>
                                    <th class="px-4 py-2">Descrição</th>
                                    <th class="px-4 py-2">Quantidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($history as $item)
                                <tr>
                                    <td class="px-4 py-2">{{ $item->created_at->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2">{{ $item->description }}</td>
                                    <td class="px-4 py-2">{{ $item->amount }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-2 text-gray-400">Nenhuma transação encontrada.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Últimas Gerações -->
            <div class="mb-8">
                <div class="flex justify-between items-center mb-4">
                    <div class="text-lg font-semibold text-gray-700">Últimas Imagens Geradas</div>
                    <a href="{{ route('dashboard.geracoes') }}"
                        class="text-purple-600 hover:underline">Ver todas</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    @forelse($generatedImages as $image)
                    <div class="bg-white rounded-lg shadow border overflow-hidden flex flex-col">
                        <div class="h-40 bg-gray-100 flex items-center justify-center">
                            @if($image->status === 'completed')
                            <img src="{{ Storage::disk('s3')->url($image->generated_image_path) }}" alt="Imagem Gerada"
                                class="object-cover w-full h-full">
                            @elseif($image->status === 'failed')
                            <span class="text-red-500">Erro</span>
                            @else
                            <span class="text-gray-400">Processando...</span>
                            @endif
                        </div>
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="font-semibold text-gray-700">Estilo: {{ $image->style }}</div>
                                <div class="text-sm text-gray-500">Status: {{ ucfirst($image->status) }}</div>
                            </div>
                            @if($image->status === 'failed')
                            <div class="text-xs text-red-500 mt-2">{{ $image->error_message }}</div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 text-gray-400">Nenhuma imagem gerada ainda.</div>
                    @endforelse
                </div>
            </div>
            <!-- Banner Promocional -->
            <div
                class="w-full bg-gradient-to-r from-orange-400 to-pink-500 rounded-lg p-8 flex items-center justify-center shadow mb-4 min-h-[120px]">
                <span class="text-white text-xl font-bold">Em breve: novidades e promoções aqui!</span>
            </div>
        </main>
    </div>

</body>

</html>

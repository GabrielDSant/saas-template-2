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
                    @forelse($generatedImages as $img)
                    <div class="bg-gray-50 rounded-lg shadow p-4 flex flex-col items-center">
                        <img src="{{ $img->generated_image_path ? Storage::disk('s3')->url($img->generated_image_path) : '/img/placeholder.png' }}"
                            alt="Imagem Gerada" class="w-full h-40 object-cover rounded mb-2">
                        <div class="flex items-center gap-2 mb-1">
                            <span
                                class="text-xs px-2 py-1 rounded @if($img->status=='completed') bg-green-100 text-green-700 @elseif($img->status=='processing') bg-yellow-100 text-yellow-700 @else bg-red-100 text-red-700 @endif">
                                @if($img->status=='completed') Concluída @elseif($img->status=='processing') Processando @else Erro @endif
                            </span>
                            @if($img->status=='failed')
                            <span class="text-xs text-red-500">{{ $img->error_message }}</span>
                            @endif
                        </div>
                        <div class="text-xs text-gray-500 mb-2">Estilo: <b>{{ $img->style }}</b></div>
                        @if($img->status=='completed')
                        <a href="{{ Storage::disk('s3')->url($img->generated_image_path) }}" download
                            class="text-purple-600 hover:underline text-sm">Baixar</a>
                        @endif
                    </div>
                    @empty
                    <div class="col-span-3 text-gray-400 text-center">Nenhuma imagem gerada ainda. <a
                            href="{{ route('dashboard.geracoes') }}" class="text-purple-600 hover:underline">Experimente
                            agora!</a></div>
                    @endforelse
                </div>
            </div>
        </main>
    </div>
</body>

</html>

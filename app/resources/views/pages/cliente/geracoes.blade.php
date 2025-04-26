<!doctype html>
<html>

@include('components.head')

    <style>
        .style-card {
            transition: all 0.3s ease;
        }

        .style-card.selected {
            border-color: #2563eb;
            background-color: #ebf8ff;
        }
    </style>

<body class="bg-gray-100">
    @include('components.header')
    <div class="flex flex-col items-center px-4 sm:px-6 lg:px-8">
        <!-- Main Content -->
        <main class="w-full max-w-7xl bg-white shadow-md rounded-lg mt-8 p-6">
            <!-- Upload Section -->
            <div class="text-center">
                <form action="{{ route('gerar.imagem') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label for="uploadFile1"
                        class="bg-gray-50 text-slate-500 font-semibold text-base rounded-lg w-full max-w-md h-52 flex flex-col items-center justify-center cursor-pointer border-2 border-gray-300 border-dashed mx-auto hover:bg-gray-100 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 mb-3 fill-gray-500" viewBox="0 0 32 32">
                            <path
                                d="M23.75 11.044a7.99 7.99 0 0 0-15.5-.009A8 8 0 0 0 9 27h3a1 1 0 0 0 0-2H9a6 6 0 0 1-.035-12 1.038 1.038 0 0 0 1.1-.854 5.991 5.991 0 0 1 11.862 0A1.08 1.08 0 0 0 23 13a6 6 0 0 1 0 12h-3a1 1 0 0 0 0 2h3a8 8 0 0 0 .75-15.956z"
                                data-original="#000000" />
                            <path
                                d="M20.293 19.707a1 1 0 0 0 1.414-1.414l-5-5a1 1 0 0 0-1.414 0l-5 5a1 1 0 0 0 1.414 1.414L15 16.414V29a1 1 0 0 0 2 0V16.414z"
                                data-original="#000000" />
                        </svg>
                        <span id="fileLabel" class="text-sm font-medium">Clique para fazer upload</span>
                        <input type="file" id="uploadFile1" name="image" class="hidden" required multiple />
                        <p class="text-xs font-medium text-slate-400 mt-2">PNG, JPG, SVG, WEBP, e GIF são permitidos.</p>
                    </label>

                    <!-- Style Selection -->
                    <div class="mt-8">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4">Escolha os estilos:</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            <div class="style-card border-2 rounded-lg p-4 cursor-pointer hover:shadow-lg" data-style="perfil_profissional">
                                <img src="{{ asset('images/perfil_profissional_example.png') }}" alt="Perfil Profissional"
                                    class="w-full h-32 object-cover rounded-lg mb-2">
                                <p class="text-center font-medium text-gray-700">Perfil Profissional</p>
                            </div>
                            <div class="style-card border-2 rounded-lg p-4 cursor-pointer hover:shadow-lg" data-style="estilo_pintura">
                                <img src="{{ asset('images/estilo_pintura_example.png') }}" alt="Estilo Pintura"
                                    class="w-full h-32 object-cover rounded-lg mb-2">
                                <p class="text-center font-medium text-gray-700">Estilo Pintura</p>
                            </div>
                            <div class="style-card border-2 rounded-lg p-4 cursor-pointer hover:shadow-lg" data-style="estilo_cartoon">
                                <img src="{{ asset('images/estilo_cartoon_example.png') }}" alt="Estilo Cartoon"
                                    class="w-full h-32 object-cover rounded-lg mb-2">
                                <p class="text-center font-medium text-gray-700">Estilo Cartoon</p>
                            </div>
                        </div>
                        <input type="hidden" name="styles" id="selectedStyles" value="" required>
                    </div>

                    <button type="submit"
                        class="mt-6 bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                        Gerar Imagem
                    </button>
                </form>
            </div>

            <!-- Last Generated Images -->
            <div class="mt-12">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Últimas Imagens Geradas</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($lastGeneratedImages as $image)
                        <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                            <img src="{{ asset('storage/' . $image->path) }}" alt="Imagem Gerada"
                                class="w-full h-40 object-cover">
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#uploadFile1').on('change', function () {
                const files = $(this)[0].files;
                const fileNames = Array.from(files).map(file => file.name).join(', ');
                $('#fileLabel').text(fileNames || 'Clique para fazer upload');
            });
        });
    </script>
</body>

</html>

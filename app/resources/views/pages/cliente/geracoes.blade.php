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
                    <p class="text-lg">Créditos atuais: <span id="currentCredits"
                            class="font-semibold text-green-600">0</span></p>
                </div>
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
                        <input type="file" id="uploadFile1" name="image" class="hidden" required />
                        <p class="text-xs font-medium text-slate-400 mt-2">PNG, JPG, SVG, WEBP, e GIF são permitidos.
                        </p>
                    </label>

                    <!-- Pré-visualização da imagem -->
                    <h3 class="text-sm mt-4 font-medium text-gray-700 mb-2">Imagem selecionada:</h3>
                    <div id="previewContainer" class="mt-4 hidden flex justify-center">
                        <img id="imagePreview" src="" alt="Pré-visualização da imagem"
                            class="w-full max-w-md rounded-lg shadow-md">
                    </div>

                    <!-- Style Selection -->
                    <div class="mt-8">
                        <h2 class="text-lg font-semibold text-gray-700 mb-4">Escolha os estilos:</h2>
                        <div class="hidden lg:grid grid-cols-3 gap-6">
                            @foreach ($estilos as $estilo)
                                <div class="style-card border-2 rounded-lg p-4 cursor-pointer hover:shadow-lg"
                                    data-style="{{ $estilo->name }}">
                                    <img src="{{ $estilo->image_path }}" alt="{{ $estilo->name }}"
                                        class="w-full h-46 object-cover rounded-lg mb-2">
                                    <p class="text-center font-medium text-gray-700">{{ $estilo->name }}</p>
                                </div>
                            @endforeach
                        </div>
                        <div class="lg:hidden">
                            <div class="carousel">
                                @foreach ($estilos as $estilo)
                                    <div class="style-card border-2 rounded-lg p-4 cursor-pointer hover:shadow-lg"
                                        data-style="{{ $estilo->name }}">
                                        <img src="{{ $estilo->image_path }}" alt="{{ $estilo->name }}"
                                            class="w-full h-46 object-cover rounded-lg mb-2">
                                        <p class="text-center font-medium text-gray-700">{{ $estilo->name }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <input type="hidden" name="styles" id="selectedStyles" value="" required>
                        <!-- Campo oculto para armazenar os estilos selecionados -->
                    </div>

                    <button type="submit"
                        class="mt-6 bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                        Gerar Imagem
                    </button>
                </form>
            </div>

            <!-- Last Generated Images -->
            <div class="mt-12">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Status das Imagens Geradas</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($generatedImages as $image)
                        <div class="border rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                            <p class="p-4">
                                <strong>Estilo:</strong> {{ $image->style }}<br>
                                <strong>Status:</strong> {{ $image->status }}
                            </p>
                            @if ($image->status === 'completed')
                                <img src="{{ asset('storage/' . $image->generated_image_path) }}" alt="Imagem Gerada"
                                    class="w-full h-40 object-cover">
                            @elseif ($image->status === 'failed')
                                <p class="text-red-500 p-4">Erro: {{ $image->error_message }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Pré-visualização da imagem
            $('#uploadFile1').on('change', function() {
                const files = $(this)[0].files;
                const fileNames = Array.from(files).map(file => file.name).join(', ');
                $('#fileLabel').text(fileNames || 'Clique para fazer upload');

                if (files && files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result);
                        $('#previewContainer').removeClass('hidden');
                    };
                    reader.readAsDataURL(files[0]);
                }
            });

            // Inicializar o carousel apenas se houver itens
            if ($('.carousel .style-card').length > 0) {
                $('.carousel').slick({
                    infinite: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    arrows: false,
                    dots: true,
                });
            }

            // Seleção de estilos (grid e carousel)
            $(document).on('click', '.style-card', function() {
                $(this).toggleClass('selected');
                const selectedStyles = $('.style-card.selected').map(function() {
                    return $(this).data('style');
                }).get();
                $('#selectedStyles').val(selectedStyles.join(',')); // Atualizar o campo oculto
            });

            // Garantir que o formulário seja enviado corretamente
            $('form').on('submit', function(e) {
                const selectedStyles = $('#selectedStyles').val();
                if (!selectedStyles) {
                    e.preventDefault();
                    alert('Por favor, selecione pelo menos um estilo antes de enviar.');
                }
            });
        });
    </script>
</body>

</html>

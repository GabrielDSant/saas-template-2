<!doctype html>
<html>

@include('components.head')


<body>
    @include('components.header')

    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8 ">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto" src="/img/logo.png" alt="Sua Empresa">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Faça login na sua conta
            </h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 p-3 text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form class="space-y-6" action="/auth/login" method="POST">
                @csrf <!-- Adiciona o token CSRF -->
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-900">Endereço de email</label>
                    <div class="mt-2">
                        <input type="email" name="email" id="email" autocomplete="email" required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Senha</label>
                        <div class="text-sm">
                            <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Esqueceu a
                                senha?</a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <input type="password" name="password" id="password" autocomplete="current-password" required
                            class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                </div>

                <div>
                    <button type="submit"
                        class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Entrar</button>
                </div>
                <div class="mt-6">
                    <a href="{{ $googleLoginUrl }}"
                        class="flex w-full justify-center rounded-md bg-red-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                        Entrar com Google
                    </a>
            </form>
            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Não possui uma conta?
                <a href="{{ route('auth.register') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">Crie uma
                </a>
            </p>
        </div>
    </div>
</body>

</html>

#!/bin/bash
# no laravel para criar as tabelas do sessons
# php artisan session:table
# php artisan migrate
# Caminho para o diretório do projeto Laravel
PROJECT_DIR="/Ubuntu/home/sant/projetos/saas-template"

# Verifica se o Artisan está acessível
if [ ! -f "$PROJECT_DIR/artisan" ]; then
    echo "O arquivo artisan não foi encontrado no diretório especificado."
    exit 1
fi

# Executa o comando para criar a role "cliente"
cd "$PROJECT_DIR"
php artisan tinker --execute="\Spatie\Permission\Models\Role::firstOrCreate(['name' => 'cliente']);"

php artisan tinker --execute="\Spatie\Permission\Models\Role::firstOrCreate(['name' => 'admin']);"

echo "Role 'cliente' criada com sucesso (se ainda não existia)."
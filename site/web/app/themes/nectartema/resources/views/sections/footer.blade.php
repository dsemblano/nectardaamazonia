<footer class="content-info bg-fundo">
    <div
        class="container max-w-none">
        @php(dynamic_sidebar('sidebar-footer'))
        <div class="text-sm mt-4 flex flex-col items-center copyright border-gray-500 border-t border-solid pt-8 gap-2">
            <span class="z-10 font-bold">© 2018 - {{ date('Y') }} 
                <a class="hover:underline" href="{{ home_url('/') }}">Néctar da Amazônia</a>
                <span id="trademark" class="sup align-text-bottom">&reg;</span>
            </span>
        </div>
    </div>

</footer>

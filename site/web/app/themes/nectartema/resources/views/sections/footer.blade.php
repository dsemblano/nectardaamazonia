<footer class="content-info bg-verde text-white py-6">
    <div
        class="container max-w-none text-white prose:a:text-white">
        @php(dynamic_sidebar('sidebar-footer'))
        <div class="text-sm mt-4 flex flex-col items-center copyright border-gray-500 border-t border-solid pt-8 gap-2 text-white">
            <span class="z-10 font-bold text-white">© 2009 - {{ date('Y') }} 
                <a class="text-white hover:underline" href="{{ home_url('/') }}">Néctar da Amazônia</a>
                <span id="trademark" class="sup align-text-bottom">&reg;</span>
            </span>
        </div>
    </div>

</footer>

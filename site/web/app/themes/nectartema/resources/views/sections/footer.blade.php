<footer id="footer" class="content-info bg-verde text-black py-6">
    <div
        class="container max-w-none text-black prose:a:text-black">
        @php(dynamic_sidebar('sidebar-footer'))
        <div class="text-sm mt-4 flex flex-col items-center copyright border-gray-500 border-t border-solid pt-8 gap-2 text-black">
            <span class="z-10 font-bold text-white">© 2009 - {{ date('Y') }} 
                <a class="text-black hover:underline text-white" href="{{ home_url('/') }}">Néctar da Amazônia</a>
                <span id="trademark" class="sup align-text-bottom">&reg;</span>
            </span>
        </div>
    </div>

</footer>

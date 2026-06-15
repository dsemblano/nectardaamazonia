@props(['product'])

@php
    /** @var WC_Product $product */
    
    if ($product->is_type('variable')) {
        $outOfStock = true; // Começa assumindo que está sem estoque
        
        // Pega todas as variações do produto (mesmo as sem estoque)
        $variations = $product->get_children();
        
        foreach ($variations as $variation_id) {
            $variation = wc_get_product($variation_id);
            
            // Se encontrar pelo menos UMA variação que esteja visível e em estoque, o produto não está esgotado
            if ($variation && $variation->is_visible() && $variation->is_in_stock()) {
                $outOfStock = false;
                break; // Para o loop na primeira variação com estoque encontrada
            }
        }
    } else {
        // Produto simples segue a regra padrão
        $outOfStock = !$product->is_in_stock();
    }
@endphp

<div class="group not-prose relative flex flex-col h-full bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden pb-5">

    {{-- IMAGE CONTAINER --}}
    <div class="relative aspect-square w-full overflow-hidden bg-gray-100">
        <a href="{{ get_permalink($product->get_id()) }}" class="block h-full w-full">
            {!! $product->get_image('medium', [
                'class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-105',
                'loading' => 'lazy',
                'decoding' => 'async',
            ]) !!}
        </a>

        @if ($product->is_on_sale() && !$outOfStock)
            <span class="absolute top-3 left-3 bg-red-600 text-white text-xs font-bold uppercase tracking-wider px-2.5 py-1 rounded-md shadow-sm z-10">
                Oferta
            </span>
        @endif

        {{-- Badge visual de Fora de Estoque em cima da imagem (Opcional, mas melhora muito a UX) --}}
        @if ($outOfStock)
            <div class="absolute inset-0 bg-black/40 flex items-center justify-center z-10 esgotado">
                <span class="bg-white/90 text-gray-800 text-xs font-bold uppercase tracking-wider px-3 py-1.5 rounded-lg shadow-sm">
                    Esgotado
                </span>
            </div>
        @endif
    </div>

    {{-- CONTENT BLOCK --}}
    <div class="flex flex-col flex-grow px-4 pt-4 text-center">
        
        {{-- TITLE --}}
        <h3 class="text-sm lg:text-base font-semibold leading-snug text-verde mb-0 hover:text-primary transition-colors">
            <a href="{{ get_permalink($product->get_id()) }}">
                {{ $product->get_name() }}
            </a>
        </h3>

        {{-- PRICE + CTA --}}
        <div class="mt-auto flex flex-col items-center w-full">
            
            <div class="price text-base lg:text-lg font-bold text-melescuro pb-4 pt-2">
                {!! $product->get_price_html() !!}
            </div>

            {{-- Bloco de Ação Inteligente --}}
            @if ($outOfStock)
                {{-- Se QUALQUER tipo de produto estiver fora de estoque --}}
                <div class="w-full bg-gray-100 text-gray-400 py-2.5 px-2 rounded-xl text-sm font-semibold text-center cursor-not-allowed select-none">
                    Fora de estoque
                </div>
            @else
                @if ($product->is_type('variable'))
                    {{-- Produto variável COM estoque: Redireciona para a página interna para escolher a variação --}}
                    <a href="{{ get_permalink($product->get_id()) }}" 
                       class="w-full bg-secondary text-white py-2.5 px-4 rounded-xl text-sm font-semibold transition duration-200 hover:bg-opacity-90 text-center">
                        Ver opções
                    </a>
                @else
                    {{-- Produto simples COM estoque: Adiciona direto ao carrinho --}}
                    <a href="?add-to-cart={{ $product->get_id() }}" 
                       class="w-full bg-primary text-white py-2.5 px-4 rounded-xl text-sm font-semibold transition duration-200 hover:bg-opacity-90 text-center">
                        Adicionar
                    </a>
                @endif
            @endif

        </div>
    </div>

</div>
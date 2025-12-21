<div x-data="{ show: false, product: null }"
     x-init="Livewire.on('open-global-add-to-cart-modal', (p) => { product = p; show = true; })"
     x-show="show" style="display:none"
     class="fixed inset-0 z-50 flex items-center justify-center p-4">

    <div @click="show = false" class="absolute inset-0 bg-black bg-opacity-60"></div>

    <div class="relative bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 animate-in fade-in zoom-in">
        <h3 class="text-2xl font-bold text-center mb-6 text-gray-800">Xác nhận thêm vào giỏ</h3>
        
        <template x-if="product">
            <div class="text-center mb-8">
                <p class="text-2xl font-bold text-success" x-text="product.productName"></p>
                <p class="text-3xl font-bold text-success mt-2" x-text="new Intl.NumberFormat('vi-VN').format(product.price) + 'đ /kg'"></p>
            </div>
        </template>

        <div class="flex justify-center gap-6">
            <button @click="show = false" 
                    class="px-8 py-3 bg-gray-300 rounded-xl hover:bg-gray-400 transition text-lg font-medium">
                Hủy
            </button>
            <button @click="show = false; 
                            Livewire.dispatch('add-to-cart-from-modal', product.productId)"
                    class="px-8 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition text-lg font-medium">
                Thêm ngay
            </button>
        </div>
    </div>
</div>
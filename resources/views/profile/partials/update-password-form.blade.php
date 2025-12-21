{{-- resources/views/profile/partials/update-password-form.blade.php --}}
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Đổi mật khẩu') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Đảm bảo tài khoản của bạn sử dụng mật khẩu dài và ngẫu nhiên để bảo mật tốt hơn.') }}
        </p>
    </header>

    <form @submit.prevent="submit" x-data="passwordData()" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Mật khẩu hiện tại -->
        <div>
            <x-input-label for="current_password" value="{{ __('Mật khẩu hiện tại') }}" />
            <x-text-input 
                x-model="form.current_password" 
                id="current_password" 
                type="password" 
                class="mt-1 block w-full" 
                autocomplete="current-password" 
            />
            <div x-show="errors.current_password" class="mt-2 text-sm text-red-600" x-text="errors.current_password"></div>
        </div>

        <!-- Mật khẩu mới -->
        <div>
            <x-input-label for="password" value="{{ __('Mật khẩu mới') }}" />
            <x-text-input 
                x-model="form.password" 
                id="password" 
                type="password" 
                class="mt-1 block w-full" 
                autocomplete="new-password" 
            />
            <div x-show="errors.password" class="mt-2 text-sm text-red-600" x-text="errors.password"></div>
        </div>

        <!-- Xác nhận mật khẩu -->
        <div>
            <x-input-label for="password_confirmation" value="{{ __('Xác nhận mật khẩu') }}" />
            <x-text-input 
                x-model="form.password_confirmation" 
                id="password_confirmation" 
                type="password" 
                class="mt-1 block w-full" 
                autocomplete="new-password" 
            />
            <div x-show="errors.password_confirmation" class="mt-2 text-sm text-red-600" x-text="errors.password_confirmation"></div>
        </div>

        <!-- Nút lưu + loading + thông báo -->
        <div class="flex items-center gap-4">
            <x-primary-button 
                type="submit" 
                x-bind:disabled="loading"
                class="flex items-center gap-2"
            >
                <template x-if="!loading">
                    <span>Lưu mật khẩu mới</span>
                </template>
                <template x-if="loading">
                    <span class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Đang cập nhật...
                    </span>
                </template>
            </x-primary-button>

            <p x-show="success" x-transition class="text-sm font-medium text-green-600">
                Đổi mật khẩu thành công!
            </p>
        </div>
    </form>
</section>

<script>
function passwordData() {
    return {
        form: {
            current_password: '',
            password: '',
            password_confirmation: ''
        },
        errors: {},
        loading: false,
        success: false,

        submit() {
            this.loading = true;
            this.success = false;
            this.errors = {};

            axios.put("{{ route('password.update') }}", this.form)
                .then(response => {
                    this.success = true;
                    this.loading = false;
                    this.form = { current_password: '', password: '', password_confirmation: '' }; // clear form
                    setTimeout(() => this.success = false, 4000);
                })
                .catch(error => {
                    this.loading = false;
                    if (error.response?.status === 422) {
                        const errs = error.response.data.errors;
                        this.errors = Object.fromEntries(
                            Object.keys(errs).map(key => [key, errs[key][0]])
                        );
                    } else if (error.response?.status === 403 || error.response?.data?.message) {
                        this.errors.current_password = "Mật khẩu hiện tại không đúng!";
                    } else {
                        alert("Có lỗi xảy ra, vui lòng thử lại!");
                    }
                });
        }
    }
}
</script>
{{-- resources/views/profile/partials/update-profile-information-form.blade.php --}}
<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Thông tin tài khoản</h2>
        <p class="mt-1 text-sm text-gray-600">
            Cập nhật thông tin cá nhân, email, số điện thoại và địa chỉ nhận hàng.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <form @submit.prevent="submit" x-data="profileData()" class="mt-6 space-y-6">
        @csrf @method('patch')

        <!-- Tên -->
        <div>
            <x-input-label for="name" value="Họ và tên" />
            <x-text-input x-model="form.name" id="name" type="text" class="mt-1 block w-full" required />
            <div x-show="errors.name" class="mt-2 text-sm text-red-600" x-text="errors.name"></div>
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input x-model="form.email" id="email" type="email" class="mt-1 block w-full" required />
            <div x-show="errors.email" class="mt-2 text-sm text-red-600" x-text="errors.email"></div>

            @if (!$user->hasVerifiedEmail())
                <p class="mt-2 text-sm text-gray-600">
                    Email chưa xác thực.
                    <button type="button" @click="resendVerification" class="underline text-blue-600 hover:text-blue-800">
                        Gửi lại email xác thực
                    </button>
                </p>
                <p x-show="verificationSent" class="mt-2 text-sm text-green-600">Đã gửi lại!</p>
            @endif
        </div>

        <!-- Phone -->
        <div>
            <x-input-label for="phone" value="Số điện thoại" />
            <x-text-input x-model="form.phone" id="phone" type="text" class="mt-1 block w-full" placeholder="0901234567" />
            <div x-show="errors.phone" class="mt-2 text-sm text-red-600" x-text="errors.phone"></div>
        </div>

        <!-- Address -->
        <div>
            <x-input-label for="address" value="Địa chỉ nhận hàng" />
            <textarea x-model="form.address" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
            <div x-show="errors.address" class="mt-2 text-sm text-red-600" x-text="errors.address"></div>
        </div>

        <!-- Nút lưu + loading + thông báo (ĐÃ FIX 100%) -->
        <div class="flex items-center gap-4">
            <x-primary-button 
                type="submit" 
                x-bind:disabled="loading"
                class="flex items-center gap-2"
            >
                <template x-if="!loading">
                    <span>Lưu thay đổi</span>
                </template>
                <template x-if="loading">
                    <span class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Đang lưu...
                    </span>
                </template>
            </x-primary-button>

            <p x-show="success" x-transition.duration.500ms class="text-sm font-medium text-green-600">
                Cập nhật thành công!
            </p>
        </div>
    </form>
</section>

<script>
function profileData() {
    return {
        form: {
            name: "{{ addslashes($user->name) }}",
            email: "{{ $user->email }}",
            phone: "{{ $user->phone ?? '' }}",
            address: "{{ addslashes($user->address ?? '') }}",
        },
        errors: {},
        loading: false,
        success: false,
        verificationSent: false,

        submit() {
            this.loading = true;
            this.success = false;
            this.errors = {};

            axios.patch("{{ route('profile.update') }}", this.form)
                .then(r => {
                    this.success = true;
                    this.loading = false;
                    setTimeout(() => this.success = false, 3000);
                })
                .catch(e => {
                    this.loading = false;
                    if (e.response && e.response.status === 422) {
                        const errs = e.response.data.errors;
                        this.errors = Object.fromEntries(
                            Object.keys(errs).map(key => [key, errs[key][0]])
                        );
                    } else {
                        alert("Có lỗi xảy ra, vui lòng thử lại!");
                    }
                });
        },

        resendVerification() {
            axios.post("{{ route('verification.send') }}")
                .then(() => {
                    this.verificationSent = true;
                    setTimeout(() => this.verificationSent = false, 5000);
                });
        }
    }
}
</script>
<x-guest-layout>
    <x-auth-card>
        <h1 class="text-center text-2xl p-4 font-semibold italic">3points book</h1>
        <div class="pb-4">
            <h2 class="text-center text-xl p-2 bg-primary text-white">仮会員登録完了</h2>
            <div class="mb-4 text-sm text-gray-600">
                <p class="pt-6">
                    この度は、ご登録いただき、誠にありがとうございます。<br><br>
                    ご本人様確認のため、ご登録いただいたメールアドレスに、
                    本登録のご案内メールが届きます。<br><br>
                    メール内に記載されているURLにアクセスし、
                    アカウントの本登録をお願いいたします。
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div>
                        <x-button>
                            {{ __('Resend Verification Email') }}
                        </x-button>
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>

    </x-auth-card>
</x-guest-layout>

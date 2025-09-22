
@section('title', 'Login')

@section('content')
<style>
    body {
        background-color: white !important;
    }
    @media (max-width: 48rem) {
        .login-container {
            padding: 1.5rem 1rem;
        }
        .login-box {
            padding: 1.5rem;
        }
    }
</style>

<div class="login-container" style="max-width: 32rem; margin: 0 auto; padding: 2.5rem 1.5rem; height: 100vh; display: flex; align-items: center;">
    <div class="login-box" style="background-color: white; border: 1px solid #90E0EF; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 2rem; width: 100%;">
        <h2 style="font-size: 1.875rem; font-weight: bold; color: #023E8A; text-align: center; margin-bottom: 1.5rem;">Login to Fleet Management Module</h2>

        @if (session('error'))
            <div style="background-color: #FEE2E2; color: #b91c1c; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div style="background-color: #FEE2E2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                <ul style="margin: 0; padding-left: 1rem; list-style-type: disc;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 1rem;">
            @csrf
            <div>
                <label for="username" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500; color: #023E8A;">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required
                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #90E0EF; color: #03045E; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;"
                       placeholder="Enter your username"
                       onfocus="this.style.borderColor='#00B4D8'" onblur="this.style.borderColor='#90E0EF'">
            </div>
            <div>
                <label for="password" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500; color: #023E8A;">Password</label>
                <input type="password" id="password" name="password" required
                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #90E0EF; color: #03045E; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;"
                       placeholder="Enter your password"
                       onfocus="this.style.borderColor='#00B4D8'" onblur="this.style.borderColor='#90E0EF'">
            </div>
            <div style="width: 100%; display: flex; justify-content: center;">
                <button type="submit"
                        style="background-color: #00B4D8; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#0096C7'" onmouseout="this.style.backgroundColor='#00B4D8'">
                    <i class="fa-solid fa-sign-in-alt" style="margin-right: 0.25rem;"></i> Login
                </button>
            </div>
        </form>
    </div>
</div>

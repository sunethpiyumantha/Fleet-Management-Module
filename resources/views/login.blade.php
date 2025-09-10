

@section('title', 'Login')

@section('content')
<div style="max-width: 32rem; margin: 0 auto; padding: 2.5rem 1.5rem; height: 100vh; display: flex; align-items: center;">
    <div style="background-color: white; border: 1px solid #f97316; border-radius: 1rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); padding: 2rem; width: 100%;">
        <h2 style="font-size: 1.875rem; font-weight: bold; color: #ea580c; text-align: center; margin-bottom: 1.5rem;">Login in to Fleet Management Module</h2>

        @if (session('error'))
            <div style="background-color: #fee2e2; color: #b91c1c; padding: 0.75rem 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                {{ session('error') }}
            </div>
        @endif
        @if ($errors->any())
            <div style="background-color: #fee2e2; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
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
                <label for="username" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}" required
                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;"
                       placeholder="Enter your username">
            </div>
            <div>
                <label for="password" style="display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500;">Password</label>
                <input type="password" id="password" name="password" required
                       style="width: 100%; height: 38px; border-radius: 0.5rem; border: 1px solid #d1d5db; color: #374151; padding: 0.5rem 0.75rem; outline: none; font-size: 0.875rem;"
                       placeholder="Enter your password">
            </div>
            <div style="width: 100%; display: flex; justify-content: center;">
                <button type="submit"
                        style="background-color: #f97316; color: white; font-weight: 600; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#f97316'">
                    <i class="fa-solid fa-sign-in-alt" style="margin-right: 0.25rem;"></i> Login
                </button>
            </div>
        </form>
    </div>
</div>

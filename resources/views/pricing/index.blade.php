@extends('layouts.app')

@section('title', 'Pricing Plans')

@section('content')
<div class="bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        @if (session('vnpay_data'))
            @php $data = session('vnpay_data'); @endphp
            <div class="bg-white shadow-md rounded-lg p-6 mb-8 border-l-4 {{ $data['vnp_ResponseCode'] === '00' ? 'border-green-500' : 'border-red-500' }}">
                <h3 class="text-xl font-bold mb-4">Transaction Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                    <div><strong>Order ID:</strong> {{ $data['vnp_TxnRef'] ?? 'N/A' }}</div>
                    <div><strong>Amount:</strong> <span class="font-semibold">{{ number_format(($data['vnp_Amount'] ?? 0) / 100, 0, ',', '.') }} VND</span></div>
                    <div><strong>Content:</strong> {{ $data['vnp_OrderInfo'] ?? 'N/A' }}</div>
                    <div><strong>VNPAY Transaction No:</strong> {{ $data['vnp_TransactionNo'] ?? 'N/A' }}</div>
                    <div><strong>Bank:</strong> {{ $data['vnp_BankCode'] ?? 'N/A' }}</div>
                    <div><strong>Payment Time:</strong> {{ isset($data['vnp_PayDate']) ? \Carbon\Carbon::createFromFormat('YmdHis', $data['vnp_PayDate'])->format('d/m/Y H:i:s') : 'N/A' }}</div>
                </div>
                <div class="mt-4">
                    <strong>Result:</strong>
                    @if ($data['vnp_ResponseCode'] === '00')
                        <span class="font-semibold text-green-600">Payment Successful</span>
                        <p class="text-sm text-gray-600 mt-1">Your plan will be activated shortly after our system confirms the transaction.</p>
                    @else
                        <span class="font-semibold text-red-600">Payment Failed</span>
                        <p class="text-sm text-gray-600 mt-1">Error code: {{ $data['vnp_ResponseCode'] ?? 'Unknown' }}. Please try again or contact support.</p>
                    @endif
                </div>
            </div>
        @endif
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl">
                Choose the Right Plan for You
            </h1>
            <p class="mt-4 text-xl text-gray-600">
                Flexible pricing for companies of all sizes.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($plans as $plan)
                <div class="bg-white rounded-lg shadow-lg p-8 flex flex-col
                            @if($plan->slug === 'premium') border-4 border-purple-600 relative @endif">

                    @if($plan->slug === 'premium')
                        <div class="absolute top-0 -translate-y-1/2 left-1/2 -translate-x-1/2">
                            <span class="px-4 py-1 text-white text-sm font-semibold tracking-wider bg-purple-600 rounded-full uppercase">
                                Most Popular
                            </span>
                        </div>
                    @endif

                    <h2 class="text-2xl font-bold text-gray-900">{{ $plan->name }}</h2>
                    <p class="mt-4 text-gray-500">
                        @if($plan->price > 0)
                            A perfect plan for growing businesses.
                        @else
                            Get started for free.
                        @endif
                    </p>

                    <div class="mt-6">
                        <span class="text-4xl font-extrabold text-gray-900">
                            @if($plan->price > 0)
                                {{ number_format($plan->price, 0, ',', '.') }} VND
                            @else
                                Free
                            @endif
                        </span>
                        @if($plan->price > 0)
                            <span class="text-base font-medium text-gray-500">/month</span>
                        @endif
                    </div>

                    <ul class="mt-8 space-y-4 text-gray-600 flex-grow">
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>
                                @if($plan->features['post_jobs_limit'] == -1)
                                    <strong>Unlimited</strong> Job Posts
                                @else
                                    <strong>{{ $plan->features['post_jobs_limit'] }}</strong> Job Post(s)
                                @endif
                            </span>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 {{ $plan->features['can_search_cvs'] ? 'text-green-500' : 'text-red-400' }} mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                @if($plan->features['can_search_cvs'])
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                @endif
                            </svg>
                            <span>CV Search Access</span>
                        </li>
                        {{-- Bạn có thể thêm các feature khác ở đây --}}
                    </ul>

                    <form action="{{ route('employer.subscriptions.store') }}" method="POST" class="mt-8">
                        @csrf
                        <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        @if($plan->id === $currentPlanId)
                            <button type="button"
                                    disabled
                                    class="w-full py-3 px-6 text-center rounded-lg transition bg-gray-400 text-white cursor-not-allowed">
                                Current Plan
                            </button>
                        @else
                            <button type="submit"
                                    class="w-full py-3 px-6 text-center rounded-lg transition
                                    @if($plan->slug === 'premium')
                                        bg-purple-600 text-white hover:bg-purple-700
                                    @else
                                        bg-gray-800 text-white hover:bg-gray-900
                                    @endif">
                                {{ $currentPlanId ? 'Switch Plan' : 'Choose Plan' }}
                            </button>
                        @endif
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

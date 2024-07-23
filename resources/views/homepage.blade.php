@include('layouts.header')

<x-app-layout>
    <x-slot name="header">
        <div class="relative overflow-hidden bg-cover bg-center text-center text-white" style="background-image: url('https://img.freepik.com/free-photo/flat-lay-workstation-with-copy-space-laptop_23-2148430879.jpg');">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="relative z-10 p-5">
                <h1 class="font-bold mb-5 animate-pulse font-autumn" style="font-size: 30px;">
                    <b>{{ __('WELCOME TO CHECK TIMES SYSTEM') }}</b>
                </h1>
            </div>
        </div>
    </x-slot>

    <!-- Default slot for main content -->
    <div class="relative overflow-hidden bg-cover bg-center text-center text-white" style="height: 500px;background-image: url('https://media.istockphoto.com/id/1534543100/photo/autumn-inspired-office-theme-top-view-of-laptop-steaming-mug-of-pumpkin-spice-latte-stylish.webp?b=1&s=170667a&w=0&k=20&c=5GHsCKL5vjlZeN-snMQytscvAByU_J6QoXnbE4Xeeuc=');">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative z-10 flex justify-center space-x-4 mt-10 pt-24">
            <button type="button" class="btn btn-primary btn-custom m-3"><b>CHECK-IN</b></button>
            <button type="button" class="btn btn-warning btn-custom m-3"><b>STORY CHECKIN</b></button>
        </div>
    </div>
</x-app-layout>
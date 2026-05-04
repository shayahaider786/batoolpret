@extends('layouts.frontend')

@push('canonical')
    <link rel="canonical" href="{{ route('contact') }}">
@endpush

@section('content')
<div class="bg-white"> 
    <div class="container headerTop p-5">
    </div>
</div>

<!-- breadcrumb -->
<div class="container">
    <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
        <a href="{{ route('index') }}" class="stext-109 cl8 hov-cl1 trans-04">
            Home
            <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
        </a>

        <span class="stext-109 cl4">
            {{ __('messages.contact.title') ?? 'Contact' }}
        </span>
    </div>
</div>

<!-- Title page -->
<section class="txt-center p-lr-15 p-tb-92 bg-dark">
    <h2 class="ltext-105 cl0 txt-center">
        {{ __('messages.contact.title') ?? 'Contact' }}
    </h2>
</section>	


<!-- Content page -->
<section class="bg0 p-t-104 p-b-116">
    <div class="container">
        <!-- Success Message -->
        @if(session('success'))
            <div class="container" style="margin-top: 20px; margin-bottom: 20px;">
                <div class="alert alert-success" style="padding: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 4px;">
                    <strong>Success!</strong> {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Error Messages -->
        @if($errors->any())
            <div class="container" style="margin-top: 20px; margin-bottom: 20px;">
                <div class="alert alert-danger" style="padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px;">
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin-top: 10px; margin-bottom: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="flex-w flex-tr">
            <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
                <form method="POST" action="{{ route('contact.store') }}">
                    @csrf
                    <h4 class="mtext-105 cl2 txt-center p-b-30">
                        {{ __('messages.contact.sendMessage') ?? 'Send Us A Message' }}
                    </h4>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="bor8 m-b-20">
                                <input class="stext-111 cl2 plh3 size-116 p-lr-30 @error('fname') is-invalid @enderror" 
                                       type="text" 
                                       name="fname" 
                                       value="{{ old('fname') }}"
                                       placeholder="{{ __('messages.contact.firstName') ?? 'First Name' }} *" 
                                       required>
                                @error('fname')
                                    <span class="invalid-feedback" role="alert" style="display: block; color: #f44336; margin-top: 5px; font-size: 12px;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="bor8 m-b-20">
                                <input class="stext-111 cl2 plh3 size-116 p-lr-30 @error('lname') is-invalid @enderror" 
                                       type="text" 
                                       name="lname" 
                                       value="{{ old('lname') }}"
                                       placeholder="{{ __('messages.contact.lastName') ?? 'Last Name' }} *" 
                                       required>
                                @error('lname')
                                    <span class="invalid-feedback" role="alert" style="display: block; color: #f44336; margin-top: 5px; font-size: 12px;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bor8 m-b-20 how-pos4-parent">
                        <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30 @error('phone') is-invalid @enderror" 
                               type="text" 
                               name="phone" 
                               value="{{ old('phone') }}"
                               placeholder="{{ __('messages.contact.phone') ?? 'Phone Number' }} *" 
                               required>
                        <img class="how-pos4 pointer-none" src="{{ asset('frontend/images/icons/icon-email.png') }}" alt="ICON">
                        @error('phone')
                            <span class="invalid-feedback" role="alert" style="display: block; color: #f44336; margin-top: 5px; font-size: 12px; margin-left: 62px;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="bor8 m-b-20 how-pos4-parent">
                        <input class="stext-111 cl2 plh3 size-116 p-l-62 p-r-30 @error('email') is-invalid @enderror" 
                               type="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="{{ __('messages.contact.email') ?? 'Your Email Address' }} *" 
                               required>
                        <img class="how-pos4 pointer-none" src="{{ asset('frontend/images/icons/icon-email.png') }}" alt="ICON">
                        @error('email')
                            <span class="invalid-feedback" role="alert" style="display: block; color: #f44336; margin-top: 5px; font-size: 12px; margin-left: 62px;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="bor8 m-b-30">
                        <textarea class="stext-111 cl2 plh3 size-120 p-lr-28 p-tb-25 @error('message') is-invalid @enderror" 
                                  name="message" 
                                  placeholder="{{ __('messages.contact.message') ?? 'How Can We Help?' }} *" 
                                  required>{{ old('message') }}</textarea>
                        @error('message')
                            <span class="invalid-feedback" role="alert" style="display: block; color: #f44336; margin-top: 5px; font-size: 12px;">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="stext-107 cl6" style="display: block; margin-top: 5px; padding-left: 28px;">
                            {{ __('messages.contact.messagePlaceholder') ?? 'Please provide at least 10 characters' }}
                        </small>
                    </div>

                    <button type="submit" class="flex-c-m stext-101 cl0 size-121 bg3 bor1 hov-btn3 p-lr-15 trans-04 pointer">
                        {{ __('messages.contact.sendMessage') ?? 'Submit' }}
                    </button>
                </form>
            </div>

            <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
                <div class="flex-w w-full p-b-42">
                    <span class="fs-18 cl5 txt-center size-211">
                        <span class="lnr lnr-map-marker"></span>
                    </span>

                    <div class="size-212 p-t-2">
                        <span class="mtext-110 cl2">
                            Address
                        </span>

                        <p class="stext-115 cl6 size-213 p-t-18">
                            Lakshmi Chowk Lahore, Pakistan
                        </p>
                    </div>
                </div>

                <div class="flex-w w-full p-b-42">
                    <span class="fs-18 cl5 txt-center size-211">
                        <span class="lnr lnr-phone-handset"></span>
                    </span>

                    <div class="size-212 p-t-2">
                        <span class="mtext-110 cl2">
                            Lets Talk
                        </span>

                        <p class="stext-115 cl1 size-213 p-t-18">
                            03144707099
                        </p>
                    </div>
                </div>

                <div class="flex-w w-full">
                    <span class="fs-18 cl5 txt-center size-211">
                        <span class="lnr lnr-envelope"></span>
                    </span>

                    <div class="size-212 p-t-2">
                        <span class="mtext-110 cl2">
                            Sale Support
                        </span>

                        <p class="stext-115 cl1 size-213 p-t-18">
                            zaylishofficial@gmail.com
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>	


<!-- Map -->
<div class="map">
    <div class="size-303" id="google_map" data-map-x="40.691446" data-map-y="-73.886787" data-pin="images/icons/pin.png" data-scrollwhell="0" data-draggable="1" data-zoom="11"></div>
</div>

@endsection

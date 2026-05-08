@extends('layouts.frontend')

@section('content')
    <div class="bg-white">
        <div class="container headerTop p-5">
        </div>
    </div>

    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h1>Terms & Conditions</h1>
                        <p class="mb-4">Please read these terms carefully before using our website</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <!-- Start Terms Section -->
    <div class="untree_co-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto">
                    <div class="content">

                        <p class="text-muted mb-4">
                            Last Updated: {{ date('F d, Y') }}
                        </p>

                        <h2 class="mb-4">Introduction</h2>
                        <p class="mb-4">
                            Welcome to <strong>Batool Pret</strong>. By accessing or using our website,
                            you agree to be bound by these Terms and Conditions. If you do not agree,
                            please do not use our services.
                        </p>

                        <h2 class="mb-4">Eligibility</h2>
                        <p class="mb-4">
                            By using this website, you confirm that you are at least 18 years old
                            or accessing the site under the supervision of a parent or guardian.
                        </p>

                        <h2 class="mb-4">Account Responsibility</h2>
                        <p class="mb-4">
                            You are responsible for maintaining the confidentiality of your account
                            information and for all activities that occur under your account.
                        </p>

                        <h2 class="mb-4">Product Information</h2>
                        <p class="mb-4">
                            We strive to display product images and descriptions as accurately as possible.
                            However, colors and appearance may vary slightly due to screen settings.
                        </p>

                        <h2 class="mb-4">Pricing & Payments</h2>
                        <p class="mb-4">
                            All prices are listed in PKR unless stated otherwise. Prices may change
                            without prior notice. Payments must be completed in full before orders
                            are processed.
                        </p>

                        <h2 class="mb-4">Order Confirmation</h2>
                        <p class="mb-4">
                            Once an order is placed, you will receive an order confirmation.
                            Batool Pret reserves the right to cancel or refuse any order
                            for any reason, including stock unavailability or payment issues.
                        </p>

                        <h2 class="mb-4 text-danger">No Return, No Exchange & No Refund Policy</h2>
                        <p class="mb-4">
                            All sales made at <strong>Batool Pret</strong> are final.
                            We do not offer returns, exchanges, or refunds under any circumstances.
                            Customers are advised to review product details carefully before placing an order.
                        </p>

                        <h2 class="mb-4">Shipping & Delivery</h2>
                        <p class="mb-4">
                            Delivery times are estimates and may vary depending on location
                            and courier services. Batool Pret is not responsible for delays
                            caused by third-party delivery providers.
                        </p>

                        <h2 class="mb-4">Intellectual Property</h2>
                        <p class="mb-4">
                            All content on this website, including logos, images, text, and designs,
                            is the property of Batool Pret and may not be copied or used without permission.
                        </p>

                        <h2 class="mb-4">User Conduct</h2>
                        <p class="mb-4">
                            You agree not to misuse this website, including attempting unauthorized access,
                            spreading harmful content, or violating any applicable laws.
                        </p>

                        <h2 class="mb-4">Limitation of Liability</h2>
                        <p class="mb-4">
                            Batool Pret shall not be liable for any indirect, incidental, or consequential
                            damages arising from the use of our website or products.
                        </p>

                        <h2 class="mb-4">Termination</h2>
                        <p class="mb-4">
                            We reserve the right to suspend or terminate access to our website
                            if these Terms and Conditions are violated.
                        </p>

                        <h2 class="mb-4">Changes to Terms</h2>
                        <p class="mb-4">
                            Batool Pret may update these Terms and Conditions at any time.
                            Continued use of the website means you accept the updated terms.
                        </p>

                        <h2 class="mb-4">Governing Law</h2>
                        <p class="mb-4">
                            These Terms and Conditions are governed by the laws of Pakistan.
                        </p>

                        <h2 class="mb-4">Contact Information</h2>
                        <p class="mb-4">
                            If you have any questions regarding these Terms and Conditions,
                            please contact us through our
                            <a href="{{ route('contact') }}">Contact Page</a>.
                        </p>

                        <div class="mt-5 pt-4 border-top">
                            <p class="text-muted">
                                By using this website, you agree to these Terms and Conditions.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Terms Section -->
@endsection

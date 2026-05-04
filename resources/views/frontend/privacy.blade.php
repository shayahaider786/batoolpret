@extends('layouts.frontend')

@section('content')
    <div class="bg-white">
        <div class="container headerTop p-5">
        </div>
    </div>


    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-12">
                <div class="text-center">
                    <h1>Privacy Policy</h1>
                    <p class="mb-4">We are committed to protecting your privacy and personal information.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="content">

                    <p class="text-muted mb-4">
                        Last Updated: {{ date('F d, Y') }}
                    </p>

                    <h2 class="mb-4">Introduction</h2>
                    <p class="mb-4">
                        Welcome to <strong>Zaylish Studio</strong>. We respect your privacy and are committed
                        to protecting your personal information. This Privacy Policy explains how we collect,
                        use, and safeguard your data when you visit or shop from our website.
                    </p>

                    <h2 class="mb-4">Information We Collect</h2>

                    <h3 class="mb-3">Personal Information</h3>
                    <p class="mb-4">
                        When you place an order or contact us, we may collect:
                    </p>
                    <ul class="mb-4">
                        <li>Your full name</li>
                        <li>Email address</li>
                        <li>Phone number</li>
                        <li>Shipping and billing address</li>
                        <li>Order and payment details</li>
                    </ul>

                    <h3 class="mb-3">Information Collected Automatically</h3>
                    <p class="mb-4">
                        We may automatically collect certain information such as:
                    </p>
                    <ul class="mb-4">
                        <li>IP address</li>
                        <li>Browser and device information</li>
                        <li>Pages visited on our website</li>
                        <li>Cookies and usage data</li>
                    </ul>

                    <h2 class="mb-4">How We Use Your Information</h2>
                    <ul class="mb-4">
                        <li>To process and deliver your orders</li>
                        <li>To communicate order updates</li>
                        <li>To improve our website and services</li>
                        <li>To respond to customer inquiries</li>
                        <li>To prevent fraud and ensure security</li>
                    </ul>

                    <h2 class="mb-4">Information Sharing</h2>
                    <p class="mb-4">
                        Zaylish Studio does not sell, trade, or rent your personal information.
                        We may share your data only with trusted service providers such as
                        payment gateways and delivery partners.
                    </p>

                    <h2 class="mb-4">Data Security</h2>
                    <p class="mb-4">
                        We take reasonable security measures to protect your personal data.
                        However, no online platform can guarantee complete security.
                    </p>

                    <h2 class="mb-4">Cookies</h2>
                    <p class="mb-4">
                        Our website uses cookies to enhance user experience and analyze website traffic.
                        You may disable cookies through your browser settings.
                    </p>

                    <h2 class="mb-4 text-danger">No Return & No Exchange Policy</h2>
                    <p class="mb-4">
                        Please note that <strong>Zaylish Studio does not offer returns or exchanges</strong>.
                        All sales are final. Once a product is purchased, it cannot be returned or exchanged.
                        Customers are advised to carefully review product details before placing an order.
                    </p>

                    <h2 class="mb-4">Your Rights</h2>
                    <ul class="mb-4">
                        <li>Access your personal information</li>
                        <li>Request correction of incorrect data</li>
                        <li>Request deletion of your data</li>
                        <li>Unsubscribe from marketing communications</li>
                    </ul>

                    <h2 class="mb-4">Data Retention</h2>
                    <p class="mb-4">
                        We retain your personal information only as long as necessary
                        to fulfill orders and comply with legal requirements.
                    </p>

                    <h2 class="mb-4">Children’s Privacy</h2>
                    <p class="mb-4">
                        Zaylish Studio does not knowingly collect personal information
                        from children under the age of 13.
                    </p>

                    <h2 class="mb-4">Third-Party Links</h2>
                    <p class="mb-4">
                        Our website may contain links to third-party websites.
                        We are not responsible for their privacy practices.
                    </p>

                    <h2 class="mb-4">Changes to This Policy</h2>
                    <p class="mb-4">
                        We may update this Privacy Policy from time to time.
                        Changes will be posted on this page.
                    </p>

                    <h2 class="mb-4">Contact Us</h2>
                    <p class="mb-4">
                        If you have any questions about this Privacy Policy,
                        please contact us via our
                        <a href="{{ route('contact') }}">Contact Page</a>.
                    </p>

                    <div class="mt-5 pt-4 border-top">
                        <p class="text-muted">
                            By using our website, you agree to this Privacy Policy.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Privacy Section -->
@endsection
